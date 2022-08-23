<?php

if(!function_exists('__')){

	function __($param){

		$CI = &get_instance();

		return $CI->lang->line($param);
	}



	function getUrl($params){
		$url = "";
		foreach($params as $key => $value){

			if(URL_WRITE_ALLOW){
				$url = $url. $key . "=" . $value . "&";
			}else{
				$url = $url. $value. "/";
			}
		}

		return $url;
	}



	function saveCustomer($customer){
		$CI = get_instance();

		$CI->session->set_userdata('customer', $json);
	}

	function getCustomer(){
		$CI = get_instance();
		$customer = $CI->session->userdata('customer');
		return $customer;
	}



	function getCustomerId($type){

		$CI = get_instance();

		if($type == "internal"){

			$data = $CI->session->userdata('customerId');

		}else{

			$data = $CI->session->userdata('customerExternalId');
		}

		return  $data;
	}



	function saveDefaultAddress($address){
		$CI = get_instance();
		$CI->session->set_userdata('default_address', $address);
	}

	function getDefaultAddress($address){
		$CI = get_instance();
		$CI->session->set_userdata('default_address', $address);
	}





	function getWishlist(){

		$CI = get_instance();

		$wishlist = $CI->input->cookie('wishlist', TRUE);

		$wishlist  = json_decode($wishlist , true);

		return $wishlist;

	}

	function addToWishlist($product){

		$CI = get_instance();

		if(empty(getWishlist())){

			$wishlist = array();

			array_push($wishlist, $product);

			$json = json_encode($wishlist);

			$CI->input->set_cookie('wishlist', $json, 3600*5);

		}else{

			$previousWishlist = getWishlist();

			array_push($previousWishlist, $product);

			$json = json_encode($previousWishlist);

			$CI->input->set_cookie('wishlist', $json , 3600*5);
		}

	}

	function removeWishlist($index){

		$CI = get_instance();

		$previousWishlist = getWishlist();

		unset($previousWishlist[$index]);

		$json = json_encode($previousWishlist);

		$CI->input->set_cookie('wishlist', $json , 3600*5);
	}



	function __saveStoreSettings($data){

		$CI = &get_instance();
		$CI->session->set_userdata("store-settings",$data);
	}

	function __getStoreSettings(){

		$CI = &get_instance();
		return $CI->session->userdata('store-settings');
	}

	function __allowPermission($feature){

		$CI = &get_instance();
		$allow = false;
		foreach (__getPartnerSettings()['settings'] as $setting) {

			if($setting['setting_key'] == $feature && $setting['setting_value'] == 'yes'){
				$allow = true;
				break;
			}
		}

		return $allow;
	}



	function getCategoriesJson(){

			$jsonFile = file_get_contents("http://dashboard.800pharmacy.ae/menus.json");
			$categories = json_decode($jsonFile);

		return 	$categories;
	}
	function __storeGuestPersonalInfo($firstName,$lastName,$phone,$email){

		$CI = &get_instance();
		$CI->input->set_cookie('first_name', $first_name, 3600*2);
		$CI->input->set_cookie('last_name', $last_name, 3600*2);
		$CI->input->set_cookie('phone', $phone, 3600*2);
		$CI->input->set_cookie('email', $email, 3600*2);
	}

	function __deleteGuestData(){

		$CI = &get_instance();

 		delete_cookie("first_name");
        delete_cookie("last_name");
        delete_cookie("phone");
        delete_cookie("email");
		deleteCheckoutData();


	}

	function deleteCheckoutData()
	{
			delete_cookie("address_id");
			delete_cookie("address_title");
			delete_cookie("closest_area");
			delete_cookie("address_unit");
			delete_cookie("address_street");
			delete_cookie("address_extra_directions");
			delete_cookie("address_lat");
			delete_cookie("address_lng");
			delete_cookie("address_apartment");
			delete_cookie("address_fullAddress");
			delete_cookie("payment_code");
			delete_cookie("payment_method");
			delete_cookie("delivery_date");
			delete_cookie("delivery_time");
			delete_cookie("delivery_day");
	}

	function __getItems($cartType){

		$CI = &get_instance();

		if($cartType == 'cart'){

			$cartItems = array();

			foreach ($CI->cart->contents() as $item) {
				if($item['isCartItem'] == '1'){
					array_push($cartItems,$item);
				}
			}

			return $cartItems;

		}

	}

	function __cartBill(){

		$CI = &get_instance();
		$subTotal = 0.0;
		$vat = 5.0; $deliveryFee = 5.75;

		foreach ($CI->cart->contents() as $item) {
			if($item['isCartItem'] == '1'){
				$subTotal = $subTotal + ((float)$item['price'] * (int)$item['qty']);
			}
		}

		// $totalVat = $subTotal * ($vat/100);
		if($subTotal < 1){
			$deliveryFee = 0;
		}

		$total = $subTotal + $deliveryFee;
		$totalVat = 0.0;
		$cartList['subTotal'] = number_format((float)$subTotal, 2, '.', '');
		$cartList['vat'] = number_format((float) $totalVat, 2, '.', '');
 		$cartList['deliveryFee'] = number_format((float)$deliveryFee, 2, '.', '');
 		$cartList['total'] =number_format((float) $total, 2, '.', '');

		return $cartList;

	}

/* sreenath - send sms */
	function trigger_sms($mobile, $sms, $auto = 1){


		$apiCall = "http://smartcall.ae/incontactclientapiv2/submithttp.aspx?MessageText=" . urlencode($sms) . "&MobileNumber=" . str_replace("+", "", $mobile) . "&UserId=" . SMS_USERNAME . "&Password=" . SMS_PASSWORD .  "&unicode=0";

			$response = file_get_contents($apiCall);

	}
/* sreenath - send sms */

function meta($page,$array = array()) {
			 $meta = '<meta charset="utf-8">';
			 switch ($page) {
					 case 'home':
					     $meta .= '<title>800 Pharmacy</title>';
							 $meta .= '<meta name="description" content="800 Pharmacy">';
							 $meta .= '<meta name="keywords" content="Lowest Price For Beauty Products,Best Offer In Town For Beauty Care Products, Trusted &amp; Quality Brands Only We Sell,
Best Offers In The Town, Sports Nutrition, Beauty Care, Mother &amp; Baby Products, Proteins, Aminos, Vitamins, Multi Vitamins, Minerals, Preventive Care, Home Health Care, Personal Care, Fitness, Wellness, Largest Pharmacy In UAE, Highest Collection Of Products, Lowest Price For Most Items In The Country">';
							 $meta .= '<meta name="robots" content="INDEX,FOLLOW" />';
							 $meta .= '<meta name="title" content="800 Pharmacy | We are Online | Order Now" />';
							 $meta .= '<meta property="og:description" content="Leading pharmacy group in UAE www.800pharmacy.ae" />';
							 $meta .= '<meta property="og:title" content="800Pharmacy" />';
							 $meta .= '<meta name="author" content="800Pharmacy" />';
							 $meta .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
							 $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
							 $meta .= '<meta name="twitter:title" content="" />';
							 $meta .= '<meta name="twitter:description" content="Leading pharmacy group in UAE" />';
							 $meta .= '<meta property="og:image" content="">';
							 $meta .= '<meta property="og:url" content="">';
							 break;
							 case 'product':
							     $meta .= '<title>'.$array['name'].'</title>';
									 $meta .= '<meta name="description" content="'.$array['description'].'">';
									 $meta .= '<meta name="keywords" content="'.$array['meta_keyword'].'">';
									 $meta .= '<meta name="robots" content="INDEX,FOLLOW" />';
									 $meta .= '<meta name="title" content="'.$array['meta_title'].'" />';
									 $meta .= '<meta property="og:description" content="'.$array['meta_description'].'" />';
									 $meta .= '<meta property="og:title" content="'.$array['name'].'" />';
									 $meta .= '<meta name="author" content="800Pharmacy" />';
									 $meta .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
									 $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
									 $meta .= '<meta name="twitter:title" content="'.$array['meta_title'].'" />';
									 $meta .= '<meta name="twitter:description" content="'.$array['meta_description'].'" />';
									 $meta .= '<meta property="og:image" content="'.$array['original_image'].'">';
									 $meta .= '<meta property="og:url" content="www.800pharmacy.ae">';
									 break;
									 case 'category':
									     $meta .= '<title>'.$array['name'].'</title>';
											 $meta .= '<meta name="description" content="'.$array['description'].'">';
											 $meta .= '<meta name="keywords" content="'.$array['meta_keyword'].'">';
											 $meta .= '<meta name="robots" content="INDEX,FOLLOW" />';
											 $meta .= '<meta name="title" content="'.$array['meta_title'].'" />';
											 $meta .= '<meta property="og:description" content="'.$array['meta_description'].'" />';
											 $meta .= '<meta property="og:title" content="'.$array['name'].'" />';
											 $meta .= '<meta name="author" content="800Pharmacy" />';
											 $meta .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
											 $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
											 $meta .= '<meta name="twitter:title" content="'.$array['meta_title'].'" />';
											 $meta .= '<meta name="twitter:description" content="'.$array['meta_description'].'" />';
											 $meta .= '<meta property="og:image" content="'.$array['original_image'].'">';
											 $meta .= '<meta property="og:url" content="www.800pharmacy.ae">';
											 break;
					 case 'contact_us':
					 $meta .= '<meta name="description" content="800 Pharmacy">';
					 $meta .= '<meta name="keywords" content="Lowest Price For Beauty Products,Best Offer In Town For Beauty Care Products, Trusted &amp; Quality Brands Only We Sell,
Best Offers In The Town, Sports Nutrition, Beauty Care, Mother &amp; Baby Products, Proteins, Aminos, Vitamins, Multi Vitamins, Minerals, Preventive Care, Home Health Care, Personal Care, Fitness, Wellness, Largest Pharmacy In UAE, Highest Collection Of Products, Lowest Price For Most Items In The Country">';
					 $meta .= '<meta name="robots" content="INDEX,FOLLOW" />';
					 $meta .= '<meta name="title" content="800 Pharmacy | We are Online | Order Now" />';
					 $meta .= '<meta property="og:description" content="Leading pharmacy group in UAE www.800pharmacy.ae" />';
					 $meta .= '<meta property="og:title" content="800Pharmacy" />';
					 $meta .= '<meta name="author" content="800Pharmacy" />';
					 $meta .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
					 $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
					 $meta .= '<meta name="twitter:title" content="" />';
					 $meta .= '<meta name="twitter:description" content="Leading pharmacy group in UAE" />';
					 $meta .= '<meta property="og:image" content="">';
					 $meta .= '<meta property="og:url" content="">';
							 break;
					 default:
					 $meta .= '<meta name="description" content="800 Pharmacy">';
					 $meta .= '<meta name="keywords" content="Lowest Price For Beauty Products,Best Offer In Town For Beauty Care Products, Trusted &amp; Quality Brands Only We Sell,
Best Offers In The Town, Sports Nutrition, Beauty Care, Mother &amp; Baby Products, Proteins, Aminos, Vitamins, Multi Vitamins, Minerals, Preventive Care, Home Health Care, Personal Care, Fitness, Wellness, Largest Pharmacy In UAE, Highest Collection Of Products, Lowest Price For Most Items In The Country">';
					 $meta .= '<meta name="robots" content="INDEX,FOLLOW" />';
					 $meta .= '<meta name="title" content="800 Pharmacy | We are Online | Order Now" />';
					 $meta .= '<meta property="og:description" content="Leading pharmacy group in UAE www.800pharmacy.ae" />';
					 $meta .= '<meta property="og:title" content="800Pharmacy" />';
					 $meta .= '<meta name="author" content="800Pharmacy" />';
					 $meta .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
					 $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
					 $meta .= '<meta name="twitter:title" content="" />';
					 $meta .= '<meta name="twitter:description" content="Leading pharmacy group in UAE" />';
					 $meta .= '<meta property="og:image" content="">';
					 $meta .= '<meta property="og:url" content="">';
							 break;
			 }
			 return $meta;
	 }

}
