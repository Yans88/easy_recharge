<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topup_point extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Top up Point';
		$this->data['judul_utama'] = 'Top up Point';
		$this->data['judul_sub'] = 'Waiting payment';
		$selects = array('top_up_point.*','members.nama','members.email','members.phone');
		$sort = array('id ','DESC');
		$this->data['transaksi'] = $this->access->readtable('top_up_point',$selects,array('top_up_point.status'=>1), 
		array('members'=>'members.id_member = top_up_point.id_member'),'',$sort,'LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('topup_point/topup_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function complete() {			
		$this->data['judul_browser'] = 'Top up Point';
		$this->data['judul_utama'] = 'Top up Point';
		$this->data['judul_sub'] = 'Payment Complete';
		$selects = array('top_up_point.*','members.nama','members.email','members.phone');
		$sort = array('id ','DESC');
		$this->data['transaksi'] = $this->access->readtable('top_up_point',$selects,array('top_up_point.status'=>2), 
		array('members'=>'members.id_member = top_up_point.id_member'),'',$sort,'LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('topup_point/topup_v', $this->data, TRUE);
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
