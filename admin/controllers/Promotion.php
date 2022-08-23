<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Promotion extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function discounts(){


			$data['pageTitle'] = "Discounts";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/discounts',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


	public function coupons(){

			$data['pageTitle'] = "Coupons";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/coupons',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));

	}

	

}
