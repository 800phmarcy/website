<?php

require_once APPPATH.'/libraries/api/APIManager.php';

class CustomerModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }

	public function login($email,$password,$skipAuth){

		 $response = $this->customer->login($email,$password,$skipAuth);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}

	public function checkAUTH($customerId, $code){

		 $response = $this->customer->checkAUTH($customerId,$code);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}


	public function searchProductByName($keyword){
		$response = $this->product->searchProductByName($keyword);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}


	public function register($data){

		$splittedName = explode(' ', $data['full_name'], 2);

		$firstName = $splittedName[0];

		if(sizeof($splittedName) == 2){
			$lastName = $splittedName[1];
		}else{
			$lastName = "";
		}



		$response = $this->customer->register($data['first_name'],$data['last_name'], $data['email'], $data['password'], $data['phone']);

        // if ($response['success'] == 1) {
        // 	return $response;

        // } else {
        // 	return false;

        // }

        return $response;

	}



	public function getProfile($customerId){

		$response = $this->customer->getProfile($customerId);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}

	public function updateProfile($data){

		$response = $this->customer->updateProfile($data);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}

	public function logout($email){

		$response = $this->customer->logout($email);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}

	public function getcustomerbyemail($email){

		$response = $this->customer->getcustomerbyemail($email);

				if ($response['success'] == 1) {
					return $response['data'];

				} else {
					return false;

				}
	}

	public function set_otp($id){

		$response = $this->customer->set_otp($id);
		if ($response['success'] == 1) {
			return $response['data'];

		} else {
			return false;

		}
	}

	public function edit_password($email,$password){

		$response = $this->customer->edit_password($email,$password);
		if ($response['success'] == 1) {
			return $response['data'];

		} else {
			return false;

		}
	}
	public function checkcode($email,$code){

		$response = $this->customer->checkcode($email,$code);
		if ($response['success'] == 1) {
			return $response['data'];

		} else {
			return false;

		}
	}

	public function contact($data){

		$response = $this->customer->contact($data);
		if ($response['success'] == 1) {
			return $response;

		} else {
			return false;

		}
	}




}


?>
