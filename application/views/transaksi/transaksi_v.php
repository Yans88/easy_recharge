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
				<input type="hidden" id="del_id" nama="del_id" value="">
                <input type="hidden" id="nilai" nama="nilai" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-success yes_app">Ya</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>



 <div class="box box-success">
 
<div class="box-body">

	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:6%">ID</th>                      
            <th style="text-align:center; width:15%">Nama Merchant</th>	
            <th style="text-align:center; width:15%">Nama Member</th>
			 <th style="text-align:center; width:15%">Tanggal Sewa</th>            
            <th style="text-align:center; width:15%">Tanggal Return</th> 
            <th style="text-align:center; width:10%">Total</th>		
			
           
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';			
				if(!empty($transaksi)){		
					foreach($transaksi as $t){	
						$view_sub = '';
						$info = (int)$t['status'] > 1 ? date("d M Y", strtotime($t['tgl_return'])).', '.date('H:i', strtotime($t['tgl_return'])).'('.$t['lama_sewa_real'].' Jam)' : '-';
						$htg_hrg = (int)$t['status'] > 1 ? '<br/>('.$t['lama_sewa'].' x '.number_format($t['point_jam'],2,',','.').')' : '';
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td align="center">'.$t['id_transaksi'].'</td>';												
						echo '<td>'.$t['nama_merchants'].'</td>';
						echo '<td>'.$t['nama'].'</td>';
						echo '<td>'.date("d M Y", strtotime($t['tgl_sewa'])).', '.date('H:i', strtotime($t['tgl_sewa'])).'</td>';
						echo '<td>'.$info.'</td>';
						echo '<td align="right">'.number_format($t['total_point'],2,',','.').''.$htg_hrg.'</td>';						
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


<script type="text/javascript">


$(function() {               
    $('#example88').dataTable({});
});


</script>