<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends Base_Model {
	private $type;
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
		$this->load->model("User_model");
		$this->type = ["photo","idcard","vehiclelicense","driverlicense","car"
			// ,"goodcitizen","insurance"
		];

		$this->load->model("Filter_model");
		$this->load->model("Send_model");
	}

	protected function more_array_unique($arr=array()){
			foreach($arr[0] as $k => $v){
					$arr_inner_key[]= $k;   //先把二維陣列中的內層陣列的鍵值記錄在在一維陣列中
			}
			foreach ($arr as $k => $v){
					$v =join(",",$v);    //降維 用implode()也行
					$temp[$k] =$v;      //保留原來的鍵值 $temp[]即為不保留原來鍵值
			}
			$temp =array_unique($temp);    //去重：去掉重複的字串
			foreach ($temp as $k => $v){
					$a = explode(",",$v);   //拆分後的重組 如：Array( [0] => james [1] => 30 )
					$arr_after[$k]= array_combine($arr_inner_key,$a);  //將原來的鍵與值重新合併
			}
			//ksort($arr_after);//排序如需要：ksort對陣列進行排序(保留原鍵值key) ,sort為不保留key值
			return $arr_after;
	}

	public function get_order_addr_end($order_no)
	{
		$list = $this->db->select("O.*")
		->from($this->order_addr_table . " O")
		->where("O.order_no = $order_no")
			->order_by('O.sort DESC')
			->get()->row_array();
		
			return $list;
		
	}
	public function get_order_addr_end_array($order_no)
	{
		$list = $this->db->select("O.*")
		->from($this->order_addr_table . " O")
		->where("O.order_no = $order_no")
			->order_by('O.sort ASC')
			->get()->result_array();
			
		
			return $list;
		
	}


	public function add_order_addr_list($data)
	{
		$res = $this->db->insert($this->order_addr_table, $data);
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function add_order($data)
	{
		$res = $this->db->insert($this->order_table, $data);
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function edit_order($data)
	{
		$res =  $this->db->where(array("order_no" => $data['order_no']))->update($this->order_table, $data);
	
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function add_order_log( $order_no , $type , $user_id ,$free_array="")
	{
		if($type != 'free'){
			$data = array(
				'order_no' => $order_no,
				'type' 		 => $type,
				'user_id'  => $user_id,
				'date'		 => date('Y-m-d')
			);
		}else{
			$data = array(
				'order_no' 					=> $order_no,
				'type' 		 					=> $type,
				'get_free_members'  => $free_array,
				'date'		 					=> date('Y-m-d')
			);
		}
		
		$res = $this->db->insert($this->order_log_table, $data);
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_manage_list($user_id)
	{
		$syntax = "O.is_delete = 0 AND O.is_finish = 0";
		$syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";

		$list = $this->db->select(",O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
						->from($this->order_table . " O")
						->where($syntax)
						->order_by('O.date ASC,O.time ASC')
						->get()->result_array();
		// print_r($list);exit;
		$i	=	0;
		foreach($list as $l){
			
			if($l['order_owner'] == $user_id){
				//建立訂單者
				if($l['owner_status'] == 'make'){
					$list[$i]['status_str'] = '未派遣';
				} else if ($l['owner_status'] == 'transfer') {
					$list[$i]['status_str'] = '已轉單';
				} else if ($l['owner_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
			 	} else if ($l['owner_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';		
				}

			} else if ($l['order_middle'] == $user_id) {
				//中游

				if ($l['middle_status'] == 'catch') {
					$list[$i]['status_str'] = '已接到轉單';
					$driver = $this->User_model->get_data($l['order_owner']);//
					$list[$i]['owner_name'] = $driver['username'];//
				} else if ($l['middle_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				} else if ($l['middle_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				}
			}
			if($l['driver_status']!='start' && $l['driver_status'] != ''){

					if ($l['driver_status'] == 'to_start') {
						$list[$i]['status_str'] = '前往起點';
					} else if ($l['driver_status'] == 'arrive_start') {
						$list[$i]['status_str'] = '抵達起點';
					} else if ($l['driver_status'] == 'start_trip') {
						$list[$i]['status_str'] = '開始行程';
					} else if ($l['driver_status'] == 'end') {
						$list[$i]['status_str'] = '結束行程';
					}
			}
			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];
			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'][]='';
			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] . $address['address'];
			}
			
			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			unset($list[$i]['driver_status']);
			// unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			$i++;
		}						
					// print_r($list);
					// exit;	
		return $list;
	}

	public function get_driver_list($user_id)
	{
		$syntax = "O.is_delete = 0 AND O.is_finish = 0";
		$syntax .= " AND (O.order_driver = $user_id)";

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price_type,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
							->from($this->order_table . " O")
							->where($syntax)
							->order_by('O.date ASC,O.time ASC')
							->get()->result_array();
							// print_r($list);exit;
		$i	=	0;
		// print_r($list);exit;
		
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			$list[$i]['sender_name'] = $sender['username'];

			if($l['order_middle']!=0){
				$sender = $this->User_model->get_data($l['order_middle']);
				$list[$i]['sender_name'] = $sender['username'];
			}


			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未執行';
				}else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				} 
			}
			// if($list[$i]['final_status']==0){
			// 	$list[$i]['price']=$list[$i]['price']-$list[$i]['final_payment'];
				
			// }else{
			// 	$list[$i]['price']=$list[$i]['price']+$list[$i]['final_payment'];
				
			// }

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] . $address['address'];
			}

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			$i++;
		}

		return $list;
	}

	public function get_order_list($phone)
	{
		$syntax = "O.is_delete = 0 AND O.is_finish = 1";
		$syntax .= " AND (O.phone = $phone)";

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.name")
			->from($this->order_table . " O")
			->where($syntax)
			->order_by('O.date ASC,O.time ASC')
			->get()->result_array();

		$i	=	0;
		foreach ($list as $l) {
			$order_no = $l['order_no'];
			$list[$i]['end']= $this->get_order_address($order_no);

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			$address = $this->get_order_addr_end($l['order_no']);
			$list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			$i++;
		}
		return $list;
	}

	public function get_edit_order($order_no)
	{

		$list = $this->db->select("O.order_no,O.name,O.phone,O.date,O.time,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price,O.final_status,O.final_payment")
			->from($this->order_table . " O")
			->where("O.order_no = $order_no")
			->get()->row_array();

		$list['outset'] = array(
			'city' => $list['start_city'],
			'area' => $list['start_dist'],
			'address' => $list['start_addr'],
		);

		$end_address = $this->get_order_address($order_no);
		$i=0;
		foreach($end_address as $e){
			$list['end'][$i] = array(
				'id' 		=> $e['sort'],
				'city' 	=> $e['city'],
				'area' 	=> $e['dist'],
				'address' => $e['address'],
			);
			$i++;
		}
		// print_r($end_address);exit;
		return $list;
	}

	public function get_order_detail($order_no,$user_id)
	{

		$list = $this->db->select("O.order_no,O.name,O.date,O.time,O.phone,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price_type,O.price,O.final_status,O.final_payment,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from($this->order_table . " O")
		->where("O.order_no = $order_no")
		->get()->row_array();

		// print_r($list);exit;

			
		if($list['final_status']==0){
			$list['last_price']=$list['price']-$list['final_payment'];
			
		}else{
			$list['last_price']=$list['price']+$list['final_payment'];
			
		}
		// if($list['final_status']==0){
		// 	$list['price']=$list['price']-$list['final_payment'];
			
		// }else{
		// 	$list['price']=$list['price']+$list['final_payment'];
			
		// }

		
		$list['driver_id']     = $list['order_driver'];
		// $end_address = $this->get_order_addr_end($order_no);
		// $list['end_addr'] = $end_address['city'] . $end_address['dist'] . $end_address['address'];

		if($list['owner_status']=='send_free' && $list['order_owner']!=$user_id){
			$list['start_addr'] = $list['start_city'].$list['start_dist'];
			$address_array = $this->get_order_addr_end_array($order_no);
			foreach($address_array as $address){
				$list['end_addr'][]= $address['city'] . $address['dist'] ;
			}
		}else{
			$list['start_addr'] = $list['start_city'].$list['start_dist'] . $list['start_addr'];
			$address_array = $this->get_order_addr_end_array($order_no);
			foreach($address_array as $address){
				$list['end_addr'][]= $address['city'] . $address['dist'] . $address['address'];
			}
		}
		// $address_array = $this->get_order_addr_end_array($order_no);
		// 	foreach($address_array as $address){
		// 		$list['end_addr'][]= $address['city'] . $address['dist'] ;
		// 	}
		

		//駕駛人
		$driver_name = "";
		$driver = $this->User_model->get_data($list['order_driver']);
		if($driver){
			$driver_name = $driver['username'];
		}
		$list['driver_name'] = $driver_name;

		//派遣人
		if($list['order_middle']==0){
			$sender = $this->User_model->get_data($list['order_owner']);
			if ($sender) {
				$list['sender_name'] = $sender['username'];
			}else{
				$list['sender_name'] = '';
			}
		}else{
			$sender = $this->User_model->get_data($list['order_middle']);
			if ($sender) {
				$list['sender_name'] = $sender['username'];
			}else{
				$list['sender_name'] = '';
			}
		}

		//右上角訂單狀態
		if ($list['order_owner'] == $user_id) {
			//建立訂單者
			if ($list['owner_status'] == 'make') {
				$list['status_str'] = '未派遣';
				$list['transfer_button'] = 'yes';	//可轉單
				$list['assign_button'] 	 = 'yes';	//可指定
				$list['free_button']     = 'yes';	//可自由
				$list['edit_button']     = 'yes';	//可編輯
			} else if ($list['owner_status'] == 'transfer') {
				$list['status_str'] = '已轉單';
				$list['transfer_button'] = 'no';	//取消轉單
				$list['assign_button']   = 'disable';	//灰色
				$list['free_button']     = 'disable';	//灰色
				$list['edit_button']     = 'yes';	//灰色
			} else if ($list['owner_status'] == 'send_free' /*|| $list['owner_status'] == 'free_get'*/) {
				$list['status_str'] = '待承接';
				$list['transfer_button'] = 'disable';	//灰色
				$list['assign_button']   = 'disable';	//灰色
				$list['free_button']     = 'no';		//取消自由承接
				$list['edit_button']     = 'yes';	//灰色
			} else if ($list['owner_status'] == 'free_get') {
				$list['status_str'] = '已有駕駛承接';
				$driver = $this->User_model->get_data($list['order_driver']);
				$list['driver_name'] = $driver['username'];

				$list['transfer_button'] = 'disable'; //無轉單按鈕
				$list['assign_button']   = 'disable';	//灰色
				$list['free_button']     = 'no';	 //取消自由承接
				// $list['edit_button']     = 'none'; //無編輯按鈕
			 } else if ($list['owner_status'] == 'assign') {
				$list['status_str'] = '已指定駕駛';
				$driver = $this->User_model->get_data($list['order_driver']);
				$list['driver_name'] = $driver['username'];

				$list['transfer_button'] = 'disable';	//灰色
				$list['assign_button']   = 'no';		//取消指定駕駛
				$list['free_button']     = 'disable';	//灰色
				$list['edit_button']     = 'yes';	//灰色
			}
			$list['is_owner'] = true;
		} else if ($list['order_middle'] == $user_id) {
			//中游

			if ($list['middle_status'] == 'catch') {
				$list['status_str'] = '已接到轉單';
				$list['transfer_button'] = 'none'; //無轉單按鈕
				$list['assign_button']   = 'yes';	 //可指定
				$list['free_button']     = 'yes';	 //可自由
				$list['edit_button']     = 'none'; //無編輯按鈕

				$driver = $this->User_model->get_data($list['order_owner']);//
				$list['owner_name'] = $driver['username'];//
			} else if ($list['middle_status'] == 'send_free'/*|| $list['owner_status'] == 'free_get'*/) {
				$list['status_str'] = '待承接';
				$list['transfer_button'] = 'none'; //無轉單按鈕
				$list['assign_button']   = 'disable';	//灰色
				$list['free_button']     = 'no';	 //取消自由承接
				$list['edit_button']     = 'none'; //無編輯按鈕
			}else if ($list['middle_status'] == 'free_get') {
				$list['status_str'] = '已有駕駛承接';
				$driver = $this->User_model->get_data($list['order_driver']);
				$list['driver_name'] = $driver['username'];
				$list['transfer_button'] = 'disable'; //無轉單按鈕
				$list['assign_button']   = 'disable';	//灰色
				$list['free_button']     = 'no';	 //取消自由承接
				// $list['edit_button']     = 'none'; //無編輯按鈕
			} else if ($list['middle_status'] == 'assign') {
				$list['status_str'] = '已指定駕駛';
				$driver = $this->User_model->get_data($list['order_driver']);
				$list['driver_name'] = $driver['username'];
				$list['transfer_button'] = 'none'; //無轉單按鈕
				$list['assign_button']   = 'no';	//取消指定駕駛
				$list['free_button']     = 'disable';	 //灰色
				$list['edit_button']     = 'none'; //無編輯按鈕
			}
			$list['is_owner'] = false;
		} else if ($list['order_driver'] == $user_id) {
			$list['status_str'] = '未執行';
			$list['is_owner'] = false;
		}
		if ($list['driver_status'] != 'start' && $list['driver_status'] != '') {

			if ($list['driver_status'] == 'to_start') {
				$list['status_str'] = '前往起點';
			} else if ($list['driver_status'] == 'arrive_start') {
				$list['status_str'] = '抵達起點';
			} else if ($list['driver_status'] == 'start_trip') {
				$list['status_str'] = '開始行程';
			} else if ($list['driver_status'] == 'end') {
				$list['status_str'] = '結束行程';
			}
			if($list['order_owner']== $user_id){
				//上游
				$list['transfer_button'] = 'disable';//灰色
				$list['assign_button']   = 'disable';//灰色
				$list['free_button']     = 'disable';//灰色
				$list['edit_button']     = 'disable';//灰色
			} elseif ($list['order_owner'] == $user_id) {
				//中游
				$list['transfer_button'] = 'none'; //無
				$list['assign_button']   = 'disable'; //灰色
				$list['free_button']     = 'disable'; //灰色
				$list['edit_button']     = 'none';//無
			}
			
		}
		$list['api_des']= "transfet_button 行程轉單按鈕 yes:行程轉單 no：取消行程轉單 disable:行程轉單(灰色) none:不顯示此按鈕
											assign_button 指定駕駛按鈕 yes:指定駕駛 no：取消指定駕駛 disable:指定駕駛(灰色) none:不顯示此按鈕
											free_button 自由承接按鈕 yes:自由承接 no：取消自由承接 disable:自由承接(灰色) none:不顯示此按鈕
											edit_button 編輯按鈕 yes:編輯 no：取消編輯 disable:編輯(灰色) none:不顯示此按鈕";

		unset($list['start_city']);
		unset($list['start_dist']);
		
		// print_r($end_address);exit;
		return $list;
	}

	public function get_order($order_no)
	{

		$list = $this->db->select("O.order_owner,O.order_no,O.owner_status,O.middle_status,O.driver_status,O.order_owner,O.order_middle,O.order_driver")
		->from($this->order_table . " O")
		->where("O.order_no = $order_no")
		->get()->row_array();

		return $list;
	}

	public function get_order_address($order_no)
	{
		$data = array(
			"F.order_no"   =>	$order_no
		);

		return $this->db->select("F.sort,F.city,F.dist,F.address")
			->from($this->order_addr_table . " F")
			->where($data)
			->get()->result_array();
	}

	public function del_origin_addr_list($order_no)
	{
		$data = array(
			"order_no"	=>	$order_no,
		);

		if ($this->db->delete($this->order_addr_table, $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function drive_action($order_no,$now_status,$user_id)
	{
		$list = $this->db->select("O.order_no,O.name,O.date,O.time,O.phone,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price_type,O.price,O.final_status,O.final_payment,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from($this->order_table . " O")
		->where("O.order_no = $order_no")
		->get()->row_array();
		
		if($list['order_driver']==0){
			$res='false';
			return  $res;
			// return array('status' => false, 'msg' => '此行程不存在');
		}
		$is_finish = 0;
		if($now_status=='start'){
			$next_status = 'to_start';
		} elseif ($now_status == 'to_start') {
			$next_status = 'arrive_start';
		} elseif ($now_status == 'arrive_start') {
			$next_status = 'start_trip';
		} elseif ($now_status == 'start_trip') {
			$next_status = 'end';
		} elseif ($now_status == 'end') {
			$is_finish = 1;
			$next_status = 'finish';
		}
		$data = array(
			"driver_status"   =>	$next_status,
			"is_finish"   =>	$is_finish,
		);
		/////new
		// $res=$this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);

		if(isset($data)){
			$res = $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);
		}else{
			$res='false';
			return  $res;
			// return array('status' => TRUE, 'msg' => '此行程不存在');
		}

		$this->add_order_log($order_no, $next_status, $user_id);

		return $res;
	}

	public function drive_cancel($order_no,$user_id)
	{
		$order = $this->get_order($order_no);
		
		//無中游 駕駛取消->返回最上層
		if($order['order_middle']==0){
			$data = array(
				"driver_status"   =>	'',
				"order_driver"    =>	0,
				"owner_status"		=> 'make',
				"order_is_super"	=> 0,
			);
		}else{
		//有中游 駕駛取消->返回中游
			$data = array(
				"driver_status"   =>	'',
				"order_driver"    =>	0,
				"middle_status"		=> 'catch',
				"owner_status"		=> 'transfer',
				"order_is_super"	=> 0,
			);
		}
		$this->db->where(array("user_id" => $user_id,"order_no" => $order_no))->update('order_log',array("is_cancel" => 1,));

		return $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);
	}

	public function order_operation($action, $order_list ,$user_id ,$next_id)
	{	
		foreach($order_list  as $o){
			
			$order = $this->get_order($o);
			
			if ($action == 'transfer') {
				//轉單-> 上游轉中游
				if($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0){

					$data = array(
						'owner_status'  => 'transfer',
						'middle_status' => 'catch',
						'order_middle' => $next_id,
						'order_is_super'=> 0
					);

				}else{
					return array('status'=>false,'msg'=>'發生問題，無法進行轉單操作');
				}
				
				
			} elseif ($action == 'assign') {
				//指定駕駛 -> 上游指定 中游指定

				//判斷駕駛身份及是否認證
				$driver = $this->db->select("U.role,U.id,U.is_verified,U.is_super")
					->from($this->user_table . " U")
					->where(array("U.id" => $next_id))
					->get()->row_array();
				// 判斷駕駛是否超級通知狀態
				if($driver['is_super']!=0){
					$order_is_super=1;
				}else{
					$order_is_super=0;
				}

				if($driver['role']!='driver'|| $driver['is_verified'] !=1){
					return array('status' => false, 'msg' => '發生問題，此駕駛無權限接收訂單');
				}

				//上游指定
				if ($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0) {

					$data = array(
						'owner_status'  => 'assign',
						'driver_status' => 'start',
						'order_driver' => $next_id,
						'order_is_super'=>$order_is_super
					);

				//中游指定	
				} else if($order['owner_status'] == 'transfer' && $order['middle_status'] == 'catch' && $order['driver_status'] == ''  &&  $order['order_middle'] == $user_id && $order['order_driver'] == 0) {
					$data = array(
						'owner_status'  => 'assign',
						'middle_status'  => 'assign',
						'driver_status' => 'start',
						'order_driver' => $next_id,
						'order_is_super'=>$order_is_super
					);
				}else{
					return array('status' => false, 'msg' => '發生問題，此筆訂單無法指定駕駛');
				}

			} elseif ($action == 'delete') {

				//只有上游可刪除
				if ($order['order_owner'] == $user_id) {

					$data = array(
						'owner_status'  => '',
						'middle_status' => '',
						'driver_status' => '',
						'order_middle'  => 0,
						'order_driver' 	=> 0,
						'is_delete'		 	=>1,
						'order_is_super'=> 0
					);

					$this->Order_model->del_origin_addr_list($o);

				} else {
					return array('status' => false, 'msg' => '您的權限無法刪除訂單');
				}		
			}elseif ($action == 'reset') {

				//重置派遣
				if ($order['order_owner'] == $user_id ) {

					$data = array(
						'owner_status'  => 'make',
						'middle_status' => '',
						'driver_status' => '',
						'order_middle'  => 0,
						'order_driver' 	=> 0,
						'order_is_super'=> 0
						
					);

					
					// $res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
					$this->db->where(array("type !=" => 'make',"order_no" => $o))->update('order_log',array("is_cancel" => 1,));
					$res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
					if ($res) {
						$this->add_order_log($o, $action, $user_id);
						//刪除自由承接發送者
						$this->db->where(array("order_no" => $o))->delete('free_order_driver');
						
					}
					continue;
					// return array('status' => true, 'msg' => '操作完成');

				}elseif($order['order_middle'] == $user_id){
					$data = array(
						'owner_status'  => 'transfer',
						'middle_status' => 'catch',
						'driver_status' => '',
						'order_middle'  => $user_id,
						'order_driver' 	=> 0,
						'order_is_super'=> 0
						
					);

					
					$res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
					continue;
				} else {
					return array('status' => false, 'msg' => '您的權限無法重置訂單');
				}		
			}
		
			$res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
			if($res){
				$this->add_order_log($o, $action, $next_id);

				if($action == 'transfer'){
					//轉單 
					$this->Send_model->add_corn($user_id, $o, 'manage');
					$this->Send_model->add_corn($user_id, $o, 'manage_record');
				} else if ($action == 'assign') {
					//指定
					$this->Send_model->add_corn($user_id, $o, '');

					$this->Send_model->add_corn($user_id, $o, 'my_trip');
					$this->Send_model->add_corn($user_id, $o, 'can_get');
					$this->Send_model->add_corn($user_id, $o, 'record');
				}else if ($action == 'reset') {
					//重置
					$this->Send_model->add_corn($user_id, $o, 'my_trip');
					$this->Send_model->add_corn($user_id, $o, 'can_get');
					$this->Send_model->add_corn($user_id, $o, 'record');
					$this->Send_model->add_corn($user_id, $o, 'manage');
					$this->Send_model->add_corn($user_id, $o, 'manage_record');
				} else if ($action == 'delete') {
					//刪除
					$this->Send_model->add_corn($user_id, $o, 'my_trip');
					$this->Send_model->add_corn($user_id, $o, 'can_get');
					$this->Send_model->add_corn($user_id, $o, 'record');
					$this->Send_model->add_corn($user_id, $o, 'manage');
					$this->Send_model->add_corn($user_id, $o, 'manage_record');
				}
				
			}
		}



		return array('status' => true, 'msg' => '操作完成');
	}

	public function order_detail_operation($action, $order_no, $user_id)
	{
		//轉單transfer_cancel 指定assign_cancel 自由承接free_cancel 刪除delete 取消cancel
		$order = $this->get_order($order_no);

		if ($action == 'transfer_cancel') {
			//轉單取消-> 上游轉中游
			if ($order['owner_status'] == 'transfer' &&  $order['order_owner'] == $user_id) {

				$data = array(
					'owner_status'  => 'make',
					'middle_status' => '',
					'order_middle' => 0,
					'order_is_super'=>0
				);
			} else {
				return array('status' => false, 'msg' => '發生問題，無法進行取消轉單操作');
			}
		} elseif ($action == 'assign_cancel') {
			//指定駕駛取消 -> 上游指定取消 中游指定取消

			//上游指定取消
			if ($order['owner_status'] == 'assign' &&  $order['order_owner'] == $user_id) {

				$data = array(
					'owner_status'  => 'make',
					'driver_status' => '',
					'order_driver' => 0,
					'middle_status'  => '',
					'order_middle'	=>0,
					'order_is_super'=>0
				);

				//中游指定	
			} else if ($order['owner_status'] == 'assign' && $order['middle_status'] == 'assign' &&  $order['order_middle'] == $user_id ) {
				$data = array(
					'middle_status'  => 'catch',
					'driver_status' => '',
					'order_driver' => 0,
					'owner_status'  => 'transfer',
					'order_is_super'=>0
				);
			} else {
				return array('status' => false, 'msg' => '發生問題，此筆訂單無法指定駕駛');
			}
			//
			// $this->db->where(array("user_id" => $user_id,"order_no" => $order_no))->update('order_log',array("is_cancel" => 1,));
		} elseif ($action == 'free_cancel') {
			//自由承接取消 -> 上游取消 中游取消

			//上游自由承接取消
			if (($order['owner_status'] == 'send_free' || $order['owner_status'] == 'free_get') &&  $order['order_owner'] == $user_id) {

				$data = array(
					'owner_status'  => 'make',
					'driver_status' => '',
					'order_driver' => 0,
					'middle_status'  => '',
					'order_middle'	=>0,
					'order_is_super'=>0
				);

				//中游自由承接取消
			} else if (($order['middle_status'] == 'send_free' || $order['middle_status'] == 'free_get') &&  $order['order_middle'] == $user_id) {
				$data = array(
					'middle_status'  => 'catch',
					'driver_status' => '',
					'order_driver' => 0,
					'owner_status'  => 'transfer',
					'order_is_super'=>0
				);
			} else {
				return array('status' => false, 'msg' => '發生問題，此筆訂單無法取消自由承接');
			}
		} elseif ($action == 'delete') {

			//只有上游可刪除
			if ($order['order_owner'] == $user_id) {

				$data = array(
					'owner_status'  => '',
					'middle_status' => '',
					'driver_status' => '',
					'order_middle'  => 0,
					'order_driver' 	=> 0,
					'is_delete'		 => 1,
					'order_is_super'=>0
				);

				$this->Order_model->del_origin_addr_list($order_no);
			} else {
				return array('status' => false, 'msg' => '您的權限無法刪除訂單');
			}
		} elseif ($action == 'cancel') {

			//只有中游可取消接受轉單
			if ($order['order_middle'] == $user_id) {

				$data = array(
					'owner_status'  => 'make',
					'middle_status' => '',
					'driver_status' => '',
					'order_middle'  => 0,
					'order_driver' 	=> 0,
					'order_is_super'=>0
				);
			} else {
				return array('status' => false, 'msg' => '您的權限無法取消訂單');
			}
		}elseif ($action == 'reset') {

			//重置派遣
			if ($order['order_owner'] == $user_id) {

				$data = array(
					'owner_status'  => 'make',
					'middle_status' => '',
					'driver_status' => '',
					'order_middle'  => 0,
					'order_driver' 	=> 0,
					'order_is_super'=>0
					
				);
				$this->db->where(array("type !=" => 'make',"order_no" => $order_no))->update('order_log',array("is_cancel" => 1,));
				$res = $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);
				// $res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
				// return array('status' => true, 'msg' => '操作完成');

			} else {
				return array('status' => false, 'msg' => '您的權限無法重置訂單');
			}		
		}

		if ($action == 'transfer_cancel') {
			//取消轉單
			$this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			$this->Send_model->add_corn($user_id, $order_no, 'can_get');
			$this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');

		}else if ($action == 'assign_cancel') {
			//指定駕駛取消
			$this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			$this->Send_model->add_corn($user_id, $order_no, 'can_get');
			$this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');

		}else if ($action == 'free_cancel') {
			//自由承接取消
			// $this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			$this->Send_model->add_corn($user_id, $order_no, 'can_get');
			// $this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');

		} else if ($action == 'delete') {
			//刪除
			$this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			$this->Send_model->add_corn($user_id, $order_no, 'can_get');
			$this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');

		} else if ($action == 'cancel') {
			//刪除
			// $this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			// $this->Send_model->add_corn($user_id, $order_no, 'can_get');
			$this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');
		}

		$res = $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);
		if ($res) {
			$this->add_order_log($order_no, $action, $user_id);
			//刪除自由承接發送者
			$this->db->where(array("order_no" => $order_no))->delete('free_order_driver');
			
		}



		return array('status' => true, 'msg' => '操作完成');
	}

	public function get_order_log($order_no)
	{
		

		$syntax = "O.order_no = $order_no";
		$syntax_log = "O.order_no = $order_no AND O.is_cancel = 0";

	
		$list = $this->db->select("O.*,U.username")
			->from($this->order_log_table . " O")
			->join($this->user_table . " U" ,"U.id = O.user_id")
			->where($syntax_log)
			->order_by('O.timestamp ASC')
			->get()->result_array();

		//取得操作日期array
		$date_array = $this->db->select("O.date")
		->from($this->order_log_table . " O")
		->where($syntax_log)
		->group_by('O.date')
		->order_by('O.date DESC')
		->limit(1)
		->get()->result_array();

		$data = array();
		// unset($data);
		// print_r($date_array);exit;
		
		foreach($date_array as $d){

			$data[$d['date']] = array();

			$ii = 0;	
			foreach($list as $l){

				if ($d['date'] == $l['date']) {

					$data[$d['date']][$ii] = $l;
					$data[$d['date']][$ii]['time'] = date('H:i',strtotime($l['timestamp']));

					// if($l['type']== 'make'){
					// 	$data[$d['date']][$ii]['status'] = '建立訂單';
					// 	$data[$d['date']][$ii]['member'] = '';

					// } 
					//else if ($l['type'] == 'transfer') {
					// 	$data[$d['date']][$ii]['status'] = '行程轉單';
					// 	$member = $this->User_model->get_data($l['user_id']);
					// 	$data[$d['date']][$ii]['member'] = $member['username'];

					// } else if ($l['type'] == 'transfer_cancel') {
					// 	$data[$d['date']][$ii]['status'] = '取消轉單';
					// 	$data[$d['date']][$ii]['member'] = '';

					// } else if ($l['type'] == 'assign') {
					// 	$data[$d['date']][$ii]['status'] = '指定駕駛';
					// 	$member = $this->User_model->get_data($l['user_id']);
					// 	$data[$d['date']][$ii]['member'] = $member['username'];

					// } else if ($l['type'] == 'assign_cancel') {
					// 	$data[$d['date']][$ii]['status'] = '取消駕駛';
					// 	$data[$d['date']][$ii]['member'] = '';

					// } else if ($l['type'] == 'free') {
					// 	$data[$d['date']][$ii]['status'] = '自由承接';
					// 	// $member = $this->User_model->get_data($l['user_id']);
					// 	$members = unserialize($l['get_free_members']);
					// 	$member_str = '';
					// 	foreach($members as $m){
					// 		$member = $this->User_model->get_data($m);

					// 		$member_str .= $member['username'].' ';
					// 	}
					// 	$data[$d['date']][$ii]['member'] = $member_str;

					// } else if ($l['type'] == 'free_cancel') {
					// 	$data[$d['date']][$ii]['status'] = '取消自由承接';
					// 	$data[$d['date']][$ii]['member'] = '';

					// } else if ($l['type'] == 'cancel') {
					// 	$data[$d['date']][$ii]['status'] = '取消承接';
					// 	$member = $this->User_model->get_data($l['user_id']);
					// 	$data[$d['date']][$ii]['member'] = $member['username'];
					// } 
					if ($l['type'] == 'arrive_start') {
						// if($l['is_cancel']==0){
							$data[$d['date']][$ii]['status'] = '抵達起點';
							$data[$d['date']][$ii]['member'] = '';
						// }
						
						// $data[$d['date']][$ii]['member'] = $l['username'];
					// 	$member = $this->User_model->get_data($l['user_id']);
					// 	$data[$d['date']][$ii]['member'] = $member['username'];
					} 
					else if ($l['type'] == 'start_trip') {
						// if($l['is_cancel']==0){
						$data[$d['date']][$ii]['status'] = '開始行程';
						$data[$d['date']][$ii]['member'] = '';
						// }
						// $member = $this->User_model->get_data($l['user_id']);
						// $data[$d['date']][$ii]['member'] = $member['username'];
					} 
					else if ($l['type'] == 'finish') {
						$data[$d['date']][$ii]['status'] = '行程結束';
						$data[$d['date']][$ii]['member'] = '';
						// $member = $this->User_model->get_data($l['user_id']);
						// $data[$d['date']][$ii]['member'] = $member['username'];
					}

					unset($data[$d['date']][$ii]['id']);
					unset($data[$d['date']][$ii]['date']);
					unset($data[$d['date']][$ii]['order_no']);
					unset($data[$d['date']][$ii]['type']);
					unset($data[$d['date']][$ii]['timestamp']);
					unset($data[$d['date']][$ii]['get_free_members']);
					$ii++;
				}


				
			}
		}
		// foreach($date_array as $d){

		// 	$data= array();

		// 	$ii = 0;	
		// 	foreach($list as $l){

		// 		if ($d['date'] == $l['date']) {

		// 			$data[$ii] = $l;
		// 			$data[$ii]['time'] = date('H:i',strtotime($l['timestamp']));

					
					
		// 			if ($l['type'] == 'arrive_start') {
		// 				// if($l['is_cancel']==0){
		// 					$data[$ii]['status'] = '抵達起點';
		// 					$data[$ii]['member'] = '';
		// 				// }
						
		// 				// $data[ ][$ii]['member'] = $l['username'];
		// 			// 	$member = $this->User_model->get_data($l['user_id']);
		// 			// 	$data[ ][$ii]['member'] = $member['username'];
		// 			} 
		// 			else if ($l['type'] == 'start_trip') {
		// 				// if($l['is_cancel']==0){
		// 				$data[$ii]['status'] = '開始行程';
		// 				$data[$ii]['member'] = '';
		// 				// }
		// 				// $member = $this->User_model->get_data($l['user_id']);
		// 				// $data[ ][$ii]['member'] = $member['username'];
		// 			} 
		// 			else if ($l['type'] == 'finish') {
		// 				$data[$ii]['status'] = '行程結束';
		// 				$data[$ii]['member'] = '';
		// 				// $member = $this->User_model->get_data($l['user_id']);
		// 				// $data[ ][$ii]['member'] = $member['username'];
		// 			}

		// 			unset($data[$ii]['id']);
		// 			unset($data[$ii]['date']);
		// 			unset($data[$ii]['order_no']);
		// 			unset($data[$ii]['type']);
		// 			unset($data[$ii]['timestamp']);
		// 			unset($data[$ii]['get_free_members']);
		// 			$ii++;
		// 		}
		// 	}
		// }
		// print_r(gettype($data));exit;
		return $data;
	}

	////
	// public function get_order_log_test($order_no)
	// {

	// 	$syntax = "O.order_no = $order_no";

	
	// 	$list = $this->db->select("O.*,U.username")
	// 		->from($this->order_log_table . " O")
	// 		->join($this->user_table . " U" ,"U.id = O.user_id")
	// 		->where($syntax)
	// 		->order_by('O.timestamp ASC')
	// 		->get()->result_array();

	// 	//取得操作日期array
	// 	$date_array = $this->db->select("O.date")
	// 	->from($this->order_log_table . " O")
	// 	->where($syntax)
	// 	->group_by('O.date')
	// 	->get()->result_array();

	// 	$data = array();
		
	// 	foreach($date_array as $d){

	// 		$data[$d['date']] = array();

	// 		$ii = 0;	
	// 		foreach($list as $l){

	// 			if ($d['date'] == $l['date']) {

	// 				$data[$d['date']][$ii] = $l;
	// 				$data[$d['date']][$ii]['time'] = date('H:i',strtotime($l['timestamp']));

	// 				// if($l['type']== 'make'){
	// 				// 	$data[$d['date']][$ii]['status'] = '建立訂單';
	// 				// 	$data[$d['date']][$ii]['member'] = '';

	// 				// } 
	// 				//else if ($l['type'] == 'transfer') {
	// 				// 	$data[$d['date']][$ii]['status'] = '行程轉單';
	// 				// 	$member = $this->User_model->get_data($l['user_id']);
	// 				// 	$data[$d['date']][$ii]['member'] = $member['username'];

	// 				// } else if ($l['type'] == 'transfer_cancel') {
	// 				// 	$data[$d['date']][$ii]['status'] = '取消轉單';
	// 				// 	$data[$d['date']][$ii]['member'] = '';

	// 				// } else if ($l['type'] == 'assign') {
	// 				// 	$data[$d['date']][$ii]['status'] = '指定駕駛';
	// 				// 	$member = $this->User_model->get_data($l['user_id']);
	// 				// 	$data[$d['date']][$ii]['member'] = $member['username'];

	// 				// } else if ($l['type'] == 'assign_cancel') {
	// 				// 	$data[$d['date']][$ii]['status'] = '取消駕駛';
	// 				// 	$data[$d['date']][$ii]['member'] = '';

	// 				// } else if ($l['type'] == 'free') {
	// 				// 	$data[$d['date']][$ii]['status'] = '自由承接';
	// 				// 	// $member = $this->User_model->get_data($l['user_id']);
	// 				// 	$members = unserialize($l['get_free_members']);
	// 				// 	$member_str = '';
	// 				// 	foreach($members as $m){
	// 				// 		$member = $this->User_model->get_data($m);

	// 				// 		$member_str .= $member['username'].' ';
	// 				// 	}
	// 				// 	$data[$d['date']][$ii]['member'] = $member_str;

	// 				// } else if ($l['type'] == 'free_cancel') {
	// 				// 	$data[$d['date']][$ii]['status'] = '取消自由承接';
	// 				// 	$data[$d['date']][$ii]['member'] = '';

	// 				// } else if ($l['type'] == 'cancel') {
	// 				// 	$data[$d['date']][$ii]['status'] = '取消承接';
	// 				// 	$member = $this->User_model->get_data($l['user_id']);
	// 				// 	$data[$d['date']][$ii]['member'] = $member['username'];
	// 				// } 
	// 				if ($l['type'] == 'arrive_start') {
	// 					$data[$d['date']][$ii]['status'] = '起點';
	// 					$data[$d['date']][$ii]['member'] = '';
	// 					// $data[$d['date']][$ii]['member'] = $l['username'];
	// 				// 	$member = $this->User_model->get_data($l['user_id']);
	// 				// 	$data[$d['date']][$ii]['member'] = $member['username'];
	// 				} 
	// 				else if ($l['type'] == 'start_trip') {
	// 					$data[$d['date']][$ii]['status'] = '開始行程';
	// 					$data[$d['date']][$ii]['member'] = '';
	// 					// $member = $this->User_model->get_data($l['user_id']);
	// 					// $data[$d['date']][$ii]['member'] = $member['username'];
	// 				} 
	// 				else if ($l['type'] == 'finish') {
	// 					$data[$d['date']][$ii]['status'] = '行程結束';
	// 					$data[$d['date']][$ii]['member'] = '';
	// 					// $member = $this->User_model->get_data($l['user_id']);
	// 					// $data[$d['date']][$ii]['member'] = $member['username'];
	// 				} 

	// 				unset($data[$d['date']][$ii]['id']);
	// 				unset($data[$d['date']][$ii]['date']);
	// 				unset($data[$d['date']][$ii]['order_no']);
	// 				unset($data[$d['date']][$ii]['type']);
	// 				unset($data[$d['date']][$ii]['timestamp']);
	// 				unset($data[$d['date']][$ii]['get_free_members']);
	// 				$ii++;
	// 			}


				
	// 		}
	// 	}
	// 	// print_r(gettype($data));exit;
	// 	return $data;
	// }
	///
	public function order_operate_check($action, $order_list, $user_id)
	{
		foreach ($order_list  as $o) {

			$order = $this->get_order($o);

			if ($action == 'transfer') {
				//轉單-> 上游轉中游
				if ($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0) {

					continue;

				} else {
					return array('status' => false, 'msg' => '發生問題，訂單無法進行轉單操作');
				}
			} elseif ($action == 'assign') {
				//指定駕駛 -> 上游指定 中游指定

				//上游指定
				if ($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0) {
					continue;

					//中游指定	
				} else if ($order['owner_status'] == 'transfer' && $order['middle_status'] == 'catch' && $order['driver_status'] == ''  &&  $order['order_middle'] == $user_id && $order['order_driver'] == 0) {
					continue;

				} else {
					return array('status' => false, 'msg' => '發生問題，此筆訂單無法指定駕駛');
				}
			} elseif ($action == 'delete') {

				//只有上游可刪除
				if ($order['order_owner'] == $user_id) {
					continue;
				} else {
					return array('status' => false, 'msg' => '您的權限無法刪除訂單');
				}
			}elseif ($action == 'reset') {

				//只有上游可重置
				if ($order['order_owner'] == $user_id) {
					continue;
				}elseif($order['order_middle'] == $user_id){
					continue;
				} else {
					return array('status' => false, 'msg' => '您的權限無法重置訂單');
				}
			}
		}



		return array('status' => true, 'msg' => '操作完成');
	}

	public function order_free_check($order_list, $user_id)
	{
		foreach ($order_list  as $o) {
			//可導向自由承接頁面 上游按自由承接 中游按自由承接
			
			$order = $this->get_order($o);
			
			//上游按自由承接
			if ($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0) {

				continue;

			//上游按自由承接
			} else if ($order['owner_status'] == 'transfer' && $order['middle_status'] == 'catch' && $order['driver_status'] == ''  &&  $order['order_middle'] == $user_id &&  $order['order_driver'] == 0) {
				continue;

			} else {
				return array('status' => false, 'msg' => '發生問題，訂單無法進自由承接操作');
			}
		}



		return array('status' => true, 'msg' => '操作完成');
	}

	public function get_free_list($user_id,$search)
	{
		$syntax = "O.is_delete = 0 AND O.is_finish = 0";
		$syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";
		$list = array();
		//群組
		$group = $this->User_model->get_groups($user_id , $search);

		foreach($group as $g){

			$data = array(
				'type' 			=> 'group',
				'group_id'	=> 	$g['id'],
				'driver_id' => 0,
				'title' => $g['title'],
				'cnt' => $g['cnt'],
			);

			array_push($list,$data);
			
		}

		$friend = $this->User_model->get_friends_list($user_id, $search);

		foreach ($friend as $f) {

			$data = array(
				'type' 			=> 'friend',
				'group_id'	=> 	0,
				'driver_id' =>  $f['driver_id'],
				'title' => $f['showname'],
				'cnt' => 0,
			);

			array_push($list, $data);
		}

		
		return $list;
	}

	public function free_send_action($order_list, $user_id,$group_list,$friend_list)
	{
		//發送自由承接動作
		//order改狀態
		//發送存入free_order_driver
		//order_log紀錄

		foreach ($order_list  as $o) {
			$order = $this->get_order($o);
			//上游按自由承接
			if ($order['owner_status'] == 'make' && $order['middle_status'] == '' && $order['driver_status'] == ''  &&  $order['order_owner'] == $user_id &&  $order['order_middle'] == 0 &&  $order['order_driver'] == 0) {

				$data = array(
					'owner_status'  => 'send_free',
				);

				//上游按自由承接
			} else if ($order['owner_status'] == 'transfer' && $order['middle_status'] == 'catch' && $order['driver_status'] == ''  &&  $order['order_middle'] == $user_id &&  $order['order_driver'] == 0) {

				$data = array(
					'middle_status'  => 'send_free',
					'owner_status'  => 'send_free',
				);

			} else {
				return array('status' => false, 'msg' => '發生問題，訂單無法進自由承接操作');
			}

			//group
			$free_array = array();
			//取得group內driver
			$get_not_me=array();
			$black_r_id=array();
			if($group_list!=array() && $group_list[0]!=""){
				
				foreach($group_list as $g){
					$group_driver = $this->User_model->get_group_drivers($g);

					$res_crate=$this->db->select("U.id, U.username")
						->from($this->group_table." G")
						->join($this->user_table." U", "U.id = G.user_id", "left")
						->where(array("G.id"=>$g))
						->get()->row_array();
						if($user_id!=$res_crate['id']){
							$get_not_me[]=$res_crate;
						}
						
					// print_r($res_crate);exit;
					foreach($group_driver as $u){
							// if($res_crate){
								
							// }
							if($user_id!=$u['id']){
								$get_not_me[]=$u;
								
							}
						}	
						// print_r($get_not_me);exit;
						$black_r=$this->User_model->get_black_data($user_id);
				// 		print_r($user_id);
				// exit;
				foreach($get_not_me as  $g){
					
						$get_not_me_id[]=$g['id'];
					
					
				}
				// print_r($get_not_me_id);
				// print_r($get_not_me_id);exit;
				foreach($black_r as  $b){
					$black_r_id[]=$b['id'];
				}
				// print_r($black_r_id);

				$diff_id=array_diff($get_not_me_id,$black_r_id);

				// print_r($diff_id);

				foreach($get_not_me as  $g)
				{
					foreach($diff_id as $d_id){
						if($g['id']==$d_id){
							$final_group[]=$g;
						}
					}
					
				}
				
				
						// $this->User_model->get_group_drivers($g);
					
						foreach($final_group as $u){
						$black=$this->User_model->get_black($user_id, $u['id']);
						
						// print_r($black['user_id']);
						// print '---';
						// $b_user_id=$black['user_id'];
						// $b_driver_id=$black['driver_id'];
						if(!$black){
							// print 123;
							$group[]=$u;

						}else{
							// print_r($black) ;
							continue;
							// print_r($black['id']) ;
						}
					}

					// print_r($group);
					// exit;
					foreach($group as $g){
						// print_r($u['id']);
						// print '___';
						// print_r($g);exit;

						// $res = $this->Filter_model->check_super_info($o, $u['id']);
						$res = $this->Filter_model->check_super_info($o, $g['id']);
						if ($res) {
							//符合超級通知篩選->發送超級通知
							$f_o_data = array(
								'order_no'  => $o,
								'driver_id' => $g['id'],
								'is_super'  => 1,
							);

							$this->Send_model->send_super_info($g['id'], $o);
						} else {
							//不符合超級通知篩選->存入fcm_log 待排程發							
							$f_o_data = array(
								'order_no'  => $o,
								'driver_id' => $g['id'],
							);

							$this->Send_model->add_corn($g['id'], $o, 'can_get', true);
						}		

// print_r($f_o_data);

						if(!$this->db->where($f_o_data)->get('free_order_driver', $f_o_data)->row_array()){
							array_push($free_array, $g['id']);											

							$this->db->insert('free_order_driver', $f_o_data);
							
						}
						
					}
					// exit;
				}
			}
			// print_r($group_test);
			// exit;
			//friend
			if($friend_list != array() && $friend_list[0]!=""){
				foreach ($friend_list as $f) {
					$res = $this->Filter_model->check_super_info($o, $f);

					if ($res) {
						//符合超級通知篩選->發送超級通知
						$this->Send_model->send_super_info($f, $o);

						$f_o_data = array(
							'order_no'  => $o,
							'driver_id' => $f,
							'is_super'	=> 1
						);
					} else {
						//不符合超級通知篩選->存入fcm_log 待排程發							
						$this->Send_model->add_corn($f, $o, 'can_get', true);

						$f_o_data = array(
							'order_no'  => $o,
							'driver_id' => $f,
						);
					}		
					// print_r($f_o_data);exit;



					if (!$this->db->where($f_o_data)->get('free_order_driver', $f_o_data)->row_array()) {
						array_push($free_array, $f);
						$this->db->insert('free_order_driver', $f_o_data);

	
					}
				}
			}

			$res = $this->db->where(array("order_no" => $o))->update($this->order_table, $data);
			if ($res) {
				$this->add_order_log($o, 'free', 0,serialize($free_array));
			}
		}



		return array('status' => true, 'msg' => '發送成功');
	}

	public function undertake_list($user_id,$is_super_check)
	{
		//先從free_order_driver取得可接行程list
		// $f_o_list = $this->db->from('free_order_driver')->where(array('driver_id'=>$user_id))->get()->result_array();

		// //判斷是否有重複的訂單 use
		// $f_o_list = $this->more_array_unique($f_o_list);

		$list = array();

		// foreach($f_o_list as $f){
		// 	$order_no = $f['order_no'];

		// 	$order = 	$this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		// 			->from($this->free_order_driver . " F")
		// 			->join($this->order_table . " O", "F.order_no = O.order_no", "left")					
		// 			->where("O.order_no = $order_no")					
		// 			->get()->row_array();

		// 	$order['is_super'] = $f['is_super'];


		// 	array_push($list,$order);		
		// }
		$list = 	$this->db->select("O.is_delete,O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle,F.is_super")
				->from($this->free_order_driver . " F")
				->join($this->order_table . " O", "F.order_no = O.order_no", "left")
				->where(array('F.driver_id' => $user_id,'is_super'=>0))
				->order_by("date ASC,time ASC")
				->get()->result_array();

		$super_list = 	$this->db->select("O.is_delete,O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle,F.is_super")
		->from($this->free_order_driver . " F")
		->join($this->order_table . " O", "F.order_no = O.order_no", "left")
		->where(array('F.driver_id' => $user_id, 'is_super' => 1))
		->order_by("date ASC,time ASC")
		->get()->result_array();				

// print_r($super_list);
// exit;
$data[0]=null;
$j=0;
		$i	=	0;
		foreach ($list as $l) {
			// print_r($l['final_status']);exit;
			// $final_status=$l['final_status'];
			// $price=$l['price'];
			// $final_payment=$l['final_payment'];
			
			$list[$i]['final_status']=$l['final_status'];
			$list[$i]['price']=$l['price'];
			$list[$i]['final_payment']=$l['final_payment'];
			// print $final_status.$final_payment.$price;
			// print_r($list[$i]['final_payment']);
			// exit;
			if($list[$i]['final_status']==0){
				$list[$i]['price']=$list[$i]['price']-$list[$i]['final_payment'];
				// print $list[$i]['price'];exit;
			}else{
				$list[$i]['price']=$list[$i]['price']+$list[$i]['final_payment'];
				// print $final_payment;exit;
			}
			

			$sender = $this->User_model->get_data($l['order_owner']);
			
			
			$list[$i]['sender_name'] = (isset($sender['username']))? $sender['username']:'';
			// $list[$i]['sender_name'] = $sender['username'];
			
		

			if ($l['order_middle'] != 0) {
				$sender = $this->User_model->get_data($l['order_middle']);
				$list[$i]['sender_name'] = $sender['username'];
			}


			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] ;

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] ;
			}

			// unset($list[$i]['owner_status']);
			// unset($list[$i]['middle_status']);
			// // unset($list[$i]['driver_status']);
			// unset($list[$i]['order_driver']);
			// unset($list[$i]['order_owner']);
			// unset($list[$i]['order_middle']);
			// unset($list[$i]['start_city']);
			// unset($list[$i]['start_dist']);
			// unset($list[$i]['start_addr']);

			//只留下承接的訂單
			// if($l['is_delete']==1){
			// 	unset($list[$i]['address_start']);
			// 	unset($list[$i]['address_end']);
			// 	unset($list[$i]);
				
			// }
			
			
			if($list[$i]['order_driver']!=0 || $list[$i]['is_delete']!=0|| $list[$i]['owner_status']=='make'){
				// unset($list[$i]['address_start']);
				// unset($list[$i]['address_end']);
				// $list[$i]['address_start']='';
				unset($list[$i]);
			}else{
				
				$data[$j]=$list[$i];
				$j++;
			}
			// if($data==false){
			// 	$data[0]=null;
			// }
			$i++;
		}
		// return $data;
		// return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
		$super_data[0]=null;
		$j=0;
		$i	=	0;
		foreach ($super_list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			$super_list[$i]['sender_name'] = $sender['username'];

			if ($l['order_middle'] != 0) {
				$sender = $this->User_model->get_data($l['order_middle']);
				$super_list[$i]['sender_name'] = $sender['username'];
			}

			$super_list[$i]['final_status']=$l['final_status'];
			$super_list[$i]['price']=$l['price'];
			$super_list[$i]['final_payment']=$l['final_payment'];
			
			if($super_list[$i]['final_status']==0){
				$super_list[$i]['price']=$super_list[$i]['price']-$super_list[$i]['final_payment'];
				// print $list[$i]['price'];exit;
			}else{
				$super_list[$i]['price']=$super_list[$i]['price']+$super_list[$i]['final_payment'];
				// print $final_payment;exit;
			}


			$super_list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $super_list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];
			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$super_list[$i]['address_end'][]= $address['city'] . $address['dist'] ;
			}
			// unset($super_list[$i]['owner_status']);
			// unset($super_list[$i]['middle_status']);
			// // unset($super_list[$i]['driver_status']);
			// unset($super_list[$i]['order_driver']);
			// unset($super_list[$i]['order_owner']);
			// unset($super_list[$i]['order_middle']);
			// unset($super_list[$i]['start_city']);
			// unset($super_list[$i]['start_dist']);
			// unset($super_list[$i]['start_addr']);

			//只留下承接的訂單
			// if ($l['order_driver'] != 0) {
			// 	unset($super_list[$i]);
			// }
			if($super_list[$i]['order_driver']!=0 || $super_list[$i]['is_delete']!=0|| $super_list[$i]['owner_status']=='make'){
				// unset($list[$i]['address_start']);
				// unset($list[$i]['address_end']);
				// $list[$i]['address_start']='';
				unset($super_list[$i]);
			}else{
				
				$super_data[$j]=$super_list[$i];
				$j++;
			}

			$i++;
		}
		// print_r($super_data);exit;
		// return $list;
		if($is_super_check==1){
			if($super_data){
				foreach($super_data as $s_data){
					if($s_data==''){
						$last_list = $data;
					}else{
						$last_list = array_merge($data, $super_data);
					}
				}
			}else{
				$last_list = array_merge($data, $super_data);
			}
			// if($super_data!=array()){
			// // if(!empty($super_data)){
			// 	// print 123;
			// 	$last_list = array_merge($data, $super_data);
			// }else{
			// 	$last_list = $data;
			// }


			foreach($last_list as &$item){
				if($item){
					@$item['is_super'] = 1;
				}
			}
			
		}elseif($is_super_check==2){
			// $last_list =  $super_list; //is_super =1
			$last_list = array_merge($data, $super_data);
		}else{
			$last_list =  $data;  //is_super =0
		}
		// print_r($last_list);exit;
		return $last_list;
		// $data= [
		// 	'list'  => $list,
		// 	'super_list' => $super_list,
		// ];
		// return $data;

		
	}

	public function free_get_order($order_no,$user_id)
	{

		$driver = $this->db->select("U.role,U.id,U.is_verified,U.is_super")
		->from($this->user_table . " U")
		->where(array("U.id" => $user_id))
			->get()->row_array();

		if($driver['is_super']!=0){
			$order_is_super=1;
		}else{
			$order_is_super=0;
		}
		// print_r($order_is_super);exit;

		if ($driver['role'] != 'driver' || $driver['is_verified'] != 1) {
			return array('status' => false, 'msg' => '發生問題，您無權限承接此訂單');
		}


		$order = $this->get_order($order_no);

		if($order['order_driver']!="0"){
			return array('status' => TRUE, 'msg' => '此筆訂單已有人承接');
		}

		//有中游 自由承接
		if ($order['owner_status'] == 'send_free' && $order['middle_status'] == 'send_free') {
			$data = array(
				// "driver_status"   =>  'start',
				// "order_driver"    =>	$user_id,
				// "owner_status"		=> 'free_get', 
				"driver_status"   =>  'start',
				"order_driver"    =>	$user_id,
				"middle_status"		=> 'free_get',
				"owner_status"		=> 'free_get', 
				'order_is_super'=>$order_is_super
			);
		} else if ($order['owner_status'] == 'send_free' ) {
			//無中游 自由承接 自由承接
			$data = array(
				// "driver_status"   =>  'start',
				// "order_driver"    =>	$user_id,
				// "middle_status"		=> 'free_get',
				"driver_status"   =>  'start',
				"order_driver"    =>	$user_id,
				"owner_status"		=> 'free_get', 
				'order_is_super'=>$order_is_super
			);
		}
		// print base_url()."driver/undertake";
		// exit;
		// if(!isset($data)){
		// 	// header("Location:http://localhost/beecar_1/driver/undertake");
		// 	// $url  =  "http://localhost/beecar_1/driver/undertake" ; 
		// 	// echo " <   script   language = 'javascript' 
		// 	// type = 'text/javascript' > "; 
		// 	// echo " window.location.href = '$url' "; 
		// 	// echo " <  /script > "; 

		// 	// print base_url()."driver/undertake";
		// 	// exit;
		// 	return array('status' => false, 'msg' => '查無訂單');
		// }
		if(isset($data)){
			$res = $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);
		}else{
			return array('status' => TRUE, 'msg' => '此行程不存在');
		}
		
		if ($res) {

			//發推播
			$this->Send_model->add_corn($user_id, $order_no, 'my_trip');
			$this->Send_model->add_corn($user_id, $order_no, 'can_get');
			$this->Send_model->add_corn($user_id, $order_no, 'record');
			$this->Send_model->add_corn($user_id, $order_no, 'manage');
			$this->Send_model->add_corn($user_id, $order_no, 'manage_record');

			return array('status' => TRUE, 'msg' => '已成功承接此行程');
		}else{
			return array('status' => TRUE, 'msg' => '承接失敗 請重新操作');
		}
	}

	public function revert_all_action($order_no)
	{

		$order = $this->get_order($order_no);
		$data = array(
			'owner_status'  => 'make',
			'middle_status' => '',
			'driver_status' => '',
			'order_middle'  => 0,
			'order_driver'  => 0,
		);

		$res = $this->db->where(array("order_no" => $order_no))->update($this->order_table, $data);

		if ($res) {

			//發推播
			$this->Send_model->add_corn($order['order_ownder'], $order_no, 'manage');
			$this->Send_model->add_corn($order['order_ownder'], $order_no, 'manage_record');

			$this->Send_model->add_corn($order['order_middle'], $order_no, 'manage');
			$this->Send_model->add_corn($order['order_middle'], $order_no, 'manage_record');

			$this->Send_model->add_corn($order['order_driver'], $order_no, 'my_trip');
			$this->Send_model->add_corn($order['order_driver'], $order_no, 'can_get');
			$this->Send_model->add_corn($order['order_driver'], $order_no, 'record');
			

			$this->add_order_log($order_no, 'edit', $order['order_owner']);
		}else{
			return array('status' => true, 'msg' => '還原訂單至可編輯狀態失敗');	
		}


		return array('status' => true, 'msg' => '還原訂單至可編輯狀態成功');
	}

	public function manager_list_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $status, $start_addr,	$end_addr){
		$user_id = $user['id'];

		$syntax = "O.is_delete = 0 AND O.is_finish = 0";
		$syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";

		if($start_date != " " && $end_date != " "){
			$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
		}

		if ($start_time != " " && $end_time != " ") {
			$start = explode(':',$start_time)[0]. explode(':', $start_time)[1];
			$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
			$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
		}

		if ($car_model != " ") {

			$syntax .= " AND (";
			$index = 0;
			foreach ($car_model as $s) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .=  "(O.car_model = '" . $s. "' )";
				$index++;
			}
			$syntax .= ")";

			// $syntax .= " AND (O.car_model = '$car_model')";
		}
		

		if ($status != " ") {

			$syntax .= " AND (";
			$index = 0;
			foreach ($status as $s) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .=  " (O.owner_status = '$s' OR O.middle_status = '$s')";
				$index++;
			}
			$syntax .= ")";

			// $syntax .= " AND (O.car_model = '$car_model')";
		}

		// if ($status != " ") {
		// 	$syntax .= " AND (O.owner_status = '$status' OR O.middle_status = '$status')";
		// }

		if ($start_addr != " ") {
			// $start_addr = json_decode($start_addr, TRUE);
			$syntax .= " AND (";
			$index = 0;
			foreach ($start_addr as $s) {
				if ($index > 0) $syntax .= " OR ";
				if($s['area']!=""){
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
				}else{
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
				}
				
				$index++;
			}
			$syntax .= ")";
		}

		if ($end_addr != " ") {
			// $end_addr = json_decode($end_addr, TRUE);
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

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
											->from($this->order_table . " O")
											->join($this->order_addr_table." A",'O.order_no = A.order_no','left')
											->where($syntax)
											->order_by('O.date ASC,O.time ASC')
											->group_by("O.order_no")
											->get()->result_array();
		$i	=	0;
		foreach ($list as $l) {

			if ($l['order_owner'] == $user_id) {
				//建立訂單者
				if ($l['owner_status'] == 'make') {
					$list[$i]['status_str'] = '未派遣';
				} else if ($l['owner_status'] == 'transfer') {
					$list[$i]['status_str'] = '已轉單';
				} else if ($l['owner_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				} else if ($l['owner_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';
				}
			} else if ($l['order_middle'] == $user_id) {
				//中游

				if ($l['middle_status'] == 'catch') {
					$list[$i]['status_str'] = '已接到轉單';
				} else if ($l['middle_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				} else if ($l['middle_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				}
			}
			if ($l['driver_status'] != 'start' && $l['driver_status'] != '') {

				if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				}
			}
			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];


			//
			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] . $address['address'];
			}

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			$i++;
		}			
		return array('status' => TRUE, 'msg' => '取得資料成功', 'data'=>$list);
		
	}

	public function undertake_list_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr)
	{
		$user_id = $user['id'];
		$syntax = "O.is_delete = 0 AND O.is_finish = 0";

		if ($start_date != " " && $end_date != " ") {
			$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
		}

		if ($start_time != " " && $end_time != " ") {
			$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
			$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
			$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
		}

		if ($car_model != " ") {

			$syntax .= " AND (";
			$index = 0;
			foreach ($car_model as $s) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .=  "(O.car_model = '" . $s . "' )";
				$index++;
			}
			$syntax .= ")";

			// $syntax .= " AND (O.car_model = '$car_model')";
		}

		// print_r($car_model);exit;

		if ($start_addr != " ") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($start_addr as $s) {
				if ($index > 0) $syntax .= " OR ";
				if ($s['area'] != "") {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
				} else {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
				}

				$index++;
			}
			$syntax .= ")";
		}

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

		$list_123 = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from($this->order_table . " O")
		->join($this->order_addr_table . " A", 'O.order_no = A.order_no', 'left')
		->where($syntax)
			->where('O.order_driver = 0')
			->group_by("O.order_no")
			->get()->result_array();

		//先從free_order_driver取得可接行程list
		$f_o_list = $this->db->from('free_order_driver')->where(array('driver_id' => $user_id))->get()->result_array();
		$check_list = array();

		$list = 	$this->db->select("O.is_delete,O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle,F.is_super")
				->from($this->free_order_driver . " F")
				->join($this->order_table . " O", "F.order_no = O.order_no", "left")
				->where($syntax)
				->where(array('F.driver_id' => $user_id,'is_super'=>0))
				->order_by("date ASC,time ASC")
				->get()->result_array();

		// print_r($list);
		// print_r($list);exit;
		// exit;
		foreach ($f_o_list as $f) {
			// $order_no = $f['order_no'];
			foreach($list as $l){
				if($f['order_no'] == $l['order_no']){
					array_push($check_list, $l);
				}
			}
			
		}
		$data[0]=null;
		$j=0;
		$i	=	0;
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			$list[$i]['sender_name'] = $sender['username'];

			if ($l['order_middle'] != 0) {
				$sender = $this->User_model->get_data($l['order_middle']);
				$list[$i]['sender_name'] = $sender['username'];
			}


			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] ;

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] ;
			}

			// unset($list[$i]['owner_status']);
			// unset($list[$i]['middle_status']);
			// // unset($list[$i]['driver_status']);
			// unset($list[$i]['order_driver']);
			// unset($list[$i]['order_owner']);
			// unset($list[$i]['order_middle']);
			// unset($list[$i]['start_city']);
			// unset($list[$i]['start_dist']);
			// unset($list[$i]['start_addr']);

			//只留下承接的訂單
			// if ($l['order_driver'] != 0) {
			// 	unset($list[$i]);
			// }

			if($list[$i]['order_driver']!=0 || $list[$i]['is_delete']!=0|| $list[$i]['owner_status']=='make'){
				// unset($list[$i]['address_start']);
				// unset($list[$i]['address_end']);
				// $list[$i]['address_start']='';
				unset($list[$i]);
			}else{
				
				$data[$j]=$list[$i];
				$j++;
			}

			$i++;
		}

		// print_r($data);exit;
		
		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $data);
	}

	public function get_record_list($user_id=false)
	{
		$syntax = "O.is_delete = 0 AND O.is_finish = 1";
		if($user_id){
			$syntax .= " AND O.order_driver = $user_id  ";
		}

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle,O.number,O.baggage")
		->from($this->order_table . " O")
		->where($syntax)
			->order_by('O.date ASC,O.time ASC')
			->get()->result_array();

		$i	=	0;

		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			$list[$i]['sender_name'] = $sender['username'];
			$list[$i]['sender_id'] = $sender['id'];

			if ($l['order_middle'] != 0) {
				$sender = $this->User_model->get_data($l['order_middle']);
				$list[$i]['sender_name'] = $sender['username'];
				$list[$i]['sender_id'] = $sender['id'];
			}


			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未';
				} else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				}
			}

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] ;

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] ;

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			if(count($address_array)>0){
				foreach($address_array as $address){
					$list[$i]['address_end'][]= $address['city'] . $address['dist'];
				}
			}else{
				$list[$i]['address_end']='';
			}
			
			

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			$i++;
		}
		// return $list;
		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
	}

	public function record_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr)
	{
		$user_id = $user['id'];
		$syntax = "O.is_delete = 0 AND O.is_finish = 1";
		$syntax .= " AND O.order_driver = $user_id  ";

		if ($start_date != " " && $end_date != " ") {
			$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
		}

		if ($start_time != " " && $end_time != " ") {
			$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
			$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
			$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
		}

		// if ($car_model != " ") {
		// 	$syntax .= " AND (O.car_model = '$car_model')";
		// }
		if ($car_model != " ") {

			$syntax .= " AND (";
			$index = 0;
			foreach ($car_model as $s) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .=  "(O.car_model = '" . $s . "' )";
				$index++;
			}
			$syntax .= ")";

			// $syntax .= " AND (O.car_model = '$car_model')";
		}



		if ($start_addr != " ") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($start_addr as $s) {
				if ($index > 0) $syntax .= " OR ";
				if ($s['area'] != "") {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
				} else {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
				}

				$index++;
			}
			$syntax .= ")";
		}

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

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from($this->order_table . " O")
		->where($syntax)
			->order_by('O.date ASC,O.time ASC')
			->get()->result_array();

		$i	=	0;
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			$list[$i]['sender_name'] = $sender['username'];
			$list[$i]['sender_id'] = $sender['id'];

			if ($l['order_middle'] != 0) {
				$sender = $this->User_model->get_data($l['order_middle']);
				$list[$i]['sender_name'] = $sender['username'];
				$list[$i]['sender_id'] = $sender['id'];
			}


			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未執行';
				} else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				}
			}

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] ;

			$address = $this->get_order_addr_end($l['order_no']);
			$list[$i]['address_end'] = $address['city'] . $address['dist'] ;

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			$i++;
		}

		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
	}
	public function get_manage_record_old($user_id=false)
	{
		$syntax = "O.is_delete = 0 ";
		$syntax .= " AND (O.order_driver = $user_id) OR (O.order_driver !=0 AND O.order_owner = $user_id) OR (O.order_driver !=0 AND O.order_middle = $user_id)";
		// $syntax .= " AND (O.order_driver = $user_id OR O.order_owner = $user_id OR O.order_middle = $user_id)";
		$list = $this->db->select("O.*")
							->from($this->order_table . " O")
							->where($syntax)
							->order_by('O.date ASC,O.time ASC')
							->get()->result_array();
							// print_r($list);exit;
		$i	=	0;

		
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			// print_r($sender);
			$list[$i]['sender_name'] = $sender['username'];

			if($l['order_middle']!=0){
				$sender = $this->User_model->get_data($l['order_middle']);
				
				$list[$i]['sender_name'] = $sender['username'];
			}


			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未執行';
				}else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				} else if ($l['driver_status'] == 'finish') {
					$list[$i]['status_str'] = '完成行程';
				}
			}
			if($list[$i]['final_status']==0){
				$list[$i]['price']=$list[$i]['price']-$list[$i]['final_payment'];
				
			}else{
				$list[$i]['price']=$list[$i]['price']+$list[$i]['final_payment'];
				
			}

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] . $address['address'];
			}

			//駕駛人
			$driver_name = "";
			$driver_id = "";
			$driver = $this->User_model->get_data($l['order_driver']);
			if ($driver) {
				$driver_name = $driver['username'];
				$driver_id = $driver['id'];		
			}
			$list[$i]['driver_name'] = $driver_name;
			$list[$i]['driver_id'] = $driver_id;	

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);
			unset($list[$i]['price_type']);

			$i++;
		}
		// exit;
		// return $list;
		// $syntax = "O.is_delete = 0";
		// $syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";

		// $list = $this->db->select("O.order_no,O.name,O.date,O.time,O.phone,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price,O.final_status,O.final_payment,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		// ->from($this->order_table . " O")
		// ->where($syntax)
		// 	->order_by('O.date ASC,O.time ASC')
		// 	->get()->result_array();
		// $i	=	0;
		// foreach ($list as $l) {
			

		// 	$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

		// 	$address = $this->get_order_addr_end($l['order_no']);
		// 	$list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

		// 	//駕駛人
		// 	$driver_name = "";
		// 	$driver_id = "";
		// 	$driver = $this->User_model->get_data($l['order_driver']);
		// 	if ($driver) {
		// 		$driver_name = $driver['username'];
		// 		$driver_id = $driver['id'];		
		// 	}
		// 	$list[$i]['driver_name'] = $driver_name;
		// 	$list[$i]['driver_id'] = $driver_id;			
			
		// 	// unset($list[$i]['owner_status']);
		// 	// unset($list[$i]['middle_status']);
		// 	// // unset($list[$i]['driver_status']);
		// 	// unset($list[$i]['order_driver']);
		// 	// unset($list[$i]['order_owner']);
		// 	// unset($list[$i]['order_middle']);
		// 	// unset($list[$i]['start_city']);
		// 	// unset($list[$i]['start_dist']);
		// 	// unset($list[$i]['start_addr']);

		// 	$i++;
		// }			
		// return $list;
		// print_r($list);exit;
		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
	}
	public function get_manage_record($user_id=false)
	{
		$syntax = "O.is_delete = 0 ";
		// $syntax .= " AND (O.order_driver = $user_id) OR (O.order_driver !=0 AND O.order_owner = $user_id) OR (O.order_driver !=0 AND O.order_middle = $user_id)";
		//  $syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";
		 $syntax .= " AND ((O.order_driver !=0 AND O.order_owner = $user_id) OR (O.order_driver !=0 AND O.order_middle = $user_id))";
		 //$syntax .= " AND (O.order_driver = $user_id OR O.order_owner = $user_id OR O.order_middle = $user_id)";
		$list = $this->db->select("O.*")
							->from($this->order_table . " O")
							->where($syntax)
							->order_by('O.date ASC,O.time ASC')
							->get()->result_array();
							// print_r($list);exit;
		$i	=	0;

		
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			// print_r($sender);
			$list[$i]['sender_name'] = $sender['username'];

			if($l['order_middle']!=0){
				$sender = $this->User_model->get_data($l['order_middle']);
				
				$list[$i]['sender_name'] = $sender['username'];
			}

			//////////////////
			if($l['order_owner'] == $user_id){
				//建立訂單者
				if($l['owner_status'] == 'make'){
					$list[$i]['status_str'] = '未派遣';
				} else if ($l['owner_status'] == 'transfer') {
					$list[$i]['status_str'] = '已轉單';
				} else if ($l['owner_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
			 	} else if ($l['owner_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';		
				}

			} else if ($l['order_middle'] == $user_id) {
				//中游

				if ($l['middle_status'] == 'catch') {
					$list[$i]['status_str'] = '已接到轉單';
					$driver = $this->User_model->get_data($l['order_owner']);//
					$list[$i]['owner_name'] = $driver['username'];//
				} else if ($l['middle_status'] == 'send_free') {
					$list[$i]['status_str'] = '待承接';
				} else if ($l['owner_status'] == 'free_get') {
					$list[$i]['status_str'] = '已有駕駛承接';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				} else if ($l['middle_status'] == 'assign') {
					$list[$i]['status_str'] = '已指定駕駛';
					$driver = $this->User_model->get_data($l['order_driver']);
					$list[$i]['driver_name'] = $driver['username'];
				}
			}
			///////////////////

			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未執行';
				}else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				} else if ($l['driver_status'] == 'finish') {
					$list[$i]['status_str'] = '完成行程';
				}
			}
			if($list[$i]['final_status']==0){
				$list[$i]['price']=$list[$i]['price']-$list[$i]['final_payment'];
				
			}else{
				$list[$i]['price']=$list[$i]['price']+$list[$i]['final_payment'];
				
			}

			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			// $address = $this->get_order_addr_end($l['order_no']);
			// $list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			$address_array = $this->get_order_addr_end_array($l['order_no']);
			foreach($address_array as $address){
				$list[$i]['address_end'][]= $address['city'] . $address['dist'] . $address['address'];
			}

			//駕駛人
			$driver_name = "";
			$driver_id = "";
			$driver = $this->User_model->get_data($l['order_driver']);
			if ($driver) {
				$driver_name = $driver['username'];
				$driver_id = $driver['id'];		
			}
			$list[$i]['driver_name'] = $driver_name;
			$list[$i]['driver_id'] = $driver_id;	

			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);
			unset($list[$i]['price_type']);

			$i++;
		}
		// exit;
	
			

				
		// return $list;
		// print_r($list);exit;
		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
	}

	public function manage_record_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr)
	{
		$user_id = $user['id'];
		// $syntax = "O.is_delete = 0 AND O.is_finish = 1";
		$syntax = "O.is_delete = 0  AND O.driver_status !='' ";
		$syntax .= " AND (O.order_driver = $user_id OR O.order_owner = $user_id OR O.order_middle = $user_id)";
		// $syntax .= " AND (O.order_driver = $user_id) OR (O.order_driver !=0 AND O.order_owner = $user_id) OR (O.order_driver !=0 AND O.order_middle = $user_id)";

		if ($start_date != " " && $end_date != " ") {
			$syntax .= " AND (O.date BETWEEN '$start_date' AND '$end_date')";
		}

		if ($start_time != " " && $end_time != " ") {
			$start = explode(':', $start_time)[0] . explode(':', $start_time)[1];
			$end = explode(':', $end_time)[0] . explode(':', $end_time)[1];
			$syntax .= " AND (CONCAT(SUBSTRING_INDEX(O.time,':',1),SUBSTRING_INDEX(O.time,':',-1)) BETWEEN $start AND $end )";
		}

		// if ($car_model != " ") {
		// 	$syntax .= " AND (O.car_model = '$car_model')";
		// }
		if ($car_model != " ") {

			$syntax .= " AND (";
			$index = 0;
			foreach ($car_model as $s) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .=  "(O.car_model = '" . $s . "' )";
				$index++;
			}
			$syntax .= ")";

			// $syntax .= " AND (O.car_model = '$car_model')";
		}

		if ($start_addr != " ") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($start_addr as $s) {
				if ($index > 0) $syntax .= " OR ";
				if ($s['area'] != "") {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%' AND O.start_dist LIKE '%" . $s['area'] . "%')";
				} else {
					$syntax .=  "(O.start_city LIKE '%" . $s['city'] . "%')";
				}

				$index++;
			}
			$syntax .= ")";
		}

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

		$list = $this->db->select("O.order_no,O.name,O.date,O.time,O.phone,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price,O.final_status,O.final_payment,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from($this->order_table . " O")
		->where($syntax)
			->order_by('O.date ASC,O.time ASC')
			->get()->result_array();
		$i	=	0;
		foreach ($list as $l) {

			$sender = $this->User_model->get_data($l['order_owner']);
			// print_r($sender);
			$list[$i]['sender_name'] = $sender['username'];

			if($l['order_middle']!=0){
				$sender = $this->User_model->get_data($l['order_middle']);
				
				$list[$i]['sender_name'] = $sender['username'];
			}


			if ($l['driver_status'] != '') {

				if ($l['driver_status'] == 'start') {
					$list[$i]['status_str'] = '未執行';
				}else if ($l['driver_status'] == 'to_start') {
					$list[$i]['status_str'] = '前往起點';
				} else if ($l['driver_status'] == 'arrive_start') {
					$list[$i]['status_str'] = '抵達起點';
				} else if ($l['driver_status'] == 'start_trip') {
					$list[$i]['status_str'] = '開始行程';
				} else if ($l['driver_status'] == 'end') {
					$list[$i]['status_str'] = '結束行程';
				} else if ($l['driver_status'] == 'finish') {
					$list[$i]['status_str'] = '完成行程';
				}
			}
			
			if($list[$i]['final_status']==0){
				$list[$i]['price']=$list[$i]['price']-$list[$i]['final_payment'];
				
			}else{
				$list['price']=$list[$i]['price']+$list[$i]['final_payment'];
				
			}
			
			$list[$i]['address_start'] = $l['start_city'] . $l['start_dist'] . $l['start_addr'];

			$address = $this->get_order_addr_end($l['order_no']);
			$list[$i]['address_end'] = $address['city'] . $address['dist'] . $address['address'];

			//駕駛人
			$driver_name = "";
			$driver_id = "";;
			$driver = $this->User_model->get_data($l['order_driver']);
			if ($driver) {
				$driver_name = $driver['username'];
				$driver_id = $driver['id'];
			}
			$list[$i]['driver_name'] = $driver_name;
			$list[$i]['driver_id'] = $driver_id;

			// if($l['driver_status'] == ''){
			// 	unset($list[$i]);
			// 	// $list[$i]['status_str'] = '無';
			// }
			unset($list[$i]['owner_status']);
			unset($list[$i]['middle_status']);
			// unset($list[$i]['driver_status']);
			unset($list[$i]['order_driver']);
			unset($list[$i]['order_owner']);
			unset($list[$i]['order_middle']);
			unset($list[$i]['start_city']);
			unset($list[$i]['start_dist']);
			unset($list[$i]['start_addr']);

			// $list_list[]=

			$i++;
		}			
		// print_r($list);exit;

		return array('status' => TRUE, 'msg' => '取得資料成功', 'data' => $list);
	}

	
}
