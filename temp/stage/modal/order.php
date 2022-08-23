<?php
class ModelCheckoutOrder extends Model {



	public function addOrderModified($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "order
		SET customer_id = '" . $data['customer_id'] ."',
		address_id = '" . $data['address_id']."',
		firstname = '" . $data['firstname']."',
		lastname = '" . $data['lastname']."',
		telephone = '" . $data['telephone']."',
		payment_method = '" . $data['payment_method']."',
		payment_code = '" . $data['payment_code']."',
		actual_payment_code = '" . $data['actual_payment_code']."',
		payment_status = '" . $data['payment_status']."',
		payment_reference = '" . $data['payment_reference']."',
		save_card = '".$data['save_card']."',
		comment = '" . $data['comment']."',
		total = '" . $data['total_value']."',
		actual_total = '" . $data['total_value']."',
		order_status_id = '" . $data['order_status_id'] . "',
		withInsurance = '" . $data['withInsurance']."',
		withPrescription = '" . $data['withPrescription']."',
		eRxNumber = '" . $data['eRxNumber']."',
		delivery_date = '" . $data['delivery_date']."',
		delivery_time = '" . $data['delivery_time']."',
		change_required = '" . $data['change_required']."',
		source_id = '" . $data['source_id']."',
		family_member_id = '" . $data['family_member_id'] . "',
		currency_code ='" . $data['currency_code'] . "',
		date_added = NOW(),
		date_modified = NOW(),
        credits = '".$data['credits']."',
		os = '" . $data['os'] . "'");

		$order_id = $this->db->getLastId();
		if($data['credits'] > 0)
		{
			$total_credits = $this->db->query("SELECT sum(credits) as total FROM `" . DB_PREFIX . "cust_customer_credits` WHERE customer_id = '" . $this->db->escape($data['customer_id']) . "'");
      $balance = 0;
			$points  = 0;
			$remaining_points = 0;
			$available_points = 0;
			if($data['credits'] > $total_credits->row['total'])
			{
				$balance = abs($total_credits->row['total'] - $data['credits']);
				$this->db->query("INSERT INTO " . DB_PREFIX . "cust_customer_credits SET customer_id = '" . $this->db->escape($data['customer_id']) . "',order_id = '". $order_id ."',credits = '-".$total_credits->row['total']."',date_added = NOW()");
        $available_points = $this->getSumCustomerRewardsByCustomer($data['customer_id']);
				$redeem_perc = $this->getSettingValue('redeem_value');
				$remaining_points = round((100/$redeem_perc) * $balance);
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . $this->db->escape($data['customer_id']) . "',order_id = '". $order_id ."',points = '-".(int)$remaining_points."',date_added = NOW()");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "cust_customer_credits SET customer_id = '" . $this->db->escape($data['customer_id']) . "',order_id = '". $order_id ."',credits = '-".$data['credits']."',date_added = NOW()");
        $available_points = $this->getSumCustomerRewardsByCustomer($data['customer_id']);
				}
		}

    $this->addOrderHistory($order_id, $data['order_status_id'], 'Order Created');
		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");
			}
		}

		// Totals
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}

		// Virtual Products
		if (isset($data['virtual'])){

			foreach ($data['virtual'] as $virtual) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "cust_order_product_request SET
				order_id = '" . (int)$order_id . "',
				name = '" . $virtual['name'] . "',
				item_type = '" . $virtual['item_type'] . "',
				quantity = '" . (int)$virtual['quantity'] . "',
				image = '" . $virtual['image'] . "',
				created_date = NOW()
				");

			}

		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE customer_id = '" . $data['customer_id'] . "'");

		return $order_id;
	}



	public function addOrder($data) {
		// $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? json_encode($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? json_encode($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "',shipping_lat = '" . $this->db->escape($data['shipping_lat']) . "', shipping_lng = '" . $this->db->escape($data['shipping_lng']) . "', area_id = '" . $this->db->escape($data['shipping_area_id']) . "', shipping_extra_direction = '" . $this->db->escape($data['shipping_extra_direction']) . "', shipping_house_building_no = '" . $this->db->escape($data['shipping_house_building_no']) . "', shipping_apartment = '" . $this->db->escape($data['shipping_apartment']) . "', shipping_street = '" . $this->db->escape($data['shipping_street']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");



		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "',
			store_id = '" . (int)$data['store_id'] . "',
			store_name = '" . $this->db->escape($data['store_name']) . "',
			store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "',
			customer_group_id = '" . (int)$data['customer_group_id'] . "',
			firstname = '" . $this->db->escape($data['firstname']) . "',
			lastname = '" . $this->db->escape($data['lastname']) . "',
			email = '" . $this->db->escape($data['email']) . "',
			telephone = '" . $this->db->escape($data['telephone']) . "',
			custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "',
			payment_method = '" . $this->db->escape($data['payment_method']) . "',
			payment_code = '" . $this->db->escape($data['payment_code']) . "',
			shipping_method = '" . $this->db->escape($data['shipping_method']) . "',
			shipping_code = '" . $this->db->escape($data['shipping_code']) . "',
			shipping_lat = '" . $this->db->escape($data['shipping_lat']) . "',
			shipping_lng = '" . $this->db->escape($data['shipping_lng']) . "',
			address_id = '" . $this->db->escape($data['shipping_address_id']) . "',
			comment = '" . $this->db->escape($data['comment']) . "',
			total = '" . (float)$data['total'] . "',
			affiliate_id = '" . (int)$data['affiliate_id'] . "',
			commission = '" . (float)$data['commission'] . "',
			marketing_id = '" . (int)$data['marketing_id'] . "',
			tracking = '" . $this->db->escape($data['tracking']) . "',
			language_id = '" . (int)$data['language_id'] . "',
			currency_id = '" . (int)$data['currency_id'] . "',
			currency_code = '" . $this->db->escape($data['currency_code']) . "',
			currency_value = '" . (float)$data['currency_value'] . "',
			ip = '" . $this->db->escape($data['ip']) . "',
			forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "',
			user_agent = '" . $this->db->escape($data['user_agent']) . "',
			accept_language = '" . $this->db->escape($data['accept_language']) . "',
			hub_id = '" . $this->db->escape($data['hub_id']) . "',
			date_added = NOW(),
			date_modified = NOW()");




		$order_id = $this->db->getLastId();

		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
			}
		}

		// Gift Voucher
		$this->load->model('extension/total/voucher');

		// Vouchers
		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_extension_total_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}

		// Totals
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}

		return $order_id;
	}




































	public function editOrder($order_id, $data) {
		// Void the order first
		$this->addOrderHistory($order_id, 0);

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET
		 invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "',
		 store_id = '" . (int)$data['store_id'] . "',
		 store_name = '" . $this->db->escape($data['store_name']) . "',
		 store_url = '" . $this->db->escape($data['store_url']) . "',
		 customer_id = '" . (int)$data['customer_id'] . "',
		 customer_group_id = '" . (int)$data['customer_group_id'] . "',
		 firstname = '" . $this->db->escape($data['firstname']) . "',
		 lastname = '" . $this->db->escape($data['lastname']) . "',
		 email = '" . $this->db->escape($data['email']) . "',
		 telephone = '" . $this->db->escape($data['telephone']) . "',
		 custom_field = '" . $this->db->escape(json_encode($data['custom_field'])) . "',
		 payment_method = '" . $this->db->escape($data['payment_method']) . "',
		 payment_code = '" . $this->db->escape($data['payment_code']) . "',
		 shipping_method = '" . $this->db->escape($data['shipping_method']) . "',
		 shipping_code = '" . $this->db->escape($data['shipping_code']) . "',
		 comment = '" . $this->db->escape($data['comment']) . "',
		 total = '" . (float)$data['total'] . "',
		 affiliate_id = '" . (int)$data['affiliate_id'] . "',
		 commission = '" . (float)$data['commission'] . "',
		 date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");



		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");


		// Products
		if (isset($data['products'])) {

			foreach ($data['products'] as $product) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
			}

		}


		if($data['order_status_id'] == 7){
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET
		 	cancelled_by = 'customer' WHERE order_id = '" . (int)$order_id . "'");
		}



		// Gift Voucher
		$this->load->model('extension/total/voucher');

		$this->model_extension_total_voucher->disableVoucher($order_id);

		// Vouchers
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_extension_total_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}





		// Totals
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}
	}















	public function editOrderByAPI($order_id, $data){


		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");






		//Products
		if (isset($data['products'])) {

			foreach ($data['products'] as $product) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
			}

		}

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
			$data['shipping'] = 0;

			$data['order_totals'] = array();

			$order_totals = $this->getOrderTotals($order_id);




			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');

				if ($start && $end) {
					$data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
					$data['discount_value'] = $order_total['value'];
					$data['discount_type'] = $order_total['code'];
				}


				if ($order_total['code'] == 'shipping') {
					$data['shipping_cost'] = $order_total['value'];
				}


			}



			if ($data['coupon'] != ""){
				$coupon_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE code = '" . $this->db->escape($data['coupon']) . "'");

					if ($coupon_query->row['type'] == "P"){
						$data['discount'] = ( ($data['sub_total'] * abs($coupon_query->row['discount'])) / 100);

					}else {
						$data['discount'] = abs($coupon_query->row['discount']);

					}

			}else{
				$data['discount'] = abs($data['discount_value']);

			}


			$totalOrderValue = (( $data['sub_total'] + $data['shipping_cost']) - $data['discount']);

			$totals = array(
				'sub_total' => $data['sub_total'],
				$data['discount_type'] => abs($data['discount']),
				'shipping' => $data['shipping_cost'],
				'total' => $totalOrderValue
			);


			foreach($totals as $totalKey => $totalValue){
				$this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = '" .  $totalValue  . "' WHERE order_id = '" . $order_id . "' AND code = '" . $totalKey . "'");

			}


			$this->db->query("UPDATE " . DB_PREFIX . "order SET payment_required = '" . $data['payment_required'] . "', actual_total = '" . $data['actual_total'] . "', total = '" . $totalOrderValue . "', replacement_required = '0',replacement_status = 'completed',  order_status_id = '1' ,attention_required = '0' WHERE order_id = '" . $order_id . "'");


	}























	public function deleteOrder($order_id) {
		// Void the order first
		$this->addOrderHistory($order_id, 0);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_transaction` WHERE order_id = '" . (int)$order_id . "'");

		// Gift Voucher
		$this->load->model('extension/total/voucher');

		$this->model_extension_total_voucher->disableVoucher($order_id);
	}
	public function addTiny($customer_id,$actual_url,$tiny_url,$type){
	$this->db->query("INSERT INTO " . DB_PREFIX . "tiny_url SET customer_id = '" . (int)$customer_id . "', actual_url = '" . $actual_url . "', tiny_url = '" . $tiny_url . "', type = '" . $this->db->escape($type) . "',date = NOW()");
	}
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}




			//change by rizwan
            $reward = 0;

            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

            foreach ($order_product_query->rows as $product) {
                $reward += $product['reward'];
            }
            //end change by rizwan




            //attachments
            $order_attachments = $this->getPrescription((int)$order_id);

            if(!$order_attachments){
            	$attachments = "";
            }else {
            	$attachments = $order_attachments['file_name'];
            }

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'address_id'                => $order_query->row['address_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'reward'                 => $reward, //change by rizwan
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified'],
				'prescription' 			  => $attachments
			);
		} else {
			return false;
		}
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	public function getOrderProductsWithDetails($order_id) {
		$query = $this->db->query("SELECT op.*, image, name, sku,upc FROM " . DB_PREFIX . "order_product op
			LEFT JOIN " . DB_PREFIX . "product p ON op.product_id = p.product_id WHERE order_id = '" . (int)$order_id . "'");
		return $query->rows;
	}
	public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = true, $override = false) {
		$order_info = $this->getOrder($order_id);

		if ($order_info) {
			// Fraud Detection
			$this->load->model('account/customer');

			$customer_info = $this->model_account_customer->getCustomer($order_info['customer_id']);

			if ($customer_info && $customer_info['safe']) {
				$safe = true;
			} else {
				$safe = false;
			}

			// Only do the fraud check if the customer is not on the safe list and the order status is changing into the complete or process order status
			if (!$safe && !$override && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Anti-Fraud
				$this->load->model('setting/extension');

				$extensions = $this->model_setting_extension->getExtensions('fraud');

				foreach ($extensions as $extension) {
					if ($this->config->get('fraud_' . $extension['code'] . '_status')) {
						$this->load->model('extension/fraud/' . $extension['code']);

						if (property_exists($this->{'model_extension_fraud_' . $extension['code']}, 'check')) {
							$fraud_status_id = $this->{'model_extension_fraud_' . $extension['code']}->check($order_info);

							if ($fraud_status_id) {
								$order_status_id = $fraud_status_id;
							}
						}
					}
				}
			}

			// If current order status is not processing or complete but new status is processing or complete then commence completing the order
			if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Redeem coupon, vouchers and reward points
				$order_totals = $this->getOrderTotals($order_id);

				foreach ($order_totals as $order_total) {
					$this->load->model('extension/total/' . $order_total['code']);

					if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'confirm')) {
						// Confirm coupon, vouchers and reward points
						$fraud_status_id = $this->{'model_extension_total_' . $order_total['code']}->confirm($order_info, $order_total);

						// If the balance on the coupon, vouchers and reward points is not enough to cover the transaction or has already been used then the fraud order status is returned.
						if ($fraud_status_id) {
							$order_status_id = $fraud_status_id;
						}
					}
				}

				// Stock subtraction
				$order_products = $this->getOrderProducts($order_id);

				foreach ($order_products as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_options = $this->getOrderOptions($order_id, $order_product['order_product_id']);

					foreach ($order_options as $order_option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Add commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
					$this->load->model('account/customer');

					if (!$this->model_account_customer->getTotalTransactionsByOrderId($order_id)) {
						$this->model_account_customer->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
					}
				}
			}

			// Update the DB with the new statuses
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

			// If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
			if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Restock
				$order_products = $this->getOrderProducts($order_id);

				foreach($order_products as $order_product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_options = $this->getOrderOptions($order_id, $order_product['order_product_id']);

					foreach ($order_options as $order_option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Remove coupon, vouchers and reward points history
				$order_totals = $this->getOrderTotals($order_id);

				foreach ($order_totals as $order_total) {
					$this->load->model('extension/total/' . $order_total['code']);

					if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'unconfirm')) {
						$this->{'model_extension_total_' . $order_total['code']}->unconfirm($order_id);
					}
				}

				// Remove commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id']) {
					$this->load->model('account/customer');

					$this->model_account_customer->deleteTransactionByOrderId($order_id);
				}
			}

			$this->cache->delete('product');
		}
	}



    public function uploadOrderDetails($order_id, $data){



    	if(strtolower($data['delivery_date']) == "tomorrow"){
    		$date = date("Y-m-d", strtotime('tomorrow'));
    	}else{
    		$date = date("Y-m-d", time());
    	}

        $query = $this->db->query( "UPDATE " . DB_PREFIX . "order SET withInsurance = '" . $data['insurance'] . "', withPrescription = '" . $data['prescription'] . "', eRxNumber = '" . $data['erx'] . "', delivery_date = '" . $date . "' , delivery_time = '" . $data['delivery_time'] . "' , change_required = '" . $data['change_required'] . "', comment = '" . $data['comments'] . "', family_member_id = '" .$data['family_member_id']. "', payment_reference = '" .$data['payment_reference']. "', payment_status = '" .$data['payment_status']. "', actual_payment_code = '" .$data['actual_payment_code']. "', token_id = '" .$data['token_id']. "', source_id = '".$data['source_id']."' WHERE order_id = '" . $order_id . "'");
        //echo $query;

    }






    //changes by rizwan
    public function getTotalCustomerRewardsByOrderId($order_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "' AND points > 0");

        return $query->row['total'];
    }

    public function getSumCustomerRewardsByOrderId($order_id) {
        $query = $this->db->query("SELECT points AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");

        return $query->row['total'];
    }

		public function getSumCustomerRewardsByCustomer($customer_id) {
         $query = $this->db->query("SELECT sum(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . $customer_id . "'");

         return $query->row['total'];
     }

 		public function getSettingValue($key, $store_id = 0) {
 			$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = '" . $this->db->escape($key) . "'");

 			if ($query->num_rows) {
 				return $query->row['value'];
 			} else {
 				return null;
 			}
 		}

    public function addReward($customer_id, $description = '', $points = '', $order_id = 0) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', points = '" . (int)$points . "', description = '" . $this->db->escape($description) . "', date_added = NOW()");
    }

		public function addCredits($customer_id, $description = '', $credits = '', $order_id = 0) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "cust_customer_credits SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', credits = '" . (float)$credits . "', description = '" . $this->db->escape($description) . "', date_added = NOW()");
		}


    public function updateOrderStatus($orderStatus, $id){


    	$result = $this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id = '" . $orderStatus . "' WHERE order_id = '" . $id . "'");
		$this->addOrderHistory($id, $orderStatus);

    }




    public function getReplacementProducts($order_id){

    	$query = $this->db->query("SELECT pr.product_id, (select quantity from " .DB_PREFIX. "order_product WHERE order_id = pr.order_id AND product_id = pr.product_id) as quantity FROM " . DB_PREFIX . "cust_product_replacements pr WHERE order_id = '" . $order_id . "' group by product_id");
    	return $query->rows;
    }



    public function getSuggestedProducts($product_id, $order_id){

    	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cust_product_replacements WHERE product_id = '" . $product_id . "' AND order_id = '" . $order_id . "'");
    	return $query->rows;
    }


    public function getReplacementOrders($customer_id){

    	$query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = '" . $customer_id . "' AND replacement_required = '1'");

		if ($query->num_rows) {

			$row = $query->row;
	    	return $row['order_id'];

	    }else{
	    	return 0;
	    }

    }



    public function getIfPaymentRequired($customer_id){

    	$query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = '" . $customer_id . "' AND payment_required = '1' ORDER BY order_id");

		if ($query->num_rows) {

			$row = $query->row;
	    	return $row['order_id'];

	    }else{
	    	return 0;
	    }
	}




	    public function getReplacementRequestedProducts($order_id){

	    	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cust_product_replacements WHERE order_id = '" . $order_id . "' GROUP BY product_id");
	    	return $query->rows;

	    }




	    public function deleteOrderProduct($order_product_id, $order_id){

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE product_id = '" .(int)$order_product_id. "' AND order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" .(int)$order_product_id. "' AND order_id = '" . (int)$order_id . "'");

	    }

 public function getChannelIdByName($internal_name){

        $result = $this->db->query("SELECT * from " . DB_PREFIX ."cust_sources WHERE internal_name = '" . $internal_name . "'");
        return $result->row;
    }
	//sreenath **Order transfer
	public function getHub($area_id)
	{
		$query = $this->db->query( "SELECT hub_id FROM " . DB_PREFIX . "cust_hub_bridge WHERE area_id =".$area_id );
		return $query->row;
	}
	//sreenath **Order transfer

    //end changes by rizwan

	public function getAddressSummary($address_id)
	{
		$address_query = $this->db->query('SELECT DISTINCT * FROM '.DB_PREFIX."address WHERE address_id = '".(int) $address_id."'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query('SELECT * FROM '.DB_PREFIX."country WHERE country_id = '".(int) $address_query->row['country_id']."'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query('SELECT * FROM '.DB_PREFIX."zone WHERE zone_id = '".(int) $address_query->row['zone_id']."'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			$address_data = array(
				'address_id'=> $address_query->row['address_id'],
				'firstname' => $address_query->row['firstname'],
				'lastname' => $address_query->row['lastname'],
				'title' => $address_query->row['title'],
				'address_1' => $address_query->row['address'],
				'address_2' => $address_query->row['address'],
				'postcode' => $address_query->row['postcode'],
				'street' => $address_query->row['street'],
				'house_building_no' => $address_query->row['house_building_no'],
				'apartment' => $address_query->row['apartment'],
				'area_id'   =>  $address_query->row['area_id'],
				'extra_direction' => $address_query->row['extra_direction'],
				'city' => $address_query->row['city'],
				'zone' => $zone,
				'zone_code' => $zone_code,
				'country_id' => $address_query->row['country_id'],
				'country' => $country,
				'lat' => (float) $address_query->row['lat'],
				'lng' => (float) $address_query->row['lng']
			);

			return $address_data;
		} else {
			return false;
		}}



		public function deleted_item_for_order($data){
			$sql = "INSERT INTO " . DB_PREFIX . "order_product_deleted SET
			order_product_id = '" . $data['order_product_id'] . "',
			order_id = '" . $data['order_id'] . "',
			product_id = '" . $data['product_id'] . "',
			name = '" . $data['name'] . "',
			quantity = '" . $data['quantity'] . "',
			price = '" . $data['price'] . "',
			deleted_date = '" . date("Y-m-d H:i:s") . "'
			";
			$result = $this->db->query($sql);

		}




		public function getPrescription($order_id){

			$sql = "SELECT * FROM ph_order_attachments WHERE file_type = 'prescription' AND order_id = " . $order_id . " ORDER BY attachment_id DESC LIMIT 1";
			$result = $this->db->query($sql);

			if($result->num_rows){
				return $result->row;

			}else {
				return false;

			}
		}


 //Temp files
    public function uploadTempFiles($file_name, $session_id, $partner_id, $extension){

        $this->db->query("INSERT INTO ph_cust_temp_upload_files SET 
            session_id = '".$session_id."', 
            file_name = '".$file_name."',
            partner_id = '".$partner_id."',
            added_date = '". date("Y-m-d H:i:s", time()) ."', 
            extension = '" . $extension . "'
            ");
        return $this->db->insert_id();

    }

    public function delete_temp($id, $session_id){
        $this->db->query('DELETE FROM ph_cust_temp_upload_files WHERE id = ' . $id . ' AND session_id = ' . $this->db->escape($session_id));
    }


    public function get_temp_images($session_id){
        $result = $this->db->query("SELECT * FROM ph_cust_temp_upload_files WHERE session_id = " . $this->db->escape($session_id));

        if ($result->num_rows()) {
            return $result->result_array();

        } else {
            return false;

        }

    }
    public function update_prescription($order_id, $path)
    {
        $this->db->query("INSERT INTO ph_order_attachments SET
        order_id = '" . $order_id . "',
        file_name = '" . $path . "',
        file_type = 'prescription'");
    }


}
