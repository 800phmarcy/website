<?php
require_once DIR_SYSTEM . 'libraries/rest.php';

class Orders extends Rest
{
// 1204
    // Pak100
    public function __construct()
    {
        parent::__construct();
        $this->validteHeaders();
        $this->load->model('orders_m');
        $this->load->model('addresses_m');
        $this->load->model('customers_m');
        $this->load->model('partners_m');
        $this->load->model('catalog/product_m');
    }

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            try {

                if ($this->input->get('id') !== null) {
                    $recordSet = $this->_getOrder($this->input->get('id'));
                } else {
                    $recordSet = $this->_listOrders();
                }

                $this->json['data'] = $recordSet;
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {

            }

        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();

    }

    private function _getOrder($order_id)
    {

        $result = $this->orders_m->getOrder(array(
            'partner_id' => get_partner_id(),
            'order_id'   => $order_id,
        ));



        if (!$result) {
            throw new Exception(NO_CONTENT, 200);

        } else {

            $addressData = $this->addresses_m->get_address(array(
                'partner_id' => get_partner_id(),
                'address_id' => $result['address_id'],
            ));

            $addresses = array(
                "firstname"         => $addressData["firstname"],
                "lastname"          => $addressData["lastname"],
                "title"             => $addressData["title"],
                "address"           => $addressData["address"],
                "country"           => $addressData["country_name"],
                "street"            => $addressData["street"],
                "house_building_no" => $addressData["house_building_no"],
                "apartment"         => (int) $addressData["apartment"],
                "extra_direction"   => $addressData["extra_direction"],
                "lat"               => $addressData["lat"],
                "lng"               => $addressData["lng"],
                "title"             => $addressData["title"],
                "area"              => $addressData['area_name'],

            );

            $totalData = $this->orders_m->getOrderTotal($result['order_id']);

            foreach ($totalData as $total) {
                $totals[] = array(
                    "code"       => $total['code'],
                    "title"      => $total['title'],
                    "value"      => (float) $total['value'],
                    "sort_order" => (int) $total['sort_order'],
                );
            }

            $activityData = $this->orders_m->getOrderHistories($result['external_order_id']);


            if(count($activityData) > 0){
                foreach ($activityData as $activity) {
                    $activities[] = array(
                        "date_added" => date("d/m/Y H:i:s", strtotime($activity['date_added'])),
                        "status"     => $activity['status'],
                        "comments"   => $activity['comment'],
                        "notify"     => (int) $activity['notify'],
                    );
                }
            }else {
                $activities = [];
            }

            $attachmentData = $this->orders_m->getAttachements($result['external_order_id']);

            if(count($attachmentData)> 0){

                foreach ($attachmentData as $attachment) {
                    $attachments[] = array(
                        "attachment_url"  => LOCAL_ROOT_URL . $attachment['file_name'],
                        "attachment_type" => $attachment['file_type'],
                    );
                }

            }else {
                $attachments = array();
            }

            $orderProducts = $this->product_m->getOrderProducts($result['order_id']);

            if ($orderProducts) {

                $parameters['partner_id'] = get_partner_id();
                $allowThumb               = $this->partners_m->get_partner_setting_key($parameters['partner_id'], "allow_product_thumbs");


                if(count($orderProducts) > 0){
                foreach ($orderProducts as $oProduct) {
                    $orderProductsData[] = array(
                        'product_id'       => (int)$oProduct['product_id'],
                        'sku'              => $oProduct['sku'],
                        'name'             => $oProduct['name'],
                        'quantity'         => (int)$oProduct['quantity'],
                        'price'            => (double)$oProduct['price'],
                        'discount_applied' => (double)$oProduct['discount_applied'],
                        'total'            => (double)$oProduct['total'],
                        'image'            => CATALOG_URL . (($allowThumb == "yes") ? $oProduct['image'] : "none"),
                    );
                }
            }else{
                $orderProductsData = array();

            }
        }else{
            $orderProductsData = array();
        }

            return array(
                "order_id"          => $result['external_order_id'],
                "order_id_internal" => $result['order_id'],
                "firstname"         => $result['first_name'],
                "lastname"          => $result['last_name'],
                "email"             => $result['email'],
                "telephone"         => $result['telephone'],
                "payment_method"    => $result['payment_method'],
                "payment_status"    => $result['payment_status'],
                "payment_reference" => $result['payment_reference'],
                "shipping_method"   => $result['shipping_method'],
                "shipping_lat"      => $result['shipping_lat'],
                "shipping_lng"      => $result['shipping_lng'],
                "comment"           => $result['comment'],
                "currency_code"     => $result['currency_code'],
                "currency_value"    => (float) $result['currency_value'],
                "ip"                => $result['ip'],
                "date_added"        => date("Y-m-d H:i:s", strtotime($result['date_added'])),
                "date_modified"     => date("Y-m-d H:i:s", strtotime($result['date_modified'])),
                "delivery_date"     => date("Y-m-d H:i:s", strtotime($result['delivery_date'])),
                "delivery_time"     => ucwords($result['delivery_time']),
                "rating"            => $result['rating'],
                "insurance"         => (int) $result['withInsurance'],
                "prescription"      => (int) $result['withPrescription'],
                "order_status"      => $result['name'],
                "internal_name"      => $result['internal_name'],
                "total"             => isset($totals) ? $totals : 0,
                "address"           => $addresses,
                "activities"        => $activities,
                "attachments"       => isset($attachments) ? $attachments : array(),
                "products"          => $orderProductsData,
                "erx"               => $result['eRxNumber'],
                "order_status_id"   => $result['order_status_id'],
                "cancel_key"        => $result['key_for_cancel']
            );
        }
    }

