<?php defined('BASEPATH') OR exit('No direct script access allowed');
include("./phpmailer/class.phpmailer.php");
require "./phpmailer/PHPMailerAutoload.php";
class User_model extends Base_Model {

	private $user_identify_key = "mobile";

	private $fb_app_id = '2502322560038825';
	private $fb_app_secret = 'ea032ac4128c4be5ac995df8b71319a4';
	private $fb_version = 'v5.0';
	private $fb_callback = 'member/fb_callback';

	private $g_CLIENT_ID = '16568070192-on37ujqtbr9muklp0ti63shepps9e8fg.apps.googleusercontent.com';
	private $g_CLIENT_SECRET = 'KncEd8x4zDTMpdGKXcELBJEA';
	private $g_CLIENT_REDIRECT_URL = 'member/g_callback';

	private $loginpage = 'login';


	function __construct(){
		parent::__construct ();
		date_default_timezone_set("Asia/Taipei");
	}

	//fcm token
	public function check_fcm_token($user_id, $fcm_token)
	{

		$str="select * from fcm_token  where user_id = $user_id  ORDER BY id DESC LIMIT 1 ";
		$res_log=$this->db->query($str)->row_array();
		// print_r($res_log);exit;

		if($res_log){
			if($res_log['token']==''  || $res_log['token']==null){
				// print_r($res_log);exit;
				return FALSE;
			}elseif($this->db->get_where($this->token_table, array("user_id" => $user_id, "token" => $fcm_token))->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->get_where($this->token_table, array("user_id" => $user_id, "token" => $fcm_token))->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// return ($this->db->get_where($this->token_table, array("user_id" => $user_id, "token" => $fcm_token))->num_rows() > 0) ? TRUE : FALSE;
	}

	public function save_fcm_token($user_id, $fcm_token)
	{


		if(!$this->check_fcm_token($user_id, $fcm_token)){
			
			$data = array(
				"user_id"		=>	$user_id,
				"token"	=>	$fcm_token
			);

			$this->db->insert($this->token_table, $data);
		}



	}

	//blacklist
	public function black_to_friend($user_id, $driver_id){
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id
		);
		$this->db->where(array("user_id"=>$user_id,"driver_id"=>$driver_id))->update($this->friends_table, array("is_delete"=>0));
		$this->db->where(array("user_id"=>$driver_id,"driver_id"=>$user_id))->update($this->friends_table, array("is_delete"=>0));

		if($this->get_black($user_id, $driver_id)){
		$this->db->where(array("user_id"=>$user_id,"driver_id"=>$driver_id))->update($this->blacklist_table, array("is_delete"=>1));
		}
		// if($this->get_black( $driver_id,$user_id)){
		// $this->db->where(array("user_id"=>$driver_id,"driver_id"=>$user_id))->update($this->blacklist_table, array("is_delete"=>1));
		// }
		return TRUE;
		exit;
		$blackdata = $this->get_black($user_id, $driver_id);

		if ($this->db->delete($this->blacklist_table, $data)) {
			$data['nickname'] = $blackdata['nickname'];
			if ($this->db->insert($this->friends_table, $data)) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function friend_to_black($user_id, $driver_id){
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id
		);
		// $friend = $this->get_friend($user_id, $driver_id);
		$friend = $this->get_friend($user_id, $driver_id);
		
		if( $friend !='' || $friend !=null){
			$data['nickname']=$friend['nickname'];
		}else{
			$data['nickname']='';
		}

		//new 1207 改軟刪除
		$this->db->where(array("user_id"=>$user_id,"driver_id"=>$driver_id))->update($this->friends_table, array("is_delete"=>1));
		$this->db->where(array("user_id"=>$driver_id,"driver_id"=>$user_id))->update($this->friends_table, array("is_delete"=>1));
		if($this->get_black_to_one($user_id, $driver_id)){
			$this->db->where(array("user_id"=>$user_id,"driver_id"=>$driver_id))->update($this->blacklist_table, array("is_delete"=>0));
		}elseif(!$this->get_black_have($user_id, $driver_id)){
			// (isset($friend) || $friend !=''))? $data['nickname']=$friend['nickname']:$data['nickname']='';
			$this->db->insert($this->blacklist_table, $data);
		}else{
			// $data['nickname'] = $friend['nickname'];
			// $this->db->insert($this->blacklist_table, $data);
		}

		return TRUE;
		exit;
		if ($this->db->delete($this->friends_table, $data)) {
			$data['nickname'] = $friend['nickname'];
			if ($this->db->insert($this->blacklist_table, $data)) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function get_black($user_id, $driver_id){
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id,
			"is_delete" => 0
		);
		return $this->db->get_where($this->blacklist_table, $data)->row_array();
	}
	///
	public function get_black_to_one($user_id, $driver_id){
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id,
			"is_delete" => 1
		);
		return $this->db->get_where($this->blacklist_table, $data)->row_array();
	}
	public function get_black_have($user_id, $driver_id){
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id,
			// "is_delete" => 0
		);
		return $this->db->get_where($this->blacklist_table, $data)->row_array();
	}
	public function get_black_data($user_id){
	

		$list = $this->db->select("U.id, U.username, B.nickname")
						 ->from($this->user_table." U")
						//  ->join($this->user_table." U", "U.id = GD.driver_id", "left")
						 ->join($this->blacklist_table." B", "B.user_id = U.id ")
						 ->where(array("B.driver_id"=>$user_id,"B.is_delete"=>0))
						//  ->order_by("GD.create_date DESC")
						 ->get()->result_array();
		// $data_r = array(
		// 	"driver_id"	=>	$driver_id
		// );

		return $list;
		// return $this->db->get_where($this->blacklist_table, $data_r)->result_array();
	}


	public function get_black_list($user_id, $search = ""){
		$syntax = "B.user_id = '{$user_id}' AND B.is_delete=0";
		if ($search != "") {
			$syntax .= " AND U.username LIKE '%{$search}%'";
		}
		$list = $this->db->select("U.*")
						 ->from($this->blacklist_table." B")
						 ->join($this->user_table." U", "B.driver_id = U.id", "left")
						 ->where($syntax)
						 ->order_by("B.create_date DESC")
						 ->get()->result_array();
		return $list;
	}

	//group
	public function get_group_drivers($group_id){
		$group = $this->get_group_detail($group_id);
		if ($group['is_delete'] == 1) return FALSE;

		$list = $this->db->select("U.id, U.username, F.nickname")
						 ->from($this->group_driver_table." GD")
						 ->join($this->user_table." U", "U.id = GD.driver_id", "left")
						 ->join($this->friends_table." F", "F.driver_id = U.id AND F.user_id = '".$group['user_id']."'", "left")
						 ->where(array("GD.group_id"=>$group_id))
						 ->order_by("GD.create_date DESC")
						 ->get()->result_array();
		return $list;
	}
	public function get_black_drivers($group_id){
		$group = $this->get_group_detail($group_id);
		if ($group['is_delete'] == 1) return FALSE;

		$list = $this->db->select("U.id, U.username, F.nickname")
						 ->from($this->group_driver_table." GD")
						 ->join($this->user_table." U", "U.id = GD.driver_id", "left")
						 ->join($this->friends_table." F", "F.driver_id = U.id AND F.user_id = '".$group['user_id']."'", "left")
						 ->where(array("GD.group_id"=>$group_id))
						 ->order_by("GD.create_date DESC")
						 ->get()->result_array();
		return $list;
	}

	public function group_out($user_id, $group_id){
		$group = $this->get_group_detail($group_id);
		if ($group['user_id'] == $user_id) return FALSE;

		return $this->db->delete($this->group_driver_table, array("group_id"=>$group_id, "driver_id"=>$user_id));
	}

	public function del_group($user_id, $group_id){
		$group = $this->get_group_detail($group_id);
		if ($group['user_id'] != $user_id) return FALSE;

		if ($this->edit_group($group_id, array("is_delete"=>1))) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function group_join_friend($group_id, $data){
		$group = $this->get_group_detail($group_id);
		if ($group['is_delete'] == 1) return FALSE;
		$cnt = 0;
		foreach ($data as $driver_id) {
			if ($group['user_id'] == $driver_id) continue;
			$related  =array(
				"group_id"	=>	$group_id,
				"driver_id"	=>	$driver_id
			);

			if ($this->db->get_where($this->group_driver_table, $related)->num_rows() > 0) continue;
			
			if ($this->db->insert($this->group_driver_table, $related)) $cnt++;
		}

		if ($cnt > 0) {
			$this->edit_group($group_id, array("cnt"=>($group['cnt'] + $cnt)));
		}

		return TRUE;
	}

	public function create_group($data){
		$res = $this->db->insert($this->group_table, $data);
		if ($res) {
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}

	public function check_group_code_exist($code){
		return ($this->db->get_where($this->group_table, array("code"=>$code, "is_delete"=>0))->num_rows() > 0)?TRUE:FALSE;
	}

	public function edit_group($group_id, $data){
		return $this->db->where(array("id"=>$group_id))->update($this->group_table, $data);
	}

	public function get_group_detail($group_id){
		return $this->db->select("G.*, U.username AS creater")
						->from($this->group_table." G")
						->join($this->user_table." U", "U.id = G.user_id", "left")
						->where(array("G.id"=>$group_id))
						->get()->row_array();
	}

	public function get_groups_mycreate($user_id = 0, $search = ""){
		$group_id = array();
		$data = array();
		$syntax = "is_delete = 0";
		if ($user_id != 0) {
			$syntax .= " AND user_id = '{$user_id}'";
		}
		if ($search != "") {
			$syntax .= " AND (title LIKE '%{$search}%' OR code = '{$search}')";
		}
		foreach ($this->db->get_where($this->group_table, $syntax)->result_array() as $item) {

			$cnt = $this->db
				->from($this->group_driver_table . " GD")
				->where("GD.group_id = {$item['id']}")
				->get()->num_rows();

			$data[] = array(
				"id"	=>	$item['id'],
				"title"	=>	$item['title'],
				"code"	=>	$item['code'],
				"cnt"	=>	"$cnt",
				"mine"	=>	true
			);
			$group_id[] = $item['id'];
		}

		if ($user_id == 0) return $data;

		
		return $data;
	}

	public function get_groups($user_id = 0, $search = ""){
		$group_id = array();
		$data = array();
		$syntax = "is_delete = 0";
		if ($user_id != 0) {
			$syntax .= " AND user_id = '{$user_id}'";
		}
		if ($search != "") {
			$syntax .= " AND (title LIKE '%{$search}%' OR code = '{$search}')";
		}
		foreach ($this->db->get_where($this->group_table, $syntax)->result_array() as $item) {

			$cnt = $this->db
				->from($this->group_driver_table . " GD")
				->where("GD.group_id = {$item['id']}")
				->get()->num_rows();

			$data[] = array(
				"id"	=>	$item['id'],
				"title"	=>	$item['title'],
				"code"	=>	$item['code'],
				"cnt"	=>	"$cnt",
				"mine"	=>	true
			);
			$group_id[] = $item['id'];
		}

		if ($user_id == 0) return $data;

		$syntax = "GD.driver_id = '{$user_id}' AND G.is_delete = 0";
		if ($search != "") {
			$syntax .= " AND G.title LIKE '%{$search}%'";
		}
		$im_join = $this->db->select("G.*")
							->from($this->group_driver_table." GD")
							->join($this->group_table." G", "G.id = GD.group_id", "left")
							->where($syntax)
							->order_by("GD.create_date DESC")
							->get()->result_array();
		foreach ($im_join as $item) {
			if (in_array($item['id'], $group_id)) continue;

			$cnt = $this->db
				->from($this->group_driver_table . " GD")
				->where("GD.group_id = {$item['id']}")
				->get()->num_rows();

			$data[] = array(
				"id"	=>	$item['id'],
				"title"	=>	$item['title'],
				"code"	=>	$item['code'],
				"cnt"	=>	"$cnt",
				"mine"	=>	false
			);
		}
		return $data;
	}

	//friends
	public function edit_friend($user_id, $driver_id, $data){
		$syntax = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id
		);
		if ($this->db->get_where($this->friends_table, $syntax)->num_rows() <= 0) return FALSE;
		return $this->db->where($syntax)->update($this->friends_table, $data);
	}

	public function add_friend($user_id, $driver_id){
		
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id
		);

		if ($this->db->get_where($this->friends_table, $data)->num_rows() <= 0) {
			$this->db->insert($this->friends_table, $data);
		}
		return TRUE;
	}

	public function add_address($user_id, $city, $dist, $address)
	{
		
		foreach($this->get_zipcode()['city'] as $key => $item){

			if($item['name']==$city){
				$city_code = $key;
				foreach ($item['dist'] as $t) {					
					if($t['name']==$dist){
						$dist_code = $t['c3'];
					}

				}
			}
		}
		
		$data = array(
			"user_id"			=>	$user_id,
			"city_str"		=>	$city,
			"city"				=>	$city_code,
			"dist_str"		=>	$dist,
			"zipcode"			=>	$dist_code,
			"address"			=>	$address,
		);

		$res = $this->db->insert($this->address_table, $data);
		if ($res) {
			return TRUE;			
		}else{
			return FALSE;			
		}

	}

	public function address_list($user_id)
	{
		$data = array(
			"A.user_id"   	=>	$user_id,
			"A.is_delete"   =>	0,
		);
		if ($this->db->get_where($this->address_table . " A", $data)->num_rows() <= 0) return FALSE;

		return $this->db->select("A.id,A.user_id,A.city_str,A.dist_str,A.address")
			->from($this->address_table . " A")		
			->where($data)
			->get()->result_array();
	}

	public function get_address($user_id, $address_id)
	{
		$data = array(
			"F.user_id"   =>	$user_id,
			"F.id" =>	$address_id
		);
		if ($this->db->get_where($this->address_table . " F", $data)->num_rows() <= 0) return FALSE;

		return $this->db->select("F.city_str as city,F.dist_str as area,F.address,F.id as addr_id")
			->from($this->address_table . " F")
			->where($data)
			->get()->row_array();
	}

	public function del_address($user_id, $address_id)
	{
		$data = array(
			"user_id"	=>	$user_id,
			"id"	=>	$address_id
		);

		if ($this->db->delete($this->address_table, $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_user($user_id){
		$data = array(
			"U.id"   =>	$user_id,
		);

		return $this->db->select("U.*,U.username AS showname")
						->from($this->user_table." U")
						->where($data)
						->get()->row_array();
	}

	public function get_friend($user_id, $driver_id){
		$data = array(
			"F.user_id"   =>	$user_id,
			"F.driver_id" =>	$driver_id
		);
		if ($this->db->get_where($this->friends_table." F", $data)->num_rows() <= 0) return FALSE;

		return $this->db->select("F.nickname, IF(F.nickname <>'',F.nickname, U.username) AS showname, U.*")
						->from($this->friends_table." F")
						->join($this->user_table." U", "F.driver_id = U.id", "left")
						->where($data)
						->get()->row_array();
	}

	public function get_friends($user_id, $search = "", $exclude_group_id = ""){
		$syntax = "F.user_id = '{$user_id}' AND F.is_delete=0 ";
		if ($search != "") {
			$syntax .= " AND U.username LIKE '%".$search."%'";
		}
		if ($exclude_group_id != "") {
			$syntax .= " AND U.id NOT IN (SELECT driver_id FROM `".$this->group_driver_table."` WHERE `group_id` = '{$exclude_group_id}')";
		}
		$user = $this->db->select("F.id, F.username as nickname,F.id as friend_id, F.username as showname ,F.username ,F.email,F.mobile,F.line_id,F.role ")
		->from($this->user_table . " F")
		->where("F.id = '{$user_id}'")
			->get()->row_array();
		$user_list[0] = $user;
		$list = $this->db->select("U.id,F.nickname,U.id as friend_id, IF(F.nickname <>'',F.nickname, U.username) AS showname, IF(F.nickname <>'',F.nickname, U.username) AS username,U.email,U.mobile,U.line_id,U.role")
						 ->from($this->friends_table." F")
						 ->join($this->user_table." U", "F.driver_id = U.id", "left")
						 ->where($syntax)
						 ->order_by("F.create_date DESC")
						 ->get()->result_array();

		$new = array_merge($user_list,$list);
		// print_r($new);exit;						 
		return $list;
	}
	public function get_friend_list($user_id, $search = "", $exclude_group_id = ""){
		$syntax = "F.user_id = '{$user_id}' AND F.is_delete=0 ";
		if ($search != "") {
			$syntax .= " AND U.username LIKE '%".$search."%'";
		}
		if ($exclude_group_id != "") {
			$syntax .= " AND U.id NOT IN (SELECT driver_id FROM `".$this->group_driver_table."` WHERE `group_id` = '{$exclude_group_id}')";
		}
		$user = $this->db->select("F.id, F.username as nickname,F.id as friend_id, F.username as showname ,F.username ,F.email,F.mobile,F.line_id,F.role ")
		->from($this->user_table . " F")
		->where("F.id = '{$user_id}'")
			->get()->row_array();
		$user_list[0] = $user;
		$list = $this->db->select("U.id,F.nickname,U.id as friend_id, IF(F.nickname <>'',F.nickname, U.username) AS showname, IF(F.nickname <>'',F.nickname, U.username) AS username,U.email,U.mobile,U.line_id,U.role")
						 ->from($this->friends_table." F")
						 ->join($this->user_table." U", "F.driver_id = U.id", "left")
						 ->where($syntax)
						 ->order_by("F.create_date DESC")
						 ->get()->result_array();

		$new = array_merge($user_list,$list);
		// print_r($new);exit;						 
		return $new;
	}

	public function get_friends_list($user_id, $search = "", $exclude_group_id = "")
	{
		$syntax = "F.user_id = '{$user_id}' AND F.is_delete = 0";
		if ($search != "") {
			$syntax .= " AND U.username LIKE '%" . $search . "%'";
		}
		if ($exclude_group_id != "") {
			$syntax .= " AND U.id NOT IN (SELECT driver_id FROM `" . $this->group_driver_table . "` WHERE `group_id` = '{$exclude_group_id}')";
		}
		$list = $this->db->select("F.driver_id,F.nickname,U.id as friend_id, IF(F.nickname <>'',F.nickname, U.username) AS showname")
		->from($this->friends_table . " F")
		->join($this->user_table . " U", "F.driver_id = U.id", "left")
		->where($syntax)
			->order_by("F.create_date DESC")
			->get()->result_array();
		return $list;
	}

	public function del_friend($user_id, $driver_id)
	{
		$data = array(
			"user_id"	=>	$user_id,
			"driver_id"	=>	$driver_id
		);
		
		if ($this->db->delete($this->friends_table, $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	//user alone
	public function get_fcm_token($user_id)
	{
		return $this->db->get_where($this->token_table, array("user_id" => $user_id))->result_array();
	}

	public function get_all_user(){
		return $this->db->get_where($this->user_table, array("is_delete"=>0))->result_array();
	}
	
	public function get_data($user_id, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array("id"=>$user_id)
		);
		return $this->db->get()->row_array();
	}
	public function get_token($user_id, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->token_table);
		$this->db->where(
			array("user_id"=>$user_id)
		);
		$this->db->order_by("id","DESC");
		return $this->db->get()->row_array();
	}
	public function get_data_by_key($value, $key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$value,
				'is_delete'=>'0',
				'is_verified'=>'1'
			)
		);
		return $this->db->get()->row_array();
	}

	public function get_data_by_identify($user_identify_key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				$this->user_identify_key =>	$user_identify_key,
				"is_delete"          =>	0,
				// "is_verified"            =>	0
			)
		);
		return $this->db->get()->row_array();
	}
	///
	public function get_data_by_identify_email($user_identify_key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				'email' =>	$user_identify_key,
				"is_delete"          =>	0,
				// "is_verified"            =>	0
			)
		);
		return $this->db->get()->row_array();
	}
	////add 0529
	public function account_not_verified_exist($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key,'is_delete'=>'0','is_verified'=>'0')
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function email_not_verified_exist($email, $user_id = FALSE){
		$syntax = array("email"=>$email,'is_delete'=>'0','is_verified'=>'0');
		if ($user_id !== FALSE) {
			$syntax["id<>"] = $user_id;
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where($syntax);
		$r = $this->db->get()->row();
		// print_r($r);exit;
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function get_data_by_not_verified_email($user_identify_key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				'email' =>	$user_identify_key,
				"is_delete"          =>	0,
				"is_verified"            =>	0
			)
		);
		return $this->db->get()->row_array();
	}
	public function get_data_by_not_verified($user_identify_key, $fields = "*"){
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				$this->user_identify_key =>	$user_identify_key,
				"is_delete"          =>	0,
				"is_verified"            =>	0
			)
		);
	}
	public function account_exist_first($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key,'is_delete'=>'0','is_verified'=>'1','password !='=>"")
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function email_exist_first($email, $user_id = FALSE){
		$syntax = array("email"=>$email,'is_delete'=>'0','is_verified'=>'1','password !='=>"");
		if ($user_id !== FALSE) {
			$syntax["id<>"] = $user_id;
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where($syntax);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	/////

	public function get_data_by_social_id($social_type, $social_id, $fields = "*"){
		$key = "";
		if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		$this->db->select($fields);
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$social_id)
		);
		return $this->db->get()->row_array();
	}

	public function social_account_exist($social_type, $social_id){
		$key = "";
		if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($key=>$social_id)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function social_bind($user_id, $social_type, $social_id){
		if ($social_type == 'fb') {
			$key = 'fb_id';
		}else if ($social_type == 'google') {
			$key = 'g_id';
		}else if ($social_type == 'apple') {
			$key = 'apple_id';
		}else if ($social_type == 'line') {
			$key = 'line_id';
		}
		if($this->db->where(array("id"=>$user_id))->update($this->user_table, array($key=>$social_id))){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function check_account_exist_not_verify($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				$this->user_identify_key =>	$user_identify_key,
				"verify_code<>"          =>	"",
				"is_verified"            =>	0,
			)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function account_exist($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key,'is_delete'=>'0','is_verified'=>'1')
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function account_pws_exist($user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array($this->user_identify_key=>$user_identify_key,'is_delete'=>'0','is_verified'=>'1','password'=>'')
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function email_exist($email, $user_id = FALSE){
		$syntax = array("email"=>$email,'is_delete'=>'0','is_verified'=>'1');
		if ($user_id !== FALSE) {
			$syntax["id<>"] = $user_id;
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where($syntax);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function email_pws_exist($email, $user_id = FALSE){
		$syntax = array("email"=>$email,'is_delete'=>'0','is_verified'=>'1','password'=>'');
		if ($user_id !== FALSE) {
			$syntax["id<>"] = $user_id;
		}
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where($syntax);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	

	public function pwd_confirm($pwd_md5encrypt, $user_identify_key){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array(
				$this->user_identify_key =>	$user_identify_key,
				"is_delete"          =>	0,
				// "is_verified"            =>	0
			)
		);
		$r = $this->db->get()->row();
		if ($r == null) {
			return FALSE;
		}else{
			if ($this->encryption->decrypt($r->password) == $pwd_md5encrypt) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}


	public function edit($id, $data){
		return $this->db->where(array("id"=>$id))->update($this->user_table, $data);
	}


	public function can_send_sms($phone){
		$this->db->select("*");
		$this->db->from("sms_log");
		$this->db->where("phone = '{$phone}' AND create_date > '".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) - 60*3)."'");
		if($this->db->get()->num_rows() > 0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function exsit_check($phone){
		$exsit = $this->db->get_where($this->user_table, array("phone"=>$phone))->row();
		if ($exsit) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function verify_check($phone, $code){
		$this->db->select("*");
		$this->db->from($this->user_table);
		$this->db->where(
			array("phone"=>$phone, "verify_code"=>$code)
		);
		$r = $this->db->get()->row();
		if($r == null){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function send_sms($phone, $destName, $msg){
		$username = "82955186";
		$password = "iwish82955186";
		// $username = "50875169";
		// $password = "Pass82962755";
		
		$encoding = "UTF8";
		$dlvtime = "";			//預約簡訊YYYYMMDDHHNNSS，若為空則為即時簡訊
		$vldtime = "3600";		//簡訊有效時間YYYYMMDDHHNNSS，整數值為幾秒後內有限，不可超過24hr
		$smsbody = $msg;
								//簡訊內容，空白直接空白即可，換行請使用 chr(6)
		$response = "";			//簡訊狀態回報網址
		$ClientID = "";			//用於避免重複發送(不太會用到)

		$url = "https://smsapi.mitake.com.tw/api/mtk/SmSend?username=".$username."&password=".$password."&dstaddr=".$phone."&encoding=".$encoding."&DestName=".$destName."&dlvtime=".$dlvtime."&vldtime=".$vldtime."&smbody=".$smsbody."&response=".$response."&ClientID=".$ClientID;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		$r=curl_exec($ch);
		curl_close($ch);
		// echo $r;
		$this->db->insert("sms_log", array("phone"=>$phone, "content"=>$msg));
	}

	public function send_mail($email, $body, $subject = ""){
		$mail = new PHPMailer();

		$mail->IsSMTP();
		
		// $mail->SMTPDebug = 2;
		// $mail->Host = "localhost";
		$mail->CharSet = "utf-8";
		  
		//Google 寄信
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		
		
		// $mail->Username = "service@honeybeezdispatch.com";
		// $mail->Password = 'NxU$f6%4cTNJ6kt';
		
		// $mail->From = "service@honeybeezdispatch.com";
		// $mail->FromName = "BeeCar";

		$mail->Username = "anbon.tw@gmail.com";
		$mail->Password = "vxtseczukfobscgb";
		
		$mail->From = "anbon.tw@gmail.com";
		$mail->FromName = "ANBONTW";
			  
		$mail->Subject = $subject;
		  
		$mail->IsHTML(true);
		$mail->AddAddress($email, $email);
		$mail->Body = $body;

		if($mail->Send()) {
			return array("status"=>TRUE);
		} else {
			return array("status"=>FALSE, "msg"=>$mail->ErrorInfo);
		}
		$mail->ClearAddresses(); 
	}


	//Login


	public function login($data){
		$data["isLogin"] = $this->encryption->encrypt(md5("uLogIn"));

		$data['id'] = $this->encryption->encrypt($data['id']);

		$this->session->set_userdata($data);
	}

	public function check_login(){
		if ($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn")) {
			return $this->get_data($this->encryption->decrypt($this->session->id));
		}else{
			return FALSE;
		}
	}

	public function is_login(){
		if (!($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn"))) {
			header("Location: ".base_url());
		}
	}

	public function register($data, $is_exist = FALSE){
		if ($is_exist) {
			$this->db->where(array($this->user_identify_key=>$data[$this->user_identify_key]));
			return $this->db->update($this->user_table, $data);
		}else{
			$this->db->insert($this->user_table, $data);
			return $this->db->insert_id();
		}
	}

	public function active_super_info($user_id)
	{
		$data = array('is_super'=>1);

		$res = $this->db->where(array('id'=>$user_id))->update($this->user_table, $data);

		if($res){
			return true;
		}else{
			return false;
		}

	}

	public function active_super_info_check($user_id,$action)
	{
		if($action=='on'){
			$data = array('is_super_check' => 1,'is_super'=>1);

			$res = $this->db->where(array('id' => $user_id))->update($this->user_table, $data);

			if ($res) {
				return
				array('status' => true, 'msg' => '有新的可接行程就通知我');
			} else {
				return
				array('status' => true, 'msg' => '操作失敗');
			}
		}else if($action=='off'){
			$data = array('is_super_check' => 0,'is_super'=>0);

			$res = $this->db->where(array('id' => $user_id))->update($this->user_table, $data);

			if ($res) {
				return
					array('status' => true, 'msg' => '取消超級通知');
			} else {
				return
					array('status' => true, 'msg' => '操作失敗');
			}
		}else if($action=='customize'){
			$data = array('is_super_check' => 2,'is_super'=>1);

			$res = $this->db->where(array('id' => $user_id))->update($this->user_table, $data);

			if ($res) {
				return
					array('status' => true, 'msg' => '自定通知條件');
			} else {
				return
					array('status' => true, 'msg' => '操作失敗');
			}
		}
		

		
	}

	public function check_super_info($user_id)
	{		
		// is_super_check'=>1 全通知
		// is_super_check'=>2 自訂義

		// $res = $this->db->where(array('id' => $user_id, 'is_super' => 1, 'is_super_check'=>1))->get($this->user_table)->row_array();
		$res = $this->db->where(array('id' => $user_id, 'is_super' => 1, 'is_super_check!='=>0))->get($this->user_table)->row_array();
		
		if ($res) {
			return $res;
			// return true;
		} else {
			return false;
		}
	}

	/*
	GOOGLE LOGIN
	 */
	
	public function g_login(){
		$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode($this->g_CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . $this->g_CLIENT_ID . '&access_type=online';

		header("Location: ".$login_url);
	}

	public function g_callback(){
		if($this->input->get("code")) {
			try {
				// Get the access token 
				$data = $this->g_GetAccessToken($this->g_CLIENT_ID, $this->g_CLIENT_REDIRECT_URL, $this->g_CLIENT_SECRET, $this->input->get("code"));
				$user_info = $this->g_GetUserProfileInfo($data['access_token']);
				return array(
					"name"	=>	$user_info['displayName'],
					"id"	=>	$user_info['id'],
					"email"	=>	$user_info['emails'][0]['value'],
					"pic"	=>	$user_info['image']['url']
				);
			}
			catch(Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
	}

	private function g_GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {	
		$url = 'https://accounts.google.com/o/oauth2/token';			
		
		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to receieve access token');
			
		return $data;
	}

	private function g_GetUserProfileInfo($access_token) {	
		$url = 'https://www.googleapis.com/plus/v1/people/me';			
		
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
		$data = json_decode(curl_exec($ch), true);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get user information');
			
		return $data;
	}

	/*
	FB LOGIN
	 */
	
	public function fb_login(){
		if (!session_id()) {
		    session_start();
		}
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

		$permissions = ['public_profile','email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url().$this->fb_callback, $permissions);
        header("Location: ".$loginUrl);
	}

	public function fb_callback(){
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
        	//嚴格模式下，要代入callback的url
        	$accessToken = $helper->getAccessToken(base_url().$this->fb_callback);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
	        echo 'Graph returned an error: ' . $e->getMessage();
	        header("Location: ".base_url().$this->loginpage);
	        exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
        	echo 'Facebook SDK returned an error: ' . $e->getMessage();
        	header("Location: ".base_url().$this->loginpage);
        	exit;
        }

        if (! isset($accessToken)) {
	        if ($helper->getError()) {
	            header('HTTP/1.0 401 Unauthorized');
	            echo "Error: " . $helper->getError() . "\n";
	            echo "Error Code: " . $helper->getErrorCode() . "\n";
	            echo "Error Reason: " . $helper->getErrorReason() . "\n";
	            echo "Error Description: " . $helper->getErrorDescription() . "\n";
	            header("Location: ".base_url().$this->loginpage);
	        } else {
	            header('HTTP/1.0 400 Bad Request');
	            echo 'Bad request';
	        }
	        exit;
        }

		$response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
		$user = $response->getGraphUser();
		return $user;
		// $user['name'];
		// $user['id'];
		// $user['email'];
	}

	public function get_text_list($type){
		$res=$this->db->select("*")
						->from('text_list')
						->where(
							array("type"=>$type,'is_delete'=>'0')
						)->get()->row_array();
	
		return $res;
	}
}