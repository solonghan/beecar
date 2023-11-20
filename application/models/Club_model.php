<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Club_model extends Base_Model {
	

	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function user_add_club($user_id, $club_arr){
		$data = array();
		foreach ($club_arr as $c) {
			$data[] = array(
				"user_id"	=>	$user_id,
				"club_id"	=>	$c
			);
		}
		if(count($data) > 0) $this->db->insert_batch($this->user_club_related_table, $data);
	}

	//取得所有在地獵場
	public function get_all_local_club(){
		return $this->db->select("id, code, name as full_name, show_name as name, IF(`cover` = '', '' ,CONCAT('".base_url()."', cover)) as cover")
						->from($this->club_table)
						->where(array("type"=>"local", "is_delete"=>0))
						->get()->result_array();
	}
}