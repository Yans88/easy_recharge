<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $params = array('server_key' => 'SB-Mid-server-Btg5z166s3amR1W3PZTH0i3Z', 'production' => false);
        // $this->load->library('veritrans');
        // $this->veritrans->config($params);
        $this->load->model('Access', 'access', true);
    }

    public function index()
    {
        //echo 'test notification handler';
        // error_log(serialize($_POST));
        // init_set('always_populate_raw_post_data','-1');
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        // if($result){
        // $notif = $this->veritrans->status($result->order_id);
        // }

        $transaction = $result->transaction_status;
        $type = $result->payment_type;
        $order_id = $result->order_id;
        $fraud = $result->fraud_status;

        $simpan = array();

        $status_transaksi = 1;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    error_log("Transaction order_id: " . $order_id . " is challenged by FDS");
                    $status_transaksi = 3; //reject payment
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    error_log("Transaction order_id: " . $order_id . " successfully captured using " . $type);
                    $status_transaksi = 2; //complete payment
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            error_log("Transaction order_id: " . $order_id . " successfully transfered using " . $type);
            $status_transaksi = 2; //complete payment
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            error_log("Waiting customer to finish transaction order_id: " . $order_id . " using " . $type);
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $status_transaksi = 3; //deny payment
            error_log("Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.");
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'Denied'
            $status_transaksi = 7; //expired
            error_log("Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.");
        }
        $id_member = 0;
        $id_transaksi = 0;
        $chk_transaksi = $this->access->readtable('top_up_point', '', array('id' => $order_id, 'top_up_point.status' => 1))->row();
        $id_member = (int)$chk_transaksi->id_member;
        $id_transaksi = (int)$chk_transaksi->id;
        $point = (int)$chk_transaksi->point;


        $upd_dt = array();
        $upd_dt = array(
            'transaction_time' => date('Y-m-d H:i:s', strtotime($result->transaction_time)),
            'transaction_status' => $transaction,
            'transaction_id_midtrans' => $result->transaction_id,
            'status_code' => $result->status_code,
            'payment_types_midtrans' => $type,
            'status' => $status_transaksi
        );
        if ($status_transaksi == 2) $upd_dt += array('url_payment' => '');
        $this->access->updatetable('top_up_point', $upd_dt, array('id' => $id_transaksi));
        if ($status_transaksi == 2) {
            $login = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
            $total_point = (int)$login->total_point;
            $total_point = (int)$point + $total_point;
            $this->access->updatetable('members', array('total_point' => $total_point), array('id_member' => $id_member));
            $dt_history = array(
                'id_trans' => $id_transaksi,
                'id_member' => $id_member,
                'tipe' => 1,
                'point_saat_ini' => (int)$login->total_point,
                'point' => $point,
                'point_after_transaksi' => $total_point,
                'created_at' => date('Y-m-d H:i:s')
            );
            $save = $this->access->inserttable("point_history", $dt_history);
        }

    }

    public function succes_payment()
    {
        $res['dt'] = 'Congratulation';
        //echo '<script>console.log(\'RECEIVEOK\');</script>';
        $this->load->view('themes/succes_payment', $res);
    }


}