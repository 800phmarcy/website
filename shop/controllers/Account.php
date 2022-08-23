<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Account extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Login";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/login',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function register(){


			$data['pageTitle'] = "Create Account";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/create-account',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));

	}




}
