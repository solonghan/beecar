<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal_model extends Base_Model {
    
	public function __construct() {
        
    }
    // paypal身分驗證 取得token
    public function verify(){
         // 设置你的 PayPal 客户端 ID 和 Secret
        $clientId = 'AVnFkH9hnRcIBoQraxgRi2oqrOTtpcAtKl8wtIiffrvBgQ97u4sEJdvfsCBOmGvlUO6a_0i4upYzh_0h';
        $clientSecret = 'EGJwp69Uz1o3M0-q1-7TA0amY7cWMiU9ORIV44Z6DZF2ONOb4IqBwr8RFRRSIpLBHvs50VMpQ5F5ZUWL';
        $api = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
        
        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode("$clientId:$clientSecret"),
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行 cURL 请求
        $response = curl_exec($ch);

        // 取得資訊
        $info = curl_getinfo($ch);

        // 取得狀態碼
        $http_code = $info["http_code"];

        if ($http_code !== 200) {
            throw new Exception('驗證身分失敗');
        }
        // print_r($response);exit;
        return json_decode($response, true);


    }
    public function create_order($data){
         // 取的驗證token
		$res=$this->verify();
		// 使用 PayPal API 會用來驗證身分
		$accessToken = $res['access_token'];

        // 设置 PayPal API 端点和路径
        $apiEndpoint = 'https://api-m.sandbox.paypal.com'; // 沙盒环境
        // $apiEndpoint = 'https://api-m.paypal.com'; // 生产环境
        $apiPath = '/v2/checkout/orders';

        $currency_code=$data['currency_code'];
        $value=$data['value'];
        // 构建请求数据
        $data = [
            'intent' => 'CAPTURE', // 商家希望在客戶付款後立即取得付款。
            'purchase_units' => [
                [
                    // 'reference_id' => 'ABC123456789',//自訂參考ID (看需要可用)
                    'amount' => [
                        'currency_code' => $currency_code,
                        'value' => $value,
                    ],
                    
                ],
            ],
            " payment_source"=> [ 
                "paypal"=> [
                  "experience_context"=> [ 
                    //付款方式偏好
                    'payment_method_preference' =>'IMMEDIATE_PAYMENT_REQUIRED',     // 僅接受客戶的立即付款
                    "brand_name"=> "EXAMPLE INC",
                    "locale"=>"en-US",
                    "landing_page"=>"GUEST_CHECKOUT",
                    "shipping_preference"=> "SET_PROVIDED_ADDRESS",             // 取得商家提供的位址
                    "user_action"=>"PAY_NOW",                                   // 立即付款
                    "return_url"=>"https://anbon.vip/beecar/api/paypal_success", // 用於指定交易成功後，用戶將被重定向到的URL。通常用於顯示感謝頁面或進行其他交易完成後的操作。
                    "cancel_url"=>"https://anbon.vip/beecar/api/paypal_cancel"  // 用於指定用戶取消或失敗交易後，將被重定向到的URL
                    
                  ]
                ]
            ]
        ];

        // print_r($data);exit;

        // 转换数据为 JSON 格式
        $jsonData = json_encode($data);
        // print_R($jsonData);exit;

        // 构建 cURL 请求
        $ch = curl_init("$apiEndpoint$apiPath");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken 
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行 cURL 请求
        $response = curl_exec($ch);
        

        // 处理响应
        if ($response === false) {
            die('Error occurred during curl execution: ' . curl_error($ch));
        }
        $responseData = json_decode($response, true);
        curl_close($ch);

        // echo $response;exit;

        // 处理支付响应
        if (isset($responseData['id'])) {
            // 支付创建成功，重定向用户到支付链接
            // $approvalLink = $responseData['links'][1]['href'];
            $res=$this->confirm_order($responseData['id']);

            return $res;
            exit;
            // header("Location: $approvalLink");
        } else {
            // 处理错误
            die('Payment creation failed: ' . print_r($responseData, true));
        }

    }
    // 付款人(授權)確認訂單
    public function confirm_order($order_no){
 
         // 取的驗證token
		$res=$this->verify();
		// 使用 PayPal API 會用來驗證身分
		$accessToken = $res['access_token'];
		
		// $order_no  = $this->input->post('order_no');
		// POST https://api-m.sandbox.paypal.com/v2/checkout/orders/1MR28683PH790642H/confirm-payment-source
		$apiEndpoint = 'https://api-m.sandbox.paypal.com'; // 沙盒环境
        // $apiEndpoint = 'https://api-m.paypal.com'; // 生产环境
        $apiPath = '/v2/checkout/orders/'.$order_no.'/confirm-payment-source'; 

		$data = [
            'intent' => 'CAPTURE', // 商家希望在客戶付款後立即取得付款。
            'payment_source' => [
               
                    'paypal' => [
                        'name' => [
							'given_name' =>'Johb',//名
							'surname' =>'Doe',   //姓
						],
						'email_address' => 'customer@example.com',//PayPal 帳戶持有人的電子郵件地址
							
						'experience_context' => [
							'payment_method_preference' =>'IMMEDIATE_PAYMENT_REQUIRED',     // 僅接受客戶的立即付款
							'brand_name' =>'EXAMPLE INC',
							'locale' =>'en-US',
							'landing_page' =>'LOGIN',                                       // 重定向到登入 PayPal 並批准付款的頁面
							'shipping_preference' =>'SET_PROVIDED_ADDRESS',                 // 取得商家提供的位址
							'user_action' =>'PAY_NOW',                                      // 立即付款
							"return_url"=>"https://anbon.vip/beecar/api/paypal_success",    // 用於指定交易成功後，用戶將被重定向到的URL。通常用於顯示感謝頁面或進行其他交易完成後的操作。
                            "cancel_url"=>"https://anbon.vip/beecar/api/paypal_cancel",     // 用於指定用戶取消或失敗交易後，將被重定向到的URL
						],
                    ],
               
            ],

		];

		 // 转换数据为 JSON 格式
		 $jsonData = json_encode($data);


		$ch = curl_init("$apiEndpoint$apiPath");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken ,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 // 执行 cURL 请求
		 $response = curl_exec($ch);
		//  print_r($response);exit;
         // 处理响应
        if ($response === false) {
            die('Error occurred during curl execution: ' . curl_error($ch));
        }
        $responseData = json_decode($response, true);
        curl_close($ch);

        // echo $response;exit;


        // 处理支付响应
        if (isset($responseData['id'])) {
            // 支付创建成功，重定向用户到支付链接
            $approvalLink = $responseData['links'][1]['href'];
            // echo $approvalLink;exit;
            return $approvalLink;
            exit;
            // header("Location: $approvalLink");
        } else {
            // 处理错误
            die('Payment creation failed!!!: ' . print_r($responseData, true));
        }
	}
    //捕獲訂單付款 
    public function capture_order($order_no){
         // 取的驗證token
		$res=$this->verify();
		// 使用 PayPal API 會用來驗證身分
		$accessToken = $res['access_token'];
		
		$apiEndpoint = 'https://api-m.sandbox.paypal.com'; // 沙盒环境
        // $apiEndpoint = 'https://api-m.paypal.com'; // 生产环境
        $apiPath = '/v2/checkout/orders/'.$order_no.'/capture'; 


        // 构建 cURL 请求
        $ch = curl_init("$apiEndpoint$apiPath");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken ,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行 cURL 请求
        $response = curl_exec($ch);
     
        // 处理响应
        if ($response === false) {
            die('Error occurred during curl execution: ' . curl_error($ch));
        }
        $responseData = json_decode($response, true);
        curl_close($ch);

        // 处理支付响应
        if (isset($responseData['id'])) {
            $this->update_order($responseData['id']);
            exit;
            // header("Location: $finishLink");
        } else {
            // 处理错误
            die('Payment creation failed!!!: ' . print_r($responseData, true));
        }
	}

    //更新訂單
    public function update_order($order_no){
        // 取的驗證token
        $res=$this->verify();
        // 使用 PayPal API 會用來驗證身分
        $accessToken = $res['access_token'];
        
        $apiEndpoint = 'https://api-m.sandbox.paypal.com'; // 沙盒环境
        // $apiEndpoint = 'https://api-m.paypal.com'; // 生产环境
        $apiPath = '/v2/checkout/orders/'.$order_no; 


        // 构建 cURL 请求
        $ch = curl_init("$apiEndpoint$apiPath");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken ,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行 cURL 请求
        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
        curl_close($ch);
        echo $response;exit;
        // 处理支付响应
        if (isset($responseData['id'])) {
          // 導向自訂網頁
            $finishLink="https://www.google.com/";
            header("Location: $finishLink");
           
        } else {
            // 处理错误
            die('Payment  failed!!!: ' . print_r($responseData, true));
        }
        

     }

     
}