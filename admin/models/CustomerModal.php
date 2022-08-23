<?php

require_once APPPATH.'/libraries/api/APIManager.php';

class CustomerModal extends APIManager{


	public function __construct() {
		parent::__construct();
   }

	 public function session(){

 		 $response = $this->customer->getSession();

         if ($response['success'] == 1) {

 					 $data = $response['data'];
 					 $error_message = '';
         	return array(
         		'session' => $data["session"]
         	);
         } else {
 					$error_message = $response['error'];
         	return false;

         }
 	}



	public function login($data){

		 $response = $this->customer->login($data);



        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        	return array(
        		'customer_id' => $data["customer_id"],
						'store_id' => $data["store_id"],
        		'firstname' => $data["firstname"],
        		'lastname' => $data["lastname"],
						'email' => $data["email"],
						'country_code' => $data["country_code"],
						'telephone' => $data["telephone"],
						'date_of_birth' => $data["date_of_birth"],
						'address_id' => $data["address_id"],
						'emirates_id' => $data["emirates_id"],
						'insurance_card' => $data["insurance_card"],
						'external_customer_id' => $data["external_customer_id"],
						'referrer_key' => $data["referrer_key"],
						'referrer_value' => $data["referrer_value"],
						'referrer_code' => $data["referrer_code"],
						'rewards' => $data["rewards"],
						'tokens' => $data["tokens"],
						'credits' => $data["credits"],
						'redeem_points' => $data["redeem_points"]
        	);
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }
	}

		public function forgotPassword($email){

		 $response = $this->customer->forgotPassword($email);



        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        		return $data;
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }
	}



	public function resetPassword($data){

		$response = $this->customer->resetPassword($data);
		
        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        		return $data;
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }

		return $response;
	}


	public function settings(){

		$response = $this->customer->settings();
		$data = $response['data'];
				if ($response['success'] == 1) {
					$error_message = '';
					$settings = array(
        				    'store_email' => $data["store_email"],
						        'store_name' => $data["store_name"],
        				    'store_address' => $data["store_address"],
        				    'store_phone' => $data["store_phone"],
						        'store_logo' => $data["store_logo"],
        	);


					return $settings;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}



	public function getRewards($data,$customerId){

		$response = $this->customer->getCustomerRewards($data,$customerId);
		$data = $response['data'];


				if ($response['success'] == 1) {
					$error_message = '';

					$points = array();

					foreach($data['points']  as $point){
							array_push($points,array("customer_reward_id"=>$point['customer_reward_id'], "order_id" => $point['order_id'], "description" => $point['description'], "points"=>  $point['points'], "date_added" => $point['date_added'], "amount" => $point['amount'] ));
					}


					$rewards = array(
        				    'points' => $points,
						        'total' => $data["total"],
        				    'cashback' => $data["cashback"]
        			);


					return $rewards;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}


	public function getNotifications($data,$customerId){

		$response = $this->customer->getNotifications($data,$customerId);
		$data = $response['data'];

				if ($response['success'] == 1) {
					$error_message = '';


					$notifications = array();

					foreach($data as $notification){
							array_push($notifications,array("id"=>$notification['id'], "type" => $notification['type'], "customer_id" => $notification['customer_id'], "title"=>  $notification['title'], "notification" => $notification['notification'], "new" => $notification['new'], "time" => $notification['time'] , "today" => $notification['today'], "color" => $notification['color'] ));
					}

					
					return $notifications;
				} else {
					$error_message = $response['error'];
					return false;
				}
	}


	public function logout(){

		$response = $this->customer->logout();

				if ($response['success'] == 1) {
					$error_message = '';
					return $response;

				} else {
					$error_message = $response['error'];
					return false;

				}
	}

	public function emailcheck($data){



		$response = $this->customer->emailcheck($data);

				if ($response['success'] == 1) {
					$error_message = '';
					return $response;

				} else {
					$error_message = $response['error'];
					return false;

				}
	}

	public function register($data){

	

		$response = $this->customer->register($data);
			

        if ($response['success'] == 1) {
          $error_message = '';
					return $response;
        } else {
					$error_message = $response['error'];
        	return false;

        }


	}

		public function uploadDocuments($data,$customerId){

	

		$response = $this->customer->uploadDocuments($data,$customerId);


        if ($response['success'] == 1) {
          $error_message = '';
					return $response;
        } else {
					$error_message = $response['error'];
        	return false;

        }


	}



	public function getProfile($customerId){

		$response = $this->customer->getProfile($customerId);

        if ($response['success'] == 1) {
        	return $response;

        } else {
        	return false;

        }
	}

	public function updateProfile($data,$customerId){

		$response = $this->customer->updateProfile($data,$customerId);



        if ($response['success'] == 1) {
					$error_message = '';
        	return $response;

        } else {
					$error_message = '';
        	return $response['error'];

        }
	}

	public function suggestProduct($data,$customerId){

		$response = $this->customer->suggestProduct($data,$customerId);

	

        if ($response['success'] == 1) {
					$error_message = '';
        	return $response;

        } else {
					$error_message = '';
        	return $response['error'];

        }
	}

	public function homeData($emirate){

		$response = $this->customer->homeData($emirate);



				if ($response['success'] == 1) {
					$error_message = '';
					$data = $response['data'];
					$symptoms = $data['symptoms'];

					$dataarray['symptoms'] =  array(
							'id' => $symptoms['id'],
							'name' => $symptoms['name'],
							'description' => $symptoms['description'],
							'image' =>  $symptoms['image'],
							'original_image' => $symptoms['original_image']);

       				$symp_sub_categories = $data['symptoms']['sub_categories'];

					foreach($symp_sub_categories as $symp_sub_category){
						$dataarray['symptoms']['sub_categories'][] = array(

							'category_id' => $symp_sub_category['category_id'],
				            'parent_id' => $symp_sub_category['parent_id'],
							'name' => $symp_sub_category['name'],
							'image' => $symp_sub_category['image'],
							'original_image' => $symp_sub_category['original_image']
						);
					}


					$categories = $data['categories'];
					$dataarray['categories'] =  array(

							'id' => $categories['id'],
							'name' => $categories['name'],
							'image' => $categories['image'],
							'original_image' => $categories['original_image']
					);

					$sub_categories = $data['categories']['sub_categories'];

					foreach($sub_categories as $sub_category){
						$dataarray['categories']['sub_categories'][] = array(

							'category_id' => $sub_category['category_id'],
							'parent_id' => $sub_category['parent_id'],
							'name' => $sub_category['name'],
							'image' => $sub_category['image'],
							'original_image' => $sub_category['original_image']
						);

					$latest_products = 	$data['latest'];

					foreach($latest_products as $latest_product){

			

						$dataarray['latest'][] = array(

					 		'product_id' => $latest_product['product_id'],
				     		'thumb' => $latest_product['thumb'],
							'name' => $latest_product['name'],
							'quantity' => $latest_product['quantity'],
							'quantity_size' => $latest_product['quantity_size'],
							'price' => $latest_product['price'],
							'price_formated' => $latest_product['price_formated'],
							'prescription_required' => $latest_product['prescription_required'],
							);

					
					}

																				 				}

					$popular_products = 	$data['popular'];

					foreach($popular_products as $popular_product){

						

						$dataarray['popular'][] = array(

					 		'product_id' => $popular_product['product_id'],
				     		'thumb' => $popular_product['thumb'],
							'name' => $popular_product['name'],
							'quantity_size' => $popular_product['quantity_size'],
							'quantity' => $popular_product['quantity'],
							'price' => $popular_product['price'],
							'price_formated' => $popular_product['price_formated'],
							'prescription_required' => $popular_product['prescription_required'],
							);
					
					}

					$manufacturers = 	$data['manufacturers'];

					foreach($manufacturers as $manufacturer){

						$dataarray['manufacturers'][] = array(

					 		'manufacturer_id' => $manufacturer['manufacturer_id'],
				     		'name' => $manufacturer['name'],
							'image' => $manufacturer['image'],
							'original_image' => $manufacturer['original_image'],

							);
					}

					$banners = 	$data['banners'];




					foreach($banners as $banner){

						$dataarray['banners'][] = array(

						 	'banner_id' => $banner['banner_id'],
				            'name' => $banner['name'],
							'banner_type' => $banner['banner_type'],
							'object_id' => $banner['object_id'],
							'image' => $banner['image'],
						);
					}

					$areas = $data['areas'];

					foreach($areas as $area){

						$dataarray['areas'][] = array(

							'area_id' => $area['area_id'],
										'name' => $area['name']
						);
					}

					$dataarray['point_info'] = $data['point_info'];
					$dataarray['point_value'] = $data['point_value'];
					$dataarray['redeem_value'] = $data['redeem_value'];
					$dataarray['emirate'] = $data['emirate'];
				return $dataarray;

				} else {
					$error_message = $response['error'];
					return false;

				}
	}




  public function changePassword($data,$customer)
	{
		$response = $this->customer->changePassword($data,$customer);

        if ($response['success'] == 1) {
					$error_message = '';
        	return $response;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}






	public function getFamilyMembers($data)
	{
		$response = $this->profile->getFamilyMembers(array('id'=> $data));

        if ($response['success'] == 1) {
					$error_message = '';
					$datas = $response['data'];

        	return $datas;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}

		public function getFamilyMemberDetails($data,$customerId)
	{
		$response = $this->profile->getFamilyMemberDetails($data,$customerId);

        if ($response['success'] == 1) {
					$error_message = '';
					$datas = $response['data'];

        	return $datas;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}

	public function addFamilyMember($data, $customerId)
	{




		$response = $this->profile->addFamilyMember($data, $customerId);
        if ($response['success'] == 1) {
					$error_message = '';
					$datas = $response['data'];

        	return $datas;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}

		public function updateFamilyMember($data, $customerId){

		$response = $this->profile->updateFamilyMember($data, $customerId);
        if ($response['success'] == 1) {
					$error_message = '';
					$datas = $response['data'];

        	return $datas;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}


	public function deleteFamilyMember($data, $customerId)
	{


		$response = $this->profile->deleteFamilyMember($data, $customerId);

	
        if ($response['success'] == 1) {
					$error_message = '';
					$datas = $response['data'];

        	return $datas;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}


 	public function subscribe($email){

		$response = $this->customer->subscribe($email);

        if ($response['success'] == 1) {
					$error_message = '';
        	return $response;

        } else {
					$error_message = $response['error'];
        	return false;

        }
	}

	public function getPage($pageType){

		$response = $this->customer->getPage($pageType);

        if ($response['success'] == 1) {
					$error_message = '';
        	return $response;

        } else {
					$error_message = $response['error'];
        	return false;

        }

	}

		public function searchProduct($product){

			$response = $this->customer->searchProduct($product);

        if ($response['success'] == 1) {
					$error_message = '';


					
        	return $response['data'];

        } else {
					$error_message = $response['error'];
        	return false;

        }

	}

		public function contact($data){

		 $response = $this->customer->contact($data);



        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        		return $data;
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }
	}


	public function getPromotionProducts(){

		$response = $this->customer->getPromotionProducts();


        if ($response['success'] == 1) {

        	$data = $response['data'];
			


			return $data;

		} else {
			$error_message = $response['error'];
			return false;
		} 


	}

		public function getPromotions(){

		$response = $this->customer->getPromotions();


        if ($response['success'] == 1) {

        	$data = $response['data'];
			


			return $data;

		} else {
			$error_message = $response['error'];
			return false;
		} 


	}
	public function submitFeedback($data,$customerId){

					 $response = $this->customer->submitFeedback($data,$customerId);



        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        		return $data;
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }

	}

	

		public function deletePaymentMethod($data,$customerId){

		 $response = $this->customer->deletePaymentMethod(array("id"=>$data),$customerId);



        if ($response['success'] == 1) {

					 $data = $response['data'];
					 $error_message = '';
        		return $data;
        } else {
					$error_message = $response['error'];
					throw new \Exception(json_encode($response['error'][0]));
        	return false;

        }
	}


}


?>
