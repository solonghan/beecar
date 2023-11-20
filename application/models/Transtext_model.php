<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Transtext_model extends CI_Model {
	
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function get_boolen_str($v=FALSE){
		switch ($v) {
			case 1:
				return "是";
				break;
			case 0:
				return "否";
				break;
			case TRUE:
				return "是";
				break;
			case FALSE:
				return "否";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_user_gender_str($v=FALSE){
		switch ($v) {
			case 'male':
				return "男";
				break;
			case 'female':
				return "女";
				break;
			case 'other':
				return "其他";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_user_status_str($v=FALSE){
		switch ($v) {
			case 'normal':
				return "正常";
				break;
			case 'block':
				return "封鎖";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_user_register_str($v=FALSE){
		switch ($v) {
			case 'facebook':
				return '<span class="label label-primary">FB登入</span>';
				break;
			case 'google':
				return '<span class="label label-warning">Google登入</span>';
				break;
			case 'normal':
				return '<span class="label label-success">電話登入</span>';
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_user_privilege_str($v=FALSE){
		switch ($v) {
			case 'user':
				return "會員";
				break;
			case 'designer':
				return "設計師";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_activity_type_str($v=FALSE){
		switch ($v) {
			case 'charity':
				return "公益";
				break;
			case 'event':
				return "報名";
				break;
			case 'gift':
				return "領取";
				break;
			case 'info':
				return "資訊";
				break;
			case 'web':
				return "網站直連";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_activity_status_str($v=FALSE){
		switch ($v) {
			case 'open':
				return "啟用";
				break;
			case 'close':
				return "不啟用";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_apply_status_str($v=FALSE,$activity_type=FALSE){
		switch ($v) {
			case 'normal':
				if($activity_type=="event") return "尚未報到";
				if($activity_type=="gift") return "尚未領取";
				break;
			case 'success':
				if($activity_type=="event") return "已報到";
				if($activity_type=="gift") return "已領取";
				break;
			case 'cancel':
				return "已取消";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_contact_form_status_str($v=FALSE){
		switch ($v) {
			case 'new':
				return "未處理";
				break;
			case 'processed':
				return "已處理";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_contact_form_contact_time_array($v=FALSE){
		$time_array = explode(",", $v);
		$time = array();
		foreach ($time_array as $key => $item) {
			switch ($item) {
				case 'night':
					$item_str = "晚上";
					break;
				case 'am':
					$item_str = "上午";
					break;
				case 'pm':
					$item_str = "下午";
					break;
				default:
					$item_str = "無";
					break;
			}
			array_push($time, $item_str);
		}
		return $time;
	}

	public function get_contact_form_contact_time_str($v=FALSE){
		$array = $this->get_contact_form_contact_time_array($v);
		return implode(',', $array);
	}

	public function get_recommend_form_type_str($v=FALSE){
		switch ($v) {
			case 'order':
				return "歐德";
				break;
			case 'uwood':
				return "優渥實木";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_recommend_form_status_str($v=FALSE){
		switch ($v) {
			case 'new':
				return "審核中";
				break;
			case 'process':
				return "服務中";
				break;
			case 'success':
				return "已簽約";
				break;
			case 'fail':
				return "未成立";
				break;
			case 'close':
				return "已撥點";
				break;
			case 'success_referrer':
				return "已撥點給推薦人";
				break;
			case 'success_referee':
				return "已撥點給被推薦人";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_product_status_str($v=FALSE){
		switch ($v) {
			case 'open':
				return "開放兌換";
				break;
			case 'close':
				return "關閉兌換";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_exchange_status_str($v=FALSE){
		switch ($v) {
			case 'normal':
				return "未處理";
				break;
			case 'success':
				return "已完成";
				break;
			default:
				return "無";
				break;
		}
	}


	public function get_maintainance_status_str($v=FALSE){
		switch ($v) {
			case 'late':
				return "已逾期";
				break;
			case 'pending':
				return "未處理";
				break;
			case 'process':
				return "已連絡客戶";
				break;
			case 'success':
				return "維修完成";
				break;
			case 'invalid':
				return "無效";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_contract_status_str($v=FALSE){
		switch ($v) {
			case 'pending':
				return "待處理";
				break;
			case 'process':
				return "處理中";
				break;
			case 'success':
				return "已完成";
				break;
			case 'cancel':
				return "取消";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_contract_status_str_verse($v=FALSE){
		switch ($v) {
			case '待處理':
				return "pending";
				break;
			case '處理中':
				return "process";
				break;
			case '已完成':
				return "success";
				break;
			case '取消':
				return "cancel";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_coupon_status_str($v=FALSE){
		switch ($v) {
			case 'normal':
				return "未使用";
				break;
			case 'used':
				return "已使用";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_defect_status_str($v=FALSE){
		switch ($v) {
			case 'pending':
				return "待接單";
				break;
			case 'abort':
				return "中止";
				break;
			case 'beshipped':
				return "待出貨";
				break;
			case 'close':
				return "結案";
				break;
			default:
				return "無";
				break;
		}
	}

	public function get_notification_type_str($v=FALSE){
		switch ($v) {
			case '文字':
				return "text";
				break;
			case '活動':
				return "activity";
				break;
			case '優惠券':
				return "coupon";
				break;
			case '合約':
				return "contract";
				break;
			case 'text':
				return "文字";
				break;
			case 'activity':
				return "活動";
				break;
			case 'coupon':
				return "優惠券";
				break;
			case 'contract':
				return "合約";
				break;
			default:
				return "無";
				break;
		}
	}



}