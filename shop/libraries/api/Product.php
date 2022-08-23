<?php
require_once APPPATH . '/libraries/api/API.php';

class Product extends API
{

    private $url = array();

    public function __construct()
    {
        $this->url = array(
            'get_products'   => 'products',
            'suggest_product' => 'account/suggestproduct'
        );
    }


    public function getProducts(){

        $orders = $this->callEndpoint('GET', $this->url['get_products'], false);
        return $orders;

    }

    public function suggestProduct($data,$customerId){

        $suggestproduct = $this->callEndpoint('POST', $this->url['suggest_product'], $data,false,$customerId);
        return $suggestproduct;

    }


}