    public function activities()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            try {

                if ($this->input->get('id') !== null) {
                    $recordSet = $this->_getActivities($this->input->get('id'));
                } else {
                    throw new Exception(NO_CONTENT, 400);
                }

                $this->json['data'] = $recordSet;
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {
            }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();
    }

    public function create()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $products = 0;

                //Customer informations
                if ($this->input->post('customer_id') == null && (($this->input->post('first_name') === null) || $this->input->post('last_name') === null)) {
                    $error[] = "First and last name is required";
                }

                if ($this->input->post('customer_id') == null && (($this->input->post('contact_number') === null) || strlen($this->input->post('contact_number')) < 9)) {
                    $error[] = "Valid contact number is required";
                }

                // if ($this->input->post('customer_id') == null && ($this->input->post('email') !== null && !filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL))) {
                //     $error[] = "Email is not valid";
                // }

                // if ($this->input->post('customer_id') == null && (empty($_FILES['emirates_id']['tmp_name']) || !is_uploaded_file($_FILES['emirates_id']['tmp_name']))) {
                //     $error[] = "Please upload emirates id";
                // }

                $addressRequired = (($this->partners_m->get_partner_setting_key(get_partner_id(), "address_required") == "no") ? false : true);

                //Address informations
                if ($this->input->post('address_id') == null && (($this->input->post('title') === null && $addressRequired) || ($addressRequired && strlen($this->input->post('title')) < 3))) {
                    $error[] = "Title is required with minimum 3 characters";
                }

                if ($this->input->post('address_id') == null && (($this->input->post('street') === null && $addressRequired) || ($addressRequired && strlen($this->input->post('street')) < 3))) {
                    $error[] = "Street is required with minimum 3 characters";
                }

                if ($this->input->post('address_id') == null && (($this->input->post('building') === null && $addressRequired) || ($addressRequired && strlen($this->input->post('building')) < 1))) {
                    $error[] = "Building is required with minimum 3 characters";
                }

                if ($this->input->post('address_id') == null && (($this->input->post('unit') === null && $addressRequired) || ($addressRequired && strlen($this->input->post('unit')) < 1))) {
                    $error[] = "Unit is required with minimum 1 character";
                }

                if ($this->input->post('address_id') == null && (($this->input->post('area_id') === null && $addressRequired) || ($this->input->post('area_id') == 0 && $addressRequired) || ($addressRequired && $this->input->post('area_id') < 1))) {
                    $error[] = "Area is required";
                }

                //Order detail
                if (($this->input->post('payment_method') !== null) && (strtolower($this->input->post('payment_method')) !== 'cash' && strtolower($this->input->post('payment_method')) != 'card' && strtolower($this->input->post('payment_method')) !== 'online')) {
                    $error[] = "Invalid payment method, default is \"cash\"";
                }

                if (($this->input->post('with_insurance') !== null) && (strtolower($this->input->post('with_insurance')) !== '0' && strtolower($this->input->post('with_insurance')) !== '1')) {
                    $error[] = "Invalid with insurance value, default is \"0\"";
                }

