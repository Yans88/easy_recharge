<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.table > tbody > tr > td{
		vertical-align : middle;
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
	<table  class="table table-bordered table-reponsive">
	<form name="frm_edit" id="frm_edit">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Information  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="11%"><b>Kategori</b><br/><span class="label label-danger nama_kategori_error"></span></td>
			<td width="2%">:</td>
			<td width="35%">
            <input type="hidden" name="id_kategori" id="id_kategori" value="<?php echo !empty($kategori) ? $kategori->id_kategori : '';?>"  />
			
			<input class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Kategori" 
			style="width:90%; height:18px;" type="text" value="<?php echo !empty($kategori) ? $kategori->nama_kategori : '';?>" />
			</td>
            
             <td width="11%"><b>Harga 2 Jam</b><br/><span class="label label-danger harga_2jam_error"></span></td><td width="2%">:</td><td width="35%">
			<input class="form-control input_number" name="harga_2jam" id="harga_2jam" placeholder="Harga 2 Jam" style="width:90%; height:18px;" type="text" value="<?php echo !empty($kategori->harga_2jam) ? str_replace('.',',',$kategori->harga_2jam) : '';?>">
			 </td>
			
			</tr>
            
            <tr style="vertical-align:middle;">
			<td><b>Harga 1 Jam</b><br/><span class="label label-danger harga_1jam_error"></span></td><td width="2%">:</td>
			<td>
			<input class="form-control input_number" name="harga_1jam" id="harga_1jam" placeholder="Harga 1 Jam" style="width:90%; height:18px;" type="text" value="<?php echo !empty($kategori->harga_1jam) ? str_replace('.',',',$kategori->harga_1jam) : '';?>">
			</td>
            <td><b>Harga 3 Jam</b><br/><span class="label label-danger harga_3jam_error"></span></td><td width="2%">:</td><td>
			<input class="form-control input_number" name="harga_3jam" id="harga_3jam" placeholder="Harga 3 Jam" style="width:90%; height:18px;" type="text" value="<?php echo !empty($kategori->harga_3jam) ? str_replace('.',',',$kategori->harga_3jam) : '';?>">
			</td>        
			
			</tr>
            
			<tr>
			<td><b>Set Harga Aktif</b></td> 
			<td>:</td>
            <td>
				<select class="form-control" name="is_active" id="is_active" style="width:93%;">
					  <option value="">-- Harga Aktif --</option>
					  <option value="harga_1jam" <?php echo !empty($kategori) && $kategori->is_active == 'harga_1jam' ? ' selected' : '';?>>Harga 1 Jam</option>
					  <option value="harga_2jam" <?php echo !empty($kategori) && $kategori->is_active == 'harga_2jam' ? ' selected' : '';?>>Harga 2 Jam</option>
					  <option value="harga_3jam" <?php echo !empty($kategori) && $kategori->is_active == 'harga_3jam' ? ' selected' : '';?>>Harga 3 Jam</option>
				  </select>
			</td>
			<td><b></b></td>
			<td></td>
            <td>
				
			</td>
			
			</tr>
			
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
    	<a href="<?php echo site_url('merchants');?>" > <button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-remove"></i> Cancel</button></a>	
		
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">



$('.btn_save').click(function(){
	 var dt = $('#frm_edit').serialize();
	 var id_kategori = $('#id_kategori').val();
	 var nama_kategori = $('#nama_kategori').val();
	 var is_active = $('#is_active').val();
	 var harga = $('#'+is_active).val();	 
	 
	$('.nama_kategori_error').text('');
	$('.harga_1jam_error').text('');
	$('.harga_3jam_error').text('');
	$('.harga_2jam_error').text('');
	if(nama_kategori <= 0 || nama_kategori == '') {
		$('.nama_kategori_error').text('Kategori harus diisi');
		return false;
	}
	
	if(harga <= 0 || harga == '') {
		$('.'+is_active+'_error').text('Harga harus diisi');
		return false;
	}
	
	 var urls = '<?php echo site_url('kategori/simpan');?>';
	 $.ajax({
		url : urls,
		data : dt,
		type : 'POST',
		success:function(res){			
			if(res > 0){
				alert('Success, Data sudah disimpan');
				window.location = '<?php echo site_url('kategori');?>';
			}
		}
	 });
 });
$('.input_number').keyup(function(event) {  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});	
});
</script>
