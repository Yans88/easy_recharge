<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Kategori';
		$this->data['judul_utama'] = 'Kategori';
		$this->data['judul_sub'] = 'List';
		$this->data['kategori'] = $this->access->readtable('kategori_station',array('*','(SELECT count(*) from merchants WHERE merchants.id_kategori = kategori_station.id_kategori) as is_delete'),array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('kategori/kategori_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_kategori' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('kategori_station', $data, $where);
	}
	
	public function detail($id_merchant){
		$this->data['judul_browser'] = 'Kategori';
		$this->data['judul_utama'] = 'Kategori';
		$this->data['judul_sub'] = 'Detail';
				
		$this->data['kategori'] = $this->access->readtable('kategori_station')->row();
		
		$this->data['isi'] = $this->load->view('kategori/kategori_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function add($id_kategori = 0){
		$this->data['judul_browser'] = 'Kategori';
		$this->data['judul_utama'] = 'Kategori';
		$this->data['judul_sub'] = 'Add';
		$kategori = '';
		if($id_kategori > 0){
			$this->data['judul_sub'] = 'Edit';
			$kategori = $this->access->readtable('kategori_station','',array('id_kategori'=>$id_kategori))->row();
		}
		
		$this->data['kategori'] = $kategori;
		$this->data['isi'] = $this->load->view('kategori/kategori_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}		

	function simpan(){
		$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
		$nama_kategori = isset($_POST['nama_kategori']) ? $_POST['nama_kategori'] : '';		
		
		$harga_1jam = isset($_POST['harga_1jam']) ? str_replace('.','',$_POST['harga_1jam']) : '';		
		$harga_1jam = str_replace(',','',$harga_1jam);
		$harga_2jam = isset($_POST['harga_2jam']) ? str_replace('.','',$_POST['harga_2jam']) : '';		
		$harga_2jam = str_replace(',','',$harga_2jam);
		$harga_3jam = isset($_POST['harga_3jam']) ? str_replace('.','',$_POST['harga_3jam']) : '';		
		$harga_3jam = str_replace(',','',$harga_3jam);
		
		$is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '';		
		
		$simpan = array(			
			'nama_kategori'	=> $nama_kategori,
			'harga_1jam'	=> $harga_1jam,
			'harga_2jam'	=> $harga_2jam,
			'harga_3jam'	=> $harga_3jam,
			'is_active'		=> $is_active		
		);
		
		$save = 0;
		if($id_kategori > 0){		
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('kategori_station', $simpan, array('id_kategori' => $id_kategori));
			$save = $id_kategori;
		}else{			
			$simpan += array('created_at' => date('Y-m-d H:i:s'),'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('kategori_station', $simpan);		
		}
		
		echo $save;
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
