<?php

require_once APPPATH.'/libraries/api/APIManager.php';

class AddressModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }


	public function getAreas(){
		$response = $this->area->getAreas();
    $areasArray = array();
			if ($response['success'] == 1) {

			$areasArray = $response['data'];
			$error_message = '';
					return $areasArray ;
				} else {
					$error_message = $response['error'];
					return false;

				}
	}

	public function getProfile($customer_id){
		$response = $this->profile->getProfile($customer_id);
		$customerArray = array();
			if ($response['success'] == 1) {

			$customerArray = $response['data'];
			$error_message = '';
					return $customerArray ;
				} else {
					$error_message = $response['error'];
					return false;

				}
	}

	public function addAddress($post,$customer_id){

		$response = $this->profile->addAddress($post,$customer_id);
		
		$addressArray = array();
			if ($response['success'] == 1) {

			$addressArray = $response['data'];
			$error_message = '';
					return $addressArray ;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}
	public function editAddress($post,$address_id){

		$response = $this->profile->editAddress($post,$address_id);
		$addressArray = array();
			if ($response['success'] == 1) {

			$addressArray = $response['data'];
			$error_message = '';
					return $addressArray ;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}

	public function updateAddress($data,$customerId){



		$response = $this->profile->editAddress($data,$customerId);
		


		$addressArray = array();
			if ($response['success'] == 1) {

			$addressArray = $response['data'];
			$error_message = '';
					return $addressArray ;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}


	public function deleteAddress($data){

		$response =  $this->profile->deleteAddress($data);
		return $response;
	}

	public function setDefaultAddress($data){

		$response = $this->profile->defaultAddress($data);
		return $response;
	}

	public function getAddressById($data,$customerId){

		$response =  $this->profile->getAddressById($data,$customerId);

		if ($response['success'] == 1) {

		$datas = $response['data'];

		$error_message = '';


			return $datas;
			
		
			} else {
				$error_message = $response['error'];
				return false;

			}
	}

	public function getAddress($data){

		$response =  $this->profile->getAddress($data);

		if ($response['success'] == 1) {

		$datas = $response['data'];

		$error_message = '';


		$addressArray = array();
		if($datas && $datas['addresses'])
		{
			foreach($datas['addresses'] as $address){

				array_push($addressArray, array(
					"address_id" => (int)$address['address_id'],
					"customer_id" => (int)$address['customer_id'],
					"firstname" =>   $address['firstname'],
					"lastname" => $address['lastname'],
					"title" => $address['title'],
					"address" => $address['address'],
					"postcode" => (int)$address['postcode'],
					"city" => $address['city'],
					"zone_id" => (int)$address['zone_id'],
					"zone" => $address['zone'],
					"zone_code" => (int)$address['zone_code'],
					"country_id" => (int)$address['country_id'],
					"country" => $address['country'],
					"iso_code_2" => $address['iso_code_2'],
					"address_format" => $address['address_format'],
					"lat" => (float)$address['lat'],
					"lng" => (float)$address['lng'],
					'area_id' => (int)$address['area_id'],
					'default_address' => $address['default_address'],
					'street' => $address['street'],
					'house_building_no'=> $address['house_building_no'],
					'apartment' => $address['apartment'],
          'extra_direction' => $address['extra_direction'],
					'default' => $address['default']
				));
			}
		}

				return $addressArray ;
			} else {
				$error_message = $response['error'];
				return false;

			}
	}


}


?>
