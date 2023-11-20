<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");

class Order extends Base_Controller {
	private $th_title = [ "行程編號", "日期","顧客資訊", "行程資訊","狀態","駕駛人", "訂單建立者", "建立時間"]; //, "置頂"
	private $th_width = ["", "100px", "", "", "","","",""];
	private $order_column = ["id", "sort","", "","", "","","create_date", ""]; //, "is_head"
	private $can_order_fields = [];



	public function __construct(){
		parent::__construct();	
		$this->is_mgr_login();
		$this->data['active'] = "ORDER";
		
	}

	public function index(){
		$this->data['excel_export'] = true;
		$this->data['excel_title'] = '匯出行程總覽';
		$this->data['export_url'] = "mgr/order/export_order";
		$this->data['action'] = base_url() . "mgr/order/";
		$this->data['title'] = '行程總覽';
		$this->data['action'] = base_url()."mgr/order/";
		$this->data['th_title'] = $this->th_title;
		$this->data['th_width'] = $this->th_width;
		$this->data['can_order_fields'] = $this->can_order_fields;
		$this->data['tool_btns'] = [
			// ['新增文章', base_url()."mgr/product/add", "btn-primary"]
		];
		$this->data['default_order_column'] = 0;
		$this->data['default_order_direction'] = 'DESC';
		$this->load->view('mgr/template_list', $this->data);
	}

	public function del(){

		$id = $this->input->post("id");
		if (is_numeric($id)) {
			if($this->db->where(array("id"=>$id))->update($this->order, array("is_delete"=>1))){
				$this->output(TRUE, "success");

			}else{
				$this->output(FALSE, "fail");
			}
		}else{
			$this->output(FALSE, "fail");
		}
	}