                // if (($this->input->post('with_prescription') !== null) && (strtolower($this->input->post('with_prescription')) !== '0' && strtolower($this->input->post('with_prescription')) !== '1')) {
                //     $error[] = "Invalid with prescription value, default is \"0\"";
                // }

//                if (($this->input->post('erx') === null) && strlen($this->input->post('erx')) < 3) {
                //                    $error[] = "Please enter valid ERX number";
                //                }

                if (($this->input->post('with_insurance') !== null) && ($this->input->post('policy_number') !== null) && strlen($this->input->post('policy_number')) < 3) {
                    $error[] = "Please enter valid policy number";
                }

                if (((empty($_FILES['prescription']['tmp_name']) || !is_uploaded_file($_FILES['prescription']['tmp_name']))) && ($this->input->post('with_prescription') == "1") && ($this->input->post('erx') === null || strlen($this->input->post('erx')) < 3)) {
                    $error[] = "Please upload prescription or pass ERX number";
                }

                if ($this->input->post('products') != null && $this->input->post('products') !== null) {

                    $result = json_decode($this->input->post('products'));

                    if (json_last_error() == 0) {
                        $products = $result;

                    } else {
                        $error[] = "Please provide valid products array";

                    }

                }

                // if (((empty($_FILES['insurance']['tmp_name']) || !is_uploaded_file($_FILES['insurance']['tmp_name']))) && ($this->input->post('with_insurance') == "1") && ($this->input->post('erx') === null || strlen($this->input->post('policy_number')) < 3)) {
                //     $error[] = "Please upload insurance card or pass policy number";
                // }

                if ($this->input->post('customer_id') !== null && strlen($this->input->post('customer_id')) > 10) {

                    $customer = $this->customers_m->validate_customer(get_partner_id(), $this->input->post('customer_id'));

                    if (!$customer) {
                        $error[] = "Invalid customer id";
                    }
                }

                if ($this->input->post('address_id') !== null && strlen($this->input->post('address_id')) > 10) {

                    $address = $this->addresses_m->get_address(array(
                        'partner_id' => get_partner_id(),
                        'address_id' => $this->input->post('address_id'),
                    ));

                    if (!$address) {
                        $error[] = "Invalid address id";
                    }
                }

                if (isset($error) && count($error) > 0) {
                    throw new Exception(json_encode($error), 406);
                }

                if ($this->input->post('customer_id') !== null && $this->input->post('customer_id') > 0) {
                    $customer = $this->customers_m->validate_customer(get_partner_id(), $this->input->post('customer_id'));
                } else {
                    //check if customer exists already
                    $customer = $this->customers_m->mobile_exists($this->input->post('contact_number'));
                }

                if (!$customer) {

                    $customer = $this->customers_m->register(array(
                        'first_name'    => $this->input->post('first_name'),
                        'last_name'     => $this->input->post('last_name'),
                        'mobile_number' => $this->input->post('contact_number'),
                        'email'         => $this->input->post('email'),
                        'partner_id'    => get_partner_id(),
                    ));
                }
                $this->customers_m->check_in_partner_bridget(get_partner_id(), $customer['external_customer_id']);

                //Address sections
                if ($this->input->post('address_id') !== null && $this->input->post('address_id') > 0) {
                    $address = $this->addresses_m->get_address(array(
                        'partner_id' => get_partner_id(),
                        'address_id' => $this->input->post('address_id'),
                    ));
                } else {

                    if (strlen($this->input->post('title')) > 3 && strlen($this->input->post('address')) > 3) {

                        $address = $this->addresses_m->create_address(array(
                            'customer_id'       => $customer['customer_id'],
                            'first_name'        => $this->input->post('first_name'),
                            'last_name'         => $this->input->post('last_name'),
                            'partner_id'        => get_partner_id(),
                            'title'             => $this->input->post('title') !== null ? $this->input->post('title') : "",
                            'address'           => $this->input->post('address') !== null ? $this->input->post('address') : "",
                            'city'              => $this->input->post('city') !== null ? $this->input->post('city') : "",
                            'street'            => $this->input->post('street') !== null ? $this->input->post('street') : "",
                            'house_building_no' => $this->input->post('building') !== null ? $this->input->post('building') : "",
                            'apartment'         => $this->input->post('unit') == "" ? 0 : $this->input->post('unit'),
                            'extra_direction'   => $this->input->post('extra_direction') !== null ? $this->input->post('extra_direction') : "",
                            'area_id'           => $this->input->post('area_id') !== null ? $this->input->post('area_id') : "0",
                            'lat'               => $this->input->post('lat') !== null ? $this->input->post('lat') : "",
                            'lng'               => $this->input->post('lng') !== null ? $this->input->post('lng') : "",
                        ));

                    } else {
                        $address['address_id']          = 0;
                        $address['external_address_id'] = "";
                    }

                }

