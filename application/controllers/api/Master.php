<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Master extends CI_Controller {

    function __construct(){        
        parent::__construct();	
		$this->load->library('send_notif');	
		$this->load->model('Api_m');	
		$this->load->model('Access','access',true);				
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }	
    
	public function contact_us(){
		$contact = $this->Api_m->get_key_val();
		
		$address = isset($contact['address']) ? $contact['address'] : '';		
		$phone = isset($contact['phone']) ? $contact['phone'] : '';
		$wa = isset($contact['wa']) ? $contact['wa'] : '';		
		$email_company = isset($contact['email_company']) ? $contact['email_company'] : '';
		$working_hour = isset($contact['working_hour']) ? $contact['working_hour'] : '';
		$tcku = array();
		$tc = array();
		$res = array();	
		if(!empty($contact)){
			$address = preg_replace("/<p[^>]*?>/", "", $address);
			$address = str_replace("</p>", "", $address);
			$tc = [					
					'address'	 	=> $address,			
					'phone'	 		=> $phone,					
					'whatsapp' 		=> $wa,									
					'email_company'	=> $email_company,
					'working_hour'	=> $working_hour
			];
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $tc,
			);			
		}else{
			$res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			);   
		}
		http_response_code(200);
		echo json_encode($res);
	}
	
	function iabout(){
		$term_condition = $this->Api_m->get_key_val();
		$about_us = isset($term_condition['about_us']) ? $term_condition['about_us'] : '';
		$tc = array();
		$res = array();	
		if(!empty($about_us)){
			$about_us = preg_replace("/<p[^>]*?>/", "", $about_us);
			$about_us = str_replace("</p>", "", $about_us);
			//$about_us = str_replace("\r\n","<br />",$about_us);
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $about_us,
			);	
		}else{
			$res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			);  
		}
		http_response_code(200);
		echo json_encode($res);
	}
	
	
	
	function tc(){
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['term_condition']) ? $term_condition['term_condition'] : '';
		$tcku = array();
		$res = array();	
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);			
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $tc,
			);	
		}else{
			$res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			);  
		}
		http_response_code(200);
		echo json_encode($res);
	}
	
	
	
	function ipolicy(){
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['policy']) ? $policy['policy'] : '';
		$tc = array();
		$res = array();	
		if(!empty($p)){
			$p = preg_replace("/<p[^>]*?>/", "", $p);
			$p = str_replace("</p>", "", $p);
			//$p = str_replace("\r\n","<br />",$p);
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $p,
			);	
		}else{
			$res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			); 
		}
		http_response_code(200);
		echo json_encode($res);
	}
	
	function faq(){
		$faq = $this->access->readtable('faq','',array('deleted_at'=>null))->result_array();
		$dt = array();
		$tc = array();
		$answer = '';
		$question = '';
		$res = array();	
		if(!empty($faq)){
			foreach($faq as $f){
				$answer = preg_replace("/<p[^>]*?>/", "", $f['answer']);
				$answer = str_replace("</p>", "", $answer);
				//$answer = str_replace("\r\n","<br />",$answer);
				$question = preg_replace("/<p[^>]*?>/", "", $f['question']);
				$question = str_replace("</p>", "", $question);
				//$question = str_replace("\r\n","<br />",$question);
				$dt[] = array(
					"id_faq"		=> $f['id_faq'],
					"question"		=> $question,
					"answer"		=> $answer
				);
			}
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $dt,
			);	
		}else{
           $res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			);
        }
		http_response_code(200);
		echo json_encode($res);
	}
	
	public function banners(){
        
		$_banner = $this->access->readtable('banner','',array('deleted_at'=>null))->result_array();		
		$dt = array();
		$path = '';
		$dataku = array();	
		$res = array();	
		if(!empty($_banner)){
			foreach($_banner as $k){
				$path = !empty($k['img']) ? base_url('uploads/banner/'.$k['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					'id_banner'		=> $k['id_banner'],						
					'image'			=> $path
				);
			}
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $dt,
			);	
			
		}else{
            $res = array(
				'err_code' 	=> '04',
                'err_msg' 	=> 'Data not be found',
                'data' 		=> null,
			);
        }
		http_response_code(200);
		echo json_encode($res);
    }
	
	function test_ios(){
		$param = $this->input->post();
		$user_id = isset($param['user_id']) ? (int)$param['user_id'] : 0;
		$dt_user = $this->access->readtable('members','', array('members.id_member' => $user_id))->row();
		$gcm_token = $dt_transaksi->gcm_token;
		$ids = array($gcm_token);
		
		$data_fcm = array(
			'user_id'		=> $user_id,
			'title'			=> 'KlikDiskon',
			'status'		=> 1,	
			'message' 		=> 'Testing',
			'notif_type' 	=> '1'
		);
		$notif_fcm = array(
			'body'			=> 'Testing',
			'badge'			=> '1',
    		'sound'			=> 'Default'
		);
		$send = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
		$dt_res = array('response'	=> $send, 'data_payloads' => $data_fcm, 'data_notif' => $notif_fcm);
		
		http_response_code(200);
		echo json_encode($dt_res);
	}
	
	function test_merchant(){
		$param = $this->input->post();
		$id_merchant = isset($param['id_merchant']) ? (int)$param['id_merchant'] : 0;
		$dt_user = $this->access->readtable('merchants','', array('merchants.id_merchants' => $id_merchant))->row();
		$gcm_token = $dt_transaksi->gcm_token;
		$ids = array($gcm_token);
		$data_fcm = array(
			'user_id'		=> $id_merchant,
			'title'			=> 'KlikDiskon',
			'status'		=> 1,	
			'message' 		=> 'Testing Merchant',
			'notif_type' 	=> '1'
		);
		$notif_fcm = array(
			'body'			=> 'Testing',
			'badge'			=> '1',
    		'sound'			=> 'Default'
		);
		$send = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
		$dt_res = array('response'	=> $send, 'data_payloads' => $data_fcm, 'data_notif' => $notif_fcm);
		http_response_code(200);
		echo json_encode($dt_res);
	}
	
	
	
	
	
}
