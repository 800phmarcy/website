 <?php
require_once(APPPATH.'/libraries/api/API.php');

class Partner extends API{

  private $urls = array(

    "partner_settings" => "partners"

  );
 

  public function getSettings($partner){

  	  $headers = array('X-Partner-Id:'.$partner);
      $partner = $this->callEndpoint('GET', $this->urls['partner_settings'], false, $headers);
      return $partner;
  
  }



}