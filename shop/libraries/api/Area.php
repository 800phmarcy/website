<?php
require_once(APPPATH.'/libraries/api/API.php');

class Area extends API{

	private $url = array();

	function __construct(){

		$this->url = array(
			'get_areas' => 'address&m=areas',
			'get_addresses' => 'account/address'
		);

	}
	

	public function getAreas(){

		$response = $this->callEndpoint('GET', $this->url['get_areas'], false);
    	return $response;
	
	}

	public function addAddress($data,$customerId){

		$response = $this->callEndpoint('POST', $this->url['get_addresses'], $data,false,$customerId);
    	return $response;
	
	}

	public function updateAddress($data){

		$response = $this->callEndpoint('POST', $this->url['get_addresses'], $data);
    	return $response;
	
	}

	public function getAddresses($data){

		$response = $this->callEndpoint('GET', $this->url['get_addresses'], $data);
    	return $response;
	
	}

	public function deleteAddress($data){

		$response = $this->callEndpoint('POST', $this->url['get_addresses'], $data);
    	return $response;

	}

	public function defaultAddress($data){
		
		$response = $this->callEndpoint('POST', $this->url['get_addresses'], $data);
    	return $response;

	}


}

?>