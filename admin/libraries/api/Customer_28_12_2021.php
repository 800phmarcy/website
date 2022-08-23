<?php
require_once(APPPATH . '/libraries/api/API.php');

class Customer extends API
{


	private $url = array();

	function __construct(){

		$this->url = array(
            'get_customers' => 'customers',
            'register_customer' => 'customers&m=register',
            'login_customer' => 'customers&m=login',
            'check_auth_customer' => 'customers&m=checkAUTH',
			'get_customer_profiles' => 'customers&m=profiles',
			'update_profile' => 'customers&m=profiles',
			'forgot_password' => 'customers&m=forgot',
			'logout_customer' => 'customers&m=logout',
			'getcustomerbyemail' => 'customers&m=getcustomerbyemail',
			'set_otp' => 'customers&m=set_otp',
			'checkcode' => 'customers&m=checkcode',
			'contact' => 'customers&m=contact',
			'edit_password' => 'customers&m=edit_password'
        );

	}


	public function getCustomers(){

		$customers = $this->callEndpoint('GET', $this->url['get_customers'], false, $this->headers);
		return $customers;
	}

	public function login($email, $password,$skipAuth){

		$data =  array(
			"username"      => $email,
			"password"   => $password,
			"skip"   => $skipAuth
		);

		$get_data = $this->callEndpoint('POST', $this->url['login_customer'], $data);

		return $get_data;
	}

	public function checkAUTH($customerId, $code){

		$data =  array(
			"customer_id"      => $customerId,
			"code"   => $code
		);

		$get_data = $this->callEndpoint('POST', $this->url['check_auth_customer'], $data);

		return $get_data;
	}

	public function register($first_name, $last_name, $email, $password, $contact_number){



		$data =  array(
			"first_name"        => $first_name,
			"last_name"         => $last_name,
			"email"             => $email,
			"password"          => $password,
			"confirm_password"  => $password,
			"contact_number"    => $contact_number
		);


		$response = $this->callEndpoint('POST', $this->url['register_customer'], $data);

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

		$response = $this->callEndpoint('POST', $this->url['forgot_password'], $data);

		return $response;
	}

	public function contact($data){
		$response = $this->callEndpoint('POST', $this->url['contact'], $data);

		return $response;
	}

	public function updateProfile($data){

		$response = $this->callEndpoint('POST', $this->url['update_profile'], $data);

		return $response;
	}


	public function logOut($email){

		$data =  array(
			"email"   => $email
		);

		$response = $this->callEndpoint('POST', $this->url['logout_customer'], $data);

		return $response;
	}

	public function getcustomerbyemail($email){

		$data =  array(
			"email"   => $email
		);

		$response = $this->callEndpoint('POST', $this->url['getcustomerbyemail'], $data);

		return $response;
	}
	public function set_otp($id){

		$data =  array(
			"id"   => $id
		);

		$response = $this->callEndpoint('POST', $this->url['set_otp'], $data);

		return $response;
	}
	public function edit_password($email,$password){

		$data =  array(
			"email"   => $email,
			"password"  => $password
		);

		$response = $this->callEndpoint('POST', $this->url['edit_password'], $data);

		return $response;
	}
	public function checkcode($email,$code){

		$data =  array(
			"email"   => $email,
			"code"   => $code
		);

		$response = $this->callEndpoint('POST', $this->url['checkcode'], $data);

		return $response;
	}
}
