<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Preset_template extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Access', 'access', true);

    }

    public function index()
    {
        $this->data['judul_browser'] = 'Preset Template';
        $this->data['judul_utama'] = 'Preset Template';
        $this->data['judul_sub'] = 'List';
        $vendors = $this->access->readtable('vendors', array('id_vendor', 'nama_vendor'), array('deleted_at' => null))->result_array();
        $_m = [];
        if (!empty($vendors)) {
            foreach ($vendors as $m) {
                $_m[$m['id_vendor']] = $m['nama_vendor'];
            }
        }
        $this->data['vendors'] = $_m;
        $this->data['preset'] = $this->access->readtable('preset_template', array('*', '(SELECT count(*) from merchants WHERE merchants.id_preset = preset_template.id_preset) as is_delete'), array('deleted_at' => null))->result_array();
        $this->data['isi'] = $this->load->view('preset/preset_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }


    public function del()
    {
        $tgl = date('Y-m-d H:i:s');
        $where = array(
            'id_preset' => $_POST['id']
        );
        $data = array(
            'deleted_at' => $tgl,
            'deleted_by' => $this->session->userdata('operator_id')
        );
        echo $this->access->updatetable('preset_template', $data, $where);
    }

    public function add($id_preset = 0)
    {
        $this->data['judul_browser'] = 'Preset Template';
        $this->data['judul_utama'] = 'Preset Template';
        $this->data['judul_sub'] = 'Add';
        $preset = '';
        if ($id_preset > 0) {
            $this->data['judul_sub'] = 'Edit';
            $preset = $this->access->readtable('preset_template', '', array('id_preset' => $id_preset))->row();
        }
        $this->data['vendors'] = $this->access->readtable('vendors', array('id_vendor', 'nama_vendor'), array('deleted_at' => null))->result_array();
        $this->data['preset'] = $preset;
        $this->data['isi'] = $this->load->view('preset/preset_frm', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    function simpan()
    {
        $id_preset = isset($_POST['id_preset']) ? (int)$_POST['id_preset'] : 0;
        $nama_template = isset($_POST['nama_template']) ? $_POST['nama_template'] : '';
        $vendor_id_2 = isset($_POST['vendor_id_2']) ? (int)$_POST['vendor_id_2'] : 0;
        $vendor_id_3 = isset($_POST['vendor_id_3']) ? (int)$_POST['vendor_id_3'] : 0;
        $vendor_id_4 = isset($_POST['vendor_id_4']) ? (int)$_POST['vendor_id_4'] : 0;

        $fee_vendor_1 = isset($_POST['fee_vendor_1']) ? str_replace('.', '', $_POST['fee_vendor_1']) : '';
        $fee_vendor_1 = str_replace(',', '', $fee_vendor_1);
        $fee_vendor_2 = isset($_POST['fee_vendor_2']) ? str_replace('.', '', $_POST['fee_vendor_2']) : '';
        $fee_vendor_2 = str_replace(',', '', $fee_vendor_2);
        $fee_vendor_3 = isset($_POST['fee_vendor_3']) ? str_replace('.', '', $_POST['fee_vendor_3']) : '';
        $fee_vendor_3 = str_replace(',', '', $fee_vendor_3);
        $fee_vendor_4 = isset($_POST['fee_vendor_4']) ? str_replace('.', '', $_POST['fee_vendor_4']) : '';
        $fee_vendor_4 = str_replace(',', '', $fee_vendor_4);

        $simpan = array(
            'nama_template' => $nama_template,
            'fee_vendor_1' => $fee_vendor_1,
            'vendor_id_2' => $vendor_id_2,
            'fee_vendor_2' => $fee_vendor_2,
            'vendor_id_3' => $vendor_id_3,
            'fee_vendor_3' => $fee_vendor_3,
            'vendor_id_4' => $vendor_id_4,
            'fee_vendor_4' => $fee_vendor_4,
        );
        $save = 0;
        if ($id_preset > 0) {
            $simpan += array('updated_by' => $this->session->userdata('operator_id'));
            $save = $this->access->updatetable('preset_template', $simpan, array('id_preset' => $id_preset));
            $save = $id_preset;
        } else {
            $simpan += array('created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('operator_id'));
            $save = $this->access->inserttable('preset_template', $simpan);
        }

        echo $save;
    }

    public function no_akses()
    {
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