                //Create order
                $order = $this->orders_m->create_order(array(
                    'partner_token'         => ($this->input->post('_token') === null ? "" : $this->input->post('_token')),
                    'partner_order_id'      => ($this->input->post('partner_order_id') === null ? "" : $this->input->post('partner_order_id')),
                    'change_status_url'     => ($this->input->post('change_status_url') === null ? "" : $this->input->post('change_status_url')),
                    'customer_id'           => $customer['customer_id'],
                    'external_customer_id'  => $customer['external_customer_id'],
                    'address_id'            => $address['address_id'],
                    'firstname'             => $customer['firstname'],
                    'lastname'              => $customer['lastname'],
                    'email'                 => $customer['email'],
                    'telephone'             => $customer['telephone'],
                    'payment_method'        => $this->input->post('payment_method') === null ? "Cash On Delivery" : $this->input->post('payment_method'),
                    'payment_code'          => $this->input->post('payment_method') === null ? "cod" : $this->input->post('payment_method'),
                    'actual_payment_code'   => $this->input->post('payment_method') === null ? "cod" : $this->input->post('payment_method'),
                    'comment'               => $this->input->post('comments'),
                    'date_added'            => date("Y-m-d H:i:s"),
                    'date_modified'         => date("Y-m-d H:i:s"),
                    'with_insurance'        => $this->input->post('with_insurance') === null ? "0" : $this->input->post('with_insurance'),
                    'with_prescriptoin'     => $this->input->post('with_prescription') === null ? "0" : $this->input->post('with_prescription'),
                    'erx_number'            => $this->input->post('erx'),
                    'delivery_date'         => $this->input->post('deliver_date') === null ? date("Y-m-d") : $this->input->post('deliver_date'),
                    'delivery_time'         => $this->input->post('delivery_time') === null ? "asap" : $this->input->post('delivery_time'),
                    'doctor_name'           => $this->input->post('doctor_name') === null ? "" : $this->input->post('doctor_name'),
                    'policy_number'         => $this->input->post('policy_number') === null ? "" : $this->input->post('policy_number'),
                    'insurance_provider'    => $this->input->post('insurance_provider') === null ? "" : $this->input->post('insurance_provider'),
                    'doctor_contact_number' => $this->input->post('doctor_contact_number') === null ? "" : $this->input->post('doctor_contact_number'),
                ));

                //check if products uploaded also
                if ($products != 0) {
                    $this->orders_m->insert_products($order['order_id'], $products);

                }

                $customerId = $customer['customer_id'];

                //Upload emirates id
                if (isset($_FILES['emirates_id']['name'])) {
                    $extension = getExtension($_FILES['emirates_id']['name']);

                    $file_path = UPLOAD_DIR_REGISTERED . 'emiratesid/' . $customerId . '_id.' . $extension;

                    //saving the file
                    if (move_uploaded_file($_FILES['emirates_id']['tmp_name'], $file_path)) {
                        $this->customers_m->update_emirates_id($customerId . '_id.' . $extension, $customerId);
                    }
                }

                //Upload Insurance card
                if (isset($_FILES['insurance']['name'])) {
                    $extension = getExtension($_FILES['insurance']['name']);

                    $file_path = UPLOAD_DIR_REGISTERED . 'insurancecard/' . $customerId . '_insurance.' . $extension;

                    //saving the file
                    if (move_uploaded_file($_FILES['insurance']['tmp_name'], $file_path)) {
                        $this->customers_m->update_insurance_card($customerId . '_insurance.' . $extension, $customerId);
                    }
                }

