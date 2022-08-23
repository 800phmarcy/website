<?php 

require_once APPPATH.'/libraries/api/APIManager.php';

class PaymentModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }

	public function save_ni_token($data){


        $response = $this->payment->savePaymentToken($data);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return $data;

        }
	}

    public function save_payment_transaction($data){
        
        $response = $this->payment->savePaymentTransaction($data);

        if ($response['success'] == 1) {
            return $response;

        } else {
            return $data;

        }
    }

    public function get_order($data){
        
        $response = $this->payment->getOrder($data);

        if ($response['success'] == 1) {
            return $response;

        } else {
            return $data;

        }
    }





}


?>