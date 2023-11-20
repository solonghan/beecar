<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Send_model extends Base_Model {
	

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
		$this->load->model("User_model");
	}

	//發送超級通知推播
	public function send_super_info($user_id,$order_no){
		
		//取得user的fcm_token
		$token_list = $this->User_model->get_fcm_token($user_id);					

		$send_data = [
			'info'  		=> 1,
			'type'  		=> 'notification',
			'order_no'	=> $order_no,
		];

		foreach($token_list as $t){

			$res = $this->send_push($t['token'], "有一個行程符合您的通知，點擊前往查看。",$send_data);

			if($res){
				$data = [
					'user_id'	 =>	$user_id,
					'fcm_token'=>	$t['token'],
					'order_no' => $order_no,
					'status'	 => 'success',
					'info'		 => 1,
					'type'  	 => 'notification',
				];

				$this->db->insert($this->fcm_table,$data);

			}else{
				$data = [
					'user_id'	 	=>	$user_id,
					'fcm_token' =>	$t['token'],
					'order_no' 	=> $order_no,
					'status'	 	=> 'fail',
					'info'		 	=> 1,
					'type'  		=> 'notification',
				];

				$this->db->insert($this->fcm_table, $data);

			}
		}
	}

	//加入排程待發送
	public function add_corn($user_id, $order_no, $type ,$wait=false)
	{
		//取得user的fcm_token
		$token_list = $this->User_model->get_fcm_token($user_id);

		if($wait){
			$date = date('Y-m-d H:i:s',strtotime('+3 minute'));
		}else{
			$date = date('Y-m-d H:i:s');
		}
		foreach ($token_list as $t) {
			$data = [
				'user_id'	 		=>	$user_id,
				'fcm_token' 	=>	$t['token'],
				'order_no' 		=>  $order_no,
				'status'	 		=>  'wait',
				'info'		 		=>  0,
				'type'  			=>  $type,
				'create_date' => $date
			];
			
			$this->db->insert($this->fcm_table, $data);
		}
	}
}