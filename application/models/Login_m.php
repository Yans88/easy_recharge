<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_m extends CI_Model {

	public function load_form_rules() {
		$form_rules = array(
			array(
				'field' => 'u_name',
				'label' => 'username',
				'rules' => 'required'
				),
			array(
				'field' => 'pass_word',
				'label' => 'password',
				'rules' => 'required'
				),
			);
		return $form_rules;
	}

	public function validasi() {
		$form = $this->load_form_rules();
		$this->form_validation->set_rules($form);

		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    // cek status user, login atau tidak?
	public function cek_user() {
		$u_name = strtolower($this->input->post('u_name'));
		$pass_word = $this->input->post('pass_word');
		
		$username = $this->converter->stringEncryption('encrypt', $u_name);
		$password = $this->converter->stringEncryption('encrypt', $pass_word);	
		error_log($username);
		error_log($password);
		//$query = $this->db->select('admin.*')
		$query = $this->db->select('admin.*,level.*')
		->join('level','level.id=admin.level','left')		
		->where('admin.username', $username)
		->where('admin.password', $password)
		->where('admin.status', '1')
		->where('admin.deleted_at', null)
		->limit(1)
		->get('admin');
		//error_log($this->db->last_query());
		if ($query->num_rows() == 1) {
			$row = $query->row();
			
			$data = array(
				'login'				=> TRUE,
				'u_name' 			=> ucwords($u_name), 
				'operator_id' 		=> $row->operator_id,
				'level_name'		=> $row->level_name,
				'data_harga'		=> $row->data_harga,
				'data_toko'			=> $row->data_toko,
				'data_event'		=> $row->data_event,
				'data_cek_hp'		=> $row->data_cek_hp,
				'logistik'			=> $row->logistik,
				'master_lokasi'		=> $row->master_lokasi,
				'price_setting'		=> $row->price_setting,
				'terms_condition'	=> $row->terms_condition,
				'data_user_eup'		=> $row->data_user_eup,
				'data_eup'			=> $row->data_eup,
				'data_cek_hp_eup'	=> $row->data_cek_hp_eup,
				'logistik_eup'		=> $row->logistik_eup,
				'grafik'			=> $row->grafik,
				'analisa'			=> $row->analisa,
				'level'				=> $row->level,
				'users'				=> $row->users
			);
			
			// simpan data session jika login benar
			$this->session->set_userdata($data);
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	// public function logout() {
		// $this->session->unset_userdata(array('u_name' => '', 'login' => FALSE));
		// $this->session->sess_destroy();
	// }
}
