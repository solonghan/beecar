<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Filter_model extends Base_Model {
	

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
		$this->load->model("User_model");
	}

	//發送超級通知
	// public function super_info_send($order_no)
	// {
	// 	//比對所有user的filter
	// 	$user_list = $this->User_model->get_all_user();

	// 	$send = false;

	// 	foreach($user_list as $user){
	// 		if($user['id']==15){
	// 			$filter_list = $this->get_superfilter_list($user['id']);

	// 			$send = false;
	// 			foreach($filter_list as $filter){

	// 				$user_id = $user['id'];
	// 				$syntax = "O.is_delete = 0";
	// 				$syntax .= " AND O.order_no = $order_no ";

	// 				$start_date = $filter['start_date'];
	// 				$end_date   = $filter['end_date'];
	// 				if ($start_date != " " && $end_date != " ") {
	// 					$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
	// 				}

	// 				$start_time = $filter['start_time'];
	// 				$end_time   = $filter['end_time'];
	// 				if ($start_time != " " && $end_time != " ") {
	// 					$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
	// 					$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
	// 					$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
	// 				}

	// 				$car_model = $filter['car_model'];

	// 				if ($car_model != " ") {

	// 					$syntax .= " AND (";
	// 					$index = 0;
	// 					foreach ($car_model as $s) {
	// 						if ($index > 0) $syntax .= " OR ";
	// 						$syntax .=  "(O.car_model = '" . $s . "' )";
	// 						$index++;
	// 					}
	// 					$syntax .= ")";						
	// 				}

	// 				$start_addr = $filter['start_addr'];
	// 				if ($start_addr != " ") {
	// 					$syntax .= " AND (";
	// 					$index = 0;
	// 					foreach ($start_addr as $s) {
	// 						if ($index > 0) $syntax .= " OR ";
	// 						if ($s['area'] != " ") {
	// 							$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
	// 						} else {
	// 							$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
	// 						}

	// 						$index++;
	// 					}
	// 					$syntax .= ")";
	// 				}
					
	// 				$end_addr = $filter['end_addr'];

	// 				if ($end_addr != " ") {
	// 					$syntax .= " AND (O.order_no IN (SELECT order_no FROM order_addr WHERE (";
	// 					$index_1 = 0;
	// 					foreach ($end_addr as $s) {
	// 						if ($index_1 > 0) $syntax .= " OR ";
	// 						if ($s['area'] != "") {
	// 							$syntax .=  "(city = '" . $s['city'] . "' AND dist= '" . $s['area'] . "')";
	// 						} else {
	// 							$syntax .=  "(city = '" . $s['city'] . "')";
	// 						}
	// 						$index_1++;
	// 					}
	// 					$syntax .= "))) ";
	// 				}
		
	// 				$order_data = $this->db->select("O.*")
	// 				->from($this->order_table . " O")
	// 				->where($syntax)					
	// 				->get()->row_array();

	// 				if($order_data!=""){
	// 					$send = true;
	// 				}

	// 			}

	// 			if($send == true){
	// 				//取得user的fcm_token
	// 				$token_list = $this->User_model->get_fcm_token($user['id']);					

	// 				foreach($token_list as $t){

	// 					$res = $this->send_push($t['token'], "有一個行程符合您的通知，點擊前往查看。");

	// 					if($res){
	// 						$data = [
	// 							'user_id'	 =>	$user['id'],
	// 							'order_no' => $order_no,
	// 							'status'	 => 'success'
	// 						];

	// 						$this->db->insert($this->fcm_table,$data);

	// 					}else{
	// 						$data = [
	// 							'user_id'	 =>	$user['id'],
	// 							'order_no' => $order_no,
	// 							'status'	 => 'fail'
	// 						];

	// 						$this->db->insert($this->fcm_table, $data);

	// 					}
	// 				}
					
	// 			}
				
	// 		}
			


			
	// 	}

	// 	return $send;
	// }

	//判斷是否發超級通知
	public function check_super_info($order_no,$user_id)
	{
		$send = false;

		//判斷使用者是否開啟超級通知
		$res = $this->User_model->check_super_info($user_id);
		// print_r($res);exit;
		// if($res){
			if(!$res){
				return false;
			}else{
				if($res['is_super_check']==2){
					$filter_list = $this->get_superfilter_list($user_id);
					// print_r($filter_list);exit;
					$send = false;
					foreach ($filter_list as $filter) {
		
						$syntax = "O.is_delete = 0";
						$syntax .= " AND O.order_no = $order_no ";
		
						$start_date = $filter['start_date'];
						$end_date   = $filter['end_date'];
		
						if ($start_date != "" && $end_date != "") {
							// print 123;
							$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
						}elseif($start_date != ""  && $end_date == ""){
							$syntax .= " AND (O.date >= '$start_date')";
						}
						// print_r($syntax);exit;
		
						$start_time = $filter['start_time'];
						$end_time   = $filter['end_time'];
						// print_r($end_time);exit;
						if ($start_time != " " && $end_time != " ") {
							// print 12345;exit;
							$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
							$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
							$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
						}elseif($start_time != " " && $end_time == " ") {
							// print 12345789;exit;
							$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
							// $end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
							$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) >= $start  )";
						}
		
						$car_model = $filter['car_model'];
		
						if ($car_model != " ") {
		
							$syntax .= " AND (";
							$index = 0;
							foreach ($car_model as $s) {
								if ($index > 0) $syntax .= " OR ";
								$syntax .=  "(O.car_model = '" . $s . "' )";
								$index++;
							}
							$syntax .= ")";
						}
		
						$start_addr = $filter['start_addr'];
						// print_r($start_addr);exit;
						if ($start_addr != " ") {
							$syntax .= " AND (";
							$index = 0;
							foreach ($start_addr as $s) {
								if ($index > 0) $syntax .= " OR ";
								if ($s['area'] != "") {
									// print_r($s['area']);
									$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
								} else {
									$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
								}
		
								$index++;
							}
							$syntax .= ")";
						}
		
						$end_addr = $filter['end_addr'];
						
		
						if ($end_addr != " ") {
							$syntax .= " AND (O.order_no IN (SELECT order_no FROM order_addr WHERE (";
							$index_1 = 0;
							foreach ($end_addr as $s) {
								if ($index_1 > 0) $syntax .= " OR ";
								if ($s['area'] != "") {
									$syntax .=  "(city = '" . $s['city'] . "' AND dist= '" . $s['area'] . "')";
								} else {
									$syntax .=  "(city = '" . $s['city'] . "')";
								}
								$index_1++;
							}
							$syntax .= "))) ";
						}
						
						$order_data = $this->db->select("O.*")
							->from($this->order_table . " O")
							->where($syntax)
							->get()->row_array();
		
						if ($order_data != "") {
							$send = true;
						}
		
						// print_r($start_addr);
					}
					// print_r($syntax);exit;
					// print_r($send);exit;
		
					return $send;
				}elseif($res['is_super_check']==1){
					$send = true;
					return $send;
				}
				
			}


	}

	public function del_superfilter($id)
	{
		$data = array(
			"is_delete"	=>	1			
		);

		$res =
		$this->db->where(array("id" => $id))->update($this->super_filter_table, $data);

		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_superfilter_list($user_id)
	{
		$syntax = "S.is_delete = 0";
		$syntax .= " AND (S.user_id = $user_id)";

		$list = $this->db->select("S.*")
			->from($this->super_filter_table . " S")
			->where($syntax)			
			->get()->result_array();
		
		$i	=	0;
		foreach ($list as $l) {
			$list[$i]['start_date'] = ($l['start_date']=="0000-00-00" ? "" : $l['start_date'] );
			$list[$i]['end_date'] = ($l['end_date'] == "0000-00-00" ? "" : $l['end_date']);

			$list[$i]['car_model'] = unserialize($l['car_model']);
			$list[$i]['start_addr'] = unserialize($l['start']);
			$list[$i]['end_addr'] = unserialize($l['end']);

			unset($list[$i]['start']);
			unset($list[$i]['end']);
			unset($list[$i]['is_delete']);
			unset($list[$i]['create_date']);
			unset($list[$i]['user_id']);
			$i++;
		}
		return $list;
	}

	public function add_super_filter( $data){
		$res = $this->db->insert($this->super_filter_table, $data);
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


}