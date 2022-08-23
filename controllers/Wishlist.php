<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Wishlist extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Wishlist";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/wishlist',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


}