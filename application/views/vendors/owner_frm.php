<style type="text/css">
    .row * {
        box-sizing: border-box;
    }

    .kotak_judul {
        border-bottom: 1px solid #fff;
        padding-bottom: 2px;
        margin: 0;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
    }

    .custom-file-input::-webkit-file-upload-button {
        visibility: hidden;
    }

    .custom-file-input::before {
        content: 'Select Photo';
        display: inline-block;
        background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
        border: 1px solid #999;
        border-radius: 3px;
        padding: 1px 4px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        text-shadow: 1px 1px #fff;
        font-weight: 700;
    }

    .custom-file-input:hover::before {
        color: #d3394c;
    }

    .custom-file-input:active::before {
        background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        color: #d3394c;
    }

</style>
<?php
$tanggal = date('Y-m');


?>

<div class="box box-success">

    <div class="box-body">
        <table class="table table-bordered table-reponsive">
            <form name="frm_edit" id="frm_edit">
                <tr class="header_kolom">

                    <th style="vertical-align: middle; text-align:center"> Vendor Information</th>
                </tr>
                <tr>

                    <td>
                        <table class="table table-responsive">
                            <tr style="vertical-align:middle;">
                                <td width="11%"><b>Nama Vendor </b></td>
                                <td width="2%">:</td>
                                <td colspan="4">
                                    <input type="hidden" name="id_vendor" id="id_vendor"
                                           value="<?php echo !empty($vendors) ? $vendors->id : ''; ?>"/>
                                    <input class="form-control" name="nama_vendor" id="nama_vendor"
                                           placeholder="Nama Vendor" style="width:98%; height:18px;" type="text"
                                           readonly
                                           value="<?php echo !empty($vendors) ? $vendors->nama_vendor : ''; ?>"/>
                                </td>
                            <tr>
                                <td><b>Profit</b><br/><span class="label label-danger profit_error"></span></td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control" name="profit" id="profit" placeholder="Profit"
                                           style="width:98%; height:18px;" type="text" maxlength="3"
                                           value="<?php echo !empty($vendors) ? $vendors->profit : ''; ?>"/>
                                </td>
                                <td align="right"><b>Sharing</b></td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control" name="sharing" id="sharing" placeholder="Sharing"
                                           style="width:95%; height:18px;" type="text" maxlength="3"
                                           value="<?php echo !empty($vendors) ? $vendors->sharing : ''; ?>"/>
                                </td>
                            </tr>


                            <tr>
                                <td><b>Alamat</b></td>
                                <td width="2%">:</td>
                                <td colspan=7>
                                    <textarea name="alamat" id="alamat" class="form-control" style="width:98%;"
                                              rows="5"><?php echo !empty($vendors->address) ? $vendors->address : ''; ?></textarea>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
        </table>

        </form>


    </div>
    <div class="box-footer" style="height:35px;">
        <div class="clearfix"></div>
        <div class="pull-right">
            <a href="<?php echo site_url('vendors'); ?>">
                <button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-remove"></i> Cancel
                </button>
            </a>

            <button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js"
        type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js"
        type="text/javascript"></script>

<script type="text/javascript">

    $('.btn_save').click(function () {
        var dt = $('#frm_edit').serialize();
        var profit = $('#profit').val();
        var sharing = $('#sharing').val();
        $('.profit_error').text('');
        if (profit <= 0 || profit == '') {
            $('.profit_error').text('Harus diisi minimal 1 dan maksimal 100');
            return false;
        }
        if (Number(profit) + Number(sharing) > 100) {
            $('.profit_error').text('Jumlah profit dan sharing tidak boleh lebih dari 100%');
            return false;
        }
        var url = '<?php echo site_url('vendors/simpan_owner');?>';
        $.ajax({
            url: url,
            data: dt,
            type: 'POST',
            success: function (result) {
                if (result > 0) {
                    alert('Success, Data sudah disimpan');
                    window.location = '<?php echo site_url('vendors');?>';
                }
            }
        });
    });

</script>
