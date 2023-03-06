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
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
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
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_id" value="">
				<input type="hidden" id="status" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_del">Yes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>




 <div class="box box-success">
 <div class="box-header hide">
	<button class="btn btn-primary btn_print"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">

    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:13%">Nama</th>			
			<th style="text-align:center; width:18%">Email</th>		
			<th style="text-align:center; width:25%">Address</th>
			<th style="text-align:center; width:10%">Status</th>
			<th style="text-align:center; width:7%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$i =1;
				$img = '';
				$view_member = '';
				if(!empty($member)){

					foreach($member as $e){
						$img = '';
						$view_member = '';
						if($e['status'] == 1 && $e['status_sms'] > 1){
							$status = '<small class="label label-success bg-green">Active</small>';
						}else if($e['status'] == 0 || $e['status_sms'] == 0){
							$status = '<small class="label label-danger">Inactive</small>';
							
						}else{
							$status = '';
						}
						
						$view_member = site_url('members/view_member/'.$e['id_member']);
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$e['nama'].'<br/>'.$e['phone'].'</td>';
						echo '<td>'.$e['email'].'</td>';				
						echo '<td>'.$e['address'].'</td>';
						echo '<td align="center">'.$status.'</td>';
						echo '<td align="center"><a href="'.$view_member .'"/><button title="View" class="btn btn-xs btn-primary view_member"><i class="fa fa-eye"></i> View</button></a>';
						if($e['status'] == 1 && $e['status_sms'] > 1){
							echo '<button id="'.$e['id_member'].'" style="margin-top:5px;" title="Inactive" class="btn btn-xs btn-danger btn_inactive"><i class="fa fa-warning"></i> Inactive</button></td>';
						}
						if($e['status'] == 0 || $e['status_sms'] == 0){
							echo '<button id="'.$e['id_member'].'" style="margin-top:5px;" title="Activate" class="btn btn-xs btn-success btn_active"><i class="fa fa-warning"></i> Activate</button></td>';
						}
						echo '</tr>';
					}
				}
			?>
		</tbody>

	</table>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off");
$('.btn_active').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(1);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.btn_inactive').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(0);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();
	var url = '<?php echo site_url('members/inactive');?>';
	$.ajax({
		data : {id : id, status:status},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data member telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				//location.reload();
			});
		}
	});

});

$(function() {
	$('.publish').change(function() {
		var id = $(this).get(0).id;
		var val = 0;
		var chk = $(this).prop('checked');
		if(chk){
			val = 1;
		}
		var url = '<?php echo site_url('events/set_active');?>';
		$.ajax({
			url : url,
			type : "POST",
			data : {id:id, aktif:val}
		});
	})
});


$(function() {
    $('#example88').dataTable({});
});

$('.first').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
				// return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
	});
$(".btn_print").click(function(){	
	var url = '<?php echo site_url('members/exports');?>';
	window.location.href = url;
});
</script>
