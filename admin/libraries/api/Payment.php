<?php
require_once(APPPATH . '/libraries/api/API.php');

class Payment extends API
{


	private $url = array();

	function __construct(){

		$this->url = array(
			'get_order' => 'payments&m=get_order',
            'save_token' => 'payment/save_ni_token',
            'payment_transaction' => 'payment/save_payment_transaction'
        );

	}


	public function savePaymentToken($data){


		$response = $this->callEndpoint('POST', $this->url['save_token'], $data);

		return $response;
	}

	public function savePaymentTransaction($data){


		$response = $this->callEndpoint('POST', $this->url['payment_transaction'], $data);

		return $response;
	}

	public function getOrder($data){


		$response = $this->callEndpoint('POST', $this->url['get_order'], $data);

		return $response;
	}



}
