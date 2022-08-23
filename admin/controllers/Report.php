<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Report extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Sales Report";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/sales-report',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


	public function stocksReport(){


			$data['pageTitle'] = "Stocks Report";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/stocks-report',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


}
