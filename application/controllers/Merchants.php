<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merchants extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Station';
		$this->data['judul_utama'] = 'Station';
		$this->data['judul_sub'] = 'List';
		$this->data['merchants'] = $this->access->readtable('merchants','',array('merchants.deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('merchants/merchants_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function list_machine() {			
		$this->data['judul_browser'] = 'Vending Machine';
		$this->data['judul_utama'] = 'Vending Machine';
		$this->data['judul_sub'] = 'List';
		$this->data['merchants'] = $this->access->readtable('merchants','',array('merchants.deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('merchants/vm_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_merchants' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('merchants', $data, $where);
	}
	
	public function detail($id_merchant){
		$this->data['judul_browser'] = 'Station';
		$this->data['judul_utama'] = 'Station';
		$this->data['judul_sub'] = 'Detail';
		$sort2 = array('id_saldo','DESC');
		
		$where = array(
			'id_merchants' => $_POST['id']			
		);
		
		$this->data['merchants'] = $this->access->readtable('merchants','',array('id_merchant'=>$id_merchant))->row();
		
		$this->data['isi'] = $this->load->view('merchants/merchant_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d');
		$id_news = isset($_POST['id_news']) ? (int)$_POST['id_news'] : 0;
		$judul = isset($_POST['judul']) ? $_POST['judul'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';		
		$simpan = array(			
			'judul'			=> $judul,
			'description'	=> $content
		);
		$where = array();
		$save = 0;	
		if($id_news > 0){
			$where = array('id_news'=>$id_news);
			$save = $this->access->updatetable('news', $simpan, $where);   
		}else{
			$simpan += array('tgl'	=> $tgl);
			$save = $this->access->inserttable('news', $simpan);   
		}  
		echo $save;	 
	}
	
	public function add($id_merchant = 0){
		$this->data['judul_browser'] = 'Station';
		$this->data['judul_utama'] = 'Station';
		$this->data['judul_sub'] = 'Add';
		$merchants = '';
		if($id_merchant > 0){
			$this->data['judul_sub'] = 'Edit';
			$merchants = $this->access->readtable('merchants','',array('id_merchants'=>$id_merchant))->row();
		}
		$this->data['kategori'] = $this->access->readtable('kategori_station','',array('deleted_at'=>null,'is_active !='=>''))->result_array();
		$this->data['preset'] = $this->access->readtable('preset_template','',array('deleted_at'=>null))->result_array();
		$this->data['merchants'] = $merchants;
		$this->data['isi'] = $this->load->view('merchants/merchants_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function simpan_merchant(){
		$id_merchants = isset($_POST['id_merchants']) ? (int)$_POST['id_merchants'] : 0;
		$nama_merchant = isset($_POST['nama_merchant']) ? $_POST['nama_merchant'] : '';		
		$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
		$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
		$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
		$id_machine = isset($_POST['id_machine']) ? $_POST['id_machine'] : '';
		$id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
		$id_preset = isset($_POST['id_preset']) ? (int)$_POST['id_preset'] : 0;
		$simpan = array(			
			'nama_merchants'	=> $nama_merchant,
			'address'			=> $alamat,
			'id_machine'		=> $id_machine,
			'id_kategori'		=> $id_kategori,
			'latitude'			=> $latitude,
			'longitude'			=> $longitude,
			'id_preset'			=> $id_preset
		);
		
		$save = 0;
		if($id_merchants > 0){			
			$save = $this->access->updatetable('merchants', $simpan, array('id_merchants' => $id_merchants));
			$save = $id_merchants;
		}else{			
			$simpan += array('created_at' => date('Y-m-d H:i:s'));
			$save = $this->access->inserttable('merchants', $simpan);		
		}
		echo $save;
	}
	
	function transaksi($id_merchant = 0){
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail';
		$this->data['transaksi'] = $this->access->readtable('transaksi', '',array('transaksi.id_merchant'=>$id_merchant), array('merchants'=>'merchants.id_merchants =  transaksi.id_merchant','members'=>'members.id_member = transaksi.id_member'),'','','LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('merchants/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function chk_machine(){
		$id_machine = $this->input->post('id_machine');
		$dt = $this->access->readtable('merchants','',array('id_machine'=>$id_machine))->row();
		$dt_cnt = count($dt) > 0 ? $dt->id_merchants : 0;
		echo $dt_cnt;
	}
	
	public function inactive(){
		$tgl = date('Y-m-d H:i:s');
		$status = $_POST['status'] > 0 ? 1 : 0;
		$where = array(
			'id_merchants' => $_POST['id']			
		);
		$key = '';
		if($status > 0){
			$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
			if ($salt === FALSE){
				$salt = hash('sha256', time() . mt_rand());
			}
			$keys = substr($salt, 0, 64);
			$key = $keys.''.$this->converter->encode($_POST['id']);	
		}
		$data = array(
			'token'			=> $key
			// 'status'		=> $status,
			// 'status_by'		=> $this->session->userdata('operator_id'),
			// 'status_date'	=> $tgl
		);
		echo $this->access->updatetable('merchants', $data, $where);
	}
	
	
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}

}
