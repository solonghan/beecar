<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Statement extends Base_Controller {
	private $th_title = ["政策及條款內容","修改日期","操作"]; //, "置頂"
	private $th_width = ["", "",""];
	private $order_column = ["", "",""]; //, "is_head"
	private $can_order_fields = [];

	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "STATEMENT";
		
	}
	
	public function index(){
		$this->data['title'] = '政策及條款';
		$this->data['excel_export'] = false;
		$this->data['export_url'] = "mgr/statement/export";
		$this->data['action'] = base_url()."mgr/statement/";

		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增FAQ', base_url()."mgr/user/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 1;
		$this->data['default_order_direction'] = 'ASC';

		$this->load->view('mgr/template_list', $this->data);
	}

	public function edit($id){
		if (!is_numeric($id)) show_404();
		
		//從blog抓出對應id的內容
		$oridata = $this->db->where(array("id"=>$id))->get($this->statement)->row_array();

		$param = [								
								["政策及條款內容", "content", "textarea",$oridata['content']],
								// ["信箱/帳號", "email", "text",$oridata['email']],
								// ["手機", "mobile", "text",$oridata['mobile']],
								// ["lineID", "line_id", "text", $oridata['line_id']],
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

			$res = $this->db->where(array("id"=>$id))->update($this->statement, $data);

			$this->db->update($this->user, array("is_statement_read"=>0));

			$str="select * from user  where role='driver' AND is_delete=0";
			$res_data=$this->db->query($str)->result_array();

			foreach($res_data as $r_data){
				// $email=$r_data['email'];
				$email='sss9611300@yahoo.com.tw';
			 	$msg = "新的政策及條款內容:<br>".$data['content'];
				$this->User_model->send_mail($email, $msg, "[蜜蜂派遺] 政策&條款修改通知信");
				// print_r($email);
			}

			// print_r($res_data);
			// exit;

			// $email='sss9611300@yahoo.com.tw';

			//  $msg = "新的政策及條款內容:<br>".$data['content'];
			// $this->User_model->send_mail($email, $msg, "[蜜蜂派遺] 政策&條款修改通知信");

			//  $this->db->update('fcm_token', array("token" =>''));
			//  $this->db->where(array("id"=>$user['id']))->update('user', array("is_statement_read"=>0));

			if ($res) {
			
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/statement");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '編輯政策及條款 ';
			$this->data['parent'] = '會員管理';
			$this->data['parent_link'] = base_url()."mgr/user";
			$this->data['action'] = base_url()."mgr/statement/edit/".$oridata['id'];
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
		
						
		$canbe_search_field = ["F.user_id","F.driver_id ","F.nickname"];

		// $syntax = "P.is_delete = 0";
        $syntax = "I.is_delete=0";
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
		
		$total = $this->db->from($this->statement." I")
			//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
			->where($syntax)
			->get()->num_rows();
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "I.id DESC";
        if ($order_column[$order] != "") {
            $order_by = "P.".$order_column[$order]." ".$direction.", ".$order_by;
        }
         
		$list = $this->db->select("I.*")
						 ->from($this->statement." I")
						//  ->join($this->faq_classify_table." S", "S.id = P.classify", "left")
						// ->join($this->user." U", "U.id = N.user_id", "left") 
                        ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();

		$total_num = $this->db->get_where($this->user)->num_rows();

        // print_r($list);exit;
		//文章管理總覽
		$html = "";
		foreach ($list as $item) {
            // var_dump($item);
            
			$html .= $this->load->view("mgr/items/statement_item", array(
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



