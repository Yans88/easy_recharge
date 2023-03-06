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
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-messages, .direct-chat-contacts {
		-webkit-transition: -webkit-transform .5s ease-in-out;
		-moz-transition: -moz-transform .5s ease-in-out;
		-o-transition: -o-transform .5s ease-in-out;
		transition: transform .5s ease-in-out;
	}
	.direct-chat-messages {
		-webkit-transform: translate(0, 0);
		-ms-transform: translate(0, 0);
		-o-transform: translate(0, 0);
		transform: translate(0, 0);
		padding: 10px;
		height: 300px;
		overflow: auto;
	}
	
	.direct-chat-msg, .direct-chat-text {
		display: block;
	}	
	.direct-chat-info {
		display: block;
		margin-bottom: 2px;
		font-size: 12px;
	}
	
	.direct-chat-text:before {
		border-width: 8px !important;
		margin-top: 3px;
	}
	.direct-chat-text:before {
		position: absolute;
		right: 100%;		
		
		border-right-color: #d2d6de;
		content: ' ';
		height: 0;
		width: 0;
		pointer-events: none;
	}
	
	.direct-chat-text {
		display: block;
	}
	.direct-chat-text {
		border-radius: 5px;
		position: relative;
		padding: 5px 10px;
		background: #d2d6de;
		border: 1px solid #d2d6de;
		margin: 5px 0 0 5px;
		color: #444;
	}
	.direct-chat-warning .right>.direct-chat-text{
		background: #ddd;
		border-color: #ddd;
		color: #000;
	}
	
	
</style>


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
				<input type="hidden" id="image" value="">
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
<?php 
$nama = !empty($member->nama) ? $member->nama : '';
$dob = !empty($member->dob) ? date('d-m-Y', strtotime($member->dob)) : '';
$email = !empty($member->email) ? $member->email : '';
$phone = !empty($member->phone) ? $member->phone : '';
$e_wallet = $member->total_point > 0 ? number_format($member->total_point,2,',','.') : '0.00'; 


$cnt_point = !empty($member->total_point) ? $member->total_point : 0;
$img = !empty($member->photo) ? $member->photo : base_url('uploads/no_photo.jpg');
$kota = !empty($member->kota) ? $member->kota : '';
$kode_pos = !empty($member->kode_pos) ? $member->kode_pos : '';
$address = !empty($member->address) ? $member->address : '';
$alamat = $address.', '.$kode_pos.', '.$kota;
?>

<div class="box box-success">

<div class="box-body">	
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>

	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center">Image</th>
			<th colspan=2 style="vertical-align: middle; text-align:center">Information</th>
			
		</tr>
		<tr>
			<td class="h_tengah" style="vertical-align:middle; width:15%">
				
			<img height="200" width="200" src="<?php echo $img;?>"/> 			
			
			</td>
			
			<td class="h_tengah" style="vertical-align:middle; width:85%">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:15%;"><b>Nama</b></td>						
						<td style="width:1%;">:</td>						
						<td colspan=4>
							<?php echo ucwords($nama);?>
							
						</td>										
					</tr>	
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Email</b></td>
						<td style="width:1%;">:</td>	
						<td style="width:20%;">
							<?php echo $email;?>
						</td>	
						<td style="width:15%;"><b>Tanggal Lahir</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $dob;?>
						</td>	
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						
						<td style="width:12%;"><b>Kota</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $kota;?>
						</td>	
						<td><b>Jumlah Point</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4>
							<?php echo $cnt_point;?>
						</td>						
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Phone</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4>
							<?php echo $phone;?>
						</td>
						
					</tr>
					
					
					
					
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Alamat</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4>
							<?php echo $alamat;?>
						</td>											
					</tr>
					
				</tbody>
			</table>
			</td>
			
			
			
		</tr>
		
	</tbody></table>
	
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:33%;" >History Top up Point</th>
			<th style="vertical-align: middle; text-align:center; width:34%;" >History Point</th>
			<th style="vertical-align: middle; text-align:center; width:33%;">History Rental</th>
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<?php
				if(count($top_up_point) > 0){
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					<?php 
					$date_point = '';
					foreach($top_up_point as $ph){
						$status = $ph['status'] == 1 ? 'Payment Complete':'';
						$date_point = '';
						$date_point = date("d-M-y H:i", strtotime($ph['created_at']));
						echo '<div class="direct-chat-info clearfix">';
						
						echo '<span class="direct-chat-text"><b>#'.$ph['id'].'<br/>'.number_format($ph['nominal'],2,',','.').'</b><br/>'.$date_point.'<span style="float:right; color:#00a65a; font-weight:bold;">'.$status.'</span></span>';
						echo '</div>';
					}
					?>
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>
			
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>
			
			<?php
				if(count($point_history) > 0){
			?>
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					<?php 
					$date_ewallet = '';
					$nilai = '0.00';
					foreach($point_history as $eh){
						if($eh['tipe'] == 1){
							$nilai = '- '.number_format($eh['point'],2,',','.');
							$ket = 'Rental';
						}
						if($eh['tipe'] == 2){
							$nilai = '+ '.number_format($eh['point'],2,',','.');
							$ket = 'Top up Point';
						}
						$date_ewallet = '';
						$date_ewallet = date("d-M-y H:i", strtotime($eh['created_at']));
						echo '<div class="direct-chat-info clearfix">';
						echo '<span class="direct-chat-text"><b>'.$ket.'</b><br/>'.$nilai.')<span style="float:right;">$date_ewallet</span></span>';
						echo '</div>';
					}
					?>
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
				
		</tr>
	</tbody>
	</table>
	
	
		

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
			
	</div>
</div>
</div>

<link href="<?php echo base_url(); ?>assets/magnific/magnific-popup.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>assets/magnific/jquery.magnific-popup.js"></script>		
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$("#success-alert").hide();
$('.back').click(function(){
	history.back();
});
$('.del_events').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('events/del_komentar');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
</script>