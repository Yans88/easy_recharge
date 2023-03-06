<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Member extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->model('Api_m');
		$this->load->library('send_api');
		$this->load->library('converter');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }

    public function index($id=0){		
		$id = (int)$id;
		$dt = array();
		$res = array();
		$login = '';
			
		if($id > 0){
			$login = $this->access->readtable('members','',array('id_member'=>$id))->row();
			if(!empty($login)){	
				$status_name = 'inactive';
				if($login->status == 1 && $login->status_sms == 1){
					$status_name = 'active';
				}
				$dt = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,							
					"email"				=> $login->email,
					"phone"				=> $login->phone,							
					"alamat"			=> $login->address,							
					"status_email"		=> $login->status,							
					"status_sms"		=> $login->status_sms,							
					"status"			=> $status_name,							
					"total_point"		=> $login->total_point,							
					"current_pass"		=> $this->converter->stringEncryption('decrypt',$login->pass),
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
				];
			}
			$res = array(
				'err_code' 	=> '00',
                'err_msg' 	=> 'ok',
                'data' 		=> $dt,
			);	
			http_response_code(200);
			echo json_encode($res);
			return false;
		}else{
			$login = $this->access->readtable('members','',array('deleted_at'=>null))->result_array();
		}
		
		
		if(!empty($login)){
			foreach($login as $l){
				$status_name = 'inactive';
				if($l['status'] == 1 && $l['status_sms'] == 1){
					$status_name = 'active';
				}
				$dt[] = array(
					"id_member"			=> $l['id_member'],
					"nama"				=> $l['nama'],							
					"email"				=> $l['email'],
					"phone"				=> $l['phone'],							
					"alamat"			=> $l['address'],							
					"status_email"		=> $l['status'],							
					"status_sms"		=> $l['status_sms'],							
					"status"			=> $status_name,							
					"total_point"		=> $l['total_point'],							
					"current_pass"		=> $this->converter->stringEncryption('decrypt',$l['pass']),
					"tgl_reg"			=> date('d-M-Y', strtotime($l['tgl_reg']))
				);
				
			}
		}
		if (!empty($dt)){
			// error_log(serialize($dt));
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

	public function reg(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$nama_member = isset($param['nama_member']) ? $param['nama_member'] : '';
		$gcm_token = isset($param['gcm_token']) ? $param['gcm_token'] : '';
		$password = isset($param['password']) ? $this->converter->stringEncryption('encrypt',$param['password']) : '';
		$email = isset($param['email']) ? $param['email'] : ''; 	
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';		
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$tgl_reg = date('Y-m-d H:i:s');		
		$user_id = isset($param['user_id']) ? $param['user_id'] : '';
		$device = isset($param['device']) ? $param['device'] : '';	
		$save_sms = 0;
		$save = 0;
		if(empty($email) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Password can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = array('err_code'	=> '06',
							'err_msg'	=> 'Email invalid format.' );
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if(empty($password) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Password can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if(empty($phone) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Phone can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$ptn = "/^0/";
		$rpltxt = "62";
		$phone = preg_replace($ptn, $rpltxt, $phone);
		
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = isset($chk_email) ? 1 : 0;
		$login = '';
		$data = array();		
		$details = '';		
		$a = '';		
		if($ketemu > 0 && $id_member != $chk_email->id_member){
			$result = array( 'err_code'	=> '04',
                             'err_msg'	=> 'Email already exist');
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$chk_email = '';
		$date_expired = '';
		$chk_email = $this->access->readtable('members','',array('phone'=>$phone,'deleted_at'=>null))->row();
		$ketemu = isset($chk_email) && (int)$chk_email->id_member > 0 ? 1 : 0;
		if($ketemu > 0 && $id_member != $chk_email->id_member){
			$result = array( 'err_code'	=> '04',
                             'err_msg'	=> 'Phone already exist');
			http_response_code(200);
			echo json_encode($result);			
			return false;
		}
		$simpan = array();
		if(!empty($nama_member)){
			$simpan += array("nama"	=> $nama_member);
		}
		if(!empty($alamat)){
			$simpan += array("address"	=> $alamat);
		}	
		if(!empty($phone)){
			$simpan += array("phone"	=> $phone);
		}
		if(!empty($user_id)){
			$simpan += array("user_id"	=> $user_id);
		}
		if(!empty($gcm_token)){
			$simpan += array("gcm_token"	=> $gcm_token);
		}
		if(!empty($device)){
			$simpan += array("device"	=> $device);
		}
		
		// if($id_member == 0 || $id_member ==  ''){
			// if(empty($password)){
				// $this->set_response([
					// 'err_code' => '05',
					// 'err_msg' => 'Password is required'
				// ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
				// return false;
			// }
		// }
		if(!empty($password)){
			$simpan += array("pass"	=> $password);
		}		

		if($id_member > 0){
			$this->access->updatetable('members',$simpan, array("id_member"=>$id_member));
			$save = $id_member;
		}else{
			$simpan +=array('tgl_reg' => $tgl_reg,'email' => $email,'phone'	=> $phone,'total_point'=>0,'status'=>0,'status_sms'=>0);
			$save = $this->access->inserttable('members',$simpan);
			
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_register'];
			$content_member = $out['content_verifyReg'];
			$content = str_replace('[#name#]', $nama_member, $content_member);
			
			if($save){
				$id = $this->converter->encode($save);
				$link = VERIFY_REGISTER_LINK.'='.$id;
				$href = '<a href="'.$link.'">'.$link.'</a>';
				$content = str_replace('[#verify_link#]', $href, $content);
				$send = $this->send_notif->send_email($from,$pass, $to,$subject, $content);
				error_log(serialize($send));
				$a = '';
				$a = mt_rand(100000,999999);
				$date_created = date_create(date('Y-m-d H:i:s'));
				date_add($date_created, date_interval_create_from_date_string('5 minutes'));
				$date_expired = date_format($date_created, 'Y-m-d H:i:s');
				$simpan_sms = array(
					'code_sms'		=> $a,
					'type'			=> 1, //register
					'date_created'	=> date('Y-m-d H:i:s'),
					'date_expired'	=> $date_expired,
					'id'			=> $save,
					'to_sms'		=> $phone,
					'status'		=> 0
					
				);
				$save_sms = $this->access->inserttable('sms_token',$simpan_sms);
				$content_sms = '';
				$_a = '';
				$content_sms = $out['sms_verification'];
				$_a = str_replace('[#code_sms#]', $a, $content_sms);
				$from = "Easy Recharge";
				$url_sms = "http://www.etracker.cc/bulksms/mesapi.aspx?user=Klikdiskon01&pass=YWtdn)0G&type=0&to=".$phone."&from=".rawurlencode($from)."&text=".rawurlencode($_a)."&servid=MES01";
				// $this->send_api->send_data($url_sms, '','','','POST');	
			}
		}

		$status_name = 'inactive';	
		$res = array();
		if($save){
			$login = $this->access->readtable('members','',array('id_member'=>$save))->row();
			if(!empty($login)){	
				if($login->status == 1 && $login->status_sms == 1){
					$status_name = 'active';
				}
				$details = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,							
					"email"				=> $login->email,
					"phone"				=> $login->phone,							
					"alamat"			=> $login->address,							
					"status_email"		=> $login->status,							
					"status_sms"		=> $login->status_sms,							
					"status"			=> $status_name,							
					"total_point"		=> $login->total_point,							
					"current_pass"		=> $this->converter->decode($login->pass),
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
				];
			}		
			$res = array(
				'err_code' => '00',
				'err_msg' => 'Ok',
				'profile_info' => $details,
				'id_otp' 		=> $save_sms,
				'code_sms'	=> $a
			);			
		}else{
			$res = array(
				'err_code' => '03',
				'err_msg' => 'Insert has problem'
			);
		}		
		http_response_code(200);
		echo json_encode($res);
		
	}

	function login(){
		$result = array();
		$login = '';
		$param = $this->input->post();
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$password = isset($param['password']) ? $this->converter->stringEncryption('encrypt',$param['password']) : '';
		$ptn = "/^0/";
		$rpltxt = "62";
		$phone = preg_replace($ptn, $rpltxt, $phone);
		if(!empty($phone) && !empty($password)){
			$login = $this->access->readtable('members','',array('phone'=>$phone,'pass'=>$password,'deleted_at'=>null))->row();
		}else{
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Phone or Password can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$status_name = 'inactive';	
		if(!empty($login)){	
			if($login->status == 1 && $login->status_sms == 1){
				$status_name = 'active';
			}
			if($login->status == 0){
				$result = array( 'err_code'	=> '06',
								 'err_msg'	=> 'Please, verify your email' );
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			if($login->status_sms == 0){
				$get_sms = $this->access->readtable('sms_token','',array('type'=>1,'id'=>$login->id_member,'status'=>0))->row();
				$id_sms = isset($get_sms) && (int)$get_sms->id_sms > 0 ? $get_sms->id_sms : 0;
				$result = array( 'err_code'	=> '05',
								 'err_msg'	=> 'Please, verify your phone number',
								 'id_otp'	=> $id_sms);
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			$details = [
				"id_member"			=> $login->id_member,
				"nama"				=> $login->nama,							
				"email"				=> $login->email,
				"phone"				=> $login->phone,							
				"alamat"			=> $login->address,							
				"status_email"		=> $login->status,							
				"status_sms"		=> $login->status_sms,							
				"status"			=> $status_name,							
				"total_point"		=> $login->total_point,							
				"current_pass"		=> $this->converter->decode($login->pass),
				"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
			];			
			$result = [
				'err_code' => '00',
				'err_msg' => 'Ok',
				'profile_info' => $details
			];	
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Login failed'
			];			
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function resend_otp(){
		$param = $this->input->post();
		$id_sms = isset($param['id_otp']) ? (int)$param['id_otp'] : 0;
		$dt_sms = $this->access->readtable('sms_token','',array('id_sms'=>$id_sms, 'status'=>0))->row();
		$a = '';
		$simpan_sms = array();
		if(!empty($dt_sms)){
			$a = '';
			$hp_merchant = $dt_sms->to_sms;
			$ptn = "/^0/";
			$rpltxt = "62";
			$to_sms = preg_replace($ptn, $rpltxt, $hp_merchant);
			$a = mt_rand(100000,999999);
			$date_created = date_create(date('Y-m-d H:i:s'));
			date_add($date_created, date_interval_create_from_date_string('3 minutes'));
			$date_expired = date_format($date_created, 'Y-m-d H:i:s');
			$simpan_sms = array(				
				'code_sms'		=> $a,			
				'date_expired'	=> $date_expired			
			);
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			$content_sms = '';
			$_a = '';
			$content_sms = $out['sms_verification'];
			$_a = str_replace('[#code_sms#]', $a, $content_sms);
			$from = "Easy Reacharge";
			$url_sms = "http://www.etracker.cc/bulksms/mesapi.aspx?user=Klikdiskon01&pass=YWtdn)0G&type=0&to=".$phone."&from=".rawurlencode($from)."&text=".rawurlencode($_a)."&servid=MES01";
				// $this->send_api->send_data($url_sms, '','','','POST');	
			$this->access->updatetable('sms_token',$simpan_sms, array('id_sms'=>$id_sms, 'status'=>0));			
			$result = [
				'err_code' 	=> '00',
				'err_msg' 	=> 'Ok',
				'id_otp' 	=> $id_sms,
				'code_sms' 	=> $a,
				'data'	 	=> 'Token SMS send to your phone'
			];	
		}else{
			$result = [
				'err_code' => '09',
				'err_msg' => 'id otp not valid'
			];	
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function chk_token_sms(){
		$param = $this->input->post();		
		
		$type = isset($param['type']) ? (int)$param['type'] : 1;
		$token_sms = isset($param['token_sms']) ? $param['token_sms'] : '';
		$now = date('Y-m-d H:i:s');
		$chk_token_sms = '';
		$chk_token_sms = $this->access->readtable('sms_token','',array('date_expired >='=>$now,'code_sms'=>$token_sms,'type'=>$type))->row();		
		
		$simpan_history = array();
		if((int)$chk_token_sms->id_sms > 0){			
			if((int)$chk_token_sms->status == 0){
				$this->access->updatetable('sms_token',array('status'=>1), array('id_sms'=>$chk_token_sms->id_sms));
				if($type == 1){
					$this->access->updatetable('members',array('status_sms'=>$chk_token_sms->id_sms), array('id_member'=>$chk_token_sms->id,'status_sms <='=>0));
				}				
				$result = [
					'err_code' => '00',
					'err_msg' => 'ok'
				];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}else{
				$result = [
					'err_code' => '08',
					'err_msg' => 'Token SMS expired or not valid'
				];
				http_response_code(200);
				echo json_encode($result);
				return false;
			}
			
		}else{
			$result = [
				'err_code' => '08',
				'err_msg' => 'Token SMS expired or not valid'
			];	
			
		}
		http_response_code(200);
		echo json_encode($result);
	}
	


	function forgot(){

		$result = array();
		$nama = '';
		$new_pass = '';
		$save = 0;
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = [
				'err_code'	=> '06',
				'err_msg'	=> 'Email invalid format'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		if($ketemu > 0){
			$new_pass = $this->converter->random(8);
			$data = array("pass" => $this->converter->encode($new_pass));
			$this->access->updatetable('members',$data, array("id_member" => $chk_email->id_member));
			$save = $email;
		}else{
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'Email Not Registered'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}

		if($save == $email){

			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}

			$nama = $chk_email->nama;

			// $this->load->library('email');
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_forgot'];
			$content_member = $out['content_forgotPass'];

			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#new_pass#]', $new_pass, $content);
			$content = str_replace('[#email#]', $email, $content);

			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK, New password was send to your email'
			];
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			http_response_code(200);
			echo json_encode($result);
		}else{

			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'Insert has problem'
			];
			http_response_code(200);
			echo json_encode($result);

		}

	}

	function loginfb(){
		$param = $this->input->post();
		$user_id = $param['user_id'];
		$email = $param['email'];
		$first_name = !empty($param['first_name']) ? $param['first_name'] : '';
		$last_name = !empty($param['last_name']) ? $param['last_name'] : '';
		$name = $first_name.' '.$last_name;
		$photo = $param['photo'];
		$type = $param['type'];

		$tgl_reg = date('Y-m-d H:i:s');
		$simpan = array(
			"user_id"	=> $user_id,
			"email"		=> $email,
			"photo"		=> $photo,
			"nama"		=> $name,
			// "status"    => 1,
			"type"		=> $type
		);
		$login = $this->access->readtable('members', '',array('user_id'=>$user_id,'type'=>$type))->row();
		$checkExistingMember = count($login);
		$result = array();
		if($checkExistingMember > 0){
			$this->access->updatetable('members',$simpan, array("id_member"=>$login->id_member));
			$login = $this->access->readtable('members', '',array('id_member'=> $login->id_member))->row();
			$details = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,
					"email"				=> $login->email,
					"tgl_reg"			=> !empty($login->tgl_reg) ? date('d-M-Y', strtotime($login->tgl_reg)) : null,
					"photo"				=> !empty($login->photo) ? $login->photo : null
			];
			$result = [
					'err_code'		=> '00',
					'err_msg'		=> 'OK',
					'profile_info'	=> $details
			];
		}else{
			$login = '';
			$simpan +=array("tgl_reg" => $tgl_reg);
			$save = $this->access->inserttable("members",$simpan);
			if($save > 0){
				$login = $this->access->readtable('members', '',array('id_member'=>$save))->row();
				$details = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,
					"email"				=> $login->email,
					"tgl_reg"			=> !empty($login->tgl_reg) ? date('d-M-Y', strtotime($login->tgl_reg)) : null,
					"photo"				=> !empty($login->photo) ? $login->photo : null
				];
				$result = [
						'err_code'		=> '00',
						'err_msg'		=> 'OK',
						'profile_info'	=> $details
				];
			}
		}
		http_response_code(200);
		echo json_encode($result);	
	}
	
	
	function sinkron(){
		$param = $this->input->post();
		$id_member = $param['id_member'];
		$user_id = $param['user_id'];
		$type = $param['type'];
		$simpan = array();
		$result = array();
		if($type == "fb"){
			$simpan = array('fb_id'	=> $user_id);
		}
		if($type == "g+"){
			$simpan = array('user_id' => $user_id);
		}
		$where = array();
		if(!empty($simpan)){
			$where = array('id_member'=>$id_member);
			$save = $this->access->updatetable('members',$simpan, $where);
			$save = $id_member;
		}
		if($save > 0){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK'
			];	
		}else{
			$result = [
				'err_code'	=> '03',
				'err_msg'	=> 'Insert has problem'
			];			
		}
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function gcmid(){
		$result = array();	
		
		$param = $this->input->post();
		$user_id = isset($param['id_member']) ? $param['id_member'] : '';
		$gcm_id = isset($param['gcm_token']) ? $param['gcm_token'] : '';		
		$device = isset($param['device']) ? $param['device'] : 1;
		$result = array();		
		//if($device == 1){
		//	$device = "ios";
		//}else if($device == 2){
		//	$device = "android";
		////}else{
			$device = $device;
		//}
		$simpan = array(
			'device'	=> $device,
			'gcm_token'	=> $gcm_id
		);
		if(!empty($user_id) && !empty($gcm_id)){
			$this->access->updatetable('members',$simpan, array("id_member"=>$user_id));
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK'
			];					
		}else{
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'Param id_member or gcm_token can\'t empty.' 
			];			
		}
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function logout(){
		$param = $this->input->post();
		$user_id = isset($param['id_member']) ? $param['id_member'] : '';
		$result = array();
		$simpan = array(
			'device'	=> 0,
			'gcm_token'	=> ''
		);
		if(!empty($user_id)){
			$this->access->updatetable('members',$simpan, array("id_member"=>$user_id));
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK'
			];					
		}else{
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'Param id_member can\'t empty.' 
			];			
		}
		http_response_code(200);
		echo json_encode($result);	
	}
	
	
	function top_up_point(){
		$result = array();
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : 0;
		$payment_type = isset($param['payment_type']) ? $param['payment_type'] : 0;
		$point = isset($param['point']) ? str_replace('.','',$param['point']) : 0;
		$point = isset($param['point']) ? str_replace(',','',$point) : 0;
		if($id_member <= 0){
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'id_member required' 
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		if($point <= 0){
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'point required' 
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$login = $this->access->readtable('members', '',array('id_member'=>$id_member))->row();
		$id_member = isset($login->id_member) ? $login->id_member : 0;
		if($id_member <= 0){
			$result = [
				'err_code'	=> '04',
                'err_msg'	=> 'id_member not found' 
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$setting = $this->Api_m->get_key_val();
		$min_deposit = isset($setting['min_deposit']) ? str_replace('.','',$setting['min_deposit']) : '';
		$min_deposit = isset($setting['min_deposit']) ? str_replace(',','',$min_deposit) : '';
		$idr_perpoint = isset($setting['idr_perpoint']) ? str_replace('.','',$setting['idr_perpoint']) : '';
		$idr_perpoint = isset($setting['idr_perpoint']) ? str_replace(',','',$idr_perpoint) : '';
		$idr_perpoint = (int)$idr_perpoint == 1 ? (int)$idr_perpoint : 1;
		$ttl_all = $point * $idr_perpoint;
		if($point < $min_deposit){
			$result = [
				'err_code'	=> '02',
                'err_msg'	=> 'minimal top up '.$min_deposit.' point'
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$data_insert = array(
			'id_member'		=> $id_member,
			'point'			=> $point,
			'nominal'		=> $ttl_all,
			'idr_perpoint'	=> $idr_perpoint,
			'status'		=> 1,
			'payment_type'	=> $payment_type,
			'created_at'	=> date('Y-m-d H:i:s')
		);
		
		$save = $this->access->inserttable("top_up_point",$data_insert);
		$post_data = array();
		$credit_card = array('secure'=>true);
		$transaction_details = array(
				'order_id' 		=> $save,
				'gross_amount' 	=> $ttl_all
		);
		$items[] = array(
			'id' 		=> 'point',
			'price' 	=>  $ttl_all,
			'quantity'	=> 1,
			'name'		=> 'Top up point sebesar '.number_format($point,0,',','.'),
		);
		$billing_address = array(
				'first_name'	=> $login->nama,
				'last_name'		=> '',
				'email'			=> $login->email,
				'phone' 		=> $login->phone,	
				'address' 		=> $login->address,				
				'country_code' 	=> 'IDN',	
		);
		$customer_details = array(
				'first_name'		=> $login->nama,
				'last_name'			=> '',
				'email'				=> $login->email,
				'phone' 			=> $login->phone,	
				'billing_address'	=> $billing_address,
				'shipping_address'	=> $billing_address,				
		);
        $enabled_payments = ["credit_card","shopeepay","bca_klikbca", "bca_klikpay", "permata_va", "bca_va", "bni_va", "other_va", "gopay","shopeepay"];
        $shopeepay = array(
            "callback_url"=> "http://shopeepay.com?order_id=$save"
        );
        $gopay = array(
            "enable_callback"=> true,
            "callback_url"=> "http://gopay.com"
        );
		$post_data = array(
			'transaction_details'	=> $transaction_details,
			'credit_card'			=> $credit_card,
			'item_details'			=> $items,
			'customer_details'		=> $customer_details,
            'enabled_payments'		=> $enabled_payments,
            'shopeepay'				=> $shopeepay,
            'gopay'					=> $gopay
		);
		$data_insert += array('id'=>$save);
		if($save > 0 && $payment_type == 1){		
			$_url_payment = $this->send_api->send_data('https://app.sandbox.midtrans.com/snap/v1/transactions', $post_data, 'Basic U0ItTWlkLXNlcnZlci1CdGc1ejE2NnMzYW1SMVczUFpUSDBpM1o6','', $method='POST');
			$url_payment = json_decode($_url_payment);			
			$redirect_url = $url_payment->redirect_url;
			//$total_point = (int)$login->total_point;
			//$total_point = (int)$point + $total_point;
			$this->access->updatetable('top_up_point',array('url_payment'=>$redirect_url), array("id"=>$save));
			$data_insert += array('url_payment'=>$url_payment);
		}
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK',
				'data'		=> $data_insert
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	function history_top_up_point(){
		$result = array();
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : 0;
		if($id_member <= 0){
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'id_member required' 
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$top_up_point = $this->access->readtable('top_up_point', '',array('id_member'=>$id_member))->result_array();
		$result = [
			'err_code'	=> '04',
			'err_msg'	=> 'data not found',
			'data'		=> $top_up_point,
		];
		if(count($top_up_point)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK',
				'data'		=> $top_up_point
			];
		}			
		http_response_code(200);
		echo json_encode($result);
	}
	
	function history_point(){
		$result = array();
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : 0;
		if($id_member <= 0){
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'id_member required' 
			];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
		$point_history = $this->access->readtable('point_history', '',array('id_member'=>$id_member))->result_array();
		$result = [
			'err_code'	=> '04',
			'err_msg'	=> 'data not found',
			'data'		=> $point_history,
		];
		if(count($point_history)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK',
				'data'		=> $point_history
			];
		}			
		http_response_code(200);
		echo json_encode($result);
	}
	

}
