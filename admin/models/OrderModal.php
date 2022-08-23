<?php

require_once APPPATH.'/libraries/api/APIManager.php';

class OrderModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }


	public function createOrder($data){
		$response = $this->order->createOrder($data);
	
		if ($response['success'] == 1) {

			return $response['data'];

		}else{
			return false;
		}

	} 

	public function getOrders($customerId){
		 $response = $this->order->getOrders($customerId);



        if ($response['success'] == 1) {

			$ordersData = $response['data'];
			$error_message = '';


			$ordersArray = array();
			foreach($ordersData as $order){
						
				array_push($ordersArray, array(
					"order_id" => $order['order_id'],
					"date_added" => $order['date_added'],
					"total" => $order['total'],
					"status" => $order['status'],
					"rating" => $order['rating'],
					"internalStatus" => $order['internal_status'],
					"status_code" => $order['status_code'],

				));
			}
        	return $ordersArray ;
        } else {
					$error_message = $response['error'];
        	return false;

        }

	}

	public function getOrderDetails($id,$customerId){
		 $response = $this->order->getOrderDetails($id,$customerId);

	
		 	$products = array();

		  if ($response['success'] == 1) {

		  	foreach($response['data']['products'] as $product){
		  		array_push($products,array(

		  			"product_id" => $product['product_id'],
		  			"order_product_id" => $product['order_product_id'], 
		  			"name" => $product['name'],
		  			"model"=> $product['model'],
		  			"image"=> $product['image'],
		  			"quantity"=> $product['quantity'],
		  			"price"=> $product['price'],
		  			"total"=> $product['total'],
					"currency"=> $response['data']['currency']['symbol_left']

		  		));
		  	}

		  	$newOrderTime = "";
		  	$underProcessTime = "";
		  	$readyForDispatchTime = "";
		  	$dispatchTime = "";
		  	$deliveredTime = "";

		  	foreach($response['data']['histories'] as $history){


		  		if($history['status'] == 'New Order'){
		  			$newOrderTime = $history['date_added'];
		  		}else if($history['status'] == 'Under Process'){
		  			$underProcessTime =$history['date_added'];
		  		}else if($history['status'] == 'Ready for Dispatch'){
		  			$readyForDispatchTime = $history['date_added'];
		  		}else if($history['status'] == 'Dispatch'){
		  			$dispatchTime = $history['date_added'];
		  		}else if($history['status'] == 'Complete'){
		  			$deliveredTime = $history['date_added'];
		  		}




		  	// 	array_push($products,array(

		  	// 		"product_id" => $product['product_id'],
		  	// 		"order_product_id" => $product['order_product_id'], 
		  	// 		"name" => $product['name'],
		  	// 		"model"=> $product['model'],
		  	// 		"image"=> $product['image'],
		  	// 		"quantity"=> $product['quantity'],
		  	// 		"price"=> $product['price'],
		  	// 		"total"=> $product['total'],
					// "currency"=> $response['data']['currency']['symbol_left']

		  	// 	));
		  	}

		  	$discount = 0;$deliveryCharge = 0;$subtotal = 0;

		  	if(sizeof($response['data']['totals'])==3){
		  		$subtotal = $response['data']['totals']['0']['value'];
		  		$deliveryCharge = $response['data']['totals']['1']['value'];

		  	}else{
		  		$subtotal = $response['data']['totals']['0']['value'];
		  		$deliveryCharge = $response['data']['totals']['1']['value'];
		  		$discount = $response['data']['totals']['2']['value'];
		  	}

 
		  	$details = array(

		  		"order_id"=> $response['data']['order_id'],
	  			"customer_id"=> $response['data']['customer_id'],
	  			"firstname"=> $response['data']['firstname'],
	  			"lastname"=> $response['data']['lastname'],
	  			"telephone"=> $response['data']['telephone'],
	  			"shipping_title"=> $response['data']['shipping_title'],
	  			"shipping_address"=> $response['data']['shipping_address'],
	  			"shipping_city"=> $response['data']['shipping_city'],
	  			"currency"=> $response['data']['currency']['symbol_left'],
	  			"order_status_id" => $response['data']['order_status_id'],
	  			"subtotal"=> $subtotal,
	  			"paymentMethod"=> $response['data']['payment_method'],
	  			"paymentCode"=> $response['data']['payment_code'],
	  			"actualPaymentCode"=> $response['data']['actual_payment_code'],
	  			"deliveryCharge"=> $deliveryCharge,
	  			"discount"=> $discount,
	  			"total"=> $response['data']['total'],
	  			"newOrderTime"=> $newOrderTime,
	  			"underProcessTime"=> $underProcessTime,
	  			"readyForDispatchTime"=> $readyForDispatchTime,
	  			"dispatchTime"=> $dispatchTime,
	  			"deliveredTime"=> $deliveredTime,
	  			"products"=> $products,
	  			"histories"=> $response['data']['histories'],

		  	);

		  	return $details;




		  }else {
					$error_message = $response['error'];
        	return false;

        }
	}

	
	public function track($id){
		return $this->order->track($id);
	}


	public function cancelOrder($data, $customerId){
		
	$response =  $this->order->cancelOrder($data, $customerId);
	 if ($response['success'] == 1) {
	 	return $response['data'];
	 }else{
	 	$error_message = $response['error'];
        	return false;
	 }

	}

	public function reOrder($data, $customerId){
		
		$response =  $this->order->reOrder($data, $customerId);
	 if ($response['success'] == 1) {
	 	return $response['data'];
	 }else{
	 	$error_message = $response['error'];
        	return false;
	 }

	}


	public function trackdriver($id){

		 $response =  $this->order->trackdriver($id);

	

        if ($response['success'] == 1) {

			$ordersData = $response['data'];
			$error_message = '';

						
			return array(
					"latitude" => $ordersData['latitude'],
					"longitude" => $ordersData['longitude'],
					"address" => $ordersData['address'],
					"current_latitude" => $ordersData['current_latitude'],
					"current_longitude" => $ordersData['current_longitude'],

				);
	
        } else {
			$error_message = $response['error'];
        	return false;

        }

	}


    public function applyPromo($coupon){

 		$response =  $this->order->applyPromo($coupon);


        if ($response['success'] == 1) {

			$ordersData = $response['data'];
			$error_message = '';
						
			return $ordersData;

        } else {

			throw new \Exception(json_encode($response['error']));
			
        	return false;
        }
    

    }



    public function updateOrder($data,$customerId){

 		$response =  $this->order->updateOrder($data,$customerId);


        if ($response['success'] == 1) {

			$ordersData = $response['data'];
			$error_message = '';
						
			return $ordersData;

        } else {

			throw new \Exception(json_encode($response['error']));
			
        	return false;
        }
    

    }



}


?>
