<?php 

require_once APPPATH.'/libraries/api/APIManager.php';

class PartnerModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }

	public function getPartnerSettings($partnerId){
		
        $response = $this->partner->getSettings($partnerId);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}





}


?>