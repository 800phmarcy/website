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


	public function orders(){


			$data['pageTitle'] = "Home";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/orders',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function categories(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/categories',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}


	public function products(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/products',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

		public function management(){


			$data['pageTitle'] = "Shop";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/management',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function customers(){


			$data['pageTitle'] = "Sale";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/customers',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}

	public function drivers(){


			$data['pageTitle'] = "Sale";
			$data['showFooter'] = true;
			$homepage = $this->load->view('pages/drivers',$data,true);
			$data['page_content'] = $homepage;
			$this->load->view('main-layout',array('data'=>$data));


	}




}
