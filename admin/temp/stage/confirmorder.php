<?php
/**
 * confirm.php
 *
 * Confirm order
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */

require_once(DIR_SYSTEM . 'engine/restcontroller.php');

class ControllerRestConfirmOrder extends RestController
{

    const PAY_RIGHT_NOW = 'pay_right_now';
    const ROUTE_OF_CONFIRMATION = 'route_of_confirmation';
    const AUTOMATIC_PAY_BUTTON_CLICK = 'automatic_pay_button_click';

    private static $paymentMethods = array(
        "authorizenet_aim" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "bank_transfer" => array(
            self::PAY_RIGHT_NOW => false,
            self::ROUTE_OF_CONFIRMATION => "payment/bank_transfer/confirm",
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "cheque" => array(
            self::PAY_RIGHT_NOW => false,
            self::ROUTE_OF_CONFIRMATION => "payment/cheque/confirm",
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "cod" => array(
            self::PAY_RIGHT_NOW => false,
            self::ROUTE_OF_CONFIRMATION => "payment/cod/confirm",
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "free_checkout" => array(
            self::PAY_RIGHT_NOW => false,
            self::ROUTE_OF_CONFIRMATION => "payment/free_checkout/confirm",
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "klarna_account" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "klarna_invoice" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "liqpay" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "moneybookers" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "nochex" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "paymate" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "paypoint" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "payza" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "payu" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "perpetual_payments" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "pp_express" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "pp_pro" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "pp_pro_iframe" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "pp_pro_pf" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "pp_pro_uk" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "pp_standard" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "sagepay" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "sagepay_direct" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "sagepay_us" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "skrill" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "twocheckout" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "worldpay" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_amex" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_banktrans" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_dirdeb" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_directbank" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_giropay" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_ideal" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => false
        ),
        "multisafepay_maestro" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_mastercard" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_mistercash" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_payafter" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_paypal" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_visa" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "multisafepay_wallet" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "bpm" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "pasargad" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
        "ccavenue" => array(
            self::PAY_RIGHT_NOW => true,
            self::ROUTE_OF_CONFIRMATION => null,
            self::AUTOMATIC_PAY_BUTTON_CLICK => true
        ),
    );

    public function confirm()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->saveOrderToDatabase();
            $this->json["data"] = array("success" => "1");

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->confirmOrder();

        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->confirmOrder("payment");

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET", "POST", "PUT");

        }

        $this->sendResponse();
    }

    public function saveOrderToDatabase()
    {

        $this->load->model('checkout/order');
        $this->load->model('account/order');




        if (isset($this->session->data['order_id'])) {
            $order_status_id = 1;
            $cod_status = $this->config->get('payment_cod_order_status_id');

            if (!empty($cod_status)) {
                $order_status_id = $cod_status;
            }
            if (!isset($this->session->data['payment_method']) || empty($this->session->data['payment_method'])) {
                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status_id, isset($this->session->data['comment']) ? $this->session->data['comment'] : '');
            } else {
                $status = $this->model_account_order->getOrderStatusById($this->session->data['order_id']);
                if (empty($status)) {
                    $defaultStatus = $this->config->get("payment_" . $this->session->data['payment_method']['code'] . '_order_status_id');
                    $defaultStatus = is_null($defaultStatus) ? $order_status_id : $defaultStatus;

                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $defaultStatus, isset($this->session->data['comment']) ? $this->session->data['comment'] : '');
                }
            }


            if (isset($this->session->data['order_id'])) {
                $this->json['data']['order_id'] = $this->session->data['order_id'];
                $this->cart->clear();

                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['guest']);
                unset($this->session->data['comment']);
                unset($this->session->data['order_id']);
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);
                unset($this->session->data['totals']);

