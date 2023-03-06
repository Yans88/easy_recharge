<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sewa extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Access', 'access', true);
        $this->load->model('Setting_m', 'sm', true);
        $this->load->model('Api_m');
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }


    public function index()
    {
        $param = $this->input->post();

        $id_member = isset($param['id_member']) ? $param['id_member'] : '';
        $id_merchant = isset($param['id_merchant']) ? $param['id_merchant'] : '';
        $setting = $this->Api_m->get_key_val();
        $min_deposit = isset($setting['min_deposit']) ? str_replace('.', '', $setting['min_deposit']) : '';
        $min_deposit = isset($setting['min_deposit']) ? str_replace(',', '', $min_deposit) : '';
        $login = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
        $total_point = (int)$login->total_point;

        if ($total_point <= 0) {
            $result = array('err_code' => '01',
                'err_msg' => 'Point anda 0');
            http_response_code(200);
            echo json_encode($result);
            return false;
        }
        if ($total_point <= $min_deposit) {
            $result = array('err_code' => '01',
                'err_msg' => 'Point anda dibawah minimal deposit');
            http_response_code(200);
            echo json_encode($result);
            return false;
        }
        $transaksi_sewa = $this->access->readtable('transaksi_sewa', array('id_transaksi'), array('id_member' => $id_member, 'status' => 1))->result_array();
        if (count($transaksi_sewa) > 0) {
            $result = array('err_code' => '03',
                'err_msg' => 'tidak bisa melakukan penyewaan karena ada sewa berjalan');
            http_response_code(200);
            echo json_encode($result);
            return false;
        }
        $result = array();

        $data_insert = array(
            'id_member' => $id_member,
            'id_merchant' => $id_merchant,
            'status' => 1,
            'tgl_sewa' => date('Y-m-d H:i:s')
        );

        $save = $this->access->inserttable("transaksi_sewa", $data_insert);
        $data_insert += array('id_transaksi' => $save);
        $result = [
            'err_code' => '00',
            'err_msg' => 'OK',
            'data' => $data_insert
        ];
        http_response_code(200);
        echo json_encode($result);
    }

    public function returns()
    {
        $param = $this->input->post();
        $tgl_now = date('Y-m-d H:i:s');
        $id_transaksi = isset($param['id_transaksi']) ? $param['id_transaksi'] : '';
        $transaksi_sewa = $this->access->readtable('transaksi_sewa', '', array('id_transaksi' => $id_transaksi))->row();

        $id_merchant = $transaksi_sewa->id_merchant;
        $tgl_sewa = date('Y-m-d H:i:s', strtotime($transaksi_sewa->tgl_sewa));
        $id_member = $transaksi_sewa->id_member;
        $login = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
        $merchants = $this->access->readtable('merchants', '', array('id_merchants' => $id_merchant, 'kategori_station.deleted_at' => null),
            array('kategori_station' => 'kategori_station.id_kategori =  merchants.id_kategori'), '', '', 'LEFT')->row();

        $id_preset = $merchants->id_preset;
        $preset = $this->access->readtable('preset_template', '', array('id_preset' => $id_preset))->row();

        $total_point = (int)$login->total_point;
        if ($total_point <= 0) {
            $result = array('err_code' => '01',
                'err_msg' => 'Point anda 0');
            http_response_code(200);
            echo json_encode($result);
            return false;
        }

        $start = date_create($tgl_sewa);
        $end = date_create($tgl_now);
        // $diff=date_diff($end,$start);
        $diff_mins = abs($start->getTimestamp() - $end->getTimestamp()) / 60;
        $lama_sewa = ceil($diff_mins / 60);

        $harga_aktif = '';
        if ($merchants->is_active == 'harga_1jam') {
            $harga_aktif = $merchants->harga_1jam;
            $kali = ceil($lama_sewa / 1);
        }

        if ($merchants->is_active == 'harga_2jam') {
            $harga_aktif = $merchants->harga_2jam;
            $kali = ceil($lama_sewa / 2);
        }

        if ($merchants->is_active == 'harga_3jam') {
            $harga_aktif = $merchants->harga_3jam;
            $kali = ceil($lama_sewa / 3);
        }
        $harga_aktif = str_replace(',', '', $harga_aktif);
        $total_biaya_point = $kali * $harga_aktif;

        $fee_vendor_1 = $preset->fee_vendor_1 > 0 ? $preset->fee_vendor_1 : 0;

        $vendor_id_2 = $preset->vendor_id_2 > 0 ? $preset->vendor_id_2 : 0;
        $fee_vendor_2 = $preset->fee_vendor_2 > 0 ? $preset->fee_vendor_2 : 0;

        $vendor_id_3 = $preset->vendor_id_3 > 0 ? $preset->vendor_id_3 : 0;
        $fee_vendor_3 = $preset->fee_vendor_3 > 0 ? $preset->fee_vendor_3 : 0;

        $vendor_id_4 = $preset->vendor_id_4 > 0 ? $preset->vendor_id_4 : 0;
        $fee_vendor_4 = $preset->fee_vendor_4 > 0 ? $preset->fee_vendor_4 : 0;

        $data_upd = array(
            'id_template' => $id_preset,
            'lama_sewa' => $kali,
            'lama_sewa_real' => $lama_sewa,
            'status' => 2,
            'total_point' => $total_biaya_point,
            'harga_aktif' => $merchants->is_active,
            'point_jam' => $harga_aktif,
            'tgl_return' => $tgl_now,
            'fee_vendor_1' => $fee_vendor_1,
            'vendor_id_2' => $vendor_id_2,
            'fee_vendor_2' => $fee_vendor_2,
            'vendor_id_3' => $vendor_id_3,
            'fee_vendor_3' => $fee_vendor_3,
            'vendor_id_4' => $vendor_id_4,
            'fee_vendor_4' => $fee_vendor_4,
        );
        if ($total_biaya_point > $total_point) {
            $result = array('err_code' => '02',
                'err_msg' => 'Point anda ' . $total_point . ' tidak cukup',
                'data' => $data_upd);
            http_response_code(200);
            echo json_encode($result);
            return false;
        }
        $total_point = (int)$total_point - $total_biaya_point;
        $this->access->updatetable('transaksi_sewa', $data_upd, array('id_transaksi' => $id_transaksi));
        $this->access->updatetable('members', array("total_point" => $total_point), array('id_member' => $id_member));
        $dt_history = array(
            'id_trans' => $id_transaksi,
            'id_member' => $id_member,
            'tipe' => 2,
            'point_saat_ini' => (int)$login->total_point,
            'point' => $total_biaya_point,
            'point_after_transaksi' => $total_point,
            'created_at' => date('Y-m-d H:i:s')
        );
        $dt_history_vendor = array();
        if ((int)$vendor_id_2 > 0) {
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_2 / 100),
                'id_vendor' => $vendor_id_2,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }
        if ((int)$vendor_id_3 > 0) {
            $dt_history_vendor = array();
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_3 / 100),
                'id_vendor' => $vendor_id_3,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }
        if ((int)$vendor_id_4 > 0) {
            $dt_history_vendor = array();
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_4 / 100),
                'id_vendor' => $vendor_id_4,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }

        $this->access->inserttable("point_history", $dt_history);
        $result = [
            'err_code' => '00',
            'err_msg' => 'OK',
            'data' => $data_upd
        ];
        http_response_code(200);
        echo json_encode($result);
    }

    public function history()
    {
        $param = $this->input->post();

        $id_member = isset($param['id_member']) ? $param['id_member'] : '';
        $id_merchant = isset($param['id_merchant']) ? $param['id_merchant'] : '';
        $transaksi_sewa = $this->access->readtable('transaksi_sewa', array('transaksi_sewa.*', 'nama_merchants', 'address', 'id_machine'), array('id_member' => $id_member),
            array('merchants' => 'merchants.id_merchants =  transaksi_sewa.id_merchant'), '', '', 'LEFT')->result_array();

        $result = array();
        $dt = [];
        if (!empty($transaksi_sewa)) {
            foreach ($transaksi_sewa as $m) {

                $dt[] = array(
                    'id_transaksi' => $m['id_transaksi'],
                    'id_member' => $m['id_member'],
                    'id_merchant' => $m['id_merchant'],
                    'status' => $m['status'],
                    'nama_merchants' => $m['nama_merchants'],
                    'address_merchants' => $m['address'],
                    'id_machine' => $m['id_machine'],
                    'lama_sewa' => $m['lama_sewa'],
                    'point_jam' => $m['point_jam'],
                    'total_point' => $m['total_point'],
                    'tgl_sewa' => $m['tgl_sewa'],
                    'tgl_return' => $m['tgl_return'],
                    'harga_aktif' => $m['harga_aktif'],
                    'lama_sewa_real' => $m['lama_sewa_real'],
                    'updated_at' => $m['updated_at'],

                );
            }
        }

        $result = [
            'err_code' => '04',
            'err_msg' => 'data not found',
            'data' => $dt
        ];
        if (count($dt) > 0) {
            $result = [
                'err_code' => '00',
                'err_msg' => 'ok',
                'data' => $dt
            ];
        }
        http_response_code(200);
        echo json_encode($result);
    }

    public function history_detail()
    {
        $param = $this->input->post();
        $id_transaksi = isset($param['id_transaksi']) ? $param['id_transaksi'] : '';
        $transaksi_sewa = $this->access->readtable('transaksi_sewa', array('transaksi_sewa.*', 'nama_merchants', 'address as address_merchants', 'id_machine'), array('id_transaksi' => $id_transaksi),
            array('merchants' => 'merchants.id_merchants =  transaksi_sewa.id_merchant'), '', '', 'LEFT')->row();
        $result = [
            'err_code' => '00',
            'err_msg' => 'ok',
            'data' => $transaksi_sewa
        ];
        http_response_code(200);
        echo json_encode($result);
    }

    function test_fee_vendor(){
        $vendor_id_2 = 2;
        $vendor_id_3 = 3;
        $vendor_id_4 = 4;
        $id_transaksi = 2;
        $total_biaya_point = 100000;
        $fee_vendor_2 = 30;
        $fee_vendor_3 = 20;
        $fee_vendor_4 = 10;
        $dt_history_vendor = array();
        if ((int)$vendor_id_2 > 0) {
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_2 / 100),
                'id_vendor' => $vendor_id_2,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }
        if ((int)$vendor_id_3 > 0) {
            $dt_history_vendor = array();
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_3 / 100),
                'id_vendor' => $vendor_id_3,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }
        if ((int)$vendor_id_4 > 0) {
            $dt_history_vendor = array();
            $dt_history_vendor = array(
                'id_trans' => $id_transaksi,
                'jumlah' => $total_biaya_point * ($fee_vendor_4 / 100),
                'id_vendor' => $vendor_id_4,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->access->inserttable("fee_vendor", $dt_history_vendor);
        }

    }


}