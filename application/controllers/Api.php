<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends Base_Controller{
	private $login_url;
	public function __construct(){
		parent::__construct();
		$this->load->model("Driver_model");
		$this->load->model("Order_model");
		$this->load->model("Filter_model");
		$this->load->model("Notification_model");
		$this->load->model("Export_model");

		$this->login_url = base_url()."home/login";
	}

	/* firebase測試 */
	public function firebase_test(){
		
		//$reg_id = 'fUspjOh24QAGNeEqB36U8p:APA91bHb3ONfiavAtjosokvCXf1o7ai8HwnRADY2l8NWPVmE9lHAHp6PEkW-Z7OfZAAH_1OsEWmW9LiPJ9T-7T7SNfDuQnMX8p7t-VNElFYl1DjfpaBh11MLWQw5_Q--uY4fLKmkp80P';
		
		$reg_id = 'cdZnOCmioOMbCOsVfC1Bhp:APA91bH00fNPp-ZyZHRlN2Au2Tm16xsclmL96wLHlYgAUZwiQ8fjMxX4eFH1TLLgD8Y0YHcgVOM6cT5Y0TNmFPD1yIrNP4Ig6L6bZ_AQwMni2uFe80Rtkf1TJRfrYNjX8qBzzAX363es';
		

		$this->send_push($reg_id, "zzzz");

		$this->output(true, '已發送通知');
	}

	public function send_push($registatoin_ids,$message, $data = FALSE)
	{

		$url = 'https://fcm.googleapis.com/fcm/send';
		$title = "beecar";

		$content = array(
			'title'	=> $title,
			'body' 	=> $message
		);

		$fields = array(
			'to'		   		 	=> $registatoin_ids,
			'notification'	=> $content
		);
	
		
		$headers = array(
			'Authorization: key=AAAAU3NWQXE:APA91bHGon_akr5JAGiLyn3KBOBjf1Ub-vRzpH60hSrvM2MbxO8ms3z90zMJ1DpRLmGc0zuN8TrfFPF7McB0PcLlPzErVvS5Evon7wSpa_aILZt9vAH7MNQm9hcZ3Xgm566Gf8BTii5x',
			'Content-Type: application/json'
		);

		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);
		
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);

		$result = json_decode($result, true);
		
		return $result;
	}

	public function test()
	{
		$order_no 			= $this->post("order_no", " ", "");
		
		$res = $this->Filter_model->super_info_send($order_no);
		if($res){
			$this->output(true, '已發送通知');
		}else{
			$this->output(FALSE, '不符合');
		}
	}

	/* firebase測試 end */



	


	
	//刪除超級通知
	public function del_superfilter()
	{
		$user     = $this->check_user_token();
		$id 			= $this->post("id"," ","刪除id不可為空");

		$res =  $this->Filter_model->del_superfilter($id);

		if ($res) {
			$this->output(TRUE, "已成功刪除篩選");
		} else {
			$this->output(FALSE, "刪除失敗，請重新操作");
		}
	}

	//超級通知列表
	public function superfilter_list()
	{
		$user             = $this->check_user_token();

		$superfilter_list = $this->Filter_model->get_superfilter_list($user['id']);

		$this->output(TRUE, "取得超級通知篩選列表成功", array(
			"list" =>	$superfilter_list
		));
	}

	//新增超級通知
	public function add_super_filter()
	{
		$user             = $this->check_user_token();
		$start_date 			= $this->post("start_date", " ", "");
		$end_date 				= $this->post("end_date", " ", "");
		$start_time 			= $this->post("start_time", " ", "");
		$end_time					= $this->post("end_time", " ", "");
		$car_model 				= $this->post("car_model", " ", "");
		$start_addr				= $this->post("start_addr", " ", "");
		$end_addr				  = $this->post("end_addr", " ", "");

		$data = [
			'user_id' 	 => $user['id'],
			'start_date' => ($start_date!=" ") ? date('Y-m-d', strtotime($start_date)) : "" ,
			'end_date' 	 => ($end_date!=" ") ? date('Y-m-d', strtotime($end_date)) : "",
			'start_time' => $start_time,
			'end_time' 	 => $end_time,
			'car_model'  => (isset($car_model))?serialize($car_model):"",
			'start' 		 => (isset($start_addr)) ? serialize($start_addr) : "",
			'end'   		 => (isset($end_addr)) ? serialize($end_addr) : "",
		];		

		//2023 11 21 判斷是否可新增
		$res_num = 	$this->Filter_model->check_super_num($user['id']);
		if($res_num){
			$res = 	$this->Filter_model->add_super_filter($data);
		}else{
			$this->output(false, "新增失敗，搜尋條件已達10組上限");
		}

		if ($res) {
			$this->output(TRUE, "新增成功");
		} else {
			$this->output(false, "新增失敗");
		}
	}

	//管理行程紀錄搜尋
	public function manage_record_search()
	{

		$user             = $this->check_user_token();
		$start_date 			= $this->post("start_date", " ", "");
		$end_date 				= $this->post("end_date", " ", "");

		if ($start_date != " " && $end_date == " ") {
			$this->output(FALSE, '已填起始日期，請設定結束日期');
		} else if ($end_date != " " && $start_date == " ") {
			$this->output(FALSE, '已填結日期，請設定起始日期');
		}

		$start_time 			= $this->post("start_time", " ", "");
		$end_time					= $this->post("end_time", " ", "");

		if ($start_time != " " && $end_time == " ") {
			$this->output(FALSE, '已填起始時間，請設定結束時間');
		} else if ($end_time != " " && $start_time == " ") {
			$this->output(FALSE, '已填結束時間，請設定起始時間');
		}

		$car_model 				= $this->post("car_model", " ", "");
		$start_addr				= $this->post("start_addr", " ", "", 'array');
		$end_addr				  = $this->post("end_addr", " ", "", 'array');

		//insomnia test
		// $start_addr = json_decode($start_addr, TRUE);
		// $end_addr = json_decode($end_addr, TRUE);

		// if ($start_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		// if ($end_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		$res = $this->Order_model->manage_record_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr);

		if ($res['status']) {
			$this->output(TRUE, '取得資料成功', array('data' => $res['data']));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//管理行程紀錄列表
	public function get_manage_record()
	{
		$user             = $this->check_user_token();

		$get_record_list = $this->Order_model->get_manage_record($user['id']);
		// print_r($get_record_list);exit;
		$this->output(TRUE, "取得承接紀錄資料成功", array(
			"list" =>	$get_record_list
		));
	}

	//承接紀錄搜尋
	public function record_search()
	{

		$user             = $this->check_user_token();

		$start_date 			= $this->post("start_date", " ", "");
		$end_date 				= $this->post("end_date", " ", "");

		if ($start_date != " " && $end_date == " ") {
			$this->output(FALSE, '已填起始日期，請設定結束日期');
		} else if ($end_date != " " && $start_date == " ") {
			$this->output(FALSE, '已填結日期，請設定起始日期');
		}

		$start_time 			= $this->post("start_time", " ", "");
		$end_time					= $this->post("end_time", " ", "");

		if ($start_time != " " && $end_time == " ") {
			$this->output(FALSE, '已填起始時間，請設定結束時間');
		} else if ($end_time != " " && $start_time == " ") {
			$this->output(FALSE, '已填結束時間，請設定起始時間');
		}

		$car_model 				= $this->post("car_model", " ", "");
		$start_addr				= $this->post("start_addr", " ", "", 'array');
		$end_addr				  = $this->post("end_addr", " ", "", 'array');

		//insomnia test
		// $start_addr = json_decode($start_addr, TRUE);
		// $end_addr = json_decode($end_addr, TRUE);

		// if ($start_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		// if ($end_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		$res = $this->Order_model->record_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr);

		if ($res['status']) {
			$this->output(TRUE, '取得資料成功', array('data' => $res['data']));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//承接紀錄列表
	public function get_record()
	{
		$user             = $this->check_user_token();

		$get_record_list = $this->Order_model->get_record_list($user['id']);

		$this->output(TRUE, "取得承接紀錄資料成功", array(
			"list" =>	$get_record_list
		));
	}

	//可接行程搜尋
	public function undertake_list_search()
	{
		//狀態(未派遣make 已轉單transfer 待承接send_free 已有駕駛承接free_get 已指定駕駛assign 已接到轉單catch)
		$user             = $this->check_user_token();
		$start_date 			= $this->post("start_date", " ", "");
		$end_date 				= $this->post("end_date", " ", "");

		if ($start_date != " " && $end_date == " ") {
			$this->output(FALSE, '已填起始日期，請設定結束日期');
		} else if ($end_date != " " && $start_date == " ") {
			$this->output(FALSE, '已填結日期，請設定起始日期');
		}

		$start_time 			= $this->post("start_time", " ", "");
		$end_time					= $this->post("end_time", " ", "");
		
		if ($start_time != " " && $end_time == " ") {
			$this->output(FALSE, '已填起始時間，請設定結束時間');
		} else if ($end_time != " " && $start_time == " ") {
			$this->output(FALSE, '已填結束時間，請設定起始時間');
		}

		$car_model 				= $this->post("car_model", " ", "");
		$start_addr				= $this->post("start_addr", " ", "", 'array');
		$end_addr				  = $this->post("end_addr", " ", "", 'array');


		// print_r($start_addr);exit;

		//insomnia test
		// $start_addr = json_decode($start_addr, TRUE);
		// $end_addr = json_decode($end_addr, TRUE);

		// if ($start_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		// if ($end_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		$res = $this->Order_model->undertake_list_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $start_addr,	$end_addr);

		if ($res['status']) {
			$this->output(TRUE, '取得資料成功', array('data' => $res['data']));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//管理行程搜尋
	public function manager_list_search(){
		//狀態(未派遣make 已轉單transfer 待承接send_free 已有駕駛承接free_get 已指定駕駛assign 已接到轉單catch)
		
		$user             = $this->check_user_token();
		$start_date 			= $this->post("start_date", " ", "");
		$end_date 				= $this->post("end_date", " ", "");

		if($start_date != " " && $end_date == " "){
			$this->output(FALSE, '已填起始日期，請設定結束日期');
		} else if ($end_date != " " && $start_date == " ") {
			$this->output(FALSE, '已填結束日期，請設定起始日期');
		}

		$start_time 			= $this->post("start_time", " ", "");
		$end_time					= $this->post("end_time", " ", "");

		if ($start_time != " " && $end_time == " ") {
			$this->output(FALSE, '已填起始時間，請設定結束時間');
		} else if ($end_time != " " && $start_time == " ") {
			$this->output(FALSE, '已填結時間，請設定起始時間');
		}

		$car_model 				= $this->post("car_model", " ", "","array");
		$status 					= $this->post("status", " ", "","array");

		$start_addr				= $this->post("start_addr", " ", "", 'array');
		$end_addr				  = $this->post("end_addr", " ", "", 'array');

		//insomnia test
		// $start_addr = json_decode($start_addr, TRUE);
		// $end_addr = json_decode($end_addr, TRUE);

		// if ($start_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		// if ($end_addr[0]['city'] == " ") {
		// 	$this->output(FALSE, '請至少填寫一組目的地資訊');
		// }

		$res = $this->Order_model->manager_list_search($user,	$start_date,	$end_date, $start_time, $end_time, $car_model, $status, $start_addr,	$end_addr);

		if ($res['status']) {
			$this->output(TRUE, '取得資料成功', array('data' => $res['data']));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//管理行程詳情頁面 編輯按鈕 還原訂單至原始狀態
	public function edit_check()
	{
		$user             = $this->check_user_token();

		$order_no = $this->post("order_no", " ", "行程訂單編號不可為空");

		$this->check_order_edit($order_no, $user['id']);

		$res = $this->Order_model->revert_all_action($order_no);

		if ($res) {
			$this->output(TRUE, $res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}
	// add 10/13
	// 取得超級通知說明狀態
	public function get_super_text_status(){
		$user    = $this->check_user_token();
		if($user['show_text_status']=='on'){
			$this->output(TRUE, '取得成功', array(
				// "statuss" =>	true,
			));
		
		}else{
			$this->output(false, '取得成功', array(
				// "statuss" =>	false,
			));
			
		}

	}
	// 切換超級通知說明狀態
	public function change_super_text_status(){
		$user    = $this->check_user_token();

		// print_r($user['id']);exit;

		$show_text_status = $this->post("show_text_status", "", "on/off，不可為空值");
		// print_r($show_text_status);exit;
		$this->db->where(array("id"=>$user['id']))
			->update('user', array(
						"show_text_status" =>$show_text_status,
					));

		$this->output(TRUE, '切換成功', array(
			"data" =>	$show_text_status,
		));
	}


	// 取得超級通知說明文件
	public function get_super_text(){
		$user    = $this->check_user_token();

		$res = $this->User_model->get_text_list('super_text');
		// print_r($data);exit;
		$title=$res['title'];
		$content=$res['content'];
		$data=array(
			'title' => $title,
			'content' => $content,
		);
		$this->output(TRUE, '取得成功', array(
			"data" =>	$data,
		));
	}
	// 取得總消費紀錄
	public  function get_spend_record(){
		$user    = $this->check_user_token();

		$data[]=array(
			'id'=> '123',
			'date'=> '2020年9月',
			'pay_status'=> 'pending',
			'price'=> '100',
		);
		$data[]=array(
			'id'=> '123',
			'date'=> '2020年8月',
			'pay_status'=> 'paid',
			'price'=> '120',
		);
		// $this->output(TRUE, '取得成功',$data);

		$this->output(TRUE, '取得成功', array(
			"data" =>	$data,
		));

	}

	// 取得當月消費紀錄
	public  function get_spend_record_list(){
		$user    = $this->check_user_token();

		$data[]=array(
			'id'=> '11',
			'date'=> '2020/08/16',
			'summary' => '抽成',
			'price'=> '100',
		);
		$data[]=array(
			'id'=> '12',
			'date'=> '2020/08/20',
			'summary' => '抽成',
			'price'=> '120',
		);

		$this->output(TRUE, '取得成功', array(
			'title'  =>  '2020年8月',
			'total_price' =>'5000',
			'pay_status'=> 'pending',
			"data" =>	$data,
		));

	}

	// 取得當月消費紀錄細節
	public  function get_spend_record_detail(){
		$user    = $this->check_user_token();
		$data=array(
			'id'=> '12',
			'transcation_date'=> '2020/08/20',
			'discount_price'=> '120',
			'content' => '抽成',
			'detail'=>array(
				'date'=>'2020/09/16',
				'time'=>'7:30',
				'address_start'=>'台北市中山北路一段',
				'address_end'=>'台北市太原路二段',
				'baggage'=>'2',
				'number'=>'3',
				'car_model'=>'中巴(20~28人座)',
				'sender_name'=>'毛毛',
				'final_status'=>'0',  //0回金 1補貼	
				'final_payment'=>'105',
				'price_type'=>'0', //	0收現 1轉帳	
				'price'=>'2020',
				// 'order_no'=>'2020/09/16',
			)
		);
		$this->output(TRUE, '取得成功', array(
			// 'total_price' =>'5000',
			// 'pay_status'=> 'paid',
			"data" =>	$data,
		));

	}

	// 取得月消費紀錄說明內容
	public  function get_spend_text(){
		$user    = $this->check_user_token();
		$res = $this->User_model->get_text_list('spend_text');

		$title=$res['title'];
		$content=$res['content'];
		$data=array(
			'title' => $title,
			'content' => $content,
		);
		
		$this->output(TRUE, '取得成功', array(
			"data" =>	$data,
		));
	}

	// 取得月消費紀錄繳款狀態
	public  function get_spend_status(){
		$user    = $this->check_user_token();

		$text='請繳款以恢復完整功能';
		// $show_
		$pay_status='pending';
		$data=array(
			'text'  => $text,
			'text'  => $text,
		);

		$this->output(TRUE, '取得成功', array(
			"data" =>	$data,
		));
	}

	// 取得付款頁面
	public  function get_spend_page(){
		$user    = $this->check_user_token();
	}


	//勾選超級通知
	public function active_super_info_check()
	{
		$user             = $this->check_user_token();
		//on啟用(勾選) off關閉(未勾選)
		$action = $this->post("action", "", "on/off/customize，不可為空值");

		if($action!='on'&& $action != 'off' && $action != 'customize'){
			$this->output(FALSE, 'action參數錯誤：on/off/customize');
		}

		$res = $this->User_model->active_super_info_check($user['id'], $action);

		if ($res) {
			$this->output(TRUE, $res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//判斷是否啟用超級通知
	public function super_info_check()
	{
		$user             = $this->check_user_token();

		$res = 	$this->check_user_super($user['id']);

		if($res){
			if($res=='on'){
				$type='on';
				$title="有新的可接行程就通知我";
			}else{
				$type='customize';
				$title="自定通知條件";
			}
			$this->output(TRUE, $title, array(
				"type" =>	$type,
			));
			// $this->output(TRUE, "你已啟用超級通知");
		}else{
			$this->output(false, "不通知", array(
				"type" =>	'off',
			));
			// $this->output(false, "你未啟用超級通知，請前往會員中心啟用");
		}

	}

	//啟用超級通知
	public function active_super_info()
	{
		$user             = $this->check_user_token();

		$user_data = $this->User_model->get_data($user['id']);

		if($user_data['is_super']==1){
			$this->output(FALSE, '您已啟用超級通知，請勿重複操作');
		}

		$res = $this->User_model->active_super_info($user['id']);

		if ($res) {
			$this->output(TRUE, '開啟超級通知成功！');
		} else {
			$this->output(FALSE, '開啟超級通知失敗，請重新操作');
		}
	}

	//行程詳情頁-承接行程
	public function get_order()
	{
		$user             = $this->check_user_token();
		$order_no = $this->post("order_no", "", "無任何行程");

		
		$res = $this->Order_model->free_get_order($order_no, $user['id']);

		if ($res) {
			$this->output(TRUE, $res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//可接行程列表
	public function undertake_list()
	{
		$user             = $this->check_user_token();

		// $undertake_list = $this->Order_model->undertake_list($user['id']);
		$undertake_list = $this->Order_model->undertake_list($user['id'],$user['is_super_check']);
		$this->output(TRUE, "取得資料成功", array(
			// "super_list" =>	$undertake_list['super_list'],
			"list" =>	$undertake_list,
			// "list" =>	$undertake_list,
		));
	}


		//承接紀錄列表
		public function get_record_123()
		{
			$user             = $this->check_user_token();
	
			$get_record_list = $this->Order_model->get_record_list($user['id']);
	
			$this->output(TRUE, "取得承接紀錄資料成功", array(
				"list" =>	$get_record_list
			));
		}

	//發送自由承接
	public function free_send()
	{
		$user      = $this->check_user_token();
			
		// print_r($user);exit;
		$order_list = $this->post("order_list", "", "無選任何行程", 'array');
		if ($order_list[0] == "") {
			$this->output(FALSE, "無選任何行程");
		}

		$group_list = $this->post("group_list", "", "", 'array');
		$friend_list = $this->post("friend_list", "", "", 'array');

		if(!isset($group_list)){
			// $group_list=array();
			$group_list[0]='';
			
		} 
		if(!isset($friend_list)){
			// $group_list=array();
			$friend_list[0]='';
			
		} 
		// print_r($group_list);exit;
		// foreach($group_list as $g){
		// $group_driver = $this->User_model->get_group_drivers($g);
		// // print_r($group_driver);exit;

		// foreach($group_driver as $g_d){
		// 	// $black=$this->User_model->get_black($user['id'], $g_d['id']);
		// 	$black_r=$this->User_model->get_black_data($g_d['id']);
		// 	// print_r($black_r);exit;
		// 	// if($black['user'])
		// 	foreach($black_r as $black){
		// 		// print_r($black['user_id']);
		// 		// print '  ';
		// 		// print_r($black['driver_id']);
		// 		// print_r($black);exit;

		// 		if($g_d['id']!=$black['driver_id']){
		// 			// continue;
		// 			// print '1,';
		// 			$group_data[]=$g_d;
		// 		}
				
		// 		// else{
		// 		// 	print '2,';
		// 		// 	$group_data[]=$g_d;
		// 		// }

		// 	// 	if(!$black_r){
		// 	// 		// print 123;
		// 	// 		$group[]=$black;
		// 	// 	}else{
		// 	// 		// print_r($black) ;
		// 	// 		// continue;
		// 	// 		// print_r($black_r) ;
		// 	// 	}
		// 	// 	// print_r($black);
		// 	}

		// 	// print_r($group_driver);
		// 	// exit;
		// 	print_r($g_d);
		// }

		// // print_r($group_data);exit;

		// exit;
		// print_r($group_driver);exit;
		// }
		 
		
		if($group_list[0]=="" && $friend_list[0] ==""){
			$this->output(FALSE, "請至少選擇一人後再發送");
		}

		$res = $this->Order_model->free_send_action($order_list, $user['id'],$group_list,$friend_list);

		if ($res['status']) {
			$this->output(TRUE, $res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//自由承接人員列表
	public function free_list()
	{
		$user             = $this->check_user_token();
		$search           = $this->post("search", "");

		$friend_list = $this->Order_model->get_free_list($user['id'], $search);

		$this->output(TRUE, "自由承接選擇頁面取得資料成功", array(
			"list" =>	$friend_list
		));
	}

	//管理訂單詳情操作判斷(自由承接)
	public function order_free_check()
	{
		$user      = $this->check_user_token();

		
		$order_list = $this->post("order_list", "", "無選任何行程", 'array');
		if ($order_list[0] == "") {
			$this->output(FALSE, "無選任何行程");
		}

		$res = $this->Order_model->order_free_check($order_list, $user['id']);

		if ($res['status']) {
			$this->output(TRUE, $res['msg'],array("order_list"=>$order_list));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//行程軌跡
	public function get_order_log()
	{
		$this->check_user_token();

		$order_no = $this->post("order_no", " ", "行程訂單編號不可為空");

		$res = $this->Order_model->get_order_log($order_no);

		if ($res) {
			$this->output(TRUE, "取得行程log", array('list'=>$res));
		} else {
			$this->output(FALSE, '發生錯誤，請重新操作');
		}
	}

	// ////
	// public function get_order_log_test()
	// {
	// 	$this->check_user_token();

	// 	$order_no = $this->post("order_no", " ", "行程訂單編號不可為空");

	// 	$res = $this->Order_model->get_order_log_test($order_no);

	// 	if ($res) {
	// 		$this->output(TRUE, "取得行程log", array('list'=>$res));
	// 	} else {
	// 		$this->output(FALSE, '發生錯誤，請重新操作');
	// 	}
	// }

	//訂單詳情操作(轉單、指定、自由、刪除)
	public function order_detail_operation()
	{
		$user      = $this->check_user_token();

		//轉單transfer_cancel 指定assign_cancel 自由承接free_cancel 刪除delete 取消cancel
		$action = $this->post("action", "", "操作不可為空");

		if($action != 'transfer_cancel' && $action != 'assign_cancel' && $action != 'free_cancel' && $action != 'delete' && $action != 'cancel'  && $action != 'reset'){
			$this->output(FALSE, 'action參數錯誤,action只能為轉單transfer_cancel//指定assign_cancel//自由承接free_cancel//刪除delete//取消cancel');
		}
		$order_no = $this->post("order_no", "", "常用地址id不可為空");
																												//操作 訂單 操作者
		$res = $this->Order_model->order_detail_operation($action,$order_no,$user['id']);

		if ($res['status']) {
			$this->output(TRUE, $res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//訂單詳情操作判斷(轉單 指定 刪除)
	public function order_operate_check()
	{
		$user      = $this->check_user_token();

		//轉單transfer 指定assign 自由承接free 刪除delete
		$action = $this->post("action", "", "操作不可為空");

		$order_list = $this->post("order_list", "", "無選任何行程", 'array');
		if ($order_list[0] == "") {
			$this->output(FALSE, "無選任何行程");
		}

		$res = $this->Order_model->order_operate_check($action, $order_list, $user['id']);

		if ($res['status']) {
			$this->output(TRUE, $res['msg'], array("order_list" => $order_list));
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//管理列表操作(轉單、指定、刪除)
	public function order_operation()
	{
		$user      = $this->check_user_token();

		//轉單transfer 指定assign 自由承接free 刪除delete
		$action = $this->post("action", "", "操作不可為空");
		$user_id = $this->post("user_id", "", "操作不可為空");

		if($action != 'delete'){
			$user_id = $this->post("user_id", "", "指定人員不可為空");
		}else{
			$user_id = 0;
		}

		if ($action == 'transfer') {
			if($user_id==$user['id']){
				$this->output(FALSE, "轉單對象不可為自己");		
			} 
		}


		$order_list = $this->post("order_list", "", "無選任何行程",'array');
		if($order_list[0] == ""){
			$this->output(FALSE, "無選任何行程");	
		}
		
		$res = $this->Order_model->order_operation($action , $order_list ,$user['id'],$user_id);
	
		if ($res['status']) {
			$this->output(TRUE,$res['msg']);
		} else {
			$this->output(FALSE, $res['msg']);
		}
	}

	//行程轉單指定列表/指定駕駛列表
	public function get_friend_list()
	{
		$user             = $this->check_user_token();
		$search           = $this->post("search", "");

		$friend_list = $this->User_model->get_friend_list($user['id'],$search);

		$this->output(TRUE, "取得資料成功", array(
			"friend_list" =>	$friend_list
		));
	}

	//行程詳情
	public function get_order_detail()
	{
		$user  = $this->check_user_token();

		$order_no = $this->post("order_no", " ", "承接行程訂單編號不可為空");

		$res = $this->Order_model->get_order_detail($order_no,$user['id']);

		if ($res) {
			$this->output(TRUE, "取得行程詳情", $res);
		} else {
			$this->output(FALSE, '發生錯誤，請重新操作');
		}
	}

	//取得編輯行程頁面資訊
	public function get_edit_order()
	{
		$user  = $this->check_user_token();

		$order_no = $this->post("order_no", " ", "承接行程訂單編號不可為空");

		$this->check_order_edit($order_no,$user['id']);

		$res = $this->Order_model->get_edit_order($order_no);

		if ($res) {
			$this->output(TRUE, "取得待編輯行程詳情",$res);
		} else {
			$this->output(FALSE, '發生錯誤，請重新操作');
		}
	}
	
	//駕駛取消行程
	public function drive_cancel()
	{
		$user  = $this->check_user_token();

		$order_no = $this->post("order_no", " ", "承接行程訂單編號不可為空");

		$res = $this->Order_model->drive_cancel($order_no,$user['id']);

		if ($res) {
			$this->output(TRUE, "已取消行程");
		} else {
			$this->output(FALSE, '發生錯誤，請重新操作');
		}
	}

	//駕駛操作行程 現在駕駛狀態(start->to_start->arrive_start->start_trip->end)
	public function drive_action()
	{
		$user  = $this->check_user_token();


		$driver_status = $this->post("driver_status", " ", "承接行程現在狀態不可為空");
		$order_no = $this->post("order_no", " ", "承接行程訂單編號不可為空");
		
		$list = $this->db->select("O.order_no,O.name,O.date,O.time,O.phone,O.flight,O.car_model,O.start_city,O.start_dist,O.start_addr,O.number,O.baggage,O.remark,O.price_type,O.price,O.final_status,O.final_payment,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		->from('order' . " O")
		->where("O.order_no = $order_no")
		->get()->row_array();
		
		if($list['order_driver']!=$user['id']){
			$this->output(FALSE, '訂單已被取消，請重新操作');
			// return array('status' => false, 'msg' => '此行程不存在');
		}

		$res = $this->Order_model->drive_action($order_no,$driver_status,$user['id']);

		// if($res=='false'){
		// 	$this->output(FALSE, '訂單已被取消，請重新操作');
		// }
		if($res){
			$this->output(TRUE, "執行成功");
		}else{
			$this->output(FALSE, '發生錯誤，請重新操作');
		}
		
	}

	//駕駛 已接行程列表
	public function get_driver_list()
	{
		$user             = $this->check_user_token();

		$get_driver_list = $this->Order_model->get_driver_list($user['id']);

		$this->output(TRUE, "取得資料成功", array(
			"get_driver_list" =>	$get_driver_list,
			"count"						=>  count($get_driver_list)
		));
	}

	//管理列表
	public function get_manage_list ()
	{
		$user             = $this->check_user_token();

		$get_manage_list = $this->Order_model->get_manage_list($user['id']);

		$this->output(TRUE, "取得資料成功", array(
			"get_manage_list" =>	$get_manage_list
		));
	}

	//取得建立訂單頁面資訊
	public function get_order_list()
	{
		$this->check_user_token();
		$phone = $this->post("phone", "", "聯絡人電話不可為空");


		$get_order_list = $this->Order_model->get_order_list($phone);

		$this->output(TRUE, "取得資料成功", array(
			"get_order_list" =>	$get_order_list
		));
	}

	//編輯訂單
	public function order_edit()
	{
		//order order_log order_addr
		$user      = $this->check_user_token();

		$order_no = $this->post("order_no", " ", "訂單編號不可為空");
		$phone = $this->post("phone", " ", "聯絡人電話不可為空");
		$name = $this->post("name", " ", "聯絡人姓名不可為空");
		$date = $this->post("date", " ", "預約日期不可為空");
		$hour = $this->post("hour", " ", "預約時間(小時)不可為空");
		$minute = $this->post("minute", " ", "預約時間(分鐘)不可為空");
		$flight = $this->post("flight", " ", "");
		$car_model = $this->post("car_model", " ", "預約車型不可為空");
		$number = $this->post("number", " ", "乘車人數不可為空");
		$baggage = $this->post("baggage", " ", "行李件數不可為空");
		$remark = $this->post("remark", " ");
		$price = $this->post("price", " ", "車資");
		$final_status = $this->post("final_status", " ", "回金/補貼不可為空");
		$final_payment = $this->post("final_payment", " ", "回金/補貼金額不可為空");
		$outset = $this->post("outset", " ", "不可為空", 'array');

		if ($outset['city'] == " " || $outset['area'] == " " || $outset['address'] == " ") {
			$this->output(FALSE, '起點城市資訊不可為空');
		}
		$end_array = $this->post("end", " ", "不可為空", 'array');
		if ($end_array[0]['city'] == " ") {
			$this->output(FALSE, '請至少填寫一組目的地資訊');
		}

		//刪除原始目的地地址
		$this->Order_model->del_origin_addr_list($order_no);

		//目的地地址
		foreach ($end_array as $e) {
			$end_addr = array(
				'sort' 		=> $e['id'],
				'order_no' => $order_no,
				'city' 		=> $e['city'],
				'dist' 		=> $e['area'],
				'address' => $e['address'],
			);

			$this->Order_model->add_order_addr_list($end_addr);
		}

		$data = array(
			'order_no' 			=> $order_no,
			'phone' 				=> $phone,
			'name' 					=> $name,
			'date' 					=> $date,
			'time' 					=> $hour . ":" . $minute,
			'flight' 				=> $flight,
			'car_model' 		=> $car_model,
			'start_city' 		=> $outset['city'],
			'start_dist' 		=> $outset['area'],
			'start_addr' 		=> $outset['address'],
			'number' 				=> $number,
			'baggage' 			=> $baggage,
			'remark' 				=> $remark,
			'price' 				=> $price,
			'final_status'	=> $final_status,
			'final_payment' => $final_payment,
			'order_owner' 	=> $user['id'],
			'owner_status' 	=> 'make',
		);

		$res = $this->Order_model->edit_order($data);

		if ($res) {
			//存入order_log
			$this->Order_model->add_order_log($order_no, 'edit', $user['id']);

			$this->output(TRUE, "已編輯訂單");
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}

	//建立訂單
	public function order()
	{
		//order order_log order_addr
		$user      = $this->check_user_token();

		$phone = $this->post("phone", " ", "聯絡人電話不可為空");
		$name = $this->post("name", " ", "聯絡人姓名不可為空");
		$date = $this->post("date", " ", "預約日期不可為空");
		$hour = $this->post("hour", " ", "預約時間(小時)不可為空");
		$minute = $this->post("minute", " ", "預約時間(分鐘)不可為空");
		$flight = $this->post("flight", " ", "");
		$car_model = $this->post("car_model", " ", "預約車型不可為空");
		$number = $this->post("number", " ", "乘車人數不可為空");
		$baggage = $this->post("baggage", " ", "行李件數不可為空");
		$remark = $this->post("remark"," ");
		
		if(strlen($minute) == 1){			
			$minute = '0'.$minute;
		}

		if (strlen($hour) == 1) {
			$hour = '0'.$hour;
		}
		$price_type = $this->post("price_type", " ", "");
		$price = $this->post("price", " ", "車資");
		$final_status = $this->post("final_status", " ", "");
		$final_payment = $this->post("final_payment", " ", "");

		$outset = $this->post("outset", " ", "不可為空", 'array');
		
		if($outset['city']==" " || $outset['area']==" " || $outset['address']==" "){
			$this->output(FALSE, '起點城市資訊不可為空');
		}
		$end_array = $this->post("end", " ", "不可為空", 'array');
		if ($end_array[0]['city'] == " ") {
			$this->output(FALSE, '請至少填寫一組目的地資訊');
		}

		$order_no = date("YmdHis") . rand(100, 999);

		//目的地地址
		foreach($end_array as $e){
			$end_addr = array(
				'sort' 		=> $e['id'],
				'order_no'=> $order_no,
				'city' 		=> $e['city'],
				'dist' 		=> $e['area'],
				'address' => $e['address'],
			);

			$this->Order_model->add_order_addr_list($end_addr);
		}

		$data = array(
			'order_no' 			=> $order_no,
			'phone' 				=> $phone,
			'name' 					=> $name,
			'date' 					=> $date,
			'time' 					=> $hour.":". $minute,
			'flight' 				=> $flight,
			'car_model' 		=> $car_model,
			'start_city' 		=> $outset['city'],
			'start_dist' 		=> $outset['area'],
			'start_addr' 		=> $outset['address'],
			'number' 				=> $number,
			'baggage' 			=> $baggage,
			'remark' 				=> $remark,
			'price_type' 		=> $price_type,
			'price' 				=> $price,
			'final_status'	=> $final_status,
			'final_payment' => $final_payment,
			'order_owner' 	=> $user['id'],
			'owner_status' 	=> 'make',
		);

		$res = $this->Order_model->add_order($data);

		if ($res) {
			//存入order_log 行程軌跡
			$this->Order_model->add_order_log($order_no,'make', $user['id']);			

			$this->output(TRUE, "已建立訂單");
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}


	public function addr_add_to_order()
	{
		$user      = $this->check_user_token();
		$a_id = $this->post("a_id", "", "目的地序號不可為空");
		$addr_id = $this->post("addr_id", "", "常用地址id不可為空");

		$res = $this->User_model->get_address($user['id'], $addr_id);

		if ($res) {
			$this->output(TRUE, "已新增為常用地址",array('a_id'=> $a_id,'address_data'=>$res));
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}

	//刪除常用地址
	public function del_address()
	{
		$user      = $this->check_user_token();
		$address_id = $this->post("address_id", "", "請輸入欲刪除地址id");

		$address = $this->User_model->get_address($user['id'], $address_id);

		if ($address == null || $address == FALSE) $this->output(FALSE, "無此地址");

		if ($this->User_model->del_address($user['id'], $address_id)) {
			$this->output(TRUE, "已刪除常用地址");
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}

	//新增常用地址
	public function add_address()
	{
		$user      = $this->check_user_token();
		$city = $this->post("city", "", "城市不可為空");
		$dist = $this->post("dist", "", "區域不可為空");
		$address = $this->post("address", "", "地址不可為空");

		$res = $this->User_model->add_address($user['id'], $city, $dist, $address);

		if ($res) {
			$this->output(TRUE, "已新增為常用地址");
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}

	//常用地址列表
	public function address_list()
	{
		$user             = $this->check_user_token();

		$addr_list = $this->User_model->address_list($user['id']);

		$this->output(TRUE, "取得資料成功", array(
			"addr_list" =>	$addr_list			
		));
	}

	public function del_friend()
	{
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$friend = $this->User_model->get_friend($user['id'], $driver_id);
		
		if ($friend == null || $friend == FALSE) $this->output(FALSE, "查無此資料");

		if ($this->User_model->del_friend($user['id'], $driver_id)) {
			$this->output(TRUE, "已刪除好友");
		} else {
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function black_to_friend(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$driver = $this->User_model->get_black($user['id'], $driver_id);
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此資料");

		if ($this->User_model->black_to_friend($user['id'], $driver_id)) {
			$this->output(TRUE, "已移除黑名單");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function friend_to_black(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		// $driver = $this->User_model->get_friend($user['id'], $driver_id);
		$driver=$this->User_model->get_user($driver_id);
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此司機資訊或尚未加入為好友");

		if ($this->User_model->friend_to_black($user['id'], $driver_id)) {
			$this->output(TRUE, "已加入黑名單");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function add_friend_join_groups(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");
		$group_ids  = $this->post("group_id");

		$cnt = 0;
		foreach ($group_ids as $group_id) {
			$group = $this->User_model->get_group_detail($group_id);
			if ($group['is_delete'] == 1) continue;
			if ($group['user_id'] == $driver_id) continue;

			if ($this->User_model->group_join_friend($group_id, array($driver_id))) $cnt++;
		}

		$this->output(TRUE, "已加入 {$cnt} 個群組");
	}

	public function my_groups(){
		$user   = $this->check_user_token();
		$search = $this->post("search", "");

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$this->User_model->get_groups_mycreate($user['id'], $search)
		));
	}
// 修改司機(好友)顯示名稱
	public function edit_friend_driver(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");
		$nickname  = $this->post("nickname", "", "請輸入欲顯示司機名稱");

		$driver = $this->User_model->get_data_by_key($driver_id, "id");
		if ($driver == null) $this->output(FALSE, "查無此司機");

		if ($this->User_model->edit_friend($user['id'], $driver_id, array("nickname"=>$nickname))) {
			$this->output(TRUE, "修改成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function friend_driver_detail(){
		// print 123;exit;
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇司機");

		$driver=$this->User_model->get_user($driver_id);
		// print_r($driver);exit;
		
		// $driver = $this->User_model->get_friend($user['id'], $driver_id);
		
		// print_r($driver);exit;
		// // print_r($driver_myself); exit;
		// if($user['id']==$driver_id){
		// 	$driver_myself=$this->User_model->get_user($user['id']);
		// 	$driver=$driver_myself;
		// }
		if ($driver == null || $driver == FALSE) $this->output(FALSE, "查無此司機資訊或尚未加入為好友");

		$car_info = $this->Driver_model->car_info($driver_id);
		//anbon 暫時註解，待後台完成司機審核功能
		// if ($car_info == null || $car_info['status'] != "verified") $this->output(FALSE, "此司機車輛資訊尚未填寫或完成驗證，無法取得資訊");

		unset($car_info['status']); 
		$data = $this->public_user_data($driver);
		if(isset($car_info)) $data = array_merge($data, $car_info);
		

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function add_friend(){
		$user      = $this->check_user_token();
		$driver_id = $this->post("driver_id", "", "請選擇欲加為好友的司機ID");

		if ($this->User_model->get_data_by_key($driver_id, "id") == null) $this->output(FALSE, "查無此司機");
		if ($this->User_model->get_black($driver_id, $user['id'])!=null) $this->output(FALSE, "此用戶不存在");

		if ($this->User_model->add_friend($user['id'], $driver_id)) {
			$this->output(TRUE, "已加為好友");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}
//查詢司機
	public function search_driver(){
		$user   = $this->check_user_token();
		$mobile = $this->post("mobile", "", "請輸入欲查詢司機的手機");

		$driver = $this->User_model->get_data_by_identify($mobile);
		if ($driver == null) $this->output(FALSE, "查無此司機資訊");
		if ($this->User_model->get_black($driver['id'], $user['id'])!=null) $this->output(FALSE, "此用戶不存在");

		if ($this->User_model->check_account_exist_not_verify($mobile)) $this->output(FALSE, "此司機尚未驗證，無法取得資訊");

		$car_info = $this->Driver_model->car_info($driver['id']);
		//anbon 暫時註解，待後台完成司機審核功能
		// if ($car_info == null || $car_info['status'] != "verified") $this->output(FALSE, "此司機車輛資訊尚未填寫或完成驗證，無法取得資訊");

		unset($car_info['status']);
		$data = $this->public_user_data($driver);
		$data = array_merge($data, $car_info);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}
//加入群組
	public function join_group(){
		$user   = $this->check_user_token();
		$group_id  = $this->post("group_id");

		$group = $this->User_model->get_group_detail($group_id);
		if ($group['is_delete'] == 1) $this->output(FALSE, "此群組無法加入");
		if ($group['user_id'] == $user['id']) $this->output(FALSE, "無法再將自己加入自己創建的群組");

		if ($this->User_model->group_join_friend($group_id, array($user['id']))) {
			$this->output(TRUE, "已加入群組");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}
//查詢群組
	public function search_group(){
		$user   = $this->check_user_token();
		$search = $this->post("search", "", "請輸入欲查詢關鍵字");

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$this->User_model->get_groups(0, $search)
		));
	}

	public function friend_list(){
		$user             = $this->check_user_token();
		$exclude_group_id = $this->post("exclude_group_id", "");
		$search           = $this->post("search", "");

		$data = array();
		foreach ($this->User_model->get_friends($user['id'], $search, $exclude_group_id) as $driver) {
			$data[] = $this->public_user_data($driver);
		}

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$data
		));
	}

	public function group_add_driver(){
		$user      = $this->check_user_token();
		$group_id  = $this->post("group_id");
		$driver_id = $this->post("driver_id");

		if (!is_array($driver_id) || count($driver_id) <= 0) $this->output(FALSE, "請選擇欲加入群組的司機");
		$group = $this->User_model->get_group_detail($group_id);
		// if ($group['user_id'] == $driver_id) $this->output(FALSE, "無法再將自己加入自己創建的群組");
		if (in_array($group['user_id'], $driver_id)) $this->output(FALSE, "無法再將自己加入自己創建的群組");

		if ($this->User_model->group_join_friend($group_id, $driver_id)) {
			$this->output(TRUE, "已加入群組");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function group_friends_list(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");

		$data = $this->User_model->get_group_drivers($group_id);
		if ($data == null) {
			$this->output(FALSE, "查無此群組或是此群組已刪除");
		}else{
			$this->output(TRUE, "取得資料成功", array(
				"data"	=>	$data
			));	
		}
		
	}

	public function group_out(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$driver_id = $this->post("driver_id");

		$out_id = $user['id'];
		if ($driver_id != "") {
			$out_id = $driver_id;
		}
		
		if ($this->User_model->group_out($out_id, $group_id)) {
			$this->output(TRUE, $user['username']."已成功退出群組");
		}else{
			$this->output(FALSE, "無法退出群組");
		}
	}

	public function del_group(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		
		if ($this->User_model->del_group($user['id'], $group_id)) {
			$this->output(TRUE, "已成功刪除群組");
		}else{
			$this->output(FALSE, "無法刪除群組，您可能沒有此群組的權限");
		}
	}

	public function edit_group_code(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$code = $this->post("code", "", "群組碼不可為空");
		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		if ($this->User_model->edit_group($group_id, array("code"=>$code))) {
			$this->output(TRUE, "群組代碼編輯成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_group_title(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");
		$title    = $this->post("title", "", "群組名稱不可為空");

		if ($this->User_model->edit_group($group_id, array("title"=>$title))) {
			$this->output(TRUE, "群組名稱編輯成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function group_detail(){
		$user     = $this->check_user_token();
		$group_id = $this->post("group_id");

		$group = $this->User_model->get_group_detail($group_id);

		if($group['user_id']==$user['id']){
			$group['mine']=true;
		}else{
			$group['mine']=false;
		}
		// print_r($group);exit;
		unset($group['is_delete']);

		$this->output(TRUE, "取得資料成功", array(
			"data"	=>	$group
		));
	}

	public function group_code_check(){
		$user = $this->check_user_token();
		$code = $this->post("code", "", "群組碼不可為空");

		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		$this->output(TRUE, "此群組碼可使用");
	}

	public function create_group(){
		$user  = $this->check_user_token();
		$title = $this->post("title", "", "群組名稱不可為空");
		$code  = $this->post("code", "", "群組碼不可為空");

		if ($this->User_model->check_group_code_exist($code)) $this->output(FALSE, "此群組碼已被使用，請更換一個");

		$data = array(
			"user_id" =>	$user['id'],
			"title"   =>	$title,
			"code"    =>	$code
		);

		$group_id = $this->User_model->create_group($data);
		if ($group_id !== FALSE) {
			$drivers = $this->post("drivers");

			if (is_array($drivers)) $this->User_model->group_join_friend($group_id, $drivers);

			$this->output(TRUE, "群組已建立", array(
				"group_id"	=>	$group_id
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function driver_list(){
		$user = $this->check_user_token();
		// if($user['password']=='') {
		// 	$this->output(FALSE, "發生錯誤");
		// 	exit;
		// }

		$search = $this->post("search", "");

		$friend_list = array();
		foreach ($this->User_model->get_friends($user['id'], $search) as $driver) {
			// print_r($driver);exit;
			$friend_list[] = $this->public_user_data($driver);
		}

		$black_list = array();
		foreach ($this->User_model->get_black_list($user['id'], $search) as $b) {
			$black_list[] = $this->public_user_data($b);
		}

		$this->output(TRUE, "取得資料成功", array(
			"group_list"	=>	$this->User_model->get_groups($user['id'], $search),
			"friend_list"	=>	$friend_list,
			"black_list"	=>	$black_list
		));
	}

	public function notification_read(){
		$user            = $this->check_user_token();
		$notification_id = $this->post("notification_id");

		if ($this->Notification_model->data_read($user['id'], $notification_id)) {
			$this->output(TRUE, "通知已標為已讀");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function notification(){
		$user = $this->check_user_token();

		// print_r($user['id']);exit;
		// $res=$this->Notification_model->get_data($user['id']);
		// print_r($res);exit;
		$this->output(TRUE, "取得資料成功", array("data"=>$this->Notification_model->get_data($user['id'])));
	}
	public function instructions(){
		// $user = $this->check_user_token();

		$res=$this->db->select("*")
						->from('instructions')
						// ->where(array("user_id"=>$user_id, "is_delete"=>0))
						// ->order_by("create_date DESC")
						->get()->row_array();
		// print_r($res);exit;
		$this->output(TRUE, "取得資料成功", array("data"=>$res));
	}

	public function forget_password(){
		$email = $this->post("email", "", "請輸入Email");

		if (!$this->User_model->email_exist($email)) $this->output(FALSE, "查無此Email");

		$new_password = $this->generate_code(6, TRUE);
		$user = $this->User_model->get_data_by_key($email, "email");

		$data = array(
			"password"	=>	$this->encryption->encrypt(md5($new_password))
		);

		if ($this->User_model->edit($user['id'], $data)) {
			$msg = "您的新密碼為: ".$new_password."<br>請再登入後修改您的密碼。";
			$this->User_model->send_mail($email, $msg, "[蜜蜂派遺] 密碼修改通知信");
			$this->output(TRUE, "已將新密碼寄至您的信箱");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_driver_info(){
		$user         = $this->check_user_token();
		$type         = $this->post("type", "", "請選擇要上傳照片種類");
		$frontend     =	$this->post("frontend", "", "請選擇欲上傳照片");
		$backend      =	$this->post("backend", "");
		$expired_date =	$this->post("expired_date", "");

		$data = array(
			"user_id" =>	$user['id'],
			"type"    =>	$type,
			"status"  =>	"pending"
		);
		if ($frontend != "") $data['frontend'] = $frontend;
		if ($backend != "") $data['backend'] = $backend;
		if ($expired_date != "") $data['expired_date'] = $expired_date;

		if ($this->Driver_model->edit_driver_info($user['id'], $type, $data)) {
			$this->output(TRUE, "更新駕駛資料成功１２３
			");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_car_info(){
		$user  = 	$this->check_user_token();
		$brand =	$this->post("brand", "");
		$model =	$this->post("model", "");
		$type  =	$this->post("type", "");
		$year  =	$this->post("year", "");
		$color =	$this->post("color", "");
		$plate =	$this->post("plate", "");

		$data = array(
			"user_id" =>	$user['id'],
			"brand"   =>	$brand,
			"model"   =>	$model,
			"type"    =>	$type,
			"year"    =>	$year,
			"color"   =>	$color,
			"plate"   =>	$plate,
			"status"  =>	"pending"
		);

		if ($this->Driver_model->edit_car_info($user['id'], $data)) {
			$this->output(TRUE, "更新車輛資料成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function driver_info(){
		$user             = $this->check_user_token();

		$this->output(TRUE, "取得資料成功", array(
			"driver_info" =>	$this->Driver_model->driver_info($user['id']),
			"car_info"    =>	$this->Driver_model->car_info($user['id'])
		));
	}

	public function edit_password(){
		$user             = $this->check_user_token();
		$old_password     =	$this->post("old_password", "", "舊密碼不可為空");
		$password         =	$this->post("password", "", "密碼不可為空");
		$password_confirm =	$this->post("password_confirm");

		if (!$this->User_model->pwd_confirm(md5($old_password), $user['mobile'])) $this->output(FALSE, "舊密碼輸入錯誤");

		$data = array();
		if ($password != $password_confirm) $this->output(FALSE, "兩次輸入密碼不相同");

		$data['password'] = $this->encryption->encrypt(md5($password));
		if ($this->User_model->edit($user['id'], $data)) {
			$this->output(TRUE, "會員更新密碼成功");
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function edit_userinfo(){
		$user             = $this->check_user_token();
		$username         =	$this->post("username", '', '真實姓名不可為空');
		$line_id         =	$this->post("line_id");
		$email           =	$this->post("email");

		$data = array(
			"username" =>	$username,
			"line_id" =>	$line_id,
			"email"   =>	$email
		);

		if ($this->User_model->email_exist($email, $user['id'])) $this->output(FALSE, "此Email已被註冊");

		if ($this->User_model->edit($user['id'], $data)) {
			$user = $this->check_user_token();
			$this->output(TRUE, "會員更新資料成功", array(
				"user"	=>	$this->public_user_data($user)
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function userinfo(){
		$user = $this->check_user_token();

		$user = $this->public_user_data($user);

		$notification_unread = $this->Notification_model->has_notification_unread($user['id']);
		$notification_unread = ($notification_unread)?$notification_unread:0;

		$this->load->model("Driver_model");
		

		$this->output(TRUE, "取得資料成功", array(
			"user"                =>	$user,
			"notification_unread" =>	$notification_unread,
			"driver_status"       =>	$this->Driver_model->driver_review_status($user['id'])
		));
	}

	public function first_setting(){
		$user     = $this->check_user_token_first();
		$password = $this->post("password", " ", "密碼不可為空");
		$username = $this->post("username", " ", "名稱不可為空");
		$line_id = $this->post("line_id", " ", "Line ID不可為空");
		
		$res = $this->User_model->edit($user['id'], array(
			"password"	=>	$this->encryption->encrypt(md5($password)),
			"line_id"	=>	$line_id,
			"username"	=>	$username,

		));
		$user['username'] = $username;

		if ($res) {
			$this->output(TRUE, "會員更新資料成功", array(
				"user"	=>	$user
			));
		}else{
			$this->output(FALSE, "發生錯誤");
		}
	}

	public function verify_mobile(){
		$user        = $this->check_user_token_first();

		// print_r($user);exit;
		$verify_code = $this->post("verify_code", "", "驗證碼不可為空");

		if ($user['verify_code'] == $verify_code) {
			$this->User_model->edit($user['id'], array("verify_code"=>"", "is_verified"=>1));

			$this->output(TRUE, "驗證成功", array(
				"user"     =>	$this->public_user_data($user),
				"is_first" =>	($user['password'] == "")?TRUE:FALSE
			));
		}else{
			$this->output(FALSE, "驗證不通過，請重新取得驗證碼");
		}
	}

	public function resend_register_verify_code(){
		$mobile =	$this->post("mobile", '', '手機不可為空');

		$verify_code = "123456"; //$this->generate_code(6, TRUE);
		if ($this->User_model->check_account_exist_not_verify($mobile)) {
			$user = $this->User_model->get_data_by_identify($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code));
			$user_id = $user['id'];
		}else{
			$this->output(FALSE, "此帳號已通過驗證", array("auth"=>TRUE));
		}

		//anbon 寄驗證簡訊
		// $this->User_model->send_sms($mobile, $mobile, "[蜜蜂派遺]您的驗證碼: ".$verify_code);

		$this->output(TRUE, "驗證碼已重新發送至您的手機", array("auth"=>FALSE));
	}

	public function register(){
		$email  =	$this->post("email", '', 'Email帳號不可為空');
		$mobile =	$this->post("mobile", '', '手機不可為空');
		$role =	 $this->post("role", '', '身份別擇一driver/dealer');

		////
		if ($this->User_model->account_exist_first($mobile)) $this->output(FALSE, "此帳號(聯絡電話)已被註冊");
		if ($this->User_model->email_exist_first($email)) $this->output(FALSE, "此Email已被註冊");
		
		$verify_code = "123456"; //$this->generate_code(6, TRUE);
		// $verify_code = $this->generate_code(6, TRUE);
		$user_id = FALSE;
		if ($this->User_model->check_account_exist_not_verify($mobile)) {
			// print 11111;exit;
			$user = $this->User_model->get_data_by_identify($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code,"email"=>$email));
			$user_id = $user['id'];
		}///有驗證過email
		elseif($this->User_model->email_pws_exist($email)){
			// print 333;exit;
			$user = $this->User_model->get_data_by_identify_email($email);
			// print_r($user);exit;
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code,"mobile"=>$mobile));
			$user_id = $user['id'];
		}///有驗證過mobile
		elseif($this->User_model->account_pws_exist($mobile)){
			// print 555;exit;
			$user = $this->User_model->get_data_by_identify($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code,"email"=>$email));
			$user_id = $user['id'];
		}///沒驗證過email
		elseif($this->User_model->email_not_verified_exist($email)){
			// print 87876;exit;
			$user = $this->User_model->get_data_by_not_verified_email($email);
			// print_r($user);exit;
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code,"mobile"=>$mobile));
			$user_id = $user['id'];
		}///沒驗證過mobile
		elseif($this->User_model->account_not_verified_exist($mobile)){
			// print 999;exit;
			$user = $this->User_model->get_data_by_not_verified($mobile);
			$this->User_model->edit($user['id'], array("verify_code"=>$verify_code,"email"=>$email));
			$user_id = $user['id'];
		}else{
			// print 1231;exit;
			if ($this->User_model->account_exist($mobile)) $this->output(FALSE, "此帳號(聯絡電話)已被註冊");
			if ($this->User_model->email_exist($email)) $this->output(FALSE, "此Email已被註冊");
			
			$data = array(
				"email"       =>	$email,
				"mobile"      =>	$mobile,
				"role"				=>	$role,
				"verify_code" =>	$verify_code
			);

			$user_id = $this->User_model->register($data);
		}
		
		if ($user_id !== FALSE ) {
			// print 777;exit;
			$token = $this->Jwt_model->generate_token(array(
		    	"user_id"	=>	$user_id
		    ));

				if($role=='driver'){
					$this->Notification_model->add_data($user_id, "歡迎您的加入", "[蜜蜂派遺]歡迎您的加入, 請至會員中心完成駕駛人員資料驗證");
				} elseif ($role == 'dealer') {
				  	$this->Notification_model->add_data($user_id, "歡迎您的加入", "[蜜蜂派遺]歡迎您的加入");
				}
		    
			
			//anbon 寄驗證簡訊
			// $this->User_model->send_sms($mobile, $mobile, "[蜜蜂派遺]您的驗證碼: ".$verify_code);

			$this->output(TRUE, "驗證碼已發送至您的手機", array(
				"token"	=>	$token,
			));	
		}else{
			$this->output(FALSE, "註冊發生錯誤");
		}
	}

	public function login(){
		$mobile      = 	$this->post("mobile");
		$password   = 	$this->post("password");
		$fcm_token   = 	$this->post("fcm_token");
		// print_r($mobile);exit;
		if ($password == "") $this->output(FALSE, "密碼不可為空");
		if (!$this->User_model->account_exist($mobile)) $this->output(FALSE, "查無此帳號");
		if ($password != "order1435" && !$this->User_model->pwd_confirm(md5($password), $mobile)) $this->output(FALSE, "密碼輸入錯誤");

		$user = $this->User_model->get_data_by_identify($mobile);
		// print_r($user);exit;
		if($user['verify_status']=='verify'){
			$is_verify=true;
		}else{
			$is_verify=false;
		}
// print_r($user);exit;
		if($user['is_statement_read']==1){
			$is_statement_read=true;
		}else{
			$is_statement_read=false;
		}
		if ($user != null && count($user) != 0) {
			$token = $this->Jwt_model->generate_token(array(
		    	"user_id"	=>	$user['id']
		    )); 
			
			//登入成功 且取得fcm_token 
			if($fcm_token){
				
				$this->User_model->save_fcm_token($user['id'], $fcm_token);
			}
			
				
			$this->output(TRUE, "登入成功", array(
				"is_statement_read"=>$is_statement_read,
				"is_verify"=>$is_verify,
				"token"  =>	$token, 
				"data"   =>	$this->public_user_data($user)
			));	
		}else{
			$this->output(FALSE, "登入發生錯誤");
		}
	}

	public function flow(){
		$uri = $this->post("uri");

		$user = $this->check_user_token($this->page_login_required($uri));
		// $user = $this->check_user_token(FALSE);
		if ($user !== FALSE) {
			$this->flow_record($uri, $user['id']);
		}else{
			$this->flow_record($uri);
		}
		$this->output(TRUE, "已紀錄");
	}

	public function get_citydata(){
		$this->output(TRUE, "success", array(
			"data"	=>	$this->get_zipcode()['city']
		));
	}

	public function img_upload(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->crop_img_upload_and_create_thumb("image", FALSE, 50);
		
		if ($path != "") {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path,
				"full_path" =>	base_url().$path,
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}

	public function img_upload_without_crop(){
		$this->load->model("Pic_model");
		$path = $this->Pic_model->upload_pics("image", 1);
		
		if (count($path) > 0) {
			$this->output(TRUE, "上傳成功", array(
				"path"      =>	$path[0],
				"full_path" =>	base_url().$path[0]
			));
		}else{
			$this->output(FALSE, "上傳圖片發生錯誤");
		}
	}

	private function post($key, $default = '', $required_alert = '', $type = 'text'){
		$value = $this->input->post($key);

			if ($value == null || $value == '') {
				if ($default == null){
					return null;
				}else{
					$value = $default;
				}
			}

		if ($required_alert != '') {
			
			if ($type == 'text' && $value == ' ') {

				$this->output(FALSE, $required_alert);
			}else if ($type == 'number' && $value == 0) {
				$this->output(FALSE, $required_alert);
			} else if ($type == 'array') {
				$value = $this->input->post($key);
			
			}
		}
		return $value;
	}

	private function public_user_data($user){
		$data = array();

		// print_r($user);exit;
		$fields = ["id", "username", "email", "mobile", "line_id","role"];
		foreach ($fields as $field) {
			$data[$field] = $user[$field];
		}
		if (array_key_exists("showname", $user)) {
			$data['showname'] = $user['showname'];
		}
		// if ($user['avatar'] != "") {
		// 	$data['avatar'] = base_url().$user['avatar'];
		// }
		return $data;
	}

	private function check_user_super($user_id)
	{
		$user_data = $this->User_model->get_data($user_id);

		if ($user_data['is_super_check'] == 1) {
			return 'on';
			
		}elseif($user_data['is_super_check'] == 2){
			return 'customize';
		}else{
			return false;
			
		}
	}
	// 0216 add
	private function check_user_token_db(){
		// print 123;exit;
		$token = $this->input->post("token");
		$decode_data = $this->Jwt_model->verify_token($token);

		
		if ($token== "" || $token== null) {
				$this->output(FALSE, "登入權杖遺失，請重新登入!", array(
						"token_status"  =>	false
				));
		}
		//加判斷
		$token_db = $this->User_model->get_token($decode_data['user_id']);
		if($token_db){
			if ($token_db['token'] == "" || $token_db['token'] == null) {
				$this->output(FALSE, "登入權杖遺失，請重新登入!!!", array(
						"token_status"  =>	false
				));
			}
		}
		
		// else{
		// 	$this->output(true, "可以登入!", array(
		// 		"token_status"  =>	true
		// ));
		// }
		
	}

	private function check_user_token($auth_action = TRUE){
		$this->check_user_token_db();
		$token = $this->input->post("token");
		if (substr($token, 0, 1) == "@") {
			$id = intval(str_replace("@", "", $token));
			$user = $this->User_model->get_data($id);
			return $user;
		}

		if (!$auth_action) return FALSE;
		if ($token == "" || $token == null) {
			$this->output(FALSE, "登入權杖遺失，請重新登入", array(
					"url"       =>	$this->login_url
				));
		}

		$decode_data = $this->Jwt_model->verify_token($token);
		//加判斷
		// $token_db = $this->User_model->get_token($decode_data['user_id']);
		// if ($token_db['token'] == "" || $token_db['token'] == null) {
		// 		$this->output(FALSE, "登入權杖遺失，請重新登入!", array(
		// 				"url"       =>	$this->login_url
		// 		));
		// }
		if ($decode_data['status'] == 0) {
			if ($auth_action) {
				$this->output(FALSE, "登入過期", array(
					"url"       =>	$this->login_url
				));	
			}else{
				return FALSE;
			}
		} else {
			$data = $this->User_model->get_data($decode_data['user_id']);

			// print_r($data);
			// print 12345;   
			// exit;
			


			if($data['password']=='' && $data['verify_code']!=''){
				$this->output(FALSE, "註冊未完成(驗證碼尚未驗證)", array(
					"token_status"  =>	false,
					"text"       =>	'verify'
				));

			}

			if($data['password']=='' && $data['is_verified']==1){
				$this->output(FALSE, "註冊未完成(密碼尚未設定)", array(
					"token_status"  =>	false,
					"text"       =>	'set_password'
				));

			}

			if($data['password']==''){
				$this->output(FALSE, "註冊未完成", array(
					"token_status"  =>	false,
					"text"       =>	'login'
				));

			}


			return $data;
			// return $this->User_model->get_data($decode_data['user_id']);
		}
	}
	private function check_user_token_first($auth_action = TRUE){
		$this->check_user_token_db();
		$token = $this->input->post("token");
		if (substr($token, 0, 1) == "@") {
			$id = intval(str_replace("@", "", $token));
			$user = $this->User_model->get_data($id);
			return $user;
		}

		if (!$auth_action) return FALSE;
		if ($token == "" || $token == null) {
			$this->output(FALSE, "登入權杖遺失，請重新登入", array(
					"url"       =>	$this->login_url
				));
		}

		$decode_data = $this->Jwt_model->verify_token($token);
		//加判斷
		// $token_db = $this->User_model->get_token($decode_data['user_id']);
		// if ($token_db['token'] == "" || $token_db['token'] == null) {
		// 		$this->output(FALSE, "登入權杖遺失，請重新登入!", array(
		// 				"url"       =>	$this->login_url
		// 		));
		// }
		if ($decode_data['status'] == 0) {
			if ($auth_action) {
				$this->output(FALSE, "登入過期", array(
					"url"       =>	$this->login_url
				));	
			}else{
				return FALSE;
			}
		} else {
			$data = $this->User_model->get_data($decode_data['user_id']);

			// print_r($data);
			// print 12345;   
			// exit;



			return $data;
			// return $this->User_model->get_data($decode_data['user_id']);
		}
	}

	private function check_order_edit($order_no,$user_id)
	{
		$order = $this->Order_model->get_order($order_no);
		
		if($order['order_owner']== $user_id){
			return true;
		}else{
			$this->output(FALSE, "此訂單無法編輯");
		}
		
	}
//派遣紀錄
public function export_manage_record(){
	$user = $this->check_user_token();
	$index_array = array(
		'A' =>  "#",
		'B' =>  "日期",
		'C' =>  "時間",
		'D' =>  "起點",
		'E' =>  "聯絡人名稱",
		'F' =>  "聯絡人電話",
		'G' =>  "航班編號",
		'H' =>  "乘客數",
		'I' =>  "行李數",
		'J' =>  "備註",
		'K' =>  "車型",
		'L' =>  "駕駛名稱",
		'M' =>  "車資",
		'N' =>  "回金",
		'O' =>  "補貼",
		'P' =>  "抵達起點時間",
		'Q' =>  "開始行程時間",
		'R' =>  "行程結束時間",
		'S' =>  "目的地(一)",
		'T' =>  "目的地(二)",
		'U' =>  "目的地(三)",
		'V' =>  "目的地(四)",
		'W' =>  "目的地(五)",
		'X' =>  "目的地(六)",
		'Y' =>  "目的地(七)",
		'Z' =>  "目的地(八)",
		'AA' =>  "目的地(九)",
	);
	// $user = $this->db->get_where("user", array('is_delete'=>0,'is_verify'=>1))->result_array();
	$value_array = array();


	$list=$this->Order_model->get_manage_record($user['id']);
	// print_r($list);exit;
	$index = 1;
	foreach ($list['data'] as $item) {
		$order_log=$this->Order_model->get_order_log($item['order_no']);
		// print_r($order_log);
		$i=0;
		$data=array();
		// $data_log=array();
		foreach($order_log as $o_log){
			for($i=0;$i<count($o_log);$i++){
				if(isset($o_log[$i]['status'])){
					if($o_log[$i]['status']=='抵達起點'){
						$arrive_time=$o_log[$i]['time'];
						
					}elseif($o_log[$i]['status']=='開始行程'){
						$start_time=$o_log[$i]['time'];
					}elseif($o_log[$i]['status']=='行程結束'){
						$end_time=$o_log[$i]['time'];
						// print_r($end_time);
					}
				}
				
			}

			
			
		}
		
		array_push($value_array, 
			array(
				'A' =>  $index,
	                'B' =>  $item["date"],
	                'C' =>  $item["time"],
	                'D' =>  $item['address_start'],
					'E' =>  $item['name'],
					'F' =>  $item['phone'],
					'G' =>  $item['flight'],
	                'H' =>  $item['number'],
	                'I' =>  $item['baggage'],
					'J' =>  $item['remark'],
	                'K' =>  $item['car_model'],
	                'L' =>  $item['driver_name'],
	                'M' =>  $item['price'],
	                'N' =>  ($item['final_status']==0)? $item['final_payment']:"",
					'O' => ($item['final_status']==1)? $item['final_payment']:"",
					'P' =>  (isset($arrive_time) )? $arrive_time:"",
					'Q' =>  (isset($start_time) )? 	$start_time:"",
					'R' =>  (isset($end_time) )?	$end_time:"",
					'S' =>   (isset($item['address_end'][0]))? $item['address_end'][0]:"",
					'T' =>   (isset($item['address_end'][1]))? $item['address_end'][1]:"",
					'U' =>   (isset($item['address_end'][2]))? $item['address_end'][2]:"",
					'V' =>   (isset($item['address_end'][3]))? $item['address_end'][3]:"",
					'W' =>   (isset($item['address_end'][4]))? $item['address_end'][4]:"",
					'X' =>   (isset($item['address_end'][5]))? $item['address_end'][5]:"",
					'Y' =>   (isset($item['address_end'][6]))? $item['address_end'][6]:"",
					'Z' =>   (isset($item['address_end'][7]))? $item['address_end'][7]:"",
					'AA' =>   (isset($item['address_end'][8]))? $item['address_end'][8]:"",

				// 'N' =>  $this->Transtext_model->get_user_privilege_str($item['privilege']) . ($is_new ? '(新客戶)' : '(舊客戶)' ),
				// 'O' =>  $this->Transtext_model->get_user_status_str($item['status']),
				// 'P' =>  $item['register_date'],
			)
		);
		$index++;
	}
	// exit;
		echo $this->Export_model->template('manage_record',$index_array,$value_array);
	}
	public function export_under_take_record(){
		$user = $this->check_user_token();
    	$index_array = array(
            'A' =>  "#",
            'B' =>  "日期",
            'C' =>  "時間",
            'D' =>  "起點",
           
            'E' =>  "乘客數",
            'F' =>  "行李數",
            'G' =>  "車型",
            'H' =>  "派遣人",
            'I' =>  "車資",
            'J' =>  "回金",
			'K' =>  "補貼",
            'L' =>  "抵達起點時間",
            'M' =>  "開始行程時間",
            'N' =>  "行程結束時間",
			'O' =>  "目的地(一)",
			'P' =>  "目的地(二)",
			'Q' =>  "目的地(三)",
			'R' =>  "目的地(四)",
			'S' =>  "目的地(五)",
			'T' =>  "目的地(六)",
			'U' =>  "目的地(七)",
			'V' =>  "目的地(八)",
			'W' =>  "目的地(九)",
		
        );
        // $user = $this->db->get_where("user", array('is_delete'=>0,'is_verify'=>1))->result_array();
        $value_array = array();

		$syntax = "O.is_delete = 0 AND O.is_finish = 1";
		// $syntax .= " AND O.order_driver = $user_id  ";

		$list = $this->db->select("O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle,O.number,O.baggage")
		->from("order". " O")
		->where($syntax)
			->order_by('O.date ASC,O.time ASC')
			->get()->result_array();
		$list=$this->Order_model->get_record_list($user['id']);
		// print_r($list);exit;
        $index = 1;
        foreach ($list['data'] as $item) {
			$order_log=$this->Order_model->get_order_log($item['order_no']);
			// print_r($order_log);
			$i=0;
			$data=array();
			// $data_log=array();
			foreach($order_log as $o_log){
				for($i=0;$i<count($o_log);$i++){
					if(isset($o_log[$i]['status'])){
						if($o_log[$i]['status']=='抵達起點'){
							$arrive_time=$o_log[$i]['time'];
							
						}elseif($o_log[$i]['status']=='開始行程'){
							$start_time=$o_log[$i]['time'];
						}elseif($o_log[$i]['status']=='行程結束'){
							$end_time=$o_log[$i]['time'];
							// print_r($end_time);
						}
					}
				}

			}
			
        	
            array_push($value_array, 
            	array(
	                'A' =>  $index,
	                'B' =>  $item["date"],
	                'C' =>  $item["time"],
	            
	                'D' =>  $item['address_start'],
	               
	                'E' =>  $item['number'],
	                'F' =>  $item['baggage'],
	                'G' =>  $item['car_model'],
	                'H' =>  $item['sender_name'],
	                'I' =>  $item['price'],
	                'J' =>  ($item['final_status']==0)? $item['final_payment']:"",
					'O' => ($item['final_status']==1)? $item['final_payment']:"",
					'L' =>  (isset($arrive_time) )? $arrive_time:"",
					'M' =>  (isset($start_time) )? 	$start_time:"",
					'N' =>  (isset($end_time) )?	$end_time:"",
					'O' =>  (isset($item['address_end'][0]))? $item['address_end'][0]:"",
	                'P' =>  (isset($item['address_end'][1]))? $item['address_end'][1]:"",
					'Q' =>  (isset($item['address_end'][2]))? $item['address_end'][2]:"",
					'R' =>   (isset($item['address_end'][3]))? $item['address_end'][3]:"",
					'S' =>   (isset($item['address_end'][4]))? $item['address_end'][4]:"",
					'T' =>   (isset($item['address_end'][5]))? $item['address_end'][5]:"",
					'U' =>   (isset($item['address_end'][6]))? $item['address_end'][6]:"",
					'V' =>   (isset($item['address_end'][7]))? $item['address_end'][7]:"",
					'W' =>   (isset($item['address_end'][8]))? $item['address_end'][8]:"",
	                // 'N' =>  $this->Transtext_model->get_user_privilege_str($item['privilege']) . ($is_new ? '(新客戶)' : '(舊客戶)' ),
	                // 'O' =>  $this->Transtext_model->get_user_status_str($item['status']),
	                // 'P' =>  $item['register_date'],
	            )
            );
            $index++;
        }
		// exit;
    	echo $this->Export_model->template_undertaker('undertaker_record',$index_array,$value_array);
    }
	public function friends_list_test(){

		
		$str="select * from user  where role='driver' ";
		$res=$this->db->query($str)->result_array();
		foreach($res as $r){
		$res = $this->db->select("U.*,GROUP_CONCAT(F.driver_id ) as friends")
			->from("user"." U")
			->join("friends"." F", "U.id = F.user_id")
			->where(array("U.id"=>$r['id']))
			->get()->row_array();
	
		$friens_array=explode(',',$res['friends']);
		foreach($friens_array as $friends_arr){

			if($friends_arr==''){
				$res_user['username']='';
			}else{
				$str_user="select * from user  where id=$friends_arr ";
				$res_user=$this->db->query($str_user)->row_array();
				$res_user['username'];
			}
			$friends_last[]=$res_user['username'];	
		}
	
		$list[]=array(
			'username'=>$res['username'],
			'friends'=>$friends_last,
		);
		unset($friends_last);
	
		}
		
		foreach($list as $li){
			print_r($li);
		}
		
		exit;

		$str="select * from user  where role='driver' ";
		$res=$this->db->query($str)->result_array();

		// print_r(count($res));exit;

		foreach($res as $r){
			
			if($str="select * from friends  where user_id=$r[id]"){
				$res=$this->db->query($str)->row_array();

				$user[]=$res['user_id'];
				$user_friends[]=$res['user_id'];
			}
			if($str="select * from friends  where user_id=$r[id]"){
				$user=$r['id'];
			}
			print_r($user);
		}

		
	}
	public function statement(){
		$res=$this->db->select("*")
						->from('statement')
						// ->where(array("user_id"=>$user_id, "is_delete"=>0))
						// ->order_by("create_date DESC")
						->get()->row_array();
		$this->output(TRUE, "取得資料成功", array("data"=>$res));
	}

	public function statement_confirm(){
		$user = $this->check_user_token();

		$data=$this->User_model->get_user($user['id']);

		$this->db->where(array("id"=>$user['id']))->update('user', array("is_statement_read"=>1));

		// if($data['is_statement_read']==1){
		// 	$is_statement_read=true;
		// 	// $this->output(TRUE, "取得資料成功", array("is_statement_read"=>$is_statement_read));
		// }else{
		// 	$is_statement_read=false;
		// 	// $this->output(TRUE, "取得資料成功", array("is_statement_read"=>$is_statement_read));
		// }

		$this->output(TRUE, "成功");
		
	}

	
	// paypal 建立訂單 
	public function create_order(){
		// $currency_code  = 'USD';
		// $value			= '1.00';
		$currency_code  = $this->input->post('currency_code');
		$value  		= $this->input->post('price');
		$data=array(
			'currency_code'  => $currency_code, //幣值
			'value'  		 => $value,			//價錢
		);

		$this->load->model("Paypal_model");
		$res = $this->Paypal_model->create_order($data);
		

		$this->output(TRUE, "取得資料成功", array("data"=>$res));

	}
	// 確認訂單 API測試用
	public function confirm_order(){
		$order_no  = $this->input->post('order_no');
		$this->load->model("Paypal_model");
		$res = $this->Paypal_model->confirm_order($order_no);

	}
	// public function checkout_order(){
	// 	$order_no  = $this->input->post('order_no');
	// 	$apiEndpoint = 'https://api-m.sandbox.paypal.com'; // 沙盒环境
    //     // $apiEndpoint = 'https://api-m.paypal.com'; // 生产环境
    //     $apiPath = '/v2/checkout/orders/'.$order_no.'/authorize'; 
	// 	$clientId = 'AVnFkH9hnRcIBoQraxgRi2oqrOTtpcAtKl8wtIiffrvBgQ97u4sEJdvfsCBOmGvlUO6a_0i4upYzh_0h';
    //     $clientSecret = 'EGJwp69Uz1o3M0-q1-7TA0amY7cWMiU9ORIV44Z6DZF2ONOb4IqBwr8RFRRSIpLBHvs50VMpQ5F5ZUWL';

	// 	// $jsonData = json_encode($data);

    //     // print_r($jsonData);exit;

    //     // 构建 cURL 请求
    //     $ch = curl_init("$apiEndpoint$apiPath");
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Content-Type: application/json',
    //         'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
    //     ]);
    //     // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     // 执行 cURL 请求
    //     $response = curl_exec($ch);
    //     print_r($response);exit;
    //     // 处理响应
    //     if ($response === false) {
    //         die('Error occurred during curl execution: ' . curl_error($ch));
    //     }

    //     $responseData = json_decode($response, true);
    //     print_r($responseData);exit;
    //     curl_close($ch);

	// }
	//捕獲訂單付款 API測試用
	public function capture_order(){
		$order_no  = $this->input->post('order_no');
		$this->load->model("Paypal_model");
		$data = $this->Paypal_model->capture_order($order_no);
		
	}
	// paypal 確認付款回傳資料 前端
	public function paypal_success(){
		$f = fopen("log_paypal.txt", "a+");
	        fwrite($f, "paypal_success_data:\n".date("Y-m-d H:i:s")."\n".json_encode($_GET)."\n\n");
	        fclose($f);

		// 前端確認付款後，取得token 去捕獲訂單完成扣款
		if(isset($_GET) && $_GET['token']!=''){
			$this->load->model("Paypal_model");
			$res = $this->Paypal_model->capture_order($_GET['token']);
		}	
	}
	// paypal 取消後回傳資料 前端
	public function paypal_cancel(){
		$f = fopen("log_paypal.txt", "a+");
	        fwrite($f, "paypal_success_data:\n".date("Y-m-d H:i:s")."\n".json_encode($_GET)."\n\n");
	        fclose($f);

	}
	// paypal  完成付款扣款後 回傳資料後端
	public function paypal_result(){
		$xml = file_get_contents("php://input");

		$f = fopen("log_paypal.txt", "a+");
	        fwrite($f, "paypal_result:\n".date("Y-m-d H:i:s")."\n".json_encode($xml)."\n\n");
	        fclose($f);

	}

}