	public function edit($id){
		if (!is_numeric($id)) show_404();
		
		$oridata = $this->db->where(array("id"=>$id))->get($this->order)->row_array();

		$param = [
								["姓名", "username", "plain", $oridata['username']],
								["手機", "phone", "plain", $oridata['phone']],
								["email", "email", "plain", $oridata['email']],
								["地址", "", "plain", $oridata['city_str']. $oridata['dist_str'].$oridata['addr']],				
								["訂單編號", "order_no", "plain", $oridata['order_no']],
								["訂單內容", "products_str", "plain", $oridata['products_str']],																							
								["付款方式", "payment", "select", $oridata['payment'], ["id","payment"]],
								["運送方式", "delivery", "select", $oridata['delivery'], ["id","delivery"]],
								["狀態", "status", "select", $oridata['status'], ["id","status"]],
								["是否出貨", "is_delivery", "select", $oridata['is_delivery'], ["id", "is_delivery"]],
								["訂單日期", "create_date", "plain", $oridata['create_date']]
						];
						

		if ($_POST) {
			
			$data = array();
			foreach ($param as $item) {
				$data[$item[1]] = $this->input->post($item[1]);	
			}

			$save = array(
				'is_delivery' => $data['is_delivery'],
				'payment' => $data['payment'],
				'status' => $data['status']
			);

			$res = $this->db->where(array("id"=>$id))->update($this->order, $save);

			if ($res) {
				$this->js_output_and_redirect("編輯成功", base_url()."mgr/bill");
			}else{
				$this->js_output_and_back("發生錯誤");
			}
		}else{
			//僅讀取edit頁面
			$this->data['title'] = '行程總覽：'.$oridata['order_no'];
			$this->data['parent'] = '行程總覽';
			$this->data['parent_link'] = base_url()."mgr/bill";
			$this->data['action'] = base_url()."mgr/order/edit/".$oridata['id'];
			$this->data['submit_txt'] = "確認編輯";


		//付款方式選項列表
			$this->data['select']['payment'] = 
			array(
				0=>array(
					'id'=>'credit',
					'payment'=>'信用卡'),
				1=>array(
					'id'=>'atm',
					'payment'=>"銀行轉帳")
			);

			//付款方式選項列表
			$this->data['select']['is_delivery'] =
			array(
				0 => array(
					'id' => 0,
					'is_delivery' => '未出貨'
				),
				1 => array(
					'id' => 1,
					'is_delivery' => "已出貨"
				)
			);	

		//付款方式選項列表
			$this->data['select']['delivery'] = 
			array(
				0=>array(
					'id'=>'custom',
					'delivery'=>'與客服聯絡'),
				1=>array(
					'id'=>'home',
					'delivery'=>"宅配"),					
			);


			//報名狀態選項列表
			$this->data['select']['status'] = 
			array(
				0=>array(
					'id'=>'paid',
					'status'=>'已付款'),
				1=>array(
					'id'=>'pending',
					'status'=>"處理中"),
				2=>array(
					'id'=>'cancel',
					'status'=>"取消"),
				3=>array(
					'id'=>'delete',
					'status'=>"刪除")				
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
		$eventsearch      = ($this->input->post("eventsearch"))?$this->input->post("eventsearch"):"";
	
		// $eventsearch      = $this->input->post("eventsearch");

		$order_column = $this->order_column;

		// print_r($search);
		// exit;
		
						
		$canbe_search_field = ["O.username","O.order_no","O.email"];

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
						//  ->join($this->recommend." C", "C.code = P.recommend", "left")
						 ->where($syntax)->get()->num_rows();

						 
		$total_page = ($total % $this->page_count == 0) ? floor(($total)/$this->page_count) : floor(($total)/$this->page_count) + 1;

		$order_by = "O.create_date DESC";
        if ($order_column[$order] != "") {
            $order_by = "O.".$order_column[$order]." ".$direction.", ".$order_by;
				}
				
		$list = $this->db->select("O.*,U.username as driver_name,UU.username as owner")
						 ->from($this->order." O")
						 ->join($this->user." U", "U.id = O.order_driver", "left")
						->join($this->user . " UU", "UU.id = O.order_owner", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						 ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();



		$total_num = $this->db->get_where($this->order, array("is_delete"=>0))->num_rows();

		//報名者總覽
		$html = "";
		foreach ($list as $item) {
			$html .= $this->load->view("mgr/items/order_item.php", array(
				"item"  =>	$item,
				"total" =>	$total_num
			), TRUE);
		}
		if ($search != "") $html = preg_replace('/'.$search.'/i', '<mark data-markjs="true">'.$search.'</mark>', $html);
		
		if ($eventsearch != "") $html = preg_replace('/'.$eventsearch.'/i', '<mark data-markjs="true">'.$eventsearch.'</mark>', $html);

		$this->output(TRUE, "成功", array(
			"html"       =>	$html,
			"page"       =>	$page,
			"total_page" =>	$total_page,
			"list"       =>	$list
		));
	}
	public function export_order(){
		$this->load->model("Export_model");
		$this->load->model("Order_model");
		// $user = $this->check_user_token();
		
        // $user = $this->db->get_where("user", array('is_delete'=>0,'is_verify'=>1))->result_array();
		$order_by = "O.create_date DESC";
		$syntax = "O.is_delete = 0";
				
		$list = $this->db->select("O.*,U.username as driver_name,UU.username as owner")
						 ->from($this->order." O")
						 ->join($this->user." U", "U.id = O.order_driver", "left")
						->join($this->user . " UU", "UU.id = O.order_owner", "left")
						 ->where($syntax)
						 ->order_by($order_by)
						//  ->limit($this->page_count, ($page-1)*$this->page_count)
						 ->get()->result_array();
        $value_array = array();

		// print_r($list);exit;


		// $list=$this->Order_model->get_manage_record();
		// print_r($list);exit;

		// print_r($list);exit;
        $index = 1;
        foreach ($list as $item) {
			$order_log=$this->Order_model->get_order_log($item['order_no']);
			// print_r($order_log);exit;
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
	                'D' =>  $item['start_city'] . $item['start_dist'] . $item['start_addr'],
					'E' =>  $item['name'],
					'F' =>  $item['phone'],
					'G' =>  $item['flight'],
	                'H' =>  $item['number'],
	                'I' =>  $item['baggage'],
					'J' =>  $item['remark'],
	                'K' =>  $item['car_model'],
					'L' =>  $item['owner'],
	                'M' =>  $item['driver_name'],
	                'N' =>  $item['price'],
	                'O' =>  ($item['final_status']==0)? $item['final_payment']:"",
					'P' => ($item['final_status']==1)? $item['final_payment']:"",
					'Q' =>  (isset($arrive_time) )? $arrive_time:"",
					'R' =>  (isset($start_time) )? 	$start_time:"",
					'S' =>  (isset($end_time) )?	$end_time:"",
					'T' =>   (isset($item['address_end'][0]))? $item['address_end'][0]:"",
					'U' =>   (isset($item['address_end'][1]))? $item['address_end'][1]:"",
					'V' =>   (isset($item['address_end'][2]))? $item['address_end'][2]:"",
					'W' =>   (isset($item['address_end'][3]))? $item['address_end'][3]:"",
					'X' =>   (isset($item['address_end'][4]))? $item['address_end'][4]:"",
					'Y' =>   (isset($item['address_end'][5]))? $item['address_end'][5]:"",
					'Z' =>   (isset($item['address_end'][6]))? $item['address_end'][6]:"",
					'AA' =>   (isset($item['address_end'][7]))? $item['address_end'][7]:"",
					'AB' =>   (isset($item['address_end'][8]))? $item['address_end'][8]:"",

	                // 'N' =>  $this->Transtext_model->get_user_privilege_str($item['privilege']) . ($is_new ? '(新客戶)' : '(舊客戶)' ),
	                // 'O' =>  $this->Transtext_model->get_user_status_str($item['status']),
	                // 'P' =>  $item['register_date'],
	            )
            );
            $index++;
        }
		
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
			'L'	=>	"派遣人名稱",
            'M' =>  "駕駛名稱",
            'N' =>  "車資",
            'O' =>  "回金",
			'P' =>  "補貼",
            'Q' =>  "抵達起點時間",
            'R' =>  "開始行程時間",
            'S' =>  "行程結束時間",
			'T' =>  "目的地(一)",
            'U' =>  "目的地(二)",
			'V' =>  "目的地(三)",
			'W' =>  "目的地(四)",
            'X' =>  "目的地(五)",
			'Y' =>  "目的地(六)",
			'Z' =>  "目的地(七)",
            'AA' =>  "目的地(八)",
			'AB' =>  "目的地(九)",
        );
		// exit;
    	echo $this->Export_model->template_all_order('OrderData',$index_array,$value_array);
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
		$sheet->getColumnDimension($x)->setWidth(30);
		$sheet->setCellValue($x . $y, '訂單編號');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '姓名');

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
		$sheet->getColumnDimension($x)->setWidth(30);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '訂單日期');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '運送方式');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '付款方式');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->getColumnDimension($x)->setWidth(40);
		$sheet->setCellValue($x . $y, '訂購商品');
		
		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '總金額');


		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '付款狀態');

		$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
		$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($x . $y)->applyFromArray($border_style);
		$sheet->setCellValue($x . $y, '運送狀態');



		$list = $this->db->select("O.*")
			->from($this->order . " O")		
			->where("O.is_delete=0")			
			->get()->result_array();

		foreach ($list as  $value) {
			$x = 'A';
			$y++;
			
			$sheet->getStyle($x . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $value['order_no'].' ');

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $value['username']);

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->getColumnDimension($x)->setWidth(35);
			$sheet->setCellValue($x . $y, $value['email']);

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->getColumnDimension($x)->setWidth(20);
			$sheet->setCellValue($x . $y, $value['phone']);

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
			$sheet->getColumnDimension($x)->setWidth(30);
			$sheet->setCellValue($x . $y, $value['addr']);

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $value['create_date']);

			if ($value['delivery'] == 'custom') {
				$delivery = '與客服聯絡';
			} else {
				$delivery = '宅配';
			}

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $delivery);


			if ($value['payment'] == 'credit') {
				$payment = '信用卡';
			} else {
				$payment = '';
			}

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $payment);
			$products_str = '';
			if ($value['products_str'] != ' ') {
				$product  =  mb_split('<br>',$value['products_str']);
				foreach($product as $p){
					$products_str .= $p." ";
				}
			}

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $products_str);

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $value['amount']);

			if ($value['status'] == 'paid') {
				$status = '已付款';
			} else if ($value['status'] == 'pending') {
				$status = '處理中';
			}

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $status);

			if ($value['is_delivery'] == 0) {
				$is_delivery = '未出貨';
			} else {
				$is_delivery = '已出貨';
			}

			$sheet->getStyle($x++ . $y)->getAlignment()->setWrapText(true);
			$sheet->getStyle($x . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($x . $y)->applyFromArray($border_style);
			$sheet->setCellValue($x . $y, $is_delivery);



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
