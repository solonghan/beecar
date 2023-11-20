<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends Base_Model {

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	//group
	public function get_event_group_list(){
		return $this->db->get_where($this->event_group_table, array("code"<>""))->result_array("id");
	}

	//exhibit(event)

	public function edit($id, $data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->update_batch($this->event_table, $data, "id");
		}else{
			return $this->db->where(array("id"=>$id))->update($this->event_table, $data);
		}
	}

	public function add($data, $is_multi = FALSE){
		if ($is_multi) {
			return $this->db->insert_batch($this->event_table, $data);
		}else{
			return $this->db->insert($this->event_table, $data);
		}
	}

	public function get_data($id){
		return $this->db->get_where($this->event_table, array("id"=>$id))->row_array();
	}

	public function get_all_list(){
		return $this->db->get_where($this->event_table, array("is_delete"=>0, "status"=>"open"))->result_array();
	}

	public function get_list($syntax, $order_by, $page = 1, $page_count = 20){
		$total = $this->db->where($syntax)->get($this->event_table)->num_rows();
		$total_page = ($total % $page_count == 0) ? floor(($total)/$page_count) : floor(($total)/$page_count) + 1;

		$list = $this->db->select("*")
						 ->from($this->event_table)
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($page_count, ($page-1)*$page_count)
						 ->get()->result_array();
		return array(
			"total"      =>	$total,
			"total_page" =>	$total_page,
			"list"       =>	$list
		);
	}
}