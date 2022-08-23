<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Authentication extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function login(){


			$data['pageTitle'] = "Admin Authentication";
			$data['showFooter'] = false;
			$homepage = $this->load->view('pages/login',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}





}
