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

                    <th style="vertical-align: middle; text-align:center"> Station Information</th>
                </tr>
                <tr>

                    <td>
                        <table class="table table-responsive">
                            <tr style="vertical-align:middle;">
                                <td width="11%"><b>Nama Station </b></td>
                                <td width="2%">:</td>
                                <td>
                                    <input type="hidden" name="id_merchants" id="id_merchants"
                                           value="<?php echo !empty($merchants) ? $merchants->id_merchants : ''; ?>"/>
                                    <input class="form-control" name="nama_merchant" id="nama_merchant"
                                           placeholder="Nama Station" style="width:90%; height:18px;" type="text"
                                           value="<?php echo !empty($merchants) ? $merchants->nama_merchants : ''; ?>"
                                </td>

                                <td width="8%"><b>Latitude</b></td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control" name="latitude" id="latitude" placeholder="Latitude"
                                           style="width:90%; height:18px;" type="text"
                                           value="<?php echo !empty($merchants->latitude) ? $merchants->latitude : ''; ?>">
                                </td>

                            </tr>

                            <tr style="vertical-align:middle;">
                                <td><b>Vending Machine</b></td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control" name="id_machine" id="id_machine"
                                           placeholder="Vending Machine" style="width:90%; height:18px;" type="text"
                                           value="<?php echo !empty($merchants->id_machine) ? $merchants->id_machine : ''; ?>">
                                </td>
                                <td><b>Longitude</b><span class="label label-danger pull-right email_error"></span></td>
                                <td width="2%">:</td>
                                <td>
                                    <input class="form-control" name="longitude" id="longitude" placeholder="Longitude"
                                           style="width:90%; height:18px;" type="text"
                                           value="<?php echo !empty($merchants->longitude) ? $merchants->longitude : ''; ?>">
                                </td>

                            </tr>

                            <tr>
                                <td><b>Kategori</b><br/><span class="label label-danger id_kategori_error"></span></td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="id_kategori" id="id_kategori" style="width:93%;">
                                        <option value="">-- Kategori --</option>
                                        <?php
                                        if (!empty($kategori)) {
                                            foreach ($kategori as $k) {
                                                if (!empty($merchants) && $merchants->id_kategori == $k['id_kategori']) {
                                                    echo '<option value="' . $k['id_kategori'] . '" selected>' . $k['nama_kategori'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $k['id_kategori'] . '">' . $k['nama_kategori'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><b>Preset template </b><br/><span class="label label-danger id_preset_error"></span>
                                </td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="id_preset" id="id_preset" style="width:93%;">
                                        <option value="">-- Preset template --</option>
                                        <?php
                                        if (!empty($preset)) {
                                            foreach ($preset as $k) {
                                                if (!empty($merchants) && $merchants->id_preset == $k['id_preset']) {
                                                    echo '<option value="' . $k['id_preset'] . '" selected>' . $k['nama_template'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $k['id_preset'] . '">' . $k['nama_template'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>

                            </tr>


                            <tr>
                                <td><b>Alamat</b></td>
                                <td width="2%">:</td>
                                <td colspan=7>
                                    <textarea name="alamat" id="alamat" class="form-control" style="width:96%;"
                                              rows="5"><?php echo !empty($merchants->address) ? $merchants->address : ''; ?></textarea>
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


    function check_machine(machine) {
        var urls = '<?php echo site_url('merchants/check_machine');?>';
        $.ajax({
            url: urls,
            data: {id_machine: machine},
            type: 'POST',
            success: function (res) {
                if (res > 0) {
                    return false;
                } else {
                    return true;
                }
            }
        });
    }

    $('.btn_save').click(function () {
        var dt = $('#frm_edit').serialize();
        var id_machine = $('#id_machine').val();
        var id_merchants = $('#id_merchants').val();
        var id_kategori = $('#id_kategori').val();
        $('.id_kategori_error').text('');
        $('.id_preset_error').text('');
        if (id_kategori <= 0 || id_kategori == '') {
            $('.id_kategori_error').text('Harus diisi');
            return false;
        }
        if (id_preset <= 0 || id_preset == '') {
            $('.id_preset_error').text('Harus diisi');
            return false;
        }
        var urls = '<?php echo site_url('merchants/chk_machine');?>';
        $.ajax({
            url: urls,
            data: {id_machine: id_machine},
            type: 'POST',
            success: function (res) {
                if (res > 0 && id_merchants != res) {
                    alert('ID Machine sudah terdaftar');
                    return false;
                } else {
                    var url = '<?php echo site_url('merchants/simpan_merchant');?>';
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: dt,
                        success: function (result) {
                            if (result > 0) {
                                alert('Success, Data sudah disimpan');
                                window.location = '<?php echo site_url('merchants');?>';
                            }
                        }
                    });
                }
            }
        });
    });
    $('#fee').keyup(function (event) {

        // format number
        $(this).val(function (index, value) {
            return value
                .replace(/[^\d,]/g, '');
        });
    });
</script>
