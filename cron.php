<?php
	$ch = curl_init();
	// 設定擷取的URL網址
	// $base_url = "https://beecar.anbon.vip/";
	$base_url = "https://www.anbon.vip/beecar/";
	curl_setopt($ch, CURLOPT_URL, $base_url."cron/fcm_cron/tw");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// 執行
	$r=curl_exec($ch);
	curl_close($ch);

?>