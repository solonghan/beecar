<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends Base_Model {
	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	public function add_data($user_id, $title, $content, $data = FALSE){
		$this->db->insert($this->notification_table, array(
            "user_id" =>    $user_id,
            "title"   =>    $title,
            "content" =>    $content,
            "type"    =>    "text"
        ));
        $insert_id = $this->db->insert_id();

        // $this->send_user_push($user_id, ["title"=>$title,"content"=>$content], $data);

        return $insert_id;
	}

    public function add_multidata($user_array, $data = FALSE){
        //classify user under os and get their token
        $android_user = array();
        $ios_user = array();
        for ($i=0; $i < count($user_array); $i++) { 
            $user = $this->db->select("L.os, L.push_token")
                         ->from($this->user_table." U")
                         ->join($this->logintoken_table." L", "L.user_id = U.id", "left")
                         ->where(array("U.id"=>$user_array[$i]["id"]))
                         ->get()->last_row("array");
            if ($user['os'] != null && $user['push_token'] != "") {
                if($user['os']=="android"){
                    array_push($android_user, $user['push_token']);
                }elseif($user['os']=="ios"){
                    array_push($ios_user, $user['push_token']);
                }
            }
            $this->db->insert($this->notification_table, array(
                "user_id"       =>  $user_array[$i]["id"],
                "group_id"      =>  $data["group_id"],
                "title"         =>  $data["title"],
                "content"       =>  $data["content"],
                "type"          =>  $data["type"],
                "relation_id"   =>  $data["relation_id"],
            ));
        }
        //send push twice(android,ios)
        $msg = array(
            "title"     =>  $data["title"],
            "content"   =>  $data["content"]
        );
        $other = array(
            "type"  =>  $data["type"],
            "id"    =>  $data["relation_id"]
        );
        if(count($android_user)!=0) $res = $this->send_push("android", $android_user, $msg, $other);
        if(count($ios_user)!=0) $res = $this->send_push("ios", $ios_user, $msg, $other);

        return $res;
    }

	public function get_data($user_id){
		return $this->db->select("id, title, content, type, relation_id, create_date, IF(is_read = 1, 'true', 'false') as is_read")
						->from($this->notification_table)
						->where(array("user_id"=>$user_id, "is_delete"=>0))
						->order_by("create_date DESC")
						->get()->result_array();
	}

	public function has_notification_unread($user_id){
		$exist = $this->db->get_where($this->notification_table, array("user_id"=>$user_id, "is_read"=>0))->num_rows();
		if ($exist > 0) {
			return $exist;
		}else{
			return FALSE;
		}
	}

	public function all_data_read($user_id){
		return $this->db->where(array("user_id"=>$user_id))->update($this->notification_table, array("is_read"=>1));
	}

    public function data_read($user_id, $notification_id){
        return $this->db->where(array("user_id"=>$user_id, "id"=>$notification_id))->update($this->notification_table, array("is_read"=>1));
    }

	public function send_user_push($user_id, $msg, $data = FALSE){
		$user = $this->db->select("L.os, L.push_token")
						 ->from($this->user_table." U")
						 ->join($this->logintoken_table." L", "L.user_id = U.id", "left")
						 ->where(array("U.id"=>$user_id))
						 ->get()->last_row("array");
		if ($user['os'] != null && $user['push_token'] != "") $this->send_push($user['os'], $user['push_token'], $msg, $data);
	}

}