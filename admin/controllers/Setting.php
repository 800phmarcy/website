<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Setting extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function profile(){


			$data['pageTitle'] = "Profile";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/profile',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


}
