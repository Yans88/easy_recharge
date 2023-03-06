<style type="text/css">
    .row * {
        box-sizing: border-box;
    }

    .form-control[readonly]{
        background-color: #fff;
        cursor:text;
    }

    .toggle.ios .toggle-handle {
        border-radius: 20px;
    }
    .box .box-header > .box-tools {
        padding: 15px 25px 15px 30px;
    }

    .box .box-header {
        border-bottom: 1px solid #dddddd;
    }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
if (is_array($txt_periode_arr)) {
    $txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
}
$tgl_view = str_replace(' - ','to', $tgl);
$tgl_view = str_replace('/','_', $tgl_view);
?>


<div class="box box-success">

    <div class="box-header">

        <div class="pull-right box-tools">
            <form action="" method="post" autocomplete="off" class="pull-right" id="search_report">

                <label>Tanggal</label>
                <input type="text" name="tgl" id="tgl" value="<?php echo $tgl;?>" style="width:150px; height: 24px;" readonly>
                <button type="button" id="btn_submit" class="btn btn-xs btn-success" style="height:27px;"><i
                            class="glyphicon glyphicon-search"></i> Search
                </button>
                <button type="button" class="btn btn-xs btn-warning res" style="height:27px;"><i
                            class="glyphicon glyphicon-refresh"></i> Reset
                </button>

            </form>
        </div>
    </div>

    <div class="box-body">

        <table id="example88" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="text-align:center; width:4%">No.</th>
                <th style="text-align:center; width:10%">Tanggal</th>
                <th style="text-align:center; width:70%">Vendor</th>
                <th style="text-align:center; width:10%">Jumlah</th>
<!--                <th style="text-align:center; width:10%">Action</th>-->

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
                    echo '<td align="center">' . $i++ . '.</td>';
                    echo '<td>' . date("d M Y", strtotime($t['created_at'])) . '</td>';
                    echo '<td>' . $t['nama_vendor'] . '</td>';

                    echo '<td align="right">' . number_format($t['jumlah'], 2, ',', '.') . '</td>';
                    //echo '<td align="center"><a href="'.site_url('fee_vendor/report_detail/'.$tgl_view).'" title="Detail"><button class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</button></a></td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>

        </table>
    </div>

</div>
<link href="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js"
        type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>


<script type="text/javascript">

    $(function () {
        $("#tgl").css({"color": "#000", "border": "1px solid #cccccc"});

        $('input[name="tgl"]').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            maxDate: moment().format('D/MM/Y'),
            locale: {
                format: 'D/MM/Y'
            }
        });
    });
    $('input[name="tgl"]').on('apply.daterangepicker', function (ev, picker) {
        $("#tgl").css({"color": "#000", "border": "1px solid #cccccc"});

        $(this).val(picker.startDate.format('D/MM/Y') + ' - ' + picker.endDate.format('D/MM/Y'));

    });

    $('input[name="tgl"]').on('cancel.daterangepicker', function (ev, picker) {
        $("#tgl").css({"color": "#000", "border": "1px solid #cccccc"});

        $(this).val('');
    });

    $(function () {
        $('#example88').dataTable({});
    });
    var url = '<?php $url;?>';
    $('.res').click(function(){
        window.location.href = url;
    });
    $("#btn_submit").click(function(){
        var tgl = $('#tgl').val();
        if(tgl == '' || tgl == 'Tanggal harus diisi'){
            $('#tgl').val('Tanggal harus diisi');
            $("#tgl").css({"color":"red","border": "1px solid red"});
            return false;
        }
        $('#search_report').attr('action', url);
        $('#search_report').submit();
    });
</script>