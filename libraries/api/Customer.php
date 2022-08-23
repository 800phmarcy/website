<?php
require_once(APPPATH . '/libraries/api/API.php');

class Customer extends API
{


	private $url = array();

	function __construct(){

		$this->url = array(
			      		'get_session' => 'rest_api/session',
			       		'rewards' => 'account/rewards',
			       		'notifications' => 'account/notifications',
			       		'suggest_product' => 'account/suggestproduct',
			      		'login_customer' => 'login/login',
						'logout_customer' => 'logout/logout',
						'exist_customer' => 'register/emailexists',
						'home_data' => 'rest_api/homedata',
						'update_profile' => 'account/updatepersonaldetail',
						'change_password' => 'account/password',
						'forgot_password' => 'account/forgot',
						'settings' => 'login/settings',
            			'register_customer' => 'register/register',
		       			'get_customer_profiles' => 'customers&m=profiles',
		       			'subscribe' => 'rest_api/subscribe',
		       			'pageinformation' => 'rest_api/pageinformation',
        				'searchProduct' => 'rest_api/products',
        				'resetPassword' => 'account/changemobilepassword',
        				'updateDocuments' => 'account/updatedocuments',
        				'contact' => 'account/contact',
        				'promotion_products' => 'rest_api/specials',
        				'promotions' => 'offers/getOffers',
        				'delte_payment_method' => 'account/delete',
        				'submit_feedback' => 'account/feedback',
        	);

	}

	public function getSession(){
	    	$get_data = $this->callEndpoint('GET', $this->url['get_session'], false,true);
	      return $get_data;
		}

	public function getCustomers(){

		$customers = $this->callEndpoint('GET', $this->url['get_customers'], false, $this->headers);
		return $customers;
	}

	public function getCustomerRewards($data,$customerId){
		$rewards = $this->callEndpoint('GET', $this->url['rewards'], $data, false,$customerId);
		return $rewards;
	}

	public function getNotifications($data,$customerId){
		$notifications = $this->callEndpoint('GET', $this->url['notifications'], $data, false,$customerId);
		return $notifications;
	}

	public function suggestProduct($data){
	
		$notifications = $this->callEndpoint('POST', $this->url['suggest_product'], $data, false,0,true);
		return $notifications;
	}

	public function contact($data){
	 
		$response = $this->callEndpoint('POST', $this->url['contact'], $data, false,0,false);
		return $response;
	}

	public function settings(){


		$settings= $this->callEndpoint('GET', $this->url['settings'], false);

		return $settings;
	}

	public function login($data){

		

		$get_data = $this->callEndpoint('POST', $this->url['login_customer'], $data,false,0,false);
		return $get_data;
	}


	public function emailcheck($data){


		$get_data = $this->callEndpoint('POST', $this->url['exist_customer'], $data,false,0);

		return $get_data;
	}

	public function register($data){

		$response = $this->callEndpoint('POST', $this->url['register_customer'], $data,false,0);

	

		return $response;
	}


	public function getProfile($customerId){

		$data = array("id" => $customerId);
		$url = $this->url['get_customer_profiles'];

		$response = $this->callEndpoint('GET', $url, $data);

		return $response;
	}


	public function forgotPassword($email){

		$data =  array(
			"email"    => $email
		);

		$response = $this->callEndpoint('GET', $this->url['forgot_password'], $data);

		return $response;
	}

	public function resetPassword($data){


		$response = $this->callEndpoint('PUT', $this->url['resetPassword'], $data);

		return $response;
	}
 
	public function changePassword($data,$customer){

		$response = $this->callEndpoint('GET', $this->url['change_password'], $data,false,$customer);

		return $response;
	}

	public function updateProfile($data,$customerId){

		
		$response = $this->callEndpoint('GET', $this->url['update_profile'], $data,false,$customerId);

		return $response;
	}


	public function logOut(){

		$response = $this->callEndpoint('POST', $this->url['logout_customer'], false,false,0,false,3510);
		return $response;
	}

	public function homeData($emirate){

		$response = $this->callEndpoint('GET', $this->url['home_data'], false,true,0,false,$emirate);
		return $response;
	}

	public function subscribe($email){
		$response = $this->callEndpoint('POST', $this->url['subscribe'], array('email' => $email),true,0,true);
	
		return $response;
	}

	public function getPage($pageType){
		$response = $this->callEndpoint('GET', $this->url['pageinformation'], array('id' => $pageType),true);
	
		return $response;
	}

	public function searchProduct($product){
		$response = $this->callEndpoint('GET', $this->url['searchProduct'],array("search"=>$product) ,true);
	
		return $response;
	}

	public function uploadDocuments($data, $customerId){
		$response = $this->callEndpoint('POST', $this->url['updateDocuments'],$data,false,$customerId,true);
		
		return $response;
	}

	public function getPromotions(){

		$response = $this->callEndpoint('GET', $this->url['promotions'], false,false);


    	return $response;
	
	}

	
	public function getPromotionProducts(){

		$response = $this->callEndpoint('GET', $this->url['promotion_products'], false,true);


    	return $response; 
	
	}

	public function submitFeedback($data,$customerId){

		$response = $this->callEndpoint('POST', $this->url['submit_feedback'], $data,false,$customerId);

    	return $response;
	
	}

	public function deletePaymentMethod($data,$customerId){

		$response = $this->callEndpoint('GET', $this->url['delte_payment_method'], $data,false,$customerId);

    	return $response;
	
	}



}
