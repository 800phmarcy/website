<?php 

require_once APPPATH.'/libraries/api/APIManager.php';

class CategoryModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }


	public function getCategories($browseType){
		return $this->category->getCategories($browseType);
	}

	public function getCategoryDetails($browseType,$categoryId){
		return $this->category->getCategoryDetails($browseType,$categoryId);
	}

	public function getProducts($categoryId,$startLimit,$endLimit){

		 $response = $this->category->getCategoryProducts($categoryId,$startLimit,$endLimit);

        if ($response['success'] == 1) {

        	$responseData = $response['data']['categories'];
			$error_message = '';
			$products = array();
			$categoryName = '';

			foreach($responseData as $responseCategory){

				if($responseCategory['category_id'] == $categoryId){
					
					$categoryProducts = $responseCategory['products'];
					$categoryName = $responseCategory['name'];

					foreach($categoryProducts as $product){

						if($product['prescription_required'] == 0){

						array_push($products, array(
						
							"product_id" =>   $product['product_id'],
                        	"thumb" => $product['thumb'],
                        	"name" => $product['name'],
                        	"quantity_size" => $product['quantity_size'],
                        	"price" => $product['price'],
                        	"price_formated" => $product['price_formated'],
                        	"prescription_required" => $product['prescription_required'],

						));
}

					}

				}

			}



        	
        	return array('products' => $products, 'category' => $categoryName);


		} else {
			$error_message = $response['error'];
			return false;
		} 

		
	}

	public function getFeaturedProducts($limit){
		return $this->category->getFeaturedProducts($limit);
	}



}


?>