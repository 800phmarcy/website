<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Checkout extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Checkout";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/checkout',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function success(){


		$data['pageTitle'] = "Thank you";
		$data['showFooter'] = true;
		$homepage = $this->load->view('pages/thankyou',$data,true);
		$data['page_content'] = $homepage;
		$this->load->view('main-layout',array('data'=>$data));


	}



}
