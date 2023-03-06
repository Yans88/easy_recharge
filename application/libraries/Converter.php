<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Converter {
	
	protected $ci;
	protected $skey;
	protected $apikey;
	

	function __construct(){

		$this->ci 		= & get_instance();
		$this->skey 	= $this->ci->config->item('encryption_key');
		$this->apikey	= $this->ci->config->item('encryption_key');
	}

    function stringEncryption($action, $string){
		  $output = false;
		  
		  $encrypt_method = 'AES-256-CBC';                
		  $secret_key = 'EASYRECHARGE';        
		  $secret_iv = '!IV@_$2'; 		  
		  $key = hash('sha256', $secret_key);		  
		  $iv = substr(hash('sha256', $secret_iv), 0, 16);		  
		  if( $action == 'encrypt' ) {
			  $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			  $output = base64_encode($output);
		  }
		  else if( $action == 'decrypt' ){
			  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		  }		  
		  return $output;
	}

	public function encode($value=null){	
		
        return trim($this->ci->encryption->encrypt($value));
    } 

    function decode($value=null){      

        return trim($this->ci->encryption->decrypt($value));

    }

	function random($length=10){
		$str 			= '0123456789abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$random_word	= str_shuffle($str);
		$word 			= substr($random_word,0,$length);
		return $word;
	}

}



?>