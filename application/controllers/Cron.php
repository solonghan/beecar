<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends Base_Controller{
	
	public function __construct(){
		parent::__construct();
	}

	//每分確認fcm table中是否有待發排程
	public function fcm_cron(){
		// $cron_list = $this->get_cron();
		
		// foreach($cron_list as $cron){

		// 	$cron_data =  [
		// 		'info'  		=> $cron['info'],
		// 		'type'  		=> $cron['type'],
		// 		'order_no'	=> $cron['order_no'],
		// 	];

		// 	if($cron['type']=='my_trip'){
		// 		$str = '已接行程列表更新';
		// 	} else if ($cron['type'] == 'can_get') {
		// 		$str = '可接行程列表更新';
		// 	} else if ($cron['type'] == 'manage') {
		// 		$str = '管理行程列表更新';
		// 	} else if ($cron['type'] == 'record') {
		// 		$str = '承接紀錄列表更新';
		// 	} else if ($cron['type'] == 'manage_record') {
		// 		$str = '管理行程紀錄列表更新';
		// 	}

		// 	$res = $this->send_push($cron['fcm_token'], $str, $cron_data);
			
		// 	if($res){
		// 			$this->db->where(array("id" => $cron['id']))->update($this->fcm_table, array("status" => 'success'));
		// 	}else{
		// 		$this->db->where(array("id" => $cron['id']))->update($this->fcm_table, array("status" => 'fail'));
		// 	}

		// }

		// $data = ['create_date'=> date('Y-m-d H:i:s')];
		// $this->db->insert('test',$data);
	}

	public function get_cron()
	{
		$date = date('Y-m-d H:i:s');
		$syntax = "S.status = 'wait'";
		$syntax .= " AND (S.create_date < '$date')";

		$list = $this->db->select("S.*")
			->from($this->fcm_table . " S")
			->where($syntax)
			->get()->result_array();
		
		return $list;
	}


}
