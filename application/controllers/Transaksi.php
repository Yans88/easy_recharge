<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';
		$selects = array('transaksi_sewa.*','members.nama','members.email','members.phone','nama_merchants','merchants.address');
		$sort = array('id_transaksi ','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi_sewa',$selects,'', 
		array('merchants'=>'merchants.id_merchants =  transaksi_sewa.id_merchant','members'=>'members.id_member = transaksi_sewa.id_member'),'',$sort,'LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
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
