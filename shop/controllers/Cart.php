<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Cart extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Cart";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/cart',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}



}
