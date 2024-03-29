<?php defined('BASEPATH') OR exit('No direct script access allowed');


class  Base_Model  extends  CI_Model  {
    protected $user_table           = "user";
    protected $address_table        = "user_address";
    protected $car_info_table       = "car_info";
    protected $driver_info_table    = "driver_info";
    protected $notification_table   = "notification";
    
    protected $free_order_driver = 'free_order_driver';
    protected $order_addr_table = "order_addr";
    protected $order_table      = "order";
    protected $order_log_table  = "order_log";

    protected $super_filter_table = "super_filter";

    protected $group_table          = "groups";
    protected $group_driver_table   = "group_driver";
    protected $friends_table        = "friends";
    protected $blacklist_table      = "black_list";

    protected $token_table      = "fcm_token";
    protected $fcm_table        = "fcm_log";
    protected $priv_menu_table  = "privilege_menu";
    protected $priv_table       = "privilege";
    protected $member_table     = "member";
    protected $fcm_key      ='AAAAU3NWQXE:APA91bHGon_akr5JAGiLyn3KBOBjf1Ub-vRzpH60hSrvM2MbxO8ms3z90zMJ1DpRLmGc0zuN8TrfFPF7McB0PcLlPzErVvS5Evon7wSpa_aILZt9vAH7MNQm9hcZ3Xgm566Gf8BTii5x';



	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Taipei");
		
	}

    //firebase發送
    public function send_push($fcm_token, $message, $data = false)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $title = "beecar";

        $content = array(
            'title'    => $title,
            'body'     => $message,
            // "data"=> array(
            //     "click_action"=> "https://www.google.com/"
            // )
            // 'click_action'=> 'https://www.google.com/'
        );

        $data=array(
           'type'  =>  'my_trip',
            "url"=> "https://www.google.com/"
        );
        // $data=array(
        //     'gcm'=>array(
        //         "notification"=>array(
        //             'type'  =>  'text',
        //             "url"=> "https://www.google.com/"
        //         )
        //     )
        // );

        // print_r($data);exit;

       
        // $data = array(
        //     'type'  =>  $type,
        //     'url'   =>  $url,
        //     'id'    =>  0
        // );
        
        // if ($data !== FALSE) {
        //     $content = array_merge($content, $data);
        // } 

        $fields = array(
            'to'              => $fcm_token,
            'notification'    => $content,
            'data'            => $data
        );

        $headers = array(
            'Authorization: key='.$this->fcm_key,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        $result = json_decode($result, true);

        if ($result['success']) {
            return true;
        } else {
            return false;
        }        
    }

    protected function custom_encrypt($string,$operation,$key='KeyyE'){
        $replcae_str = "_Sl.";
        if($operation=='D'){
            $string = str_replace($replcae_str, "/", $string);
        }
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++){
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D'){
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
                return substr($result,8);
            }else{
                return'';
            }
        }else{
            $encryt_str = str_replace('=','',base64_encode($result));
            $encryt_str = str_replace("/", $replcae_str, $encryt_str);
            return $encryt_str;
        }
    }

    protected function get_zipcode()
    {
        return json_decode('{"city":[{"dist":[{"name":"中正區","c3":"100"},{"name":"大同區","c3":"103"},{"name":"中山區","c3":"104"},{"name":"松山區","c3":"105"},{"name":"大安區","c3":"106"},{"name":"萬華區","c3":"108"},{"name":"信義區","c3":"110"},{"name":"士林區","c3":"111"},{"name":"北投區","c3":"112"},{"name":"內湖區","c3":"114"},{"name":"南港區","c3":"115"},{"name":"文山區","c3":"116"}],"name":"台北市"},{"dist":[{"name":"仁愛區","c3":"200"},{"name":"信義區","c3":"201"},{"name":"中正區","c3":"202"},{"name":"中山區","c3":"203"},{"name":"安樂區","c3":"204"},{"name":"暖暖區","c3":"205"},{"name":"七堵區","c3":"206"}],"name":"基隆市"},{"dist":[{"name":"萬里區","c3":"207"},{"name":"金山區","c3":"208"},{"name":"板橋區","c3":"220"},{"name":"汐止區","c3":"221"},{"name":"深坑區","c3":"222"},{"name":"石碇區","c3":"223"},{"name":"瑞芳區","c3":"224"},{"name":"平溪區","c3":"226"},{"name":"雙溪區","c3":"227"},{"name":"貢寮區","c3":"228"},{"name":"新店區","c3":"231"},{"name":"坪林區","c3":"232"},{"name":"烏來區","c3":"233"},{"name":"永和區","c3":"234"},{"name":"中和區","c3":"235"},{"name":"土城區","c3":"236"},{"name":"三峽區","c3":"237"},{"name":"樹林區","c3":"238"},{"name":"鶯歌區","c3":"239"},{"name":"三重區","c3":"241"},{"name":"新莊區","c3":"242"},{"name":"泰山區","c3":"243"},{"name":"林口區","c3":"244"},{"name":"蘆洲區","c3":"247"},{"name":"五股區","c3":"248"},{"name":"八里區","c3":"249"},{"name":"淡水區","c3":"251"},{"name":"三芝區","c3":"252"},{"name":"石門區","c3":"253"}],"name":"新北市"},{"dist":[{"name":"中壢區","c3":"320"},{"name":"平鎮區","c3":"324"},{"name":"龍潭區","c3":"325"},{"name":"楊梅區","c3":"326"},{"name":"新屋區","c3":"327"},{"name":"觀音區","c3":"328"},{"name":"桃園區","c3":"330"},{"name":"龜山區","c3":"333"},{"name":"八德區","c3":"334"},{"name":"大溪區","c3":"335"},{"name":"復興區","c3":"336"},{"name":"大園區","c3":"337"},{"name":"蘆竹區","c3":"338"}],"name":"桃園市"},{"dist":[{"name":"新竹市","c3":"300"}],"name":"新竹市"},{"dist":[{"name":"竹北市","c3":"302"},{"name":"湖口鄉","c3":"303"},{"name":"新豐鄉","c3":"304"},{"name":"新埔鎮","c3":"305"},{"name":"關西鎮","c3":"306"},{"name":"芎林鄉","c3":"307"},{"name":"寶山鄉","c3":"308"},{"name":"竹東鎮","c3":"310"},{"name":"五峰鄉","c3":"311"},{"name":"橫山鄉","c3":"312"},{"name":"尖石鄉","c3":"313"},{"name":"北埔鄉","c3":"314"},{"name":"峨眉鄉","c3":"315"}],"name":"新竹縣"},{"dist":[{"name":"竹南鎮","c3":"350"},{"name":"頭份鎮","c3":"351"},{"name":"三灣鄉","c3":"352"},{"name":"南庄鄉","c3":"353"},{"name":"獅潭鄉","c3":"354"},{"name":"後龍鎮","c3":"356"},{"name":"通霄鎮","c3":"357"},{"name":"苑裡鎮","c3":"358"},{"name":"苗栗市","c3":"360"},{"name":"造橋鄉","c3":"361"},{"name":"頭屋鄉","c3":"362"},{"name":"公館鄉","c3":"363"},{"name":"大湖鄉","c3":"364"},{"name":"泰安鄉","c3":"365"},{"name":"銅鑼鄉","c3":"366"},{"name":"三義鄉","c3":"367"},{"name":"西湖鄉","c3":"368"},{"name":"卓蘭鎮","c3":"369"}],"name":"苗栗縣"},{"dist":[{"name":"中區","c3":"400"},{"name":"東區","c3":"401"},{"name":"南區","c3":"402"},{"name":"西區","c3":"403"},{"name":"北區","c3":"404"},{"name":"北屯區","c3":"406"},{"name":"西屯區","c3":"407"},{"name":"南屯區","c3":"408"},{"name":"太平區","c3":"411"},{"name":"大里區","c3":"412"},{"name":"霧峰區","c3":"413"},{"name":"烏日區","c3":"414"},{"name":"豐原區","c3":"420"},{"name":"后里區","c3":"421"},{"name":"石岡區","c3":"422"},{"name":"東勢區","c3":"423"},{"name":"和平區","c3":"424"},{"name":"新社區","c3":"426"},{"name":"潭子區","c3":"427"},{"name":"大雅區","c3":"428"},{"name":"神岡區","c3":"429"},{"name":"大肚區","c3":"432"},{"name":"沙鹿區","c3":"433"},{"name":"龍井區","c3":"434"},{"name":"梧棲區","c3":"435"},{"name":"清水區","c3":"436"},{"name":"大甲區","c3":"437"},{"name":"外埔區","c3":"438"},{"name":"大安區","c3":"439"}],"name":"台中市"},{"dist":[{"name":"彰化市","c3":"500"},{"name":"芬園鄉","c3":"502"},{"name":"花壇鄉","c3":"503"},{"name":"秀水鄉","c3":"504"},{"name":"鹿港鎮","c3":"505"},{"name":"福興鄉","c3":"506"},{"name":"線西鄉","c3":"507"},{"name":"和美鄉","c3":"508"},{"name":"伸港鄉","c3":"509"},{"name":"員林鎮","c3":"510"},{"name":"社頭鄉","c3":"511"},{"name":"永靖鄉","c3":"512"},{"name":"埔心鄉","c3":"513"},{"name":"溪湖鎮","c3":"514"},{"name":"大村鄉","c3":"515"},{"name":"埔鹽鄉","c3":"516"},{"name":"田中鎮","c3":"520"},{"name":"北斗鎮","c3":"521"},{"name":"田尾鄉","c3":"522"},{"name":"埤頭鄉","c3":"523"},{"name":"溪州鄉","c3":"524"},{"name":"竹塘鄉","c3":"525"},{"name":"二林鎮","c3":"526"},{"name":"大城鄉","c3":"527"},{"name":"芳苑鄉","c3":"528"},{"name":"二水鄉","c3":"530"}],"name":"彰化縣"},{"dist":[{"name":"南投市","c3":"540"},{"name":"中寮鄉","c3":"541"},{"name":"草屯鎮","c3":"542"},{"name":"國姓鄉","c3":"544"},{"name":"埔里鎮","c3":"545"},{"name":"仁愛鄉","c3":"546"},{"name":"名間鄉","c3":"551"},{"name":"集集鎮","c3":"552"},{"name":"水里鄉","c3":"553"},{"name":"魚池鄉","c3":"555"},{"name":"信義鄉","c3":"556"},{"name":"竹山鎮","c3":"557"},{"name":"鹿谷鄉","c3":"558"}],"name":"南投縣"},{"dist":[{"name":"斗南鎮","c3":"630"},{"name":"大埤鄉","c3":"631"},{"name":"虎尾鎮","c3":"632"},{"name":"土庫鎮","c3":"633"},{"name":"褒忠鄉","c3":"634"},{"name":"東勢鄉","c3":"635"},{"name":"台西鄉","c3":"636"},{"name":"崙背鄉","c3":"637"},{"name":"麥寮鄉","c3":"638"},{"name":"斗六市","c3":"640"},{"name":"林內鄉","c3":"643"},{"name":"古坑鄉","c3":"646"},{"name":"莿桐鄉","c3":"647"},{"name":"西螺鎮","c3":"648"},{"name":"二崙鄉","c3":"649"},{"name":"北港鎮","c3":"651"},{"name":"水林鄉","c3":"652"},{"name":"口湖鄉","c3":"653"},{"name":"四湖鄉","c3":"654"},{"name":"元長鄉","c3":"655"}],"name":"雲林縣"},{"dist":[{"name":"嘉義市","c3":"600"}],"name":"嘉義市"},{"dist":[{"name":"番路鄉","c3":"602"},{"name":"梅山鄉","c3":"603"},{"name":"竹崎鄉","c3":"604"},{"name":"阿里山","c3":"605"},{"name":"中埔鄉","c3":"606"},{"name":"大埔鄉","c3":"607"},{"name":"水上鄉","c3":"608"},{"name":"鹿草鄉","c3":"611"},{"name":"太保鄉","c3":"612"},{"name":"朴子市","c3":"613"},{"name":"東石鄉","c3":"614"},{"name":"六腳鄉","c3":"615"},{"name":"新港鄉","c3":"616"},{"name":"民雄鄉","c3":"621"},{"name":"大林鎮","c3":"622"},{"name":"溪口鄉","c3":"623"},{"name":"義竹鄉","c3":"624"},{"name":"布袋鄉","c3":"625"}],"name":"嘉義縣"},{"dist":[{"name":"中西區","c3":"700"},{"name":"東區","c3":"701"},{"name":"南區","c3":"702"},{"name":"北區","c3":"704"},{"name":"安平區","c3":"708"},{"name":"安南區","c3":"709"},{"name":"永康區","c3":"710"},{"name":"歸仁區","c3":"711"},{"name":"新化區","c3":"712"},{"name":"左鎮區","c3":"713"},{"name":"玉井區","c3":"714"},{"name":"楠西區","c3":"715"},{"name":"南化區","c3":"716"},{"name":"仁德區","c3":"717"},{"name":"關廟區","c3":"718"},{"name":"龍崎區","c3":"719"},{"name":"官田區","c3":"720"},{"name":"麻豆區","c3":"721"},{"name":"佳里區","c3":"722"},{"name":"西港區","c3":"723"},{"name":"七股區","c3":"724"},{"name":"將軍區","c3":"725"},{"name":"學甲區","c3":"726"},{"name":"北門區","c3":"727"},{"name":"新營區","c3":"730"},{"name":"後壁區","c3":"731"},{"name":"白河區","c3":"732"},{"name":"東山區","c3":"733"},{"name":"六甲區","c3":"734"},{"name":"下營區","c3":"735"},{"name":"柳營區","c3":"736"},{"name":"鹽水區","c3":"737"},{"name":"善化區","c3":"741"},{"name":"大內區","c3":"742"},{"name":"山上區","c3":"743"},{"name":"新市區","c3":"744"},{"name":"安定區","c3":"745"}],"name":"台南市"},{"dist":[{"name":"新興區","c3":"800"},{"name":"前金區","c3":"801"},{"name":"苓雅區","c3":"802"},{"name":"鹽埕區","c3":"803"},{"name":"鼓山區","c3":"804"},{"name":"旗津區","c3":"805"},{"name":"前鎮區","c3":"806"},{"name":"三民區","c3":"807"},{"name":"楠梓區","c3":"811"},{"name":"小港區","c3":"812"},{"name":"左營區","c3":"813"},{"name":"仁武區","c3":"814"},{"name":"大社區","c3":"815"},{"name":"岡山區","c3":"820"},{"name":"路竹區","c3":"821"},{"name":"阿蓮區","c3":"822"},{"name":"田寮區","c3":"823"},{"name":"燕巢區","c3":"824"},{"name":"橋頭區","c3":"825"},{"name":"梓官區","c3":"826"},{"name":"彌陀區","c3":"827"},{"name":"永安區","c3":"828"},{"name":"湖內區","c3":"829"},{"name":"鳳山區","c3":"830"},{"name":"大寮區","c3":"831"},{"name":"林園區","c3":"832"},{"name":"鳥松區","c3":"833"},{"name":"大樹區","c3":"840"},{"name":"旗山區","c3":"842"},{"name":"美濃區","c3":"843"},{"name":"六龜區","c3":"844"},{"name":"內門區","c3":"845"},{"name":"杉林區","c3":"846"},{"name":"甲仙區","c3":"847"},{"name":"桃源區","c3":"848"},{"name":"那瑪夏區","c3":"849"},{"name":"茂林區","c3":"851"},{"name":"茄萣區","c3":"852"},{"name":"東沙","c3":"817"},{"name":"南沙","c3":"819"}],"name":"高雄市"},{"dist":[{"name":"屏東市","c3":"900"},{"name":"三地鄉","c3":"901"},{"name":"霧台鄉","c3":"902"},{"name":"瑪家鄉","c3":"903"},{"name":"九如鄉","c3":"904"},{"name":"里港鄉","c3":"905"},{"name":"高樹鄉","c3":"906"},{"name":"鹽埔鄉","c3":"907"},{"name":"長治鄉","c3":"908"},{"name":"麟洛鄉","c3":"909"},{"name":"竹田鄉","c3":"911"},{"name":"內埔鄉","c3":"912"},{"name":"萬丹鄉","c3":"913"},{"name":"潮州鎮","c3":"920"},{"name":"泰武鄉","c3":"921"},{"name":"來義鄉","c3":"922"},{"name":"萬巒鄉","c3":"923"},{"name":"崁頂鄉","c3":"924"},{"name":"新埤鄉","c3":"925"},{"name":"南州鄉","c3":"926"},{"name":"林邊鄉","c3":"927"},{"name":"東港鄉","c3":"928"},{"name":"琉球鄉","c3":"929"},{"name":"佳冬鄉","c3":"931"},{"name":"新園鄉","c3":"932"},{"name":"枋寮鄉","c3":"940"},{"name":"枋山鄉","c3":"941"},{"name":"春日鄉","c3":"942"},{"name":"獅子鄉","c3":"943"},{"name":"車城鄉","c3":"944"},{"name":"牡丹鄉","c3":"945"},{"name":"恆春鎮","c3":"946"},{"name":"滿洲鄉","c3":"947"}],"name":"屏東縣"},{"dist":[{"name":"台東市","c3":"950"},{"name":"綠島鄉","c3":"951"},{"name":"蘭嶼鄉","c3":"952"},{"name":"延平鄉","c3":"953"},{"name":"卑南鄉","c3":"954"},{"name":"鹿野鄉","c3":"955"},{"name":"關山鎮","c3":"956"},{"name":"海端鄉","c3":"957"},{"name":"池上鄉","c3":"958"},{"name":"東河鄉","c3":"959"},{"name":"成功鎮","c3":"961"},{"name":"長濱鄉","c3":"962"},{"name":"太麻里","c3":"963"},{"name":"金峰鄉","c3":"964"},{"name":"大武鄉","c3":"965"},{"name":"達仁鄉","c3":"966"}],"name":"台東縣"},{"dist":[{"name":"花蓮市","c3":"970"},{"name":"新城鄉","c3":"971"},{"name":"秀林鄉","c3":"972"},{"name":"吉安鄉","c3":"973"},{"name":"壽豐鄉","c3":"974"},{"name":"鳳林鎮","c3":"975"},{"name":"光復鄉","c3":"976"},{"name":"豐濱鄉","c3":"977"},{"name":"瑞穗鄉","c3":"978"},{"name":"萬榮鄉","c3":"979"},{"name":"玉里鎮","c3":"981"},{"name":"卓溪鄉","c3":"982"},{"name":"富里鄉","c3":"983"}],"name":"花蓮縣"},{"dist":[{"name":"宜蘭巿","c3":"260"},{"name":"頭城鎮","c3":"261"},{"name":"礁溪鄉","c3":"262"},{"name":"壯圍鄉","c3":"263"},{"name":"員山鄉","c3":"264"},{"name":"羅東鎮","c3":"265"},{"name":"三星鄉","c3":"266"},{"name":"大同鄉","c3":"267"},{"name":"五結鄉","c3":"268"},{"name":"冬山鄉","c3":"269"},{"name":"蘇澳鎮","c3":"270"},{"name":"南澳鄉","c3":"272"},{"name":"釣魚台","c3":"290"}],"name":"宜蘭縣"},{"dist":[{"name":"馬公市","c3":"880"},{"name":"西嶼鄉","c3":"881"},{"name":"望安鄉","c3":"882"},{"name":"七美鄉","c3":"883"},{"name":"白沙鄉","c3":"884"},{"name":"湖西鄉","c3":"885"}],"name":"澎湖縣"},{"dist":[{"name":"金沙鎮","c3":"890"},{"name":"金湖鎮","c3":"891"},{"name":"金寧鄉","c3":"892"},{"name":"金城鎮","c3":"893"},{"name":"烈嶼鄉","c3":"894"},{"name":"烏坵","c3":"896"}],"name":"金門縣"},{"dist":[{"name":"南竿","c3":"209"},{"name":"北竿","c3":"210"},{"name":"莒光","c3":"211"},{"name":"東引","c3":"212"}],"name":"連江縣"}],"version":"10410"}', TRUE);

    }

    



    //證仰流偷懶法
    public function insert($data)
    {

        if ($this->db->update($data['table'], $data['insert_data'])) {

            return true;
        } else {

            return false;
        }
    }

    public function update($data){

        if($this->db->where($data['where_syntax'])->update($data['table'],$data['update_data'])){

            return true;
        }else{

            return false;
        }

    }
}
