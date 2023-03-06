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

                    <th style="vertical-align: middle; text-align:center"> Information</th>
                </tr>
                <tr>

                    <td>
                        <table class="table table-responsive">
                            <tr style="vertical-align:middle;">
                                <td width="11%"><b>Template</b><br/><span
                                            class="label label-danger nama_template_error"></span></td>
                                <td width="2%">:</td>
                                <td colspan="4">
                                    <input type="hidden" name="id_preset" id="id_preset"
                                           value="<?php echo !empty($preset) ? $preset->id_preset : ''; ?>"/>

                                    <input class="form-control" name="nama_template" id="nama_template"
                                           placeholder="Template"
                                           style="width:96%; height:18px;" type="text"
                                           value="<?php echo !empty($preset) ? $preset->nama_template : ''; ?>"/>
                                </td>


                            </tr>

                            <tr style="vertical-align:middle;">
                                <td width="11%"><b>Vendor 1 </b><br/></td>
                                <td width="2%">:</td>
                                <td>
                                    <select class="form-control" name="vendor_1" id="vendor_1" style="width:93%;"
                                            disabled>
                                        <option value="">Easy Recharge</option>
                                    </select>
                                </td>
                                <td width="11%" align="right"><b>Fee Vendor 1 (%)</b><br/><span
                                            class="label label-danger fee_vendor_1_error"></span>
                                </td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control input_number" name="fee_vendor_1" id="fee_vendor_1"
                                           placeholder="Fee Vendor 1" style="width:91%; height:18px;" type="text"
                                           maxlength="3"
                                           value="<?php echo !empty($preset->fee_vendor_1) ? str_replace('.', ',', $preset->fee_vendor_1) : ''; ?>">
                                </td>
                            </tr>

                            <tr style="vertical-align:middle;">
                                <td><b>Vendor 2 </b><br/><span class="label label-danger vendor_id_2_error"></span></td>
                                <td width="2%">:</td>
                                <td>
                                    <select class="form-control" name="vendor_id_2" id="vendor_id_2" style="width:93%;">
                                        <option value="">-- Vendor 2 --</option>
                                        <?php if (!empty($vendors)) {
                                            foreach ($vendors as $k) {
                                                if (!empty($preset) && $preset->vendor_id_2 == $k['id_vendor']) {
                                                    echo '<option value="' . $k['id_vendor'] . '" selected>' . $k['nama_vendor'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $k['id_vendor'] . '">' . $k['nama_vendor'] . '</option>';
                                                }
                                            }
                                        } ?>
                                    </select>
                                </td>
                                <td align="right"><b>Fee Vendor 2 (%)</b><br/><span
                                            class="label label-danger fee_vendor_2_error"></span>
                                </td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control input_number" name="fee_vendor_2" id="fee_vendor_2"
                                           placeholder="Fee Vendor 2" style="width:91%; height:18px;" type="text"
                                           maxlength="2"
                                           value="<?php echo !empty($preset->fee_vendor_2) ? str_replace('.', ',', $preset->fee_vendor_2) : ''; ?>">
                                </td>
                            </tr>

                            <tr style="vertical-align:middle;">
                                <td><b>Vendor 3 </b><br/><span class="label label-danger vendor_id_3_error"></span></td>
                                <td width="2%">:</td>
                                <td>
                                    <select class="form-control" name="vendor_id_3" id="vendor_id_3" style="width:93%;">
                                        <option value="">-- Vendor 3 --</option>
                                        <?php if (!empty($vendors)) {
                                            foreach ($vendors as $k) {
                                                if (!empty($preset) && $preset->vendor_id_3 == $k['id_vendor']) {
                                                    echo '<option value="' . $k['id_vendor'] . '" selected>' . $k['nama_vendor'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $k['id_vendor'] . '">' . $k['nama_vendor'] . '</option>';
                                                }
                                            }
                                        } ?>
                                    </select>
                                </td>
                                <td align="right"><b>Fee Vendor 3 (%)</b><br/><span
                                            class="label label-danger fee_vendor_3_error"></span>
                                </td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control input_number" name="fee_vendor_3" id="fee_vendor_3"
                                           placeholder="Fee Vendor 3" style="width:91%; height:18px;" type="text"
                                           maxlength="2"
                                           value="<?php echo !empty($preset->fee_vendor_3) ? str_replace('.', ',', $preset->fee_vendor_3) : ''; ?>">
                                </td>
                            </tr>

                            <tr style="vertical-align:middle;">
                                <td><b>Vendor 4 </b><br/><span class="label label-danger vendor_id_4_error"></span></td>
                                <td width="2%">:</td>
                                <td>
                                    <select class="form-control" name="vendor_id_4" id="vendor_id_4" style="width:93%;">
                                        <option value="">-- Vendor 4 --</option>
                                        <?php if (!empty($vendors)) {
                                            foreach ($vendors as $k) {
                                                if (!empty($preset) && $preset->vendor_id_4 == $k['id_vendor']) {
                                                    echo '<option value="' . $k['id_vendor'] . '" selected>' . $k['nama_vendor'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $k['id_vendor'] . '">' . $k['nama_vendor'] . '</option>';
                                                }
                                            }
                                        } ?>
                                    </select>
                                </td>
                                <td align="right"><b>Fee Vendor 4 (%)</b><br/><span
                                            class="label label-danger fee_vendor_4_error"></span>
                                </td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control input_number" name="fee_vendor_4" id="fee_vendor_4"
                                           placeholder="Fee Vendor 4" style="width:91%; height:18px;" type="text"
                                           maxlength="2"
                                           value="<?php echo !empty($preset->fee_vendor_4) ? str_replace('.', ',', $preset->fee_vendor_4) : ''; ?>">
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
            <a href="<?php echo site_url('merchants'); ?>">
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

        var nama_template = $('#nama_template').val();
        var fee_vendor_1 = $('#fee_vendor_1').val();
        var fee_vendor_2 = $('#fee_vendor_2').val();
        var fee_vendor_3 = $('#fee_vendor_3').val();
        var fee_vendor_4 = $('#fee_vendor_4').val();
        var vendor_id_2 = $('#vendor_id_2').val();
        var vendor_id_3 = $('#vendor_id_3').val();
        var vendor_id_4 = $('#vendor_id_4').val();
        var total_fee = Number(fee_vendor_1) + Number(fee_vendor_2) + Number(fee_vendor_3) + Number(fee_vendor_4);

        $('.nama_template_error').text('');
        $('.fee_vendor_1_error').text('');
        $('.vendor_id_2_error').text('');
        $('.vendor_id_3_error').text('');
        $('.vendor_id_4_error').text('');
        if (nama_template <= 0 || nama_template == '') {
            $('.nama_template_error').text('Template harus diisi');
            return false;
        }
        if (fee_vendor_1 <= 0 || fee_vendor_1 == '') {
            $('.fee_vendor_1_error').text('Harus diisi');
            return false;
        }
        if (total_fee > 100) {
            $('.fee_vendor_1_error').text('Total fee melebihi 100 %');
        }
        if (total_fee < 100) {
            $('.fee_vendor_1_error').text('Total fee kurang dari 100 %');
        }
        if (fee_vendor_2 > 0) {
            if (vendor_id_2 == '' || vendor_id_2 <= 0) {
                $('.vendor_id_2_error').text('Harus diisi');
                return false;
            }
        }
        if (fee_vendor_3 > 0) {
            if (vendor_id_3 == '' || vendor_id_3 <= 0) {
                $('.vendor_id_3_error').text('Harus diisi');
                return false;
            }
            if (vendor_id_2 == '' || vendor_id_2 <= 0) {
                $('.vendor_id_2_error').text('Harus diisi');
                return false;
            }
        }
        if (fee_vendor_4 > 0) {
            if (vendor_id_4 == '' || vendor_id_4 <= 0) {
                $('.vendor_id_4_error').text('Harus diisi');
                return false;
            }
            if (vendor_id_3 == '' || vendor_id_3 <= 0) {
                $('.vendor_id_3_error').text('Harus diisi');
                return false;
            }
            if (vendor_id_2 == '' || vendor_id_2 <= 0) {
                $('.vendor_id_2_error').text('Harus diisi');
                return false;
            }
        }
        if (vendor_id_2 > 0 && vendor_id_3 > 0 && vendor_id_2 == vendor_id_3) {
            $('.vendor_id_3_error').text('Vendor 3 sama dengan vendor 2');
            return false;
        }
        if (vendor_id_3 > 0 && vendor_id_4 > 0 && vendor_id_3 == vendor_id_4) {
            $('.vendor_id_4_error').text('Vendor 4 sama dengan vendor 3');
            return false;
        }
        if (vendor_id_2 > 0 && vendor_id_4 > 0 && vendor_id_2 == vendor_id_4) {
            $('.vendor_id_4_error').text('Vendor 4 sama dengan vendor 2');
            return false;
        }

        var urls = '<?php echo site_url('preset_template/simpan');?>';
        $.ajax({
            url: urls,
            data: dt,
            type: 'POST',
            success: function (res) {
                if (res > 0) {
                    alert('Success, Data sudah disimpan');
                    window.location = '<?php echo site_url('preset_template');?>';
                }
            }
        });
    });
    $('.input_number').keyup(function (event) {
        // format number
        $(this).val(function (index, value) {
            return value
                .replace(/[^.\d]/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
</script>
