<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);					
	}	
	
	public function index() {
		if(!$this->session->userdata('login') && !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		$this->data['level'] = $this->access->readtable('level','',array('level.deleted_at'=>null))->result_array();			
		$this->data['isi'] = $this->load->view('level_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function add($id_level=null) {
		if(!$this->session->userdata('login') && !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['level'] = '';	
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		if(!empty($id_level)){
			$this->data['level'] = $this->access->readtable('level','',array('deleted_at'=>null,'id'=>$id_level))->row();
		}
		
		$this->data['isi'] = $this->load->view('level_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if(!$this->session->userdata('login') && !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		
		$save =0;
		$id_level = isset($_POST['id_level']) ? (int)$_POST['id_level'] : '0';		
		$level_name = isset($_POST['level_name']) ? $_POST['level_name'] : '';				
		$data_harga = isset($_POST['data_harga']) ? (int)$_POST['data_harga'] : '0';
		$data_toko = isset($_POST['data_toko']) ? (int)$_POST['data_toko'] : '0';
		$data_event = isset($_POST['data_event']) ? (int) $_POST['data_event'] : '0';
		$data_cek_hp = isset($_POST['data_cek_hp']) ? (int)$_POST['data_cek_hp'] : '0';
		$logistik = isset($_POST['logistik']) ? (int)$_POST['logistik'] : '0';
		$master_lokasi = isset($_POST['master_lokasi']) ? (int)$_POST['master_lokasi'] : '0';
		$price_setting = isset($_POST['price_setting']) ? (int)$_POST['price_setting'] : '0';
		$terms_condition = isset($_POST['terms_condition']) ? (int)$_POST['terms_condition'] : '0';
		$data_user_eup = isset($_POST['data_user_eup']) ? (int)$_POST['data_user_eup'] : '0';
		$data_eup = isset($_POST['data_eup']) ? (int)$_POST['data_eup'] : '0';
		$data_cek_hp_eup = isset($_POST['data_cek_hp_eup']) ? (int)$_POST['data_cek_hp_eup'] : '0';
		$logistik_eup = isset($_POST['logistik_eup']) ? (int)$_POST['logistik_eup'] : '0';
		$grafik = isset($_POST['grafik']) ? (int)$_POST['grafik'] : '0';
		$analisa = isset($_POST['analisa']) ? (int)$_POST['analisa'] : '0';
		$level = isset($_POST['level']) ? (int)$_POST['level'] : '0';
		$users = isset($_POST['users']) ? (int)$_POST['users'] : '0';
		$data = array(
			'level_name'		=> $level_name,
			'data_harga'		=> $data_harga,
			'data_toko'			=> $data_toko,
			'data_event'		=> $data_event,
			'data_cek_hp'		=> $data_cek_hp,
			'logistik'			=> $logistik,
			'master_lokasi'		=> $master_lokasi,
			'price_setting'		=> 0,
			'terms_condition'	=> $terms_condition,
			'data_user_eup'		=> $data_user_eup,
			'data_eup'			=> $data_eup,
			'data_cek_hp_eup'	=> $data_cek_hp_eup,
			'logistik_eup'		=> $logistik_eup,
			'grafik'			=> $grafik,
			'level'				=> $level,
			'analisa'			=> $analisa,
			'users'				=> $users
		);
		$where = array();
		$tgl = date('Y-m-d H:i:s');
		$operator_id = $this->session->userdata('operator_id');
		if($id_level > 0){
			
			$where = array('id'=>$id_level);
			$this->access->updatetable('level',$data, $where);
			$save = $id_level;
		}else{
			$data += array('created_by' => $operator_id, 'created_at' => $tgl);
			$save = $this->access->inserttable('level', $data);
		}
		
		echo $save;
	}
	
	public function del(){	
		if(!$this->session->userdata('login') && !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}		
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);		
		echo $this->access->updatetable('level', $data, $where);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}
