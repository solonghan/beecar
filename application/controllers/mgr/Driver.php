<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Driver extends Base_Controller {
	private $th_title = ["駕駛", "品牌","型號","車型", "出產年份", "顏色", "車牌號碼", "審核狀態","動作"]; //, "置頂"
	private $th_width = ["", "", "", "","","", "", "95px","", "",""];
	private $order_column = ["", "", "", "","", "", "","","", ""]; //, "is_head"
	private $can_order_fields = [];

	private $th_title_img = ["駕駛", "正面","背面", "審核狀態","動作"]; //, "置頂"
	private $th_width_img = ["", "", "", "","", "",""];
	private $order_column_img = ["", "","", "","", ""]; //, "is_head"
	private $can_order_fields_img = [];

	private $th_title_driver = ["駕駛", "正面","背面", "有效期限", "審核狀態","動作"]; //, "置頂"
	private $th_width_driver = ["", "", "", "","","", "",""];
	private $order_column_driver = ["", "", "", "", "","", ""]; //, "is_head"
	private $can_order_fields_driver = [];

	private $th_title_order =[ "行程編號", "日期","顧客資訊", "行程資訊","狀態","駕駛人", "訂單建立者", "建立時間","動作"]; //, "置頂"
	private $th_width_order = ["","","","","","","","",""];
	private $order_column_order = [ "","","","","","","","",""]; //, "is_head"
	private $can_order_fields_order = [];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = 'DRIVER';
		$this->action = base_url() . 'mgr/driver/';
		
	}
	//車輛資料
	public function car(){
			$this->data['title'] = '車輛資料';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/car/export";
		$this->data['action'] = base_url()."mgr/driver/car";
		$this->data['custom_data_url'] = base_url()."mgr/driver/car_data";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function car_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('car_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('car_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/car");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯車輛資料 '.$oridata['id'];
			$this->data['parent'] = '車輛資料';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/car_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";
			
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'normal',
					'status'=> '正常'),
				1=>array(
					'id'=>'close',
					'status'=> '封鎖')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);
			
			$this->data['select']['gender'] = 
			array(
				0=>array(
					'id'=>0,
					'gender'=>'男'),
				1=>array(
					'id'=>1,
					'gender'=>'女')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);			
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function car_del(){
		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update('car_info', array("is_delete"=>1))){

				$this->output(TRUE, "success");
			}else{
				$this->output(FALSE, "fail");
			}
		}else{
			$this->output(FALSE, "fail");
		}
	}
	public function car_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		
		$total = $this->db->from($this->user." P")
			//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
			->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('car_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/car_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	//照片驗證
	public function photo_verify(){
		$this->data['title'] = '照片驗證';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/photo_verify/export";
		$this->data['action'] = base_url()."mgr/driver/photo_verify";
		$this->data['custom_data_url'] = base_url()."mgr/driver/photo_verify_data";

		$this->data['th_title'] = $this->th_title_img;
		$this->data['th_width'] = $this->th_width_img;
		$this->data['can_order_fields'] = $this->can_order_fields_img;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function photo_verify_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('driver_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('driver_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/photo_verify");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯照片驗證 '.$oridata['id'];
			$this->data['parent'] = '照片驗證';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/photo_verify_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";		
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function photo_verify_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0  AND C.type='photo'";
		// $syntax_add = "P.is_delete = 0  AND C.type='photo' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "syntax:\n".date("Y-m-d H:i:s")."\n".json_encode($syntax)."\n\n");
				fclose($f);
		
		$total = $this->db->from($this->user." P")
							->join('driver_info'." C", "C.user_id = P.id", "right")
							->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('driver_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "list:\n".date("Y-m-d H:i:s")."\n".json_encode($list)."\n\n");
				fclose($f);
		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/photo_verify_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	//身分證
	public function ID_card(){
		$this->data['title'] = '身分證驗證';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/ID_card/export";
		$this->data['action'] = base_url()."mgr/driver/ID_card";
		$this->data['custom_data_url'] = base_url()."mgr/driver/ID_card_data";

		$this->data['th_title'] = $this->th_title_img;
		$this->data['th_width'] = $this->th_width_img;
		$this->data['can_order_fields'] = $this->can_order_fields_img;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function ID_card_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('driver_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('driver_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/ID_card");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯身分證驗證 '.$oridata['id'];
			$this->data['parent'] = '身分證驗證';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/ID_card_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";		
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function ID_card_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0  AND C.type='idcard'";
		// $syntax_add = "P.is_delete = 0  AND C.type='photo' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "syntax:\n".date("Y-m-d H:i:s")."\n".json_encode($syntax)."\n\n");
				fclose($f);
		
		$total = $this->db->from($this->user." P")
							->join('driver_info'." C", "C.user_id = P.id", "right")
							->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('driver_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "list:\n".date("Y-m-d H:i:s")."\n".json_encode($list)."\n\n");
				fclose($f);
		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/ID_card_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	//行照
	public function vehicle_license(){
		$this->data['title'] = '行照驗證';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/vehicle_license/export";
		$this->data['action'] = base_url()."mgr/driver/vehicle_license";
		$this->data['custom_data_url'] = base_url()."mgr/driver/vehicle_license_data";

		$this->data['th_title'] = $this->th_title_driver;
		$this->data['th_width'] = $this->th_width_driver;
		$this->data['can_order_fields'] = $this->can_order_fields_driver;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function vehicle_license_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('driver_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('driver_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/vehicle_license");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯行照驗證 '.$oridata['id'];
			$this->data['parent'] = '行照驗證';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/vehicle_license_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";		
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function vehicle_license_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0  AND C.type='vehiclelicense'";
		// $syntax_add = "P.is_delete = 0  AND C.type='photo' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "syntax:\n".date("Y-m-d H:i:s")."\n".json_encode($syntax)."\n\n");
				fclose($f);
		
		$total = $this->db->from($this->user." P")
							->join('driver_info'." C", "C.user_id = P.id", "right")
							->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('driver_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "list:\n".date("Y-m-d H:i:s")."\n".json_encode($list)."\n\n");
				fclose($f);
		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/vehicle_license_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	//駕照
	public function drivers_license(){
		$this->data['title'] = '駕照驗證';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/drivers_license/export";
		$this->data['action'] = base_url()."mgr/driver/drivers_license";
		$this->data['custom_data_url'] = base_url()."mgr/driver/drivers_license_data";

		$this->data['th_title'] = $this->th_title_driver;
		$this->data['th_width'] = $this->th_width_driver;
		$this->data['can_order_fields'] = $this->can_order_fields_driver;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function drivers_license_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('driver_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('driver_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/drivers_license");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯駕照驗證 '.$oridata['id'];
			$this->data['parent'] = '駕照驗證';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/drivers_license_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";		
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function drivers_license_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0  AND C.type='driverlicense'";
		// $syntax_add = "P.is_delete = 0  AND C.type='photo' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "syntax:\n".date("Y-m-d H:i:s")."\n".json_encode($syntax)."\n\n");
				fclose($f);
		
		$total = $this->db->from($this->user." P")
							->join('driver_info'." C", "C.user_id = P.id", "right")
							->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('driver_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "list:\n".date("Y-m-d H:i:s")."\n".json_encode($list)."\n\n");
				fclose($f);
		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/drivers_license_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	//車輛驗證
	public function vehicle_verify(){
		$this->data['title'] = '車輛驗證';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/driver/vehicle_verify/export";
		$this->data['action'] = base_url()."mgr/driver/vehicle_verify";
		$this->data['custom_data_url'] = base_url()."mgr/driver/vehicle_verify_data";

		$this->data['th_title'] = $this->th_title_img;
		$this->data['th_width'] = $this->th_width_img;
		$this->data['can_order_fields'] = $this->can_order_fields_img;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

		$this->load->view('mgr/template_list', $this->data);
	}
	public function vehicle_verify_edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get('driver_info')->row_array();

		$param = [["審核狀態", "status", "select", $oridata['status'],["id",'status']],];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			
			// print_r($id);
			// print_r($data);exit;
			$res = $this->db->where(array("id"=>$id))->update('driver_info', $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/driver/vehicle_verify");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯車輛驗證 '.$oridata['id'];
			$this->data['parent'] = '車輛驗證';
			$this->data['parent_link'] = base_url()."mgr/car";
			$this->data['action'] = base_url()."mgr/driver/vehicle_verify_edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";		
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'pending',
					'status'=> '審核中'),
				1=>array(
					'id'=>'verified',
					'status'=> '已通過'),
				2=>array(
					'id'=>'invalid',
					'status'=> '未通過')
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}
	public function vehicle_verify_data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0  AND C.type='car'";
		// $syntax_add = "P.is_delete = 0  AND C.type='photo' ";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "syntax:\n".date("Y-m-d H:i:s")."\n".json_encode($syntax)."\n\n");
				fclose($f);
		
		$total = $this->db->from($this->user." P")
							->join('driver_info'." C", "C.user_id = P.id", "right")
							->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*,C.*")
						 ->from($this->user." P")
						 ->join('driver_info'." C", "C.user_id = P.id", "right")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		$f = fopen("1116_log.txt", "a+");
				fwrite($f, "list:\n".date("Y-m-d H:i:s")."\n".json_encode($list)."\n\n");
				fclose($f);
		// print_r($list);exit;

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/vehicle_verify_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}
	
	// public function index(){
	// 	$this->data['title'] = '車輛資料';
	// 	$this->data['excel_export'] = false;
	// 	$this->data['export_url'] = "mgr/car/export";
	// 	$this->data['action'] = base_url()."mgr/car/";

	// 	$this->data['th_title'] = $this->th_title;
	// 	$this->data['th_width'] = $this->th_width;
	// 	$this->data['can_order_fields'] = $this->can_order_fields;
	// 	$this->data['tool_btns'] = [
	// 		// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
	// 	];
	// 	$this->data['default_order_column'] = 1;
	// 	$this->data['default_order_direction'] = 'ASC';
	// 	// $this->data['custom_data_url'] = base_url()."mgr/user/order_list/24";

	// 	$this->load->view('mgr/template_list', $this->data);
	// }

	public function edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get($this->user)->row_array();

		$param = [								
								["姓名", "username", "text",$oridata['username']],
								["信箱/帳號", "email", "text",$oridata['email']],
								["手機", "mobile", "text",$oridata['mobile']],
								["lineID", "line_id", "text", $oridata['line_id']],
								["審核狀態", "verify_status", "select", $oridata['verify_status'],["id",'verify_status']],
								// ["公司名稱", "company_name", "text", $oridata['company_name']],
								// ["職稱", "title", "text", $oridata['title']],	["性別", "gender", "select",$oridata['gender'],["id",'gender']],			
								// ["生日", "birthday", "day",$oridata['birthday']],
								// ["狀態", "status", "select",$oridata['status'],["id",'status']],
								// ["留言", "remark", "plain", $oridata['remark']],

            ];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			


			$res = $this->db->where(array("id"=>$id))->update($this->user, $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/user");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯會員 '.$oridata['id'];
			$this->data['parent'] = '會員管理';
			$this->data['parent_link'] = base_url()."mgr/user";
			$this->data['action'] = base_url()."mgr/user/edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";
			
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'normal',
					'status'=> '正常'),
				1=>array(
					'id'=>'close',
					'status'=> '封鎖')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);
			
			$this->data['select']['gender'] = 
			array(
				0=>array(
					'id'=>0,
					'gender'=>'男'),
				1=>array(
					'id'=>1,
					'gender'=>'女')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);			
			$this->data['select']['verify_status'] = 
			array(
				0=>array(
					'id'=>'verify',
					'verify_status'=> '通過'),
				1=>array(
					'id'=>'failure',
					'verify_status'=> '未通過')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}
	}

	public function data(){

		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "P.is_delete = 0";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		
		$total = $this->db->from($this->user." P")
			//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
			->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "P.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
		$list = $this->db->select("P.*")
						 ->from($this->user." P")
						 ->join('car_info'." C", "C.user_id = P.id", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/car_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}

	public function sort(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();
		$sort = $this->input->post("sort");

		$index = 1;
		foreach ($this->db->order_by("sort ASC")->get_where($this->user, array("id<>"=>$id))->result_array() as $item) {
			if ($index == $sort) $index++;
			$data[] = array(
				"id"	=>	$item['id'],
				"sort"	=>	$index
			);
			$index++;
		}
		$data[] = array(
			"id"         =>	$id,
			"sort"       =>	$sort
		);
		$res = $this->db->update_batch($this->user, $data, "id");
		if ($res) {
			$this->output(TRUE, "成功");
		}else{
			$this->output(FALSE, "失敗");
		}
	}



	public function del(){
		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update($this->user, array("is_delete"=>1))){

				$this->output(TRUE, "success");
			}else{
				$this->output(FALSE, "fail");
			}
		}else{
			$this->output(FALSE, "fail");
		}
	}
	public function order_data($id){
		// print 123;exit;
		$this->data['title'] = '會員管理';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/car/export";
		$this->data['action'] = base_url()."mgr/car/";

		$this->data['th_title'] = $this->th_title_order;
		$this->data['th_width'] = $this->th_width_order;
		$this->data['can_order_fields'] = $this->can_order_fields_order;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';
		$this->data['custom_data_url'] = base_url()."mgr/user/order_list/".$id;

		$this->load->view('mgr/template_list', $this->data);

	}

	public function order_list($user_id){
		// print 1123;exit;
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
		$order       = ($this->input->post("order"))?$this->input->post("order"):0;
		$direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

		$order_column = $this->order_column;
		
						
		$canbe_search_field = ["P.username","P.email","P.mobile"];

		$syntax = "O.is_delete = 0";
		if ($search != "") {
			$syntax .= " AND (";
			$index = 0;
			foreach ($canbe_search_field as $field) {
				if ($index > 0) $syntax .= " OR ";
				$syntax .= $field." LIKE '%".$search."%'";
				$index++;
			}
			$syntax .= ")";
		
		}
		
		$total = $this->db->from($this->order." O")
			//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
			->where($syntax)
						 ->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "O.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }

		$syntax = "O.is_delete = 0 AND O.is_finish = 0";
		$syntax .= " AND (O.order_owner = $user_id OR O.order_middle = $user_id)";

		// $list = $this->db->select("O.id,O.date,O.time,O.order_no,O.start_city,O.start_dist,O.start_addr,O.final_status,O.price,O.final_payment,O.car_model,O.remark,O.owner_status,O.middle_status,O.driver_status,O.order_driver,O.order_owner,O.order_middle")
		// $list = $this->db->select("O.*")
		// 				->from($this->order . " O")
		// 				->where($syntax)
		// 				->order_by('O.date ASC,O.time ASC')
		// 				->get()->result_array();


		$list = $this->db->select("O.*,U.username as driver_name,UU.username as owner")
						 ->from($this->order." O")
						 ->join($this->user." U", "U.id = O.order_driver", "left")
						->join($this->user . " UU", "UU.id = O.order_owner", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();					
		// $list = $this->db->select("P.*")
		// 				 ->from($this->user." P")
		// 				//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
		// 				 ->where($syntax)
		// 				 ->order_by($order_by)
		// 				 ->limit($this->page_count, ($page-1)*$this->page_count)
		// 				 ->get()->result_array();

		$total_num = $this->db->get_where($this->order)->num_rows();

		// print_r($list);exit;
		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/order_list_item", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page
		));
	}

	public function edit_order($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get($this->order)->row_array();

		$param = [								
								["日期", "date", "text",$oridata['date']],
								["時間", "time", "text",$oridata['time']],
								["客人姓名", "name", "text",$oridata['name']],
								["客人電話", "phone", "text", $oridata['phone']],
								["航班編號", "flight", "text",$oridata['flight']],
								["人數", "number", "text",$oridata['number']],
								["行李", "baggage", "text",$oridata['baggage']],
								["備註", "remark", "text",$oridata['remark']],
								["開始城市", "start_city", "text",$oridata['start_city']],
								["開始地區", "start_dist", "text", $oridata['start_dist']],
								["車型", "car_model", "text",$oridata['car_model']],
								["回金/補貼狀態", "final_status", "select", $oridata['final_status'],["id",'final_status']],
								["回金/補貼", "final_payment", "text",$oridata['final_payment']],
								["收現", "price", "text",$oridata['price']],
								// ["審核狀態", "verify_status", "select", $oridata['verify_status'],["id",'verify_status']],
								// ["公司名稱", "company_name", "text", $oridata['company_name']],
								// ["職稱", "title", "text", $oridata['title']],	["性別", "gender", "select",$oridata['gender'],["id",'gender']],			
								// ["生日", "birthday", "day",$oridata['birthday']],
								// ["狀態", "status", "select",$oridata['status'],["id",'status']],
								// ["留言", "remark", "plain", $oridata['remark']],

            ];
		if ($_POST) {
			$data = array();
			foreach ($param as $item) {
				if($item[1]=="email_verify"){
					//$email_verify不存入資料庫
					continue;
				}else{

					if ($item[2] == "select_multi") continue;
					if ($item[2] == "file") {
						if ($this->input->post($item[1]."_deleted") == "true") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink("./".$oridata[$item[1]]);
							}
							$data[$item[1]] = "";
						}
						if ($_FILES[$item[1]]['error'] != 4 && $this->input->post($item[1]) == "") {
							if ($oridata[$item[1]] != "" && file_exists($oridata[$item[1]])) {
								unlink($oridata[$item[1]]);
							}
							$dir = 'uploads/';
							$this->upload->initialize($this->set_upload_options($dir));
								$this->upload->do_upload($item[1]);
							$idata = $this->upload->data();
							$data[$item[1]] = $dir.$idata['file_name'];
						}						
					}else{
						if ($item[1] == "youtube") {
							if (strlen($this->input->post($item[1])) == 11) {
								$data[$item[1]] = $this->input->post($item[1]);
							}else{
								$yid = explode("?v=", $this->input->post($item[1]));
								$data[$item[1]] = substr($yid[1], 0, 11);
							}
						}else{
							$data[$item[1]] = $this->input->post($item[1]);	
						}
					}
				}
			}

			


			$res = $this->db->where(array("id"=>$id))->update($this->order, $data);

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/user/");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯行程 '.$oridata['id'];
			$this->data['parent'] = '行程管理';
			$this->data['parent_link'] = base_url()."mgr/user";
			$this->data['action'] = base_url()."mgr/user/edit_order/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";
			
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'normal',
					'status'=> '正常'),
				1=>array(
					'id'=>'close',
					'status'=> '封鎖')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);
			
			$this->data['select']['gender'] = 
			array(
				0=>array(
					'id'=>0,
					'gender'=>'男'),
				1=>array(
					'id'=>1,
					'gender'=>'女')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);			
			$this->data['select']['final_status'] = 
			array(
				0=>array(
					'id'=>0,
					'final_status'=> '回金'),
				1=>array(
					'id'=>1,
					'final_status'=> '補貼')
				// 2=>array(
				// 	'id'=>2,
				// 	'area'=>'高雄'),
			);

			$this->data['param'] = $param;
			$this->load->view("mgr/template_form_old", $this->data);
		}

	}

	public function export()
	{
		$fileType = 'Excel5';
		$fileName = 'report.xls';
		$objReader = PHPExcel_IOFactory::createReader($fileType);
		$obj = $objReader->load($fileName);
		$obj->setActiveSheetIndex(0);
		$sheet = $obj->getActiveSheet();


		$x = 'A';
		$y = '1';

		//隔線形式
		$border_style = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			)
		);

		$sheet->getStyle($x . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '姓名');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '性別');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '生日');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->getColumnDimension($x)->setWidth(35);
		$sheet->setCellValue($x . $y, 'Email');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->getColumnDimension($x)->setWidth(20);
		$sheet->setCellValue($x . $y, '手機');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->getColumnDimension($x)->setWidth(20);
		$sheet->setCellValue($x . $y, '電話');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '公司');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '城市');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '區');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->getColumnDimension($x)->setWidth(30);
		$sheet->setCellValue($x . $y, '地址');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '註冊日期');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '備註');


		$list = $this->db->select("P.*")
			->from($this->user . " P")		 
		 	->where('P.is_delete=0')
			->get()->result_array();

			
			foreach ($list as  $value) {
				$x = 'A';
				$y++;

				$sheet->getStyle($x . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['name']);

				if($value['gender']==0){
					$gender='男';
				}else{
					$gender = '女';
				}

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $gender);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['birthday']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['email']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['phone']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['tele']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['company_name']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['city_str']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['dist_str']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['address']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['register_date']);

				$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
				$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($x . $y)->applyFromArray($border_style);
				$sheet->setCellValue($x . $y, $value['remark']);
			}

	





			$year = date("Y");
			$new_file_name = "xls_file/user_" . date('Y') . "_" . date("Ymd_His") . ".xls";
			// Write the file
			$objWriter = PHPExcel_IOFactory::createWriter($obj, $fileType);
			$objWriter->save($new_file_name);

			header("Location: " . base_url() . $new_file_name);
			return;

	}

}



