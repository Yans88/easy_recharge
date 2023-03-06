<style type="text/css">
    .row * {
        box-sizing: border-box;
    }

    .kotak_judul {
        border-bottom: 1px solid #fff;
        padding-bottom: 2px;
        margin: 0;
    }

    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
    }

    .toggle.ios, .toggle-on.ios, .toggle-off.ios {
        border-radius: 20px;
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

<div class="modal fade" role="dialog" id="confirm_del">
    <div class="modal-dialog" style="width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
            </div>

            <div class="modal-body">
                <h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
                <input type="hidden" id="del_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_del">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="act_dialog">
    <div class="modal-dialog" style="width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
            </div>

            <div class="modal-body">
                <h4 class="text-center">Apakah anda yakin ? </h4>
                <input type="hidden" id="act_id" value="">
                <input type="hidden" id="status" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_act">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="box box-success">
    <div class="box-header">
        <a href="<?php echo site_url('vendors/add_sub_sub_vendor/' . $id_vendor); ?>">
            <button class="btn btn-success"><i class="fa fa-plus"></i> Add Sub sub Vendor</button>
        </a>
    </div>
    <div class="box-body">
        <div class='alert alert-info alert-dismissable' id="success-alert">

            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
            <div id="id_text"><b>Welcome</b></div>
        </div>
        <table id="example88" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="text-align:center; width:4%">No.</th>
                <th style="text-align:center; width:20%">Vendor Name</th>
                <th style="text-align:center; width:10%">Profit</th>

                <th style="text-align:center; width:50%">Address</th>
                <th style="text-align:center; width:10%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            $view_sub = '';
            $info = '';
            if (!empty($vendors)) {
                foreach ($vendors as $m) {
                    $view_sub = '';

                    echo '<tr>';
                    echo '<td align="center">' . $i++ . '.</td>';
                    echo '<td>' . $m['nama_vendor'] . '</td>';
                    echo '<td>' . $m['profit'] . '</td>';

                    echo '<td>' . $m['address'] . '</td>';
                    echo '<td align="center" style="vertical-align: middle;">';

                    echo '
		
			<a href="' . site_url('vendors/add_sub_sub_vendor/' . $m['id_sub_sub_vendor'] . '/' . $m['id_sub_sub_vendor']) . '" title="Edit"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<button title="Delete" id="' . $m['id_sub_sub_vendor'] . '" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
                    echo '</tr>';
                }
            }
            ?>
            </tbody>

        </table>
    </div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js"
        type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>


<script type="text/javascript">
    $("#success-alert").hide();
    $("input").attr("autocomplete", "off");
    $('.del_news').click(function () {
        var val = $(this).get(0).id;
        $('#del_id').val(val);
        $('#confirm_del').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#confirm_del").modal('show');
    });
    $('.yes_del').click(function () {
        var id = $('#del_id').val();
        var url = '<?php echo site_url('vendors/del');?>';
        $.ajax({
            data: {id: id},
            url: url,
            type: "POST",
            success: function (response) {
                $('#confirm_del').modal('hide');
                $("#id_text").html('<b>Success,</b> Data telah dihapus');
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                    $("#success-alert").alert('close');
                    location.reload();
                });
            }
        });

    });


    $(function () {
        $('#example88').dataTable({});
    });


</script>