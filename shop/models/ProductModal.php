<?php 

require_once APPPATH.'/libraries/api/APIManager.php';

class ProductModal extends APIManager{


	public function __construct() {
		parent::__construct();

   }


	public function getProductDetails($productId){

		$response = $this->category->getProductDetail($productId);

        if ($response['success'] == 1) {

        	$data = $response['data'];
			$error_message = ''; 


			return array(
				"product_id" => $data['product_id'],
				"name" => $data['name'],
				"sku" => $data['sku'],
				"model" => $data['model'],
				"thumb" => $data['thumb'],
				"price" => $data['price'],
				"special" => $data['special'],
				"price_formated" => $data['price_formated'],
				"description" => $data['description'],
				"details" => $data['details'],
				"upc" => $data['upc'],
				"how_it_work" => $data['how_it_work'],
				"ingredients" => $data['ingredients'],
				"warnings" => $data['warnings'],
				"prescription_required" => $data['prescription_required'],
				"product_leaflet" => $data['product_leaflet'],
				"related" => $data['related'],
				"original_image" => $data['original_image']
			);

		} else {
			$error_message = $response['error'];
			return false;
		} 


	}


	public function getProductsByBrand($brandId,$customerId){

		$response = $this->category->getBrandProducts($brandId,$customerId);


        if ($response['success'] == 1) {

        	$data = $response['data'];
			$error_message = ''; 
			
			$brand = "";
			
			$products = array();

			foreach($data as $product){
				
				$brand = $product['manufacturer'];
				
				array_push($products,array(
				"product_id" => $product['product_id'],
				"name" => $product['name'],
				"sku" => $product['sku'],
				"model" => $product['model'],
				"thumb" => $product['thumb'],
				"price" => $product['price'],
				"special" => $product['special'],
				"price_formated" => $product['price_formated'],
				"description" => $product['description'],
				"details" => $product['details'],
				"quantity_size" => $product['upc'],
				"prescription_required" => $product['prescription_required'],
				"original_image" => $product['original_image']
			));
			
			}


			return array("brand"=>$brand,"products"=>$products) ;

		} else {
			$error_message = $response['error'];
			return false;
		} 


	}


	public function suggestProduct($data,$customerId){

		$response = $this->product->suggestProduct($data,$customerId);

		 if ($response['success'] == 1) {

        	return $response['data'];

		} else {
			$error_message = $response['error'];
			return false;
		} 

	}


}


?>