<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends Base_Model {
	private $type;
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
		$this->type = ["photo","idcard","vehiclelicense","driverlicense","car"
			// ,"goodcitizen","insurance"
		];
	}

	public function edit_driver_info($user_id, $type, $data){
		$exist = $this->db->get_where($this->driver_info_table, array("user_id"=>$user_id, "type"=>$type))->num_rows();
		if ($exist > 0) {
			return $this->db->where(array("user_id"=>$user_id))->update($this->driver_info_table, $data);
		}else{
			return $this->db->insert($this->driver_info_table, $data);
		}
	}

	public function driver_info($user_id){
		$list = $this->db->get_where($this->driver_info_table, array("user_id"=>$user_id))->result_array("type");
		$data = array();
		foreach ($this->type as $type) {
			if (array_key_exists($type, $list)) {
				$data[$type] = array(
					"frontend"	=>	base_url().$list[$type]['frontend'],
					"backend"	=>	base_url().$list[$type]['backend'],
					"expired_date"	=>	$list[$type]['expired_date'],
					"status"	=>	$list[$type]['status']
				);
 			}else{
 				$data[$type] = array(
					"frontend"	=>	"",
					"backend"	=>	"",
					"expired_date"	=>	"",
					"status"	=>	"empty"
				);
 			}
		}
		return $data;
	}

	public function edit_car_info($user_id, $data){
		$exist = $this->db->get_where($this->car_info_table, array("user_id"=>$user_id))->num_rows();
		if ($exist > 0) {
			return $this->db->where(array("user_id"=>$user_id))->update($this->car_info_table, $data);
		}else{
			return $this->db->insert($this->car_info_table, $data);
		}
	}

	public function car_info($user_id){
		$car_info = $this->db->get_where($this->car_info_table, array("user_id"=>$user_id))->row_array();

		$data = array(
			"brand"  =>	"",
			"model"  =>	"",
			"type"   =>	"",
			"year"   =>	"",
			"color"  =>	"",
			"plate"  =>	"",
			"status" =>	"empty"
		);
		if ($car_info != null) {
			foreach ($data as $key => $item) {
				if (isset($car_info[$key]) && $car_info[$key] != "") {
					$data[$key] = $car_info[$key];
				}
			}
		}
		return $data;
	}

	public function driver_review_status($user_id){
		$invalid = $this->db->get_where($this->driver_info_table, array("user_id"=>$user_id, "status"=>"invalid"))->num_rows();
		if ($invalid > 0) {
			return "invalid";
		}else{
			$pending = $this->db->get_where($this->driver_info_table, array("user_id"=>$user_id, "status"=>"pending"))->num_rows();
			if ($pending > 0) {
				return "pending";
			}else{
				$car_info = $this->db->get_where($this->car_info_table, array("user_id"=>$user_id))->num_rows();
				$all = $this->db->get_where($this->driver_info_table, array("user_id"=>$user_id, "status"=>"verified"))->num_rows();
				if ($all == count($this->type) && $car_info >= 1) {
					return "verified";
				}else{
					return "empty";
				}
			}
		}
	}
}