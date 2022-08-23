<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Feedback extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Reviews";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/reviews',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}



}