                if(isset($this->session->data['tracking'])){
                    unset($this->session->data['tracking']);
                }

            }
        } else {
            $this->json["error"][] = "No order in session";
        }
    }

    public function confirmOrder($page = "confirm")
    {
        $this->load->model('account/customer');
        $this->load->model('checkout/order');
        $this->load->model('catalog/product');
        $this->load->model('payment/network');

        $post = $this->getPost();
       // print_r($post);exit();

        $customer = $this->model_account_customer->getCustomer($post['customer_id']);
        $channel = $post['channel'];
        if($channel === 'ios')
        {
          $source_id = 12;
          $os = "ios";
        } else if($channel === 'android')
        {
          $source_id = 12;
          $os = "android";
        } else if($channel === 'website')
        {
          $source_id = 6;
          $os = "website";
        } else {
          $source_id = 1;
          $os = "";
        }
        $data = array(
            'customer_id' => $customer['customer_id'],
            'address_id' => $post['address_id'],
            'firstname' => $customer['firstname'],
            'lastname' => $customer['lastname'],
            'telephone' => $customer['telephone'],
            'payment_method' => $post['payment_method_fullname'],
            'payment_code' => $post['payment_method_fullname'],
            'actual_payment_code' => $post['payment_method_fullname'],
            'payment_status' => $post['payment_status'],
            'payment_reference' => $post['payment_reference'],
            'save_card' => $post['save_card'],
            'comment' => $post['notes'],
            'total_value' => $post['total'],
            'order_status_id' => '1',
            'withInsurance' => $post['with_insurance'] == 'true' ? 1 : 0,
            'withPrescription' => $post['with_prescription'] == 'true' ? 1 : 0,
            'eRxNumber' => $post['erx_number'],
            'delivery_date' => $post['delivery_date'] == "" ? date("Y-m-d") : $post['delivery_date'],
            'delivery_time' => $post['delivery_time'] == "" ? "asap" : $post['delivery_time'],
            'change_required' => $post['change_required'],
            'source_id' => $source_id,
            'sub_total' => $post['sub_total'],
            'delivery_charges' => $post['delivery_charges'],
            'discount' => $post['discount'],
            'coupon' => $post['coupon_code'],
            'family_member_id' => $post['family_id'],
            'total' => $post['total'],
            'currency_code' => $post['currency_code'],
            'os' => $os,
        	'credits' => (($post['credits'] == "" ) ? 0 : $post['credits'] )
        );
         $datatoSave = array(
             'customer_id' => $post['customer_id'],
             'payment_status' => $post['payment_status'],
             'payment_reference' => $post['payment_reference'],
             'save_card' => $post['save_card'],
             'payment_method' =>  $post['payment_method_fullname'],
             'action' =>  $post['payment_capture'],
             'payment_refund' =>  $post['payment_refund'],
             'total'         =>$post['total']
         );

        if($post['products'] != ""){
            $products = json_decode($post['products'], true);


            foreach($products as $value){
                $singleProduct = $this->model_catalog_product->getProduct(key($value));
                $singleProduct['quantity'] = $value[key($value)];
                $singleProduct['total'] = $singleProduct['price'] * $singleProduct['quantity'];
                $productData[] = $singleProduct;

            }
            $data['products'] = $productData;
        }else {
            $data['products'] = "";
        }



        if($post['virtual'] != ""){
            $products = json_decode($post['virtual'], true);

            foreach($products as $value){

                $name = explode("|", key($value));
                $quantity = explode("|", $value[key($value)]);

                $virtualData[] = array(
                    'name' => $name[0],
                    'item_type' => $name[1],
                    'quantity' => $quantity[0],
                    'image' => $quantity[1]
                );

            }
            $data['virtual'] = $virtualData;
        }else {
            $data['virtual'] = "";
        }

        $counter = 1;

        $totals[] = array(
            'code' => 'sub_total',
            'title' => 'Sub-Total',
            'value' => $post['sub_total'],
            'sort_order' => $counter
        );
        $counter++;

        if ($post['delivery_charges'] > 0 ){
            $totals[] = array(
            'code' => 'shipping',
            'title' => 'Flat Shipping Rate',
            'value' => $post['delivery_charges'],
            'sort_order' => $counter
            );
            $counter++;
        }

        if($post['discount'] > 0 ){

            $totals[] = array(
                'code' => 'discount',
                'title' => $post['coupon_code'] == "" ? "Rewards Discount" : "Coupon Discount",
                'value' => $post['discount'],
                'sort_order' => $counter
                );
            $counter++;
        }
        if($data['credits'] > 0){

              $totals[] = array(
                  'code' => 'discount',
                  'title' => "Credits Discount",
                  'value' => "-".$data['credits'],
                  'sort_order' => $counter
                  );
              $counter++;

          }
        $totals[] = array(
            'code' => 'total',
            'title' => 'Total',
            'value' => $post['total'],
            'sort_order' => $counter
        );

        $data['totals'] = $totals;
        $orderId = $this->model_checkout_order->addOrderModified($data);


//upload temp images to prescription
                if(null !== $post('session')){

                    $tempImages = $this->model_checkout_order->get_temp_images($post('session'));

                    if($tempImages){

                        foreach($tempImages as $tImage){
                            $nFileName = str_replace("temp/","", $tImage['file_name']);
                            $this->model_checkout_order->($order['order_id'], $nFileName);

                            if(file_exists(HTTP_SERVER . $tImage['file_name'])){
                                rename(HTTP_SERVER . $tImage['file_name'], HTTP_SERVER . $nFileName);
                            }
                        }
                    }

                }


        try{
          $this->saveTransaction($orderId,$datatoSave);
        }
        catch(Exception $e)
        {
          $this->json["data"] = array("order_id" => $orderId);
        }


        //Get customer saved tokens
        $tokens = $this->model_payment_network->getSavedCards($post['customer_id']);
        if($tokens){
            foreach($tokens as $token){
                $savedToken[] = array(
                "saved_tokens_id" =>  (int)$token['ni_saved_tokens_id'],
                "customer_id" => (int)$token['customer_id'],
                "masked_pan" => $token['masked_pan'],
                "name" => $token['name'],
                "expiry_date" => $token['expiry_date'],
                "scheme" => $token['scheme'],
                "recapture_csc" => (int)$token['recapture_csc'],
                "set_default" => (int)$token['set_default'],
                "unique_key" => $token['unique_key']);
            }
        }else {
            $savedToken = array();
        }

        $this->json["data"] = array("order_id" => $orderId,"tokens" => $savedToken);


        return $this->sendResponse();
    }

  public function saveTransaction($orderId,$datatoSave)
  {
      $this->load->model('payment/network');
      $customer_id = $datatoSave['customer_id'];
      $this->load->model('setting/setting');
      $network_stage = $this->model_setting_setting->getSetting('payment_network_production');
      $stage = $network_stage['payment_network_production_details'];
    if ($datatoSave['payment_status'] == 'completed' && !empty($datatoSave['payment_reference']) && !empty($orderId)) {
      if($stage == 1){
        $apikey =  AUTHORIZATION_CODE;
        $outletref =  OUTLETID;
        $token_url = NITOKENURL;
        $niurl = NIURL;
      } else{
        $apikey =  SANDBOX_AUTHORIZATION_CODE;
        $outletref =  SANDBOX_OUTLETID;
        $token_url = SANDBOX_NITOKENURL;
        $niurl = SANDBOX_NIURL;
      }
    $ch = curl_init();
    if($stage == 1){
      curl_setopt_array($ch, array(
       CURLOPT_URL => $token_url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => "",
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => "POST",
       CURLOPT_POSTFIELDS =>"{\r\n    \r\n}",
       CURLOPT_HTTPHEADER => array(
         "Content-Type: application/vnd.ni-identity.v1+json",
         "Authorization: Basic ".$apikey
       ),
     ));

    } else{
      curl_setopt($ch, CURLOPT_URL, $token_url);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       "Authorization: Basic ".$apikey,
       "Content-Type: application/x-www-form-urlencoded"));
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query(array('grant_type' => 'client_credentials')));

    }

    $err = curl_error($ch);
    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    if($err){
      $data['response'] = $err;
    } else{
      $access_token = $output->access_token;

      $curl = curl_init();

      curl_setopt_array($curl, array(
          CURLOPT_URL => $niurl."transactions/outlets/".$outletref."/orders/".$datatoSave['payment_reference'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
              "accept: application/vnd.ni-payment.v2+json",
              "authorization: Bearer ".$access_token
          ),
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);
      if ($err) {
          echo "cURL Error #:" . $err;
      } else {
          //echo $response;
          $data = json_decode($response);

          //echo $data;
          // if($data->paymentMethods->wallet[0] == 'APPLE_PAY')
          // {
          //   $status = $data->_embedded->payment[0]->authResponse->success == 'true' ? 'SUCCESS' : 'FAILED';
          //   $pay_url = $data->_embedded->payment[0]->_links->self->href;
          //   $order_reference = $data->_embedded->payment[0]->orderReference;
          //   $payment_reference_link = $pay_url;
          //   $pos = strrpos($payment_reference_link, '/');
          //   $payment_reference = $pos === false ? $payment_reference_link : substr($payment_reference_link, $pos + 1);
          //   $capture_url = $data->_embedded->payment[0]->_links->{'cnp:capture'}->href;
          //   // $segments = explode('/', trim(parse_url($capture_url, PHP_URL_PATH), '/'));
          //   // $numSegments = count($segments);
          //   // $capture_id  = $segments[$numSegments - 2];
          //   $cancel_url = $data->_embedded->payment[0]->_links->{'cnp:cancel'}->href;
          //   $cardToken = $data->_embedded->payment[0]->savedCard;
          //   $this->model_payment_network->addcust_ni_transctions(array(
          //     "amount_currency_code" => $data->_embedded->payment[0]->amount->currencyCode,
          //     "amount_value" =>  ($data->_embedded->payment[0]->amount->value / 100),
          //     "order_reference" => $order_reference,
          //     // "capture_id" => $capture_id,
          //     "payment_reference" => $payment_reference,
          //     "outletId" => $data->_embedded->payment[0]->outletId,
          //     "created_date" => $data->_embedded->payment[0]->updateDateTime,
          //     "capture_url" => $capture_url,
          //     "cancel_url" => $cancel_url,
          //     "card_token" => $cardToken->cardToken,
          //     "transaction_type" => "AUTH",
          //     "customer_id" => $customer_id,
          //     "order_id" => $orderId,
          //     "response" => $status
          //
          //   ));
          //   if($datatoSave['save_card'] == 1){
          //     $this->model_payment_network->saveCard(array(
          //                         'customer_id' => $customer_id,
          //                         'masked_pan' => $cardToken->maskedPan,
          //                         'name' => $cardToken->cardholderName,
          //                         'expiry_date' => $cardToken->expiry,
          //                         'scheme' => $cardToken->scheme,
          //                         'recaptureCsc' => $cardToken->recaptureCsc,
          //                         'card_token' => $cardToken->cardToken,
          //                         )
          //                       );
          //   }
          //} else{

            $status = $data->_embedded->payment[0]->{'3ds'}->status;
            $pay_url = $data->_embedded->payment[0]->_links->self->href;
            $order_reference = $data->_embedded->payment[0]->orderReference;
            $payment_reference_link = $pay_url;
            $pos = strrpos($payment_reference_link, '/');
            $payment_reference = $pos === false ? $payment_reference_link : substr($payment_reference_link, $pos + 1);
            if($datatoSave['action'] == 'SALE')
            {
              $capture_url = $data->_embedded->payment[0]->_embedded->{'cnp:capture'}[0]->_links->self->href;
            } else {
              $capture_url = $data->_embedded->payment[0]->_links->{'cnp:capture'}->href;
            }
            $cancel_url = $data->_embedded->payment[0]->_links->{'cnp:cancel'}->href;

            $refund_link = $cancel_url;
            $segments = explode('/', trim(parse_url($capture_url, PHP_URL_PATH), '/'));
            $numSegments = count($segments);
            $capture_id  = $segments[$numSegments - 2];
            $cancel_url = $data->_embedded->payment[0]->_links->{'cnp:cancel'}->href;
            $cardToken = $data->_embedded->payment[0]->savedCard;

              $this->model_payment_network->addcust_ni_transctions(array(
                "amount_currency_code" => $data->_embedded->payment[0]->amount->currencyCode,
                "amount_value" =>  ($data->_embedded->payment[0]->amount->value / 100),
                "order_reference" => $order_reference,
                "payment_method"  => $datatoSave['payment_method'],
                "capture_id" => $datatoSave['action'] == 'SALE' ? $capture_id : '',
                "capture_response" => $datatoSave['action'] == 'SALE'  ? 'CAPTURED' : '',
                "capture_date" => $datatoSave['action'] == 'SALE'  ? $data->_embedded->payment[0]->updateDateTime : '',
                "payment_reference" => $payment_reference,
                "outletId" => $data->_embedded->payment[0]->outletId,
                "created_date" => $data->_embedded->payment[0]->updateDateTime,
                "capture_url" => $capture_url,
                "cancel_url" => $cancel_url,
                "card_token" => $cardToken->cardToken,
                'masked_pan' => $cardToken->maskedPan,
                'name' => $cardToken->cardholderName,
                'expiry_date' => $cardToken->expiry,
                'scheme' => $cardToken->scheme,
                'recaptureCsc' => $cardToken->recaptureCsc,
                "transaction_type" => $datatoSave['action'],
                "customer_id" => $customer_id,
                "order_id" => $orderId,
                "response" => $status

              ));
              if($datatoSave['save_card'] == 1){
                $cardexists = $this->model_payment_network->checkCardexists($customer_id,$cardToken->maskedPan,$cardToken->expiry);
                if($cardexists == 0)
                {
                  $this->model_payment_network->saveCard(array(
                                      'customer_id' => $customer_id,
                                      'masked_pan' => $cardToken->maskedPan,
                                      'name' => $cardToken->cardholderName,
                                      'expiry_date' => $cardToken->expiry,
                                      'scheme' => $cardToken->scheme,
                                      'recaptureCsc' => $cardToken->recaptureCsc,
                                      'card_token' => $cardToken->cardToken,
                                      )
                                    );
                }
              }
              if($datatoSave['payment_refund'] == '1'){
                $this->refundOnePayment($orderId,$datatoSave,$refund_link);
              }
        //  }
      }

    }

    }
  }

  public function refundOnePayment($orderId,$datatoSave,$refund_link)
	{

		$this->load->model('setting/setting');
		$network_stage = $this->model_setting_setting->getSetting('payment_network_production');
		$stage = $network_stage['payment_network_production_details'];
		$order_reference = $datatoSave['payment_reference'];
		$customer_id = $datatoSave['customer_id'];
		$refund_amount = $datatoSave['total'] ;
		if($stage == 1){
		 $apikey =  AUTHORIZATION_CODE;
		 $outletref =  OUTLETID;
		 $token_url = NITOKENURL;
		 $niurl = NIURL;
		} else{
		 $apikey =  SANDBOX_AUTHORIZATION_CODE;
		 $outletref =  SANDBOX_OUTLETID;
		 $token_url = SANDBOX_NITOKENURL;
		 $niurl = SANDBOX_NIURL;
		}
		$ch = curl_init();
		if($stage == 1){
      curl_setopt_array($ch, array(
       CURLOPT_URL => $token_url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => "",
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => "POST",
       CURLOPT_POSTFIELDS =>"{\r\n    \r\n}",
       CURLOPT_HTTPHEADER => array(
         "Content-Type: application/vnd.ni-identity.v1+json",
         "Authorization: Basic ".$apikey
       ),
      ));

    } else{
      curl_setopt($ch, CURLOPT_URL, $token_url);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       "Authorization: Basic ".$apikey,
       "Content-Type: application/x-www-form-urlencoded"));
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query(array('grant_type' => 'client_credentials')));

		}
		$err = curl_error($ch);
		$output = json_decode(curl_exec($ch));
		if($err){
			$this->json['error'][] = $err;
						 $this->statusCode = 404;
		} else{

		 $access_token = $output->access_token;
		 $refresh_token = $output->refresh_token;
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => $refund_link,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "PUT",
					CURLOPT_POSTFIELDS => json_encode(array("amount" => array("currencyCode" => "AED", "value" => $refund_amount * 100))),
					CURLOPT_HTTPHEADER => array(
						"accept: application/vnd.ni-payment.v2+json",
						"content-type: application/vnd.ni-payment.v2+json",
						 "authorization: Bearer ".$access_token
					),
				));
				$response = curl_exec($curl);

				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					$this->json['error'][] = $err;
								 $this->statusCode = 404;
				} else {
					 $data = json_decode($response);
					$this->model_payment_network->refundTransaction(array(
						 "order_reference" => $order_reference,
						 "amount" => $refund_amount,
						 "order_id" => $order_id,
						 "customer_id" => $customer_id,
					 ));
					 $this->json['data'] = $data;
				}

		}
		//$this->model_payment_network->changePaymentPending($order_reference);
		$this->json['savedCard'] = $this->model_payment_network->getUsedCard($order_reference,$customer_id);

	}

    function upload_test(){


// //uploading process started

foreach($_FILES['attachments']['tmp_name'] as $key => $tmp_name)
{
    echo UPLOAD_DIR_REGISTERED . $_FILES['attachments']['name'][$key]."<br /><br >";
    // $file_name = $key.$_FILES['documents']['name'][$key];
    // $file_size =$_FILES['documents']['size'][$key];
    // $file_tmp =$_FILES['documents']['tmp_name'][$key];
    // $file_type=$_FILES['documents']['type'][$key];
    // move_uploaded_file($file_tmp,"galleries/".time().$file_name);



                   $file_path = UPLOAD_DIR_REGISTERED . $_FILES['attachments']['name'][$key];

                   if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $file_path)) {

                    }

                     $counter++;




}

