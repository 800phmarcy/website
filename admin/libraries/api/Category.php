<?php 

require_once(APPPATH.'/libraries/api/API.php');


class Category extends API{


    private $url = array();

	function __construct(){

		$this->url = array(
            'get_categories' => 'categories',
            'get_category_by_parent' => 'categories&parent=',
            'get_category_products' => 'rest_api/categorydetails&id=',
            'get_productby_id' => 'rest_api/productprofile&id=',
            'get_products_by_limit' => 'products&limit=',
            'get_products_by_brand' => 'rest_api/products&manufacturer='
        );

	}
 
 	public function getCategories($browseType){
  
        if(empty($browseType)){
            $categories = $this->callEndpoint('GET', $this->url['get_categories'], false);
        }else{
            $url = $this->url['get_category_by_parent'].$browseType;
            $categories = $this->callEndpoint('GET', $url, false);
        }

    	
    	return $categories;

	}

    public function getCategoryDetails($browseType,$categoryId){
  
      
            $url = $this->url['get_category_by_parent'].$browseType."&id=".$categoryId;
            $category= $this->callEndpoint('GET', $url, false);
       

        
        return $category;

    }


	public function getCategoryProducts($categoryId,$startLimit,$endLimit){
        $url = $this->url['get_category_products'].$categoryId."&parent=1&start=".$startLimit."&limit=".$endLimit;
    	$products = $this->callEndpoint('GET', $url, false,true);
    	return $products;

	}

    public function getBrandProducts($brandId,$customerId){
        $url = $this->url['get_products_by_brand'].$brandId;

        $products = $this->callEndpoint('GET', $url, false,true,$customerId);
    
        return $products;

    }

    public function getProductDetail($productId){

        $url = $this->url['get_productby_id'].$productId;

        $productDetail = $this->callEndpoint('GET', $url, false,true);
       
        return $productDetail;

    }

    public function getFeaturedProducts($limit){
        
        $url = $this->url['get_products_by_limit'].$limit;

        $products = $this->callEndpoint('GET', $url, false);
    
        return $products;
    }




}



?>