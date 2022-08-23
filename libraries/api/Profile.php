<?php
require_once(APPPATH . '/libraries/api/API.php');

class Profile extends API
{


	private $url = array();

	function __construct(){

		$this->url = array(
			      'family_members' => 'account/members',
			      'family_member_details' => 'account/member',
			      'add_family_member' => 'account/addfamily',
			      'update_family_member' => 'account/editfamily',
			      'delete_family_member' => 'account/deletefamilymember',
				'address' => 'account/address',
					'default_address' => 'account/defaultaddress',
					'get_customer_profiles' => 'account/customer',
					'upload_documents' => 'account/updatedocuments',

        );

	}

	public function getProfile($customerId){

		$data = array("id" => $customerId);
		$url = $this->url['get_customer_profiles'];

		$response = $this->callEndpoint('GET', $url, $data,false,0);

		return $response;
	}


	public function getFamilyMembers($data){

    $response = $this->callEndpoint('GET', $this->url['family_members'], $data,false,0);

    return $response;
	}

	public function getFamilyMemberDetails($memberId,$customerId){
		$url =  $this->url['family_member_details']."&id=".$memberId;
    	$response = $this->callEndpoint('GET', $url, false,false,$customerId);

    return $response;
	}

	public function addFamilyMember($data,$customerId){

    $response = $this->callEndpoint('POST', $this->url['add_family_member'], $data,false,$customerId,true);

    return $response;
	}

	public function updateFamilyMember($data,$customerId){

    $response = $this->callEndpoint('POST', $this->url['update_family_member'], $data,false,$customerId,true);

    return $response;
	}

	public function deleteFamilyMember($data,$customerId){

    $response = $this->callEndpoint('GET', $this->url['delete_family_member'], $data,false,$customerId);

    return $response;
	}

	public function addAddress($data,$customer_id){

    $response = $this->callEndpoint('POST', $this->url['address'], $data,false, $customer_id);

    return $response;
	}

	
	public function editAddress($data,$customerId){
		
		$url = $this->url['address']."&id=".$data['address_id'];
    	$response = $this->callEndpoint('PUT', $url, $data,false, $customerId,false);

    return $response;
	}
	public function deleteAddress($data){


    $response = $this->callEndpoint('DELETE', $this->url['address'],array('id'=>$data),false, false);

    return $response;
	}
	public function defaultAddress($data){

    $response = $this->callEndpoint('POST', $this->url['default_address'], array('address_id'=>$data),false, false);

    return $response;
	}
	public function getAddress($data){
 

    $response = $this->callEndpoint('GET', $this->url['address'], false,false,$data);

    return $response;
	}

	public function getAddressById($data,$customerId){
 

    $response = $this->callEndpoint('GET', $this->url['address'], $data,false,$customerId);

    return $response;
	}

	public function uploadDocuments($data,$customerId){
 

    $response = $this->callEndpoint('POST', $this->url['upload_documents'], $data,false,$customerId,true);

    return $response;
	}






}
