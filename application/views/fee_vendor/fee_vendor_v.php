<style type="text/css">
    .row * {
        box-sizing: border-box;
    }


    .toggle.ios .toggle-handle {
        border-radius: 20px;
    }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
if (is_array($txt_periode_arr)) {
    $txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
}

?>


<div class="box box-success">

    <div class="box-body">

        <table id="example88" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="text-align:center; width:4%">No.</th>
                <th style="text-align:center; width:6%">ID</th>
                <th style="text-align:center; width:10%">Tanggal Sewa</th>
                <th style="text-align:center; width:10%">Tanggal Return</th>
                <th style="text-align:center; width:10%">Total</th>
                <th style="text-align:center; width:10%">Vendor 1</th>
                <th style="text-align:center; width:10%">Vendor 2</th>
                <th style="text-align:center; width:10%">Vendor 3</th>
                <th style="text-align:center; width:10%">Vendor 4</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            $view_sub = '';
            $info = '';
            if (!empty($transaksi)) {
                foreach ($transaksi as $t) {
                    $view_sub = '';
                    $info = (int)$t['status'] > 1 ? date("d M Y", strtotime($t['tgl_return'])) . ', ' . date('H:i', strtotime($t['tgl_return'])) . '(' . $t['lama_sewa_real'] . ' Jam)' : '-';
                    $htg_hrg = (int)$t['status'] > 1 ? '<br/>(' . $t['lama_sewa'] . ' x ' . number_format($t['point_jam'], 2, ',', '.') . ')' : '';
                    $fee_vendor1 = $t['total_point'] * ($t['fee_vendor_1'] / 100);
                    $fee_vendor2 = $t['total_point'] * ($t['fee_vendor_2'] / 100);
                    $fee_vendor3 = $t['total_point'] * ($t['fee_vendor_3'] / 100);
                    $fee_vendor4 = $t['total_point'] * ($t['fee_vendor_4'] / 100);
                    $vendor_id_2 = isset($vendors[$t['vendor_id_2']]) ? $vendors[$t['vendor_id_2']] : '';
                    $vendor_id_3 = isset($vendors[$t['vendor_id_3']]) ? $vendors[$t['vendor_id_3']] : '';
                    $vendor_id_4 = isset($vendors[$t['vendor_id_4']]) ? $vendors[$t['vendor_id_4']] : '';
                    $info1 = (int)$t['id_template'] > 0 ? 'Easy Recharge (' . $t['fee_vendor_1'] . '% = ' . number_format($fee_vendor1, 2, ',', '.') . ')' : '';
                    $info2 = (int)$t['vendor_id_2'] > 0 ? $vendor_id_2 . ' (' . $t['fee_vendor_2'] . '% = ' . number_format($fee_vendor2, 2, ',', '.') . ')' : '';
                    $info3 = (int)$t['vendor_id_3'] > 0 ? $vendor_id_3 . ' (' . $t['fee_vendor_3'] . '% = ' . number_format($fee_vendor3, 2, ',', '.') . ')' : '';
                    $info4 = (int)$t['vendor_id_4'] > 0 ? $vendor_id_4 . ' (' . $t['fee_vendor_4'] . '% = ' . number_format($fee_vendor4, 2, ',', '.') . ')' : '';
                    echo '<tr>';
                    echo '<td align="center">' . $i++ . '.</td>';
                    echo '<td align="center">' . $t['id_transaksi'] . '</td>';
                    echo '<td>' . date("d M Y", strtotime($t['tgl_sewa'])) . ', ' . date('H:i', strtotime($t['tgl_sewa'])) . '</td>';
                    echo '<td>' . $info . '</td>';
                    echo '<td align="right">' . number_format($t['total_point'], 2, ',', '.') . '' . $htg_hrg . '</td>';
                    echo '<td>' . $info1 . '</td>';
                    echo '<td>' . $info2 . '</td>';
                    echo '<td>' . $info3 . '</td>';
                    echo '<td>' . $info4 . '</td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>

        </table>
    </div>

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js"
        type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>


<script type="text/javascript">


    $(function () {
        $('#example88').dataTable({});
    });


</script>