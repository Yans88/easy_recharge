<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fee_vendor extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Transaksi - Fee Vendor';
		$this->data['judul_utama'] = 'Transaksi - Fee Vendor';
		$this->data['judul_sub'] = 'List';
		$selects = array('transaksi_sewa.*');
		$sort = array('id_transaksi ','DESC');
		$where = array('status'=>2);
		$this->data['transaksi'] = $this->access->readtable('transaksi_sewa',$selects,$where, '','',$sort)->result_array();
        $vendors = $this->access->readtable('vendors', array('id_vendor', 'nama_vendor'), array('deleted_at' => null))->result_array();
        $_m = [];
        if (!empty($vendors)) {
            foreach ($vendors as $m) {
                $_m[$m['id_vendor']] = $m['nama_vendor'];
            }
        }
		
		$this->data['isi'] = $this->load->view('fee_vendor/fee_vendor_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

    public function report() {
        $tgl = isset($_POST['tgl']) ? $_POST['tgl'] : '';
        error_log(serialize($_POST));
        $this->data['judul_browser'] = 'Report - Fee Vendor';
        $this->data['judul_utama'] = 'Report - Fee Vendor';
        $this->data['judul_sub'] = 'List';
        $selects = array('report_fee_vendor_v.*');
        $sort = array('created_at','DESC');
        $where=array();
        if(!empty($tgl)){
            $_tgl = !empty($tgl) ? explode('-', $tgl) : '';
            $start_date = !empty($tgl) ? str_replace('/','-',$_tgl[0]) : '';
            $end_date = !empty($tgl) ? str_replace('/','-',$_tgl[1]) : '';
            $from = !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date;
            $to = !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date;
        }
        if(!empty($from)){
            $where += array('date_format(created_at, "%Y-%m-%d") >= '=>$from);
        }
        if(!empty($to)){
            $where += array('date_format(created_at, "%Y-%m-%d") <= '=>$to);
        }
        $this->data['transaksi'] = $this->access->readtable('report_fee_vendor_v',$selects,$where, '','',$sort)->result_array();

        $this->data['tgl'] = $tgl;
        $this->data['isi'] = $this->load->view('fee_vendor/report_fee_vendor_v', $this->data, TRUE);
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
