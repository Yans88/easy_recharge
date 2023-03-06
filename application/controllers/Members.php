<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		
		$this->data['judul_browser'] = 'Member';
		$this->data['judul_utama'] = 'Member';
		$this->data['judul_sub'] = 'Easy Recharge';
		$this->data['title_box'] = 'List of Member';
		$select = array('members.*');
		$this->data['member'] = $this->access->readtable('members',$select)->result_array();
		
		$this->data['isi'] = $this->load->view('member_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function view_member($id_member=0){
		$this->data['judul_browser'] = 'Member';
		$this->data['judul_utama'] = 'Member';
		$this->data['judul_sub'] = 'Easy Recharge';		
		$sort2 = array('id','DESC');
		$sort = array('created_at','DESC');
		$this->data['member'] = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$this->data['point_history'] = $this->access->readtable('point_history','',array('id_member'=>$id_member),'','',$sort)->result_array();
		$this->data['top_up_point'] = $this->access->readtable('top_up_point', '',array('id_member'=>$id_member),'','',$sort2)->result_array();
		$this->data['isi'] = $this->load->view('member_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function inactive(){
		$tgl = date('Y-m-d H:i:s');
		$status = $_POST['status'] > 0 ? 1 : 0;
		$where = array(
			'id_member' => $_POST['id']			
		);
		
		$data = array(
			
			'status'		=> $status,
			'status_by'		=> $this->session->userdata('operator_id'),
			'status_date'	=> $tgl
		);
		echo $this->access->updatetable('members', $data, $where);
	}
	
	function exports(){
		$select = array('members.*','admin.fullname');
		$members = $this->access->readtable('members',$select,'',array('admin'=>'admin.operator_id = members.status_by'),'','','LEFT')->result_array();
		$dates = date("d-m-y");
		$this->load->library('excel');
		
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setTitle('data_members_'.$dates);		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Data Members');		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		
		$this->excel->getActiveSheet()->mergeCells('A1:E1');		
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		// $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		
			
		
		$this->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setSize(12);				
		$this->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		
		$this->excel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleArray);		
		
		$this->excel->getActiveSheet()->setCellValue('A3', 'No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Nama');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Email');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Tanggal Lahir');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Status');
        // $this->excel->getActiveSheet()->setCellValue('F3', 'Status');
       
		$this->excel->getActiveSheet()->getStyle('A3:E3')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFE8E5E5');
		
		$this->excel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$i=4;
		$no = 1;
		$status = '';
		foreach($members as $e){
			if($e['status'] == 1){
				$status = 'Active';
			}else if($e['status'] == 0){
				$status = 'Inactive';
			}else{
				$status = '';
			}			
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $no++);
			// $this->excel->getActiveSheet()->setCellValue('B'.$i, $this->converter->decode($e['user_id']));
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $e['nama']);
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $e['email']);
			$this->excel->getActiveSheet()->setCellValue('D'.$i, date('d-M-Y', strtotime($e['dob'])));
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $status);
			
			
			$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setSize(12);
			$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->setWrapText(true);
			$this->excel->getActiveSheet()->getStyle('B'.$i.':E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);			
			$this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
			$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			// $this->excel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			// $this->excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$i++;
		}
        unset($styleArray);
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename='data_members_'.$dates.'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
	}	
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	

}
