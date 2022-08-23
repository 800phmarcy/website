<?php
class Orders_m extends CI_Model
{

    protected $_errorCode;
    protected $_errorMessage;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get list of partners
     * @param    object  Container Partner ID , Customer ID (optional), Limit (optional), Page (optional)
     * @return      array
     */

    public function get_orders($data)
    {

        $criteria = "AND 1 = 1 ";


        if(isset($data['start_date']) && $data['start_date'] != ""){

            $criteria .= " AND o.date_added > '" .$data['start_date']. "' ";

        }


        if(isset($data['end_date']) && $data['end_date'] != ""){

            $criteria .= " AND o.date_added < '" .$data['end_date']. "' ";

        }


        if (isset($data['customer']) && $data['customer'] != "") {
            $criteria = " AND c.external_customer_id = '" . $data['customer'] . "'";
        }


        if(isset($data['dispatch']) && $data['dispatch'] == "1"){
            $criteria .= " AND (o.order_status_id > 2 and o.order_status_id < 5) ";

        }


        if (isset($data['sort']) && $data['sort'] != "") {

            if ($data['sort'] == 'status') {
                $criteria .= "ORDER BY os.name";
            } else if ($data['sort'] == 'id') {
                $criteria .= "ORDER BY o.order_id";
            } else {
                $criteria .= "ORDER BY o.date_added";
            }


            if (isset($data['orderby']) && $data['orderby'] != "") {

                if (strtolower($data['orderby']) == 'desc') {
                    $criteria .= " DESC";
                } else {
                    $criteria .= " ASC ";
                }
            } else {
                $criteria .= " DESC ";
            }
        }


        if ((isset($data['limit']) && ctype_digit($data['limit'])) && !isset($data['page'])) {
            $criteria .= " LIMIT " . $data['limit'];
        } else if ((isset($data['limit']) && ctype_digit($data['limit'])) && isset($data['page'])) {

            if ($data['page'] > 0) {
                $page = $data['page'] - 1;
            } else {
                $page = 0;
            }
            $criteria  .= " LIMIT " . $page . "," . $data['limit'];
        }

        $result = $this->db->query("SELECT o.*, c.firstname as first_name, c.lastname as last_name, os.name FROM " . DB_PREFIX . "order o
        LEFT JOIN " . DB_PREFIX . "customer c ON o.customer_id = c.customer_id
        LEFT JOIN " . DB_PREFIX . "order_status os ON o.order_status_id = os.order_status_id
        WHERE o.partner_id = '" . $data['partner_id'] . "' $criteria");


        if ($result->num_rows()) {
            return $result->result_array();
        } else {
            return false;
        }
    }



    /**
     * Get order detail
     * @param    object  Container Partner ID , Order ID
     * @return      Array
     */

    public function getOrder($data)
    {

        $result = $this->db->query("SELECT o.*, c.firstname as first_name, c.lastname as last_name, os.name, os.internal_name FROM " . DB_PREFIX . "order o
    LEFT JOIN " . DB_PREFIX . "customer c ON o.customer_id = c.customer_id
    LEFT JOIN " . DB_PREFIX . "order_status os ON o.order_status_id = os.order_status_id
    WHERE o.partner_id = '" . $data['partner_id'] . "' AND o.external_order_id = '" . $data['order_id'] . "'");


        if ($result->num_rows()) {
            return $result->row_array();
        } else {
            return false;
        }
    }



    public function getOrderById($data)
    {

        $result = $this->db->query("SELECT o.*, c.firstname as first_name, c.lastname as last_name, os.name, os.internal_name FROM " . DB_PREFIX . "order o
    LEFT JOIN " . DB_PREFIX . "customer c ON o.customer_id = c.customer_id
    LEFT JOIN " . DB_PREFIX . "order_status os ON o.order_status_id = os.order_status_id
    WHERE o.partner_id = '" . $data['partner_id'] . "' AND o.order_id = '" . $data['order_id'] . "'");


        if ($result->num_rows()) {
            return $result->row_array();
        } else {
            return false;
        }
    }


    /**
     * Get order totals
     * @param    object  Container Partner ID , Order ID
     * @return      Array
     */

    public function getOrderTotal($order_id)
    {

        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = '" . $order_id . "'");
        return $result->result_array();
    }


    public function getOrderHistories($order_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }
        
        $query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify
        FROM " . DB_PREFIX . "order_history oh
        LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id
        LEFT JOIN " . DB_PREFIX . "order o ON oh.order_id = o.order_id
        WHERE o.external_order_id = '" . $order_id . "'
        ORDER BY oh.date_added DESC LIMIT " . (int) $start . "," . (int) $limit);

        return $query->result_array();
    }



    public function getOrderStatus($id)
    {

        $query = $this->db->query("SELECT o.external_order_id, oh.date_added, os.name AS status, oh.comment, oh.notify
        FROM " . DB_PREFIX . "order_history oh
        LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id
        LEFT JOIN " . DB_PREFIX . "order o ON oh.order_id = o.order_id
        WHERE o.external_order_id = '" . $id . "'
        ORDER BY oh.order_history_id desc limit 1");

        return $query->row_array();
    }



    public function getAttachements($order_id)
    {

        $query = $this->db->query("SELECT oa.* FROM " . DB_PREFIX . "order_attachments oa
        LEFT JOIN " . DB_PREFIX . "order o ON oa.order_id = o.order_id
        WHERE o.external_order_id = '" . $order_id . "'
        ORDER BY oa.file_type
        ");

        return $query->result_array();
    }

    public function create_order($data)
    {

        if ($data['payment_code'] == 'cash' || $data['payment_code'] == 'card') {
            $shortCode = "cod";
            $longCode = "Cash / Card On Delivery";
        } else {
            $shortCode = "pol";
            $longCode = "Online Payment";
        }


        $this->db->query("INSERT INTO " . DB_PREFIX . "order SET
            customer_id = '" . $data['customer_id'] . "',
            external_customer_id = '" . $data['external_customer_id'] . "',
            address_id = '" . $data['address_id'] . "',
            firstname = '" . $data['firstname'] . "',
            lastname = '" . $data['lastname'] . "',
            email  = '" . $data['email'] . "',
            telephone  = '" . $data['telephone'] . "',
            payment_method  = '" . $longCode . "',
            payment_code  = '" . $shortCode . "',
            actual_payment_code  = '" . $shortCode . "',
            comment  = '" . $data['comment'] . "',
            date_added  = '" . $data['date_added'] . "',
            date_modified  = '" . $data['date_modified'] . "',
            withInsurance  = '" . $data['with_insurance'] . "',
            withPrescription  = '" . $data['with_prescriptoin'] . "',
            eRxNumber  = '" . $data['erx_number'] . "',
            delivery_date  = '" . $data['delivery_date'] . "',
            delivery_time  = '" . $data['delivery_time'] . "',
            order_status_id = '1',
            source_id = '7',
            partner_id = '".get_partner_id()."',
            policy_number = '".$data['policy_number']."',
            insurance_provider = '".$data['insurance_provider']."',
            doctor_name = '" . $data['doctor_name'] . "',
            doctor_contact_number = '" . $data['doctor_contact_number'] . "',
            partner_token = '" . $data['partner_token'] . "',
            change_status_url = '" . $data['change_status_url'] . "',
            partner_order_id = '" . $data['partner_order_id'] . "',
            currency_code = 'AED'

            ");

        $id = $this->db->insert_id();


        

        //total values 

        $shippingCharges = 5;

        $totalRecords = array(
            array(
                'code' => 'sub_total',
                'title' => 'Sub-Total',
                'value' => 0,
                'sort' => '1'
            ),
            array(
                'code' => 'shipping',
                'title' => 'Flat Shipping Rate',
                'value' => $shippingCharges,
                'sort' => '2'
            ),
            array(
                'code' => 'total',
                'title' => 'Total',
                'value' => 0,
                'sort' => '3'
            ),
        );

        foreach($totalRecords as $totalObject){

            $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET 
            order_id = '" . $id . "',
            code = '" . $totalObject['code'] . "',
            title = '" . $totalObject['title'] . "',
            value = '" . $totalObject['value'] . "',
            sort_order = '" . $totalObject['sort'] . "'
            ");

        }

        $this->db->query("UPDATE " . DB_PREFIX . "order SET total = '0', actual_total = '0' WHERE order_id = '" . $id . "'");

        //end total values







        $result = $this->db->query("SELECT o.* FROM " . DB_PREFIX . "order o
            WHERE o.order_id = '" . $id . "'");

        if ($result->num_rows()) {
            $data = $result->row_array();
            $this->addHistory($data);
            return $data;

        } else {
            return false;

        }
    }



    public function insert_products($order_id, $products){


        $total = 0;
        foreach($products as $product){

            $sku = trim($product->sku);
            if ($sku != ""){

                $s = "SELECT * FROM " . DB_PREFIX . "product WHERE sku = '". $sku ."'";
                $sResult = $this->db->query($s);

                if ($sResult->num_rows()) {

                    $productDetail = $sResult->row_array();
                    $sql = "INSERT INTO " . DB_PREFIX . "order_product SET 
                    order_id = '" . $order_id . "',
                    product_id = '" . $productDetail['product_id'] . "',
                    name = '" . $product->name . "',
                    quantity = '" . $product->qty . "',
                    price = '" . $productDetail['price'] . "',
                    total = '" . ($productDetail['price'] * $product->qty) . "'
                    ";

                    $total += ($productDetail['price'] * $product->qty);
                    $this->db->query($sql);

                }        

            }   

        }



        //insert record in total 
        $shippingCharges = 5;

        $totalRecords = array(
            array(
                'code' => 'sub_total',
                'title' => 'Sub-Total',
                'value' => $total,
                'sort' => '1'
            ),
            array(
                'code' => 'shipping',
                'title' => 'Flat Shipping Rate',
                'value' => $shippingCharges,
                'sort' => '2'
            ),
            array(
                'code' => 'total',
                'title' => 'Total',
                'value' => ( $total + $shippingCharges ),
                'sort' => '3'
            ),
        );

        foreach($totalRecords as $totalObject){

            $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET 
            order_id = '" . $order_id . "',
            code = '" . $totalObject['code'] . "',
            title = '" . $totalObject['title'] . "',
            value = '" . $totalObject['value'] . "',
            sort_order = '" . $totalObject['sort'] . "'
            ");

        }

        $this->db->query("UPDATE " . DB_PREFIX . "order SET total = '" . ( $total + $shippingCharges ) . "', actual_total = '" . ( $total + $shippingCharges ) . "' WHERE order_id = '" . $order_id . "'");

    }



    public function update_prescription($order_id, $path)
    {
        $this->db->query("INSERT INTO ph_order_attachments SET
        order_id = '" . $order_id . "',
        file_name = '" . $path . "',
        file_type = 'prescription'");
    }



    public function cancel_order($order_id, $cancel_key){
        $result = $this->db->query("SELECT name,order_status_id FROM " . DB_PREFIX . "order_status WHERE internal_name = 'canceled'");

        $this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id = '".$result->row_array()['order_status_id']."'
        WHERE external_order_id = '".$order_id."' AND key_for_cancel = '".$cancel_key."'");

        if($this->db->affected_rows() > 0){


                $order = $this->getOrder(array('order_id' => $order_id, 'partner_id' => get_partner_id()));

                $this->addHistory(array(
                    'order_id' => $order['order_id'],
                    'order_status_id' => $result->row_array()['order_status_id'],
                    'comment' => 'Order canceled'
                ));


            return $result->row_array()['name'];
        }else {
            return false;
        }


    }



    public function update_order_status($order_id, $status_internal_name){

        $statusResult = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status os WHERE os.internal_name = " . $this->db->escape($status_internal_name));

        if($statusResult->num_rows()){
            $status = $statusResult->row_array();

        }else {
            $status = false;
            echo "no order";

        }


        if($status){

            $result = $this->db->query(
                "UPDATE " . DB_PREFIX . "order SET order_status_id = " . $status['order_status_id'] . " WHERE order_id = " . $order_id . " AND partner_id = " . $this->db->escape(get_partner_id()));


                if($this->db->affected_rows() > 0){

                        $this->addHistory(array(
                            'order_id' => $order_id,
                            'order_status_id' => $status['order_status_id'],
                            'comment' => 'Update status'
                        ));

                    }
                    

            }
                   return true;   

    }




    public function trackOrder($order_id)
    {

        $result = $this->db->query("SELECT o.external_order_id,  d.name as driver_name, d.mobile_number as driver_mobile_number,
        tl.address, tl.street, tl.house_building_no, tl.apartment, tl.extra_directions,
        tl.lat distination_lat, tl.lng distination_lng, tl.started_date, tl.end_date,o.delivery_time,
        tl.estimated_duration, tl.estimated_distance, d.last_lat driver_current_lat, d.last_lng driver_current_lng
        from ph_order o
        LEFT JOIN ph_cust_tasks t ON o.order_id = t.order_id
        LEFT JOIN ph_cust_drivers d ON t.driver_id = d.driver_id
        LEFT JOIN ph_cust_task_locations tl ON t.task_id = tl.task_id
        WHERE external_order_id = '". $order_id ."'");

        if ($result->row_array()['started_date'] == "")
        throw new Exception("Driver not yet started the journey", 400);

        
        return $result->row_array();

    }



    public function addHistory($data){

        $query = $this->db->query("INSERT INTO ph_order_history SET
        order_id = '". $data['order_id'] ."',
        order_status_id = '". $data['order_status_id'] ."',
        comment = '". $data['comment'] ."',
        date_added = '".date("Y-m-d H:i:s")."'
        ");

    }


    public function updateOrderId($extern_order_id){
        $this->db->query("UPDATE ph_order SET doctor_name = '".$extern_order_id."' WHERE external_order_id = '".$extern_order_id."'");
        return true;
    }



    //Temp files
    public function uploadTempFiles($file_name, $session_id, $partner_id, $extension){

        $this->db->query("INSERT INTO ph_cust_temp_upload_files SET 
            session_id = '".$session_id."', 
            file_name = '".$file_name."',
            partner_id = '".$partner_id."',
            added_date = '". date("Y-m-d H:i:s", time()) ."', 
            extension = '" . $extension . "'
            ");
        return $this->db->insert_id();

    }

    public function delete_temp($id, $session_id){
        $this->db->query('DELETE FROM ph_cust_temp_upload_files WHERE id = ' . $id . ' AND session_id = ' . $this->db->escape($session_id));
    }


    public function get_temp_images($session_id){
        $result = $this->db->query("SELECT * FROM ph_cust_temp_upload_files WHERE session_id = " . $this->db->escape($session_id));

        if ($result->num_rows()) {
            return $result->result_array();

        } else {
            return false;

        }

    }

    public function recalculate_order_value($order_id){


        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product 
            WHERE order_id = " . $this->db->escape($order_id));

        if ($result->num_rows()){

            $totalOrderValue = 0;
            foreach($result->result_array() as $products){
                $totalOrderValue = $totalOrderValue + $products['total'];

            }

            $this->db->query("UPDATE " . DB_PREFIX . "order 
                SET total = " . $this->db->escape($totalOrderValue) . ", actual_total = " . $this->db->escape($totalOrderValue));


            $resultTotal = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total 
                WHERE order_id = " . $this->db->escape($order_id));

                if($resultTotal->num_rows()){

                    $totals = $resultTotal->result_array();

                    $delivery = 0;
                    $discount = 0;

                    foreach($totals as $total){

                        if($total['code'] == 'shipping'){
                            $delivery = $total['value'];
                        }

                        if($total['code'] == 'discount'){
                            $discount = $total['value'];
                        }

                    }


                    $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = " . $totalOrderValue . " WHERE order_id = " . $this->db->escape($order_id) . " AND code = 'sub_total'");

                    $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = " . $delivery . " WHERE order_id = " . $this->db->escape($order_id) . " AND code = 'shipping'");

                    $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = " . ($totalOrderValue + $delivery) . " WHERE order_id = " . $this->db->escape($order_id) . " AND code = 'total'");


                    return array(
                        'sub_total' => $totalOrderValue,
                        'delivery' => $delivery,
                        'discount' => $discount,
                        'total' => (($totalOrderValue + $delivery) - $discount)
                    );

                }else {

                    return array(
                        'sub_total' => 0,
                        'delivery' => 5,
                        'discount' => 0,
                        'total' => 5
                    );    
                }
                


        }else {


            $this->db->query("UPDATE " . DB_PREFIX . "order 
                SET total = '0', actual_total = '0'");


            $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = '0' WHERE order_id = " . $this->db->escape($order_id) . " AND code = 'sub_total'");


            $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = '0' WHERE order_id = " . $this->db->escape($order_id) . " AND code = 'total'");


            return array(
                        'sub_total' => 0,
                        'delivery' => 5,
                        'discount' => 0,
                        'total' => 5
                    );    

        }

    }


    public function add_product($data, $order_id){

        $result = $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET 
        order_id = '" . $order_id . "',
        product_id = '" . $data['product_id'] . "',
        name = '" . $data['name'] . "',
        quantity = '" . $data['quantity'] . "',
        price = '" . $data['price'] . "',
        total = '" . ($data['price'] * $data['quantity']) . "'");

        if($this->db->insert_id() > 0){
            return true;
            
        }else {
            return false;

        }

    }


    public function delete_product($product_id, $order_id){


        $result = $this->db->query("DELETE FROM " . DB_PREFIX . "order_product 
            WHERE product_id = " . $this->db->escape($product_id) . " AND order_id = " . $this->db->escape($order_id));
        return true;

    }


}
