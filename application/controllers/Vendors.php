<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vendors extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Access', 'access', true);

    }

    public function index()
    {
        $this->data['judul_browser'] = 'Vendors';
        $this->data['judul_utama'] = 'Vendors';
        $this->data['judul_sub'] = 'Add';
        $this->data['vendors'] = $this->access->readtable('vendors', '', array('vendors.deleted_at' => null))->result_array();
        $this->data['isi'] = $this->load->view('vendors/vendor_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }


    public function del()
    {
        $tgl = date('Y-m-d H:i:s');
        $where = array(
            'id_vendor' => $_POST['id']
        );
        $data = array(
            'deleted_at' => $tgl,
            'deleted_by' => $this->session->userdata('operator_id')
        );
        echo $this->access->updatetable('vendors', $data, $where);
    }

    public function detail($id_merchant)
    {
        $this->data['judul_browser'] = 'Vendors';
        $this->data['judul_utama'] = 'Vendors';
        $this->data['judul_sub'] = 'Detail';

        $this->data['vendors'] = $this->access->readtable('vendors')->row();

        $this->data['isi'] = $this->load->view('vendors/vendor_detail', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function add($id_vendor = 0)
    {
        $this->data['judul_browser'] = 'Owner';
        $this->data['judul_utama'] = 'Owner';
        $this->data['judul_sub'] = 'Add';
        $vendors = '';
        if ($id_vendor > 0) {
            $this->data['judul_sub'] = 'Edit';
            $vendors = $this->access->readtable('owner', '', array('id' => $id_vendor))->row();
        }

        $this->data['vendors'] = $vendors;
        $this->data['isi'] = $this->load->view('vendors/owner_frm', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function add_vendor($id_vendor = 0)
    {
        $this->data['judul_browser'] = 'Vendors';
        $this->data['judul_utama'] = 'Vendors';
        $this->data['judul_sub'] = 'Add';
        $vendors = '';
        if ($id_vendor > 0) {
            $this->data['judul_sub'] = 'Edit';
            $vendors = $this->access->readtable('vendors', '', array('id_vendor' => $id_vendor))->row();
        }

        $this->data['vendors'] = $vendors;
        $this->data['isi'] = $this->load->view('vendors/vendor_frm', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function add_sub_vendor($id_vendor = 0, $id_sub_vendor = 0)
    {
        $this->data['judul_browser'] = 'Sub Vendors';
        $this->data['judul_utama'] = 'Sub Vendors';
        $this->data['judul_sub'] = 'Add';
        $vendors = '';
        $this->data['owner'] = $this->access->readtable('vendors', '', array('id_vendor' => $id_vendor))->row();
        if ($id_sub_vendor > 0) {
            $this->data['judul_sub'] = 'Edit';
            $vendors = $this->access->readtable('sub_vendor', '', array('id_sub_vendor' => $id_sub_vendor))->row();
        }

        $this->data['vendors'] = $vendors;
        $this->data['isi'] = $this->load->view('vendors/sub_vendor_frm', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function add_sub_sub_vendor($id_vendor = 0, $id_sub_sub_vendor = 0)
    {
        $this->data['judul_browser'] = 'Sub sub Vendors';
        $this->data['judul_utama'] = 'Sub sub Vendors';
        $this->data['judul_sub'] = 'Add';
        $vendors = '';
        $this->data['owner'] = $this->access->readtable('sub_vendor', '', array('id_sub_vendor' => $id_vendor))->row();
        if ($id_sub_sub_vendor > 0) {
            $this->data['judul_sub'] = 'Edit';
            $vendors = $this->access->readtable('sub_sub_vendor', '', array('id_sub_sub_vendor' => $id_sub_sub_vendor))->row();
        }

        $this->data['vendors'] = $vendors;
        $this->data['isi'] = $this->load->view('vendors/sub_sub_vendor_frm', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    function simpan_sub_sub_vendor()
    {
        $id_vendor = isset($_POST['id_vendor']) ? (int)$_POST['id_vendor'] : 0;
        $id_owner = isset($_POST['id_owner']) ? (int)$_POST['id_owner'] : 0;
        $nama_vendor = isset($_POST['nama_vendor']) ? $_POST['nama_vendor'] : '';

        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $profit = isset($_POST['profit']) ? $_POST['profit'] : '';
        $sharing = isset($_POST['sharing']) ? $_POST['sharing'] : '';

        $simpan = array(
            'nama_vendor' => $nama_vendor,
            'address' => $alamat,
            'profit' => $profit,
            'sharing' => $sharing
        );

        $save = 0;
        if ($id_vendor > 0) {
            $simpan += array('updated_by' => $this->session->userdata('operator_id'));
            $save = $this->access->updatetable('sub_sub_vendor', $simpan, array('id_sub_sub_vendor' => $id_vendor));
            $save = $id_vendor;
        } else {
            $simpan += array('id_sub_vendor' => $id_owner, 'created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('operator_id'));
            $save = $this->access->inserttable('sub_sub_vendor', $simpan);
        }
        echo $save;
    }

    function simpan_sub_vendor()
    {
        $id_vendor = isset($_POST['id_vendor']) ? (int)$_POST['id_vendor'] : 0;
        $id_owner = isset($_POST['id_owner']) ? (int)$_POST['id_owner'] : 0;
        $nama_vendor = isset($_POST['nama_vendor']) ? $_POST['nama_vendor'] : '';

        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $profit = isset($_POST['profit']) ? $_POST['profit'] : '';
        $sharing = isset($_POST['sharing']) ? $_POST['sharing'] : '';

        $simpan = array(
            'nama_vendor' => $nama_vendor,
            'address' => $alamat,
            'profit' => $profit,
            'sharing' => $sharing
        );

        $save = 0;
        if ($id_vendor > 0) {
            $simpan += array('updated_by' => $this->session->userdata('operator_id'));
            $save = $this->access->updatetable('sub_vendor', $simpan, array('id_sub_vendor' => $id_vendor));
            $save = $id_vendor;
        } else {
            $simpan += array('id_vendor' => $id_owner, 'created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('operator_id'));
            $save = $this->access->inserttable('sub_vendor', $simpan);
        }
        echo $save;
    }

    function simpan_vendor()
    {
        $id_vendor = isset($_POST['id_vendor']) ? (int)$_POST['id_vendor'] : 0;
        $nama_vendor = isset($_POST['nama_vendor']) ? $_POST['nama_vendor'] : '';

        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';

        $simpan = array(
            'nama_vendor' => $nama_vendor,
            'address' => $alamat,

        );

        $save = 0;
        if ($id_vendor > 0) {
            $simpan += array('updated_by' => $this->session->userdata('operator_id'));
            $save = $this->access->updatetable('vendors', $simpan, array('id_vendor' => $id_vendor));
            $save = $id_vendor;
        } else {
            $simpan += array('created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('operator_id'));
            $save = $this->access->inserttable('vendors', $simpan);
        }
        echo $save;
    }

    function simpan_owner()
    {
        $id_vendor = isset($_POST['id_vendor']) ? (int)$_POST['id_vendor'] : 0;
        $nama_vendor = isset($_POST['nama_vendor']) ? $_POST['nama_vendor'] : '';

        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $profit = isset($_POST['profit']) ? $_POST['profit'] : '';
        $sharing = isset($_POST['sharing']) ? $_POST['sharing'] : '';

        $simpan = array(
            'nama_vendor' => $nama_vendor,
            'address' => $alamat,
            'profit' => $profit,
            'sharing' => $sharing
        );

        $save = 0;
        if ($id_vendor > 0) {
            $simpan += array('updated_by' => $this->session->userdata('operator_id'));
            $save = $this->access->updatetable('owner', $simpan, array('id' => $id_vendor));
            $save = $id_vendor;
        } else {
            $simpan += array('created_at' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('operator_id'));
            $save = $this->access->inserttable('owner', $simpan);
        }
        echo $save;
    }

    public function list_vendor($id_vendor = 0)
    {
        $this->data['judul_browser'] = 'Vendors';
        $this->data['judul_utama'] = 'Vendors';
        $this->data['judul_sub'] = 'Add';

        $this->data['vendors'] = $this->access->readtable('vendors', '', array('vendors.deleted_at' => null))->result_array();

        $this->data['isi'] = $this->load->view('vendors/vendor_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function list_sub_vendor($id_vendor = 0)
    {
        $this->data['judul_browser'] = 'Sub Vendor';
        $this->data['judul_utama'] = 'Sub Vendor';
        $this->data['judul_sub'] = 'Add';
        $this->data['id_vendor'] = $id_vendor;
        $this->data['vendors'] = $this->access->readtable('sub_vendor', '', array('deleted_at' => null, 'id_vendor' => $id_vendor))->result_array();

        $this->data['isi'] = $this->load->view('vendors/sub_vendor_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
    }

    public function list_sub_sub_vendor($id_vendor = 0)
    {
        $this->data['judul_browser'] = 'Sub sub Vendor';
        $this->data['judul_utama'] = 'Sub sub Vendor';
        $this->data['judul_sub'] = 'Add';
        $this->data['id_vendor'] = $id_vendor;
        $this->data['vendors'] = $this->access->readtable('sub_sub_vendor', '', array('deleted_at' => null, 'id_sub_vendor' => $id_vendor))->result_array();

        $this->data['isi'] = $this->load->view('vendors/sub_sub_vendor_v', $this->data, TRUE);
        $this->load->view('themes/layout_utama_v', $this->data);
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
