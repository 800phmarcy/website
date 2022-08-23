<?php
class TempMd extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function get_customer_by_email($email){
          /* temp code */
        $query = $this->db->query("SELECT * FROM ph_customer WHERE LOWER(email) = '" . strtolower($email) . "'");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
      }
      public function set_otp($customer_id)
          {

          $otp = rand(1000, 9999);
          $this->db->query("UPDATE ph_customer SET last_otp = '" . $otp . "', otp_attempt = (otp_attempt + 1), last_otp_attempt = '" . date("Y-m-h H:i:s") . "'  WHERE customer_id = '" . $customer_id . "'");

          return $otp;
      }
      public function get_setting_value($key, $store_id = 0) {
    		$query = $this->db->query("SELECT value FROM ph_setting WHERE store_id = '" . (int)$store_id . "' AND `key` = '" .$key . "'");


        if ($query->num_rows() > 0) {
            return $query->row_array()['value'];
        } else {
            return false;
        }
    	}
      public function edit_password($email, $password) {
        $salt = '123456';
            $this->db->query("UPDATE ph_customer SET salt = '" . $salt . "', password = '" . sha1($salt . sha1($salt . sha1($password))) . "', code = '' WHERE LOWER(email) = '" . strtolower($email) . "'");

        return true;
      }
      public function checkcode($email, $code) {
        $query = $this->db->query("SELECT * FROM ph_customer WHERE email = '" . strtolower($email) . "' AND `last_otp` = '" .$code . "'");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
      }
    }
