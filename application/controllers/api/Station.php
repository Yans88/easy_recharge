<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Station extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
		$this->load->library('send_api');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
    
	
	public function index() {
		$param = $this->input->post();
		$rad = 10;  		// radius of bounding circle in kilometers
		$rad_earth = 6371;	// earth's mean radius, km
		$lat = isset($param['latitude']) ? $param['latitude'] : '';
		$lon = isset($param['longitude']) ? $param['longitude'] : '';
		$get_all = isset($param['get_all']) ? $param['get_all'] : 0;
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$result = array();
		if(empty($lat)){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param latitude can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);	
			return false;
		}
		if(empty($lon)){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param longitude can\'t empty.' );
			http_response_code(200);
			echo json_encode($result);	
			return false;
		}
		// $lat = -6.178523;		
		// $lon = 106.792044;
		$maxLat = $lat + rad2deg($rad/$rad_earth);
		$minLat = $lat - rad2deg($rad/$rad_earth);
		$maxLon = $lon + rad2deg($rad/$rad_earth/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($rad/$rad_earth/cos(deg2rad($lat)));
		$merchants = $this->access->get_merchant_ll($minLat, $maxLat, $minLon, $maxLon, $keyword, $get_all);
		// error_log($lat);
		// error_log($lon);
		$dt = array();		
		$distance = '';	
		if(!empty($merchants)){
			foreach($merchants as $m){
				$distance = '';
				$distance = $this->distance($lat, $lon, $m['latitude'], $m['longitude'], true);			
				$dt[] = array(
					"id_merchant"		=> $m['id_merchants'],					
					"nama_merchants"	=> $m['nama_merchants'],
					"address"			=> $m['address'],				
					"fee"				=> $m['fee'],
					"saldo"				=> $m['saldo'],
					"latitude"			=> $m['latitude'],
					"longitude"			=> $m['longitude'],					
					"owner"				=> (int)$m['owner'] > 0 ? 1 : 0,
					'distance'			=> round($distance,2)
				);
			}
		}
		usort($dt, function($a, $b){
			$a = $a['distance'];
			$b = $b['distance'];

			if ($a == $b) return 0;
			return ($a < $b) ? -1 : 1;
		});
		if (!empty($dt)){
			$result = array( 'err_code'	=> '00',
                             'err_msg'	=> 'ok',
							 'data'		=> $dt);
        }else{
			$result = array( 'err_code'	=> '04',
                             'err_msg'	=> 'Data not be found');
            
        }
		http_response_code(200);
		echo json_encode($result);	
	}
	
	function distance($lat1, $lng1, $lat2, $lng2, $miles = false){
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
	 
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
	 
		return ($miles ? ($km * 0.621371192) : $km);
	}
	
	
	

}