<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

	public function index(){


			$data['pageTitle'] = "Home";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/index',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function about(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/about',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


	public function shop(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/shop',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

		public function details(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/shop-single',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function sale(){


			$data['pageTitle'] = "Sale";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/sale',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}




}
