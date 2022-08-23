<?php

require_once APPPATH.'/libraries/api/Area.php';
require_once APPPATH.'/libraries/api/Order.php';
require_once APPPATH.'/libraries/api/Product.php';
require_once APPPATH.'/libraries/api/Category.php';
require_once APPPATH.'/libraries/api/Session.php';
require_once APPPATH.'/libraries/api/Customer.php';
require_once APPPATH.'/libraries/api/Partner.php';
require_once APPPATH.'/libraries/api/Profile.php';
require_once APPPATH.'/libraries/api/Payment.php';
require_once APPPATH.'/libraries/api/config.php';

class APIManager extends CI_model{

	public static $instance = null;
	public $format = OBJECT_FORMAT;
	public $customer;
	public $session;
	public $area;
	public $order;
  public $product;
	public $category;
  public $partner;
  public $payment;
	public $error_code = 0;
	public $error_message = '';


  	public function __construct($responseFormat = OBJECT_FORMAT) {
  		  $this->format = $responseFormat;
  		  $this->customer = new Customer();
  		  $this->session = new Session();
  		  $this->area = new Area();
  		  $this->order = new Order();
        $this->product = new Product();
  		  $this->category = new Category();
        $this->partner = new Partner();
        $this->payment = new Payment();
				$this->profile = new Profile();

  	}

  	 public static function getInstance(){
    	if (self::$instance == null){
      		self::$instance = new APIManager();
    	}

    	return self::$instance;
  	}

}



?>
