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

	
$id_level = isset($level->id) ? $level->id : '';
$level_name = isset($level->level_name) ? $level->level_name : '';
$data_harga = isset($level->data_harga) && $level->data_harga > 0 ? 'checked' : '';
$data_toko	 = isset($level->data_toko	) && $level->data_toko	 > 0 ? 'checked' : '';
$data_event = isset($level->data_event) && $level->data_event > 0 ? 'checked' : '';
$data_cek_hp = isset($level->data_cek_hp) && $level->data_cek_hp > 0 ? 'checked' : '';
$logistik = isset($level->logistik) && $level->logistik > 0 ? 'checked' : '';
$master_lokasi = isset($level->master_lokasi) && $level->master_lokasi > 0 ? 'checked' : '';
$price_setting = isset($level->price_setting) && $level->price_setting > 0 ? 'checked' : '';
$terms_condition = isset($level->terms_condition) && $level->terms_condition > 0 ? 'checked' : '';
$data_user_eup = isset($level->data_user_eup) && $level->data_user_eup > 0 ? 'checked' : '';
$data_eup = isset($level->data_eup) && $level->data_eup > 0 ? 'checked' : '';
$data_cek_hp_eup = isset($level->data_cek_hp_eup) && $level->data_cek_hp_eup > 0 ? 'checked' : '';
$logistik_eup = isset($level->logistik_eup) && $level->logistik_eup > 0 ? 'checked' : '';
$grafik = isset($level->grafik) && $level->grafik > 0 ? 'checked' : '';
$analisa = isset($level->analisa) && $level->analisa > 0 ? 'checked' : '';
$_level = isset($level->level) && $level->level > 0 ? 'checked' : '';
$users = isset($level->users) && $level->users > 0 ? 'checked' : '';

?>

<div class="box box-success">

<div class="box-body">	
<form name="frm_editrole" id="frm_editrole"  method="post">
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left">Level</th>			
		</tr>
		<tr style="border:none;">			
			<td class="h_tengah" style="vertical-align:middle; border:none;">		
				<table class="table table-responsive">
					<tr style="vertical-align:middle; border:none;">
						<td style="border:none;" width="10%"><b> Level Name </td>
						<td style="border:none;" width="2%">:</td>
						<td style="border:none;">
						<input name="level_name" value="<?php echo $level_name;?>" type="text" style="width:100%; height:24px; padding-left: 5px;"/>
						</td>
						<input name="id_level" value="<?php echo $id_level;?>" type="hidden" style="width:100%; height:24px;"/>
					</tr>
				</table>
			</td>			
		</tr>	
	</table>
	
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left" colspan=2>Role(Hak akses management)</th>			
		</tr>
		<tr style="border-top:none;">			
			<td class="h_tengah" style="vertical-align:middle; border-top:none; width:50%;">		
				<table class="table table-responsive">
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="40%"><b>Data Harga</b></td>					
						<td style="border-top:none;">
							<input name="data_harga" <?php echo $data_harga;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Data Toko</b></td>				
						<td style="border-top:none;">
							<input name="data_toko" <?php echo $data_toko;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Data Event</b></td>				
						<td style="border-top:none;">
							<input name="data_event" <?php echo $data_event;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Data Cek HP</b></td>				
						<td style="border-top:none;">
							<input name="data_cek_hp" <?php echo $data_cek_hp;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Logistik</b></td>				
						<td style="border-top:none;">
							<input name="logistik" <?php echo $logistik;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Lokasi</b></td>				
						<td style="border-top:none;">
							<input name="master_lokasi" <?php echo $master_lokasi;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Price Setting</b></td>				
						<td style="border-top:none;">
							<input name="price_setting" <?php echo $price_setting;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Terms Condition</b></td>				
						<td style="border-top:none;">
							<input name="terms_condition" <?php echo $terms_condition;?> type="checkbox" value=1 />
						</td>
					</tr>
				</table>
			</td>			
			<td class="h_tengah" style="width:50%; border-top:none;">		
				<table class="table table-responsive">
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="40%"><b>Data User EUP</b></td>		
						<td style="border-top:none;">
							<input name="data_user_eup" <?php echo $data_user_eup;?> type="checkbox" value=1 />
						</td>
					</tr>
				
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Data EUP</b></td>		
						<td style="border-top:none;">
							<input name="data_eup" <?php echo $data_eup;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Data Cek HP EUP</b></td>		
						<td style="border-top:none;">
							<input name="data_cek_hp_eup" <?php echo $data_cek_hp_eup;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Logistik EUP</b></td>		
						<td style="border-top:none;">
							<input name="logistik_eup" <?php echo $logistik_eup;?> type="checkbox" value=1 />
						</td>
					</tr>
				
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Grafik</b></td>				
						<td style="border-top:none;">
							<input name="grafik" <?php echo $grafik;?> type="checkbox" value=1 />
						</td>
					</tr>					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Analisa</b></td>				
						<td style="border-top:none;">
							<input name="analisa" <?php echo $analisa;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Level</b></td>				
						<td style="border-top:none;">
							<input name="level" <?php echo $_level;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Users</b></td>				
						<td style="border-top:none;">
							<input name="users" <?php echo $users;?> type="checkbox" value=1 />
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
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$(".canc").click(function(){
	window.location = '<?php echo site_url('role');?>';
});
$('.save').click(function(){
	var data = $("#frm_editrole").serialize();
	console.log(data);
	var url = '<?php echo site_url('role/save');?>';
	$.ajax({
		url : url,
		type : 'POST',
		data : data,
		success:function(res){
			console.log(res);
			if(res > 0){
				window.location = '<?php echo site_url('role');?>';
			}
		}
	});
});

 
</script>