                //upload documents for server
                if (isset($_FILES['prescription']['name'])) {

                    $file_path = UPLOAD_DIR_REGISTERED . "attachments/" . $_FILES['prescription']['name'];
                    $httpPath  = ATTACHMENTS_IMAGE_URL . $_FILES['prescription']['name'];

                    //saving the file
                    if (move_uploaded_file($_FILES['prescription']['tmp_name'], $file_path)) {
                        $this->orders_m->update_prescription($order['order_id'], $httpPath);
                    }
                }



                //upload temp images to prescription
                if(null !== $this->input->post('session')){

                    $tempImages = $this->orders_m->get_temp_images($this->input->post('session'));

                    if($tempImages){

                        foreach($tempImages as $tImage){
                            $nFileName = str_replace("temp/","", $tImage['file_name']);
                            $this->orders_m->update_prescription($order['order_id'], $nFileName);

                            if(file_exists(ROOT_PHYSICAL_PATH . $tImage['file_name'])){
                                rename(ROOT_PHYSICAL_PATH . $tImage['file_name'], ROOT_PHYSICAL_PATH . $nFileName);
                            }
                        }
                    }

                }







                $this->json['data'] = array(
                    'order_id'    => $order['external_order_id'],
                    'customer_id' => $customer['external_customer_id'],
                    'address_id'  => $address['external_address_id'],
                    'cancel_key'  => $order['key_for_cancel'],
                );
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {
            }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }


    public function updatetoken()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->input->post('order_tracking_id') != "") {
                if ($this->orders_m->updateOrderId($this->input->post('order_tracking_id'))) {
                    $this->json['data'] = array('success' => 1);
                }
            } else {
                $this->json['data'] = array('success' => 0);
            }

        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }



    public function status()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            try {

                if ($this->input->get('id') !== null) {
                    $recordSet = $this->_getOrderStatus($this->input->get('id'));

                } else {
                    throw new Exception(NO_CONTENT, 400);
                }

                $this->json['data'] = $recordSet;
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {
            }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();
    }



    public function update_status(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

          //  try {

                if ($this->input->post('id') !== null) {

                    $recordSet = $this->_updateOrderStatus($this->input->post('id'), $this->input->post('internal_name'));

                    if (!$recordSet) {
                        throw new Exception(NO_CONTENT, 400);

                    } else {

                        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . 'shop/?';

                      $order = $this->orders_m->getOrderById(array('order_id' => $this->input->post('id'), 'partner_id' => get_partner_id()));

                      if($this->input->post('internal_name') == 'under_process' && ($order['address_id'] == '0' || $order['address_id'] == '' || $order['address_id'] == null) )
                      {
                      $url = $root.getUrl(array("c" => "customeraddress", "m" => "index"))."customer_id=".$order['customer_id']."&order_id=".$order['order_id'];
                      $customer = $this->customers_m->_get_customer($order['customer_id']);
                      $ch = curl_init();
                      $timeout = 5;
                      curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
                      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                      curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
                      $data = curl_exec($ch);
                      curl_close($ch);
                        $notificationMessage = str_replace("{CUSTOMER}", $customer['first_name'], ADD_ADDRESS) .$data;
                            
                            
                        trigger_sms($customer['mobile_number'], $notificationMessage);
                      } else if($this->input->post('internal_name') == 'dispatch' )
                      {
                        $url = $root.getUrl(array("c" => "customertracker", "m" => "track"))."order_id=".$order['external_order_id'];
                        $customer = $this->customers_m->_get_customer($order['customer_id']);
                        $ch = curl_init();
                        $timeout = 5;
                        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
                        $data = curl_exec($ch);
                        curl_close($ch);
                          $notificationMessage = str_replace("{CUSTOMER}", $customer['first_name'], ON_DELIVERY) .$data;

                          trigger_sms($customer['mobile_number'], $notificationMessage);
                      }
                        $recordSet = array(
                            'order_id' => $this->input->post('id'),
                            'status'   => $this->input->post('internal_name'),
                        );
                    }

                } else {
                    throw new Exception(NO_CONTENT, 400);
                }

                $this->json['data'] = $recordSet;
            // } catch (Exception $e) {

            //     $this->json['data']  = array();
            //     $this->json['error'] = $e->getMessage();
            //     $this->statusCode    = $e->getCode();
            // } finally {
            // }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();

    }

    public function cancel()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {

                if ($this->input->post('id') !== null && $this->input->post('cancel_key') !== null) {

                    $recordSet = $this->_cancelOrder($this->input->post('id'), $this->input->post('cancel_key'));

                    if (!$recordSet) {
                        throw new Exception(NO_CONTENT, 400);

                    } else {

                        $recordSet = array(
                            'order_id' => $this->input->post('id'),
                            'status'   => $recordSet,
                        );
                    }

                } else {
                    throw new Exception(NO_CONTENT, 400);
                }

                $this->json['data'] = $recordSet;
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {
            }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }

    public function _updateOrderStatus($order_id, $status_internal_name)
    {
        return $this->orders_m->update_order_status($order_id, $status_internal_name);
    }


    public function _cancelOrder($order_id, $cancel_key)
    {
        return $this->orders_m->cancel_order($order_id, $cancel_key);
    }

    public function track()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            try {

                if ($this->input->get('id') !== null) {

                    $recordSet = $this->_getTrack($this->input->get('id'));

                } else {
                    throw new Exception(NO_CONTENT, 400);
                }

                $this->json['data'] = $recordSet;
            } catch (Exception $e) {

                $this->json['data']  = array();
                $this->json['error'] = $e->getMessage();
                $this->statusCode    = $e->getCode();
            } finally {
            }
        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();
    }

    //Private functions

    private function _listOrders()
    {

        /*check limit parameter*/
        if ($this->input->get('customer') !== null && $this->input->get('customer') != "") {
            $parameters['customer'] = $this->input->get('customer');
        }

        /*check limit parameter*/
        if ($this->input->get('limit') !== null && ctype_digit($this->input->get('limit'))) {
            $parameters['limit'] = $this->input->get('limit');
        }

        /*check page parameter*/
        if ($this->input->get('page') !== null && ctype_digit($this->input->get('page'))) {
            $parameters['start'] = $this->input->get('page');
            $parameters['page']  = $this->input->get('page');
        }

        /*check page parameter*/
        if ($this->input->get('page') !== null && ctype_digit($this->input->get('page'))) {
            $parameters['start'] = $this->input->get('page');
            $parameters['page']  = $this->input->get('page');
        }

        /*check sort by parameter*/
        if ($this->input->get('sort') !== null) {

            $parameters['sort'] = $this->input->get('sort');
        }


        if($this->input->get('dispatch') !== null){
            $parameters['dispatch'] = $this->input->get('dispatch');
        }


        if ($this->input->get('orderby') !== null) {
            $parameters['orderby'] = $this->input->get('orderby');
        }

        /*check order id parameter*/
        if ($this->input->get('id') !== null && ctype_digit($this->input->get('id'))) {
            $parameters['id'] = $this->input->get('id');
        }


         /*check page parameter*/
        if ($this->input->get('start_date') !== null && $this->input->get('end_date') !== null) {
            $parameters['start_date'] = $this->input->get('start_date');
            $parameters['end_date']   = $this->input->get('end_date');
        }


        $parameters['partner_id'] = get_partner_id();

        $result = $this->orders_m->get_orders($parameters);

        if (!$result) {
            throw new Exception(NO_CONTENT, 200);
        } else {

            foreach ($result as $value) {
                $records[] = array(
                    "order_id"          => $value['external_order_id'],
                    "order_id_internal" => $value['order_id'],
                    "firstname"         => $value['first_name'],
                    "lastname"          => $value['last_name'],
                    "email"             => $value['email'],
                    "telephone"         => $value['telephone'],
                    "payment_method"    => $value['payment_method'],
                    "payment_status"    => $value['payment_status'],
                    "payment_reference" => $value['payment_reference'],
                    "shipping_method"   => $value['shipping_method'],
                    "shipping_lat"      => $value['shipping_lat'],
                    "shipping_lng"      => $value['shipping_lng'],
                    "comment"           => $value['comment'],
                    "currency_code"     => $value['currency_code'],
                    "currency_value"    => (float) $value['currency_value'],
                    "ip"                => $value['ip'],
                    "date_added"        => date("d/m/Y H:i:s", strtotime($value['date_added'])),
                    "date_modified"     => date("d/m/Y H:i:s", strtotime($value['date_modified'])),
                    "delivery_date"     => date("d/m/Y H:i:s", strtotime($value['delivery_date'])),
                    "delivery_time"     => date("d/m/Y H:i:s", strtotime($value['delivery_time'])),
                    "rating"            => $value['rating'],
                    "insurance"         => (int) $value['withInsurance'],
                    "prescription"      => (int) $value['withPrescription'],
                    "order_status"      => $value['name'],
                    "total"             => (double) $value['total'],
                    "comission"         => $value['commission'],

                );

            }

            return $records;
        }
    }

    private function _getActivities($order_id)
    {

        $activityData = $this->orders_m->getOrderHistories($order_id);

        foreach ($activityData as $activity) {
            $activities[] = array(
                "date_added" => date("d/m/Y H:i:s", strtotime($activity['date_added'])),
                "status"     => $activity['status'],
                "comments"   => $activity['comment'],
                "notify"     => (int) $activity['notify'],
            );
        }
        return $activities;
    }

    private function _getOrderStatus($order_id)
    {
        $activityData = $this->orders_m->getOrderStatus($order_id);
        // print_r($activityData);

        return array(
            'order_id'    => $activityData['external_order_id'],
            'status'      => $activityData['status'],
            'last_update' => date("d/m/Y H:i:s", strtotime($activityData['date_added'])),
            'comments'    => $activityData['comment'],
            'notify'      => (int) $activityData['notify'],
        );

    }

    private function _getTrack($order_id)
    {

        $trackData = $this->orders_m->trackOrder($order_id);
        return $trackData;
    }

    public function test()
    {

        // echo $this->partners_m->get_partner_setting_key(get_partner_id(), "address_required");
        // echo $this->partners_m->get_partner_setting_key(get_partner_id(), "delivery_charges");

    }



    public function upload_temp(){

            //upload documents for server
            if (isset($_FILES['prescription']['name'])) {


                    if(null === $this->input->post('extension')){
                    $file_path = UPLOAD_DIR_REGISTERED . "attachments/temp/" . $_FILES['prescription']['name'];
                    $httpPath  = ATTACHMENTS_IMAGE_URL . 'temp/' . $_FILES['prescription']['name'];


                    }else {
                        $extension = $this->input->post('extension');
                        $file_path = UPLOAD_DIR_REGISTERED . "attachments/temp/" . $_FILES['prescription']['name'].'.'.$extension;
                        $httpPath  = ATTACHMENTS_IMAGE_URL . 'temp/' . $_FILES['prescription']['name'].'.'.$extension;
                    }




                    //saving the file
                    if (move_uploaded_file($_FILES['prescription']['tmp_name'], $file_path)) {
                        $id = $this->orders_m->uploadTempFiles($httpPath, $this->input->post('session'), get_partner_id(), $this->input->post('extension'));

                        $this->json['data'] = array('success' => 1, 'file_path' => LOCAL_ROOT_URL . $httpPath, 'session' => $this->input->post('session'), 'inserted_id' => $id);
                        $this->sendResponse();
                        exit();
                    }
                }

                $this->json['data'] = array('success' => 0);
                $this->sendResponse();


    }

    public function delete_temp(){



        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->orders_m->delete_temp($this->input->get('id'), $this->input->get('session'));
            $this->json['data'] = array('success' => 1);


        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();

    }


    public function addproduct()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            if($this->input->post('id') > 0 && $this->input->post('quantity') > 0 && $this->input->post('order_id') > 0 ){

                $productDetail = $this->product_m->get_product_by_sku($this->input->post('id'));

                $formData = array(
                    'product_id' => $productDetail['product_id'],
                    'name' => $productDetail['name'],
                    'price' => $productDetail['price'],
                    'quantity' => $this->input->post('quantity'),
                );
                $response = $this->orders_m->add_product($formData, $this->input->post('order_id'));


                if($response){

                    $this->json['data'] = array(
                        'id' => $productDetail['product_id'],
                        'name' => $productDetail['name'],
                        'quantity' => $this->input->post('quantity'),
                        'price' => $productDetail['price'],
                        'discount' => 0,
                        'image' => CATALOG_URL . $productDetail['image'],
                        'totals' => $this->orders_m->recalculate_order_value($this->input->post('order_id'))
                    );

                }

            }


        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }




     public function deleteproduct()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            if($this->input->post('id') > 0 && $this->input->post('order_id') > 0 ){

                $response = $this->orders_m->delete_product($this->input->post('id'), $this->input->post('order_id'));

                if($response){

                    $this->json['data'] = array(
                        'result' => 1,
                        'totals' => $this->orders_m->recalculate_order_value($this->input->post('order_id'))
                    );

                }

            }


        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();
    }



}
