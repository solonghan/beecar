<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Priv extends Base_Controller {
	private $th_title = ["#", "群組名稱", "群組人員", "更新日期", "動作"]; //, "置頂"
	private $th_width = ["44px", "", "", "", "95px", "80px"];
	private $order_column = ["id", "", "", "","create_date", ""];
	private $can_order_fields = [0, 4];

	private $debug_mode = FALSE;

	private $param;
	private $action;

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "PRIV";
		$this->data['sub_active'] = 'PRIV_GROUP';

		$this->load->model("Priv_model");
		
		$this->action = base_url()."mgr/priv/";
		$this->param = [
				["姓名",		 		"name", 			"text", 					"", 		TRUE, 	""],
				["權限",		 		"privilege",		"select", 					"", 		TRUE, 	"", ["id", "text"]],
				["大頭照",	 		"avatar", 			"img",	 					"", 		FALSE, 	"", 1/1],
                ["帳號email",		"email",	 		"text", 					"", 		TRUE, 	""],
                ["密碼",				"password",			"password",					"", 		TRUE, 	""],
                ["再次輸入密碼",		"password_confirm",	"password",					"", 		TRUE, 	""],
                ["聯絡電話",			"phone",			"text",						"", 		FALSE, 	""],
            ];
	}

	public function index(){
		$this->data['title'] = '權限管理';

		$this->data['action'] = $this->action;
		$this->data['parent'] = '帳號權限管理';
		$this->data['parent_link'] = base_url()."mgr/member/";
		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			['新增權限', base_url()."mgr/priv/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 0;
		$this->data['default_order_direction'] = 'DESC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function add(){
		$nav = $this->data['nav'];
		foreach ($nav as $key => $obj) {
			$nav_action = explode(",", $nav[$key]['action']);
			$nav[$key]['action'] = array();
			foreach ($nav_action as $a) {
				$nav[$key]['action'][$a] = TRUE;
			}
			
			foreach ($nav[$key]['sub_menu'] as $sub_key => $sub_obj) {
				$subnav_action = explode(",", $nav[$key]['sub_menu'][$sub_key]['action']);
				$nav[$key]['sub_menu'][$sub_key]['action'] = array();
				foreach ($subnav_action as $a) {
					$nav[$key]['sub_menu'][$sub_key]['action'][$a] = TRUE;
				}
			}
		}

		if ($_POST) {
			$title = $this->input->post("title");
			if ($title == "") $this->js_output_and_back("群組名稱不可為空");

			$priv_id = 0;
			if(!$this->debug_mode){
				$priv_id = $this->Priv_model->add_priv($title);
				if ($priv_id === FALSE) $this->js_output_and_back("建立權限發生錯誤");
			}

			$priv_rel = array();
			foreach ($nav as $key => $obj) {
				foreach ($obj['action'] as $a_key => $a) {
					$checkbox = $this->input->post($key."_".$a_key);
					if($this->debug_mode) echo $obj['name']." ".$a_key.": ".(($checkbox && $checkbox == "on")?'開啟':'關閉')."<br>";
					$priv_rel[] = array(
						"privilege_id" =>	$priv_id,
						"menu_id"      =>	$key,
						"action_id"    =>	$a_key,
						"enabled"      =>	(($checkbox && $checkbox == "on")?1:0)
					);
				}
				
				foreach ($nav[$key]['sub_menu'] as $sub_key => $sub_obj) {
					foreach ($sub_obj['action'] as $a_key => $a) {
						$checkbox = $this->input->post($sub_key."_".$a_key);
						if($this->debug_mode) echo "∟".$sub_obj['name']." ".$a_key.": ".(($checkbox && $checkbox == "on")?'開啟':'關閉')."<br>";
						$priv_rel[] = array(
							"privilege_id" =>	$priv_id,
							"menu_id"      =>	$sub_key,
							"action_id"    =>	$a_key,
							"enabled"      =>	(($checkbox && $checkbox == "on")?1:0)
						);
					}
				}
				if($this->debug_mode) echo "<br>";
			}

			if($this->debug_mode) return;

			if ($this->Priv_model->update_priv_menu_rel($priv_id, $priv_rel) !== FALSE) {
				$this->js_output_and_redirect("新增成功", base_url()."mgr/priv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			$this->data['title'] = '新增權限';
			$this->data['sub_active'] = 'priv/add';
			// $this->data['sub_title'] = '新增';

			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/add";
			$this->data['submit_txt'] = "新增權限";
			$this->data['sub_active'] = "priv/add";

			$this->data['priv'] = $nav;
			$this->data['priv_action'] = $this->Priv_model->priv_action();

			$this->load->view("mgr/priv_detail", $this->data);
		}
	}

	public function edit_temp(){
		

			$this->data['title'] = '編輯權限';
			$this->data['sub_active'] = 'priv/add';
			

			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/add";
			$this->data['submit_txt'] = "新增";
			$this->data['sub_active'] = "priv/add";

			//column
			// $this->data['select']['privilege'] = $this->privilege_columns;

			$this->data['param'] = $this->param;
			// $this->load->view("mgr/template_form", $this->data);
			$this->load->view("mgr/priv_detail_temp", $this->data);
		
	}	

	public function switch_toggle(){
		$id     = $this->input->post("id");
		$status = $this->input->post("status");

		if ($this->Priv_model->edit($id, array("status"=>$status))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function del(){
		$id = $this->input->post("id");
		if (!is_numeric($id)) show_404();

		if ($this->Priv_model->edit($id, array("is_delete"=>1))) {
			$this->output(TRUE, "success");
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		if (!is_numeric($id)) show_404();
		
		$priv = $this->Priv_model->get_priv_data($id);

		$priv_menu = array();
		foreach ($this->Priv_model->get_priv_menu_by_privilege_id($id) as $obj) {
			if (!array_key_exists($obj['menu_id'], $priv_menu)) $priv_menu[$obj['menu_id']] = array();

			$priv_menu[$obj['menu_id']][$obj['action_id']] = ($obj['enabled'] == 1)?TRUE:FALSE;
		}

		$nav = $this->Priv_model->priv_menu("all");
		foreach ($nav as $key => $obj) {
			$nav_action = explode(",", $nav[$key]['action']);
			$nav[$key]['action'] = array();
			foreach ($nav_action as $a) {
				$nav[$key]['action'][$a] = $priv_menu[$key][$a];
			}
			
			foreach ($nav[$key]['sub_menu'] as $sub_key => $sub_obj) {
				$subnav_action = explode(",", $nav[$key]['sub_menu'][$sub_key]['action']);
				$nav[$key]['sub_menu'][$sub_key]['action'] = array();
				foreach ($subnav_action as $a) {
					if (array_key_exists($sub_key, $priv_menu)) {
						$nav[$key]['sub_menu'][$sub_key]['action'][$a] = $priv_menu[$sub_key][$a];	
					}else{
						$nav[$key]['sub_menu'][$sub_key]['action'][$a] = FALSE;
					}
					
				}	
			}
		}

		if ($_POST) {
			$priv_rel = array();
			foreach ($nav as $key => $obj) {
				foreach ($obj['action'] as $a_key => $a) {
					$checkbox = $this->input->post($key."_".$a_key);
					if($this->debug_mode) echo $obj['name']." ".$a_key.": ".(($checkbox && $checkbox == "on")?'開啟':'關閉')."<br>";
					$priv_rel[] = array(
						"privilege_id" =>	$id,
						"menu_id"      =>	$key,
						"action_id"    =>	$a_key,
						"enabled"      =>	(($checkbox && $checkbox == "on")?1:0)
					);
				}
				
				foreach ($nav[$key]['sub_menu'] as $sub_key => $sub_obj) {
					foreach ($sub_obj['action'] as $a_key => $a) {
						$checkbox = $this->input->post($sub_key."_".$a_key);
						if($this->debug_mode) echo "∟".$sub_obj['name']." ".$a_key.": ".(($checkbox && $checkbox == "on")?'開啟':'關閉')."<br>";
						$priv_rel[] = array(
							"privilege_id" =>	$id,
							"menu_id"      =>	$sub_key,
							"action_id"    =>	$a_key,
							"enabled"      =>	(($checkbox && $checkbox == "on")?1:0)
						);
					}
				}
				if($this->debug_mode) echo "<br>";
			}

			if($this->debug_mode) return;

			if ($this->Priv_model->update_priv_menu_rel($id, $priv_rel) !== FALSE) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/priv");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			// $data = $this->Priv_model->get_data($id);
			$this->data['title'] = '編輯權限 【'.$priv['title'].'】';
			$this->data['sub_active'] = 'priv';
			$this->data['action'] = $this->action;

			$this->data['th_title'] = $this->th_title;
			$this->data['th_width'] = $this->th_width;
			$this->data['can_order_fields'] = [];
			$this->data['tool_btns'] = [
				['儲存變更', base_url()."mgr/priv/edit/".$id, "btn-primary"]
			];
			$this->data['default_order_column'] = 0;
			$this->data['default_order_direction'] = 'DESC';
			$this->data['parent'] = '權限管理';
			$this->data['parent_link'] = base_url()."mgr/priv";

			$this->data['action'] = base_url()."mgr/priv/edit/".$id;
			$this->data['submit_txt'] = "確認編輯";

			
			$this->data['priv'] = $nav;
			$this->data['priv_action'] = $this->Priv_model->priv_action();

			$this->load->view("mgr/priv_detail", $this->data);
		}
	}

	public function data(){
		$page        = ($this->input->post("page"))?$this->input->post("page"):1;
		$search      = ($this->input->post("search"))?$this->input->post("search"):"";
        $order       = ($this->input->post("order"))?$this->input->post("order"):0;
        $direction   = ($this->input->post("direction"))?$this->input->post("direction"):"ASC";

        $order_column = $this->order_column;
		$canbe_search_field = ["title"];

		$syntax = "is_delete = 0";
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
		
		$order_by = "create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = $order_column[$order]." ".$direction.", ".$order_by;
        }

		$data = $this->Priv_model->get_priv_list($syntax, $order_by, $page);

		$html = "";
		foreach ($data['list'] as $item) {
			$html .= $this->load->view("mgr/items/priv_item", array(
				"item"  =>	$item
			), TRUE);
		}
		if($search!="") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$data['total_page']
		));
	}
}
