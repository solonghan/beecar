<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Base_Controller {

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "setting";
	}

	public function index(){
		$this->data['list'] = $this->db->order_by("id asc")->get_where('settings', array("id<="=>3))->result_array();
		
		$this->load->view('mgr/setting', $this->data);
	}

	public function edit(){
		$id      = $this->input->post("id");
		$content = $this->input->post("content");
		
		$this->db->where(array("id"=>$id));
		$res = $this->db->update("settings", array("content"=>$content));
		
		if ($res) {
			$this->output(100, "success");
		}else{
			$this->output(400, "fail");
		}
	}
}
