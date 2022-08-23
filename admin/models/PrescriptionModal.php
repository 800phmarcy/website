<?php 

require_once APPPATH.'/libraries/api/APIManager.php';

class PrescriptionModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }



 	function createTemp($data){

          return $this->order->createTemp($data);

    }

    function deleteTemp($data){
          return $this->order->deleteTemp($data);

    }

	function makecurlfile($file){
      $path = realpath($file);
      $actualfile = $path;
      $mime = mime_content_type($file);
      $info = pathinfo($file);
      $name = $info['basename'];
         $timestamp = time();
           $name = $timestamp.$name;
      $output = new CurlFile($actualfile, $mime, $name);
      return $output;
      }





}


?>

