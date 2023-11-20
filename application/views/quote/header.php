<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>蜜蜂派車</title>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/custom/custom.css">


    <link rel="manifest" href="<?=base_url()?>manifest.json">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/custom/PWA/bee.png">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/custom/datepair/jquery.timepicker.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.20.0/firebase-messaging.js"></script>
    <script src="<?=base_url()?>assets/custom/firebase/firebase-confing.js?v=003"></script>
    <script>
        messaging.onMessage((payload) => {
            console.log(payload);
            const data = payload.data.gcm.notification.type;
            if (data == "my_trip") {
                getDriverList();
            }
        });
    </script>
    <script>
        console.log(location.href);
        // 避開測試站網址
        const test_domain = RegExp(/anbon.vip/);
        if (location.href && !test_domain.test(location.href) ){
            var str = location.href;
            const reg = RegExp(/www/);
            if(reg.test(str)){
                location.href = str.replace('www.','')
            }  
        }
    </script>
</head>