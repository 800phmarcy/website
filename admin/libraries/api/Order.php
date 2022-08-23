<?php
require_once APPPATH . '/libraries/api/API.php';

class Order extends API
{

    private $url = array();

    public function __construct(){

        $this->url = array(

            'get_orders'   => 'order/orders',
            'create_order' => 'confirmorder/confirm',
            'temp_image'   => 'confirmorder/upload_temp',
            'delete_temp'   => 'confirmorder/delete_temp',
            'track' => 'orders&m=track',
            'track_driver' => 'task/task_location',
            'cancel_order' => 'rest_api/postorderhistory',
            'reorder' => 'order/generate_reorder',
            'update_order' => 'order/edit',
            'coupon' => 'cart/coupon'

        ); 
    }

    public function createOrder($data){

        $response = $this->callEndpoint('POST', $this->url['create_order'], $data,false,$data['customer_id']);
        
        return $response;
    }

    public function getOrders($customerId){

        $orders = $this->callEndpoint('GET', $this->url['get_orders'], false,false,$customerId);

        return $orders;

    }

    public function getOrderDetails($id,$customerId){

        $url = $this->url['get_orders'].'&id='.$id;
        $orders = $this->callEndpoint('GET', $url, false,false,$customerId);

        return $orders;

    }


    public function getOrder($order_id){

        $order = $this->callEndpoint('GET', $this->url['get_orders'] . '&id=' . $order_id, false);
        return $order;

    }

     public function cancelOrder($data, $customerId){

        $order = $this->callEndpoint('POST', $this->url['cancel_order'], $data, true,$customerId);
        return $order;

    }

    public function reOrder($data, $customerId){

        $order = $this->callEndpoint('POST', $this->url['reorder'], $data, false,$customerId);
        return $order;

    }

    public function updateOrder($data, $customerId){

        $order = $this->callEndpoint('POST', $this->url['update_order'], $data, false,$customerId);
        return $order;

    }

     public function createTemp($data){
      
        $response = $this->callEndpoint('POST', $this->url['temp_image'], $data,false,0,true);
     
        return $response;
    }


    public function deleteTemp($data){

        $response = $this->callEndpoint('GET', $this->url['delete_temp'], $data);
        return $response;
    }

    public function track($order_id){

        $details = $this->callEndpoint('GET', $this->url['track'] . '&id=' . $order_id, false);
        return $details;

    }

    public function trackdriver($order_id){

        $details = $this->callEndpoint('GET', $this->url['track_driver'] . '&id=' . $order_id, false);
        return $details;

    }


   
    public function applyPromo($coupon){

        $response = $this->callEndpoint('POST', $this->url['coupon'],array("coupon"=>$coupon));
        return $response;
    }


}
