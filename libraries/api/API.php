<?php
require_once APPPATH . '/libraries/api/config.php';

abstract class API
{

    public $error    = array();
    public $json     = array("success" => 1, "error" => array(), "data" => array());
    private $headers = array();
    private $baseUrl = "https://staging.800pharmacy.ae/index.php?route=rest/";
    private $feedUrl = "https://staging.800pharmacy.ae/index.php?route=feed/";

    protected function callEndpoint($method, $url, $data=false,$feed = false, $customer=0, $formData=false,$emirate=3510){


        $this->headers = array(

            'X-Oc-Merchant-Id: FfxFIfSTOZo3hQeS7VtdtqMFff7SnIgX',
           'X-Oc-Session:f25d8aff7bf595f514f7359db3',
            'app-version: 1.0.1',
            'currency : aed',
            'language :  en',
            'os-type : web',
            'os-version : 9',
            'udid : 9', 
            'storeid : 1',
            'verify-version : 1',
            'emirate : '. $emirate,
             'customer-id : '. $customer
        );


        $curl = curl_init();

        if($feed){
            $url = $this->feedUrl . $url;
        } else {
            $url = $this->baseUrl . $url;
        }


        switch ($method) {

            case "POST":


            

                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data) {
                    if(!$formData){



                        $body = json_encode($data);

                             curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

                    }else{


                             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    }     
                }else{
                    $body = json_encode($data);

                             curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

                }
                curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));
                break;

            case "PUT":

                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");

                if ($data) {

                     if(!$formData){

                       $body = json_encode($data);
                      
                             curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                    }else{
                             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    }


               
                }




                break;

            default:


               curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET' );
                // if($data){
                //     curl_setopt($curl, CURLOPT_POSTFIELDS, $data );
                // }
            if ($data) {
                $url = sprintf("%s&%s", $url, http_build_query($data));
            }
           ;

        }


        



        // OPTIONS:



        
        curl_setopt($curl, CURLOPT_URL, $url);

        if ($this->headers) {

            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result   = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!$result) {

            die("Connection Failure");

        }





        curl_close($curl);


        try {

            // return $result;

            return $this->_response($result, $httpcode);

        } catch (Exception $e) {

            $this->json['error']   = $e->getMessage();
            $this->json['success'] = 0;
            return $this->json;

        }

        return;
    }

    private function _response($data, $status = 200){
        //header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        // $data->message = $this->_requestStatus($status);
        // if ($status != 200) {
        //     array_push($this->error, $this->_requestStatus($status));
        // }

        $response = json_decode($data, true);



//         if ($response['success'] == 0 && !empty($response['error'])) {

//             array_push($this->error, $response['error']);
//         }


        $this->json['error'] = $response['error'];

        $this->json['success'] = $response['success'];
        $this->json['data']    = $response['data'];

        return $this->json;

    }

    // private function _requestStatus($code)
    // {
    //     $status = array(
    //         200 => 'OK',
    //         401 => 'Unauthorized request',
    //         404 => 'Not Found',
    //         405 => 'Method Not Allowed',
    //         403 => 'Forbidden',
    //         400 => 'No allowed',
    //         406 => 'Internal Server Error',
    //         500 => 'Internal Server Error',
    //     );
    //     return ($status[$code]) ? $status[$code] : $status[500];
    // }

}