// //end uploading process started

    }




    function upload_documents(){

      //  $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $counter = 1;

            foreach($_FILES['attachments']['name'] as $key => $image) {

                               //upload documents for server
               if (isset($_FILES['attachments']['name'][$key])) {

                   $file_path = UPLOAD_DIR_REGISTERED . "attachments/" . $_FILES['attachments']['name'][$key];
                   $http_path = ATTACHMENTS_IMAGE_URL . $_FILES['attachments']['name'][$key];
                   //saving the file
                   if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $file_path)) {


                    if (strpos($_FILES['attachments']['name'][$key],"insurance") !== false) {
                            $type = "approval";
                        }    else {
                            $type = 'prescription';
                        }

                    $this->db->query("
                            INSERT INTO ph_order_attachments SET
                            order_id = '" . $this->request->post['order_id'] . "',
                            file_name = '" . $http_path . "',
                            file_type = '" .$type. "'
                        ");

                       }

                       $counter++;

               }


            }

            $this->json["data"] = array("success" => "1");


        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        $this->sendResponse();

    }



















































    private function pay($data)
    {
        $this->response->addHeader('Content-Type: text/html');

        $data['styles'] = $this->document->getStyles();
        $data['scripts'] = $this->document->getScripts();

        $this->template = 'checkout/restapi_pay';

        $data['payment'] = $this->load->controller('extension/payment/' . $this->session->data['payment_method']['code']);

        $data['autosubmit'] = false;

        if (isset(static::$paymentMethods[$this->session->data['payment_method']['code']])) {
            $method = static::$paymentMethods[$this->session->data['payment_method']['code']];
            if ($method[self::PAY_RIGHT_NOW] === true) {
                if ($method[self::AUTOMATIC_PAY_BUTTON_CLICK] === true) {
                    $data['autosubmit'] = true;
                }
            } else {
                $method = static::$paymentMethods[$this->session->data['payment_method']['code']];
                $this->load->controller($method[self::ROUTE_OF_CONFIRMATION]);
            }
        }

        $this->response->setOutput($this->load->view($this->template, $data));
    }

    public function upload_temp(){
          $this->load->model('checkout/order');
            //upload documents for server
            if (isset($_FILES['prescription']['name'])) {


                    if(null === $this->input->post('extension')){
                    $file_path = UPLOAD_DIR_REGISTERED . "attachments/temp/" . $_FILES['prescription']['name'];
                    $httpPath  = ATTACHMENTS_IMAGE_URL . 'temp/' . $_FILES['prescription']['name'];


                    }else {
                        $extension = $this->input->post('extension');
                        $file_path = UPLOAD_DIR_REGISTERED . "attachments/temp/" . $_FILES['prescription']['name'].'.'.$extension;
                        $httpPath  = ATTACHMENTS_IMAGE_URL . 'temp/' . $_FILES['prescription']['name'].'.'.$extension;
                    }




                    //saving the file
                    if (move_uploaded_file($_FILES['prescription']['tmp_name'], $file_path)) {

                        $id = $this->model_checkout_order->uploadTempFiles($httpPath, $this->input->post('session'), 
                            'FfxFIfSTOZo3hQeS7VtdtqMFff7SnIgX', $this->input->post('extension'));

                        $this->json['data'] = array('success' => 1, 'file_path' => LOCAL_ROOT_URL . $httpPath, 'session' => $this->input->post('session'), 'inserted_id' => $id);
                        $this->sendResponse();
                        exit();
                    }
                }

                $this->json['data'] = array('success' => 0);
                $this->sendResponse();


    }

    public function delete_temp(){

$this->load->model('checkout/order');

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->model_checkout_order->delete_temp($this->input->get('id'), $this->input->get('session'));
            $this->json['data'] = array('success' => 1);


        } else {

            $this->statusCode     = 405;
            $this->allowedHeaders = array("GET");
        }

        $this->sendResponse();

    }
}
