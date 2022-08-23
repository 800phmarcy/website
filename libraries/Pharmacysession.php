<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Andrey Andreev
 * @link		https://codeigniter.com/user_guide/libraries/sessions.html
 */
class Pharmacysession {

	function set_session($key, $value){
    	$_SESSION[$key] = $value;

    }

	function get_session($key){
    	
    	if(isset($_SESSION[$key])){
                
        	return $_SESSION[$key];
        }else {
        	return false;
        }
    
    }

}