<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" >
    <title>wall-mobile</title>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!--<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">-->
    <link rel="icon" href="static/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">
    <!--<link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">-->
</head>
<body>
<div id="app">
    <router-view keep-alive></router-view>
</div>
<!--<script type="application/javascript" src="http://g.alicdn.com/sj/lib/jquery/dist/jquery.min.js"></script>-->
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>

<script type="application/javascript" src="/static/wall/mobile/jquery.html5uploader.min.js"></script>
<script type="text/javascript">
    //SUI初始化
    $.config = {
        autoInit: true,
        router: false
    }
    function getCookie(name) {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }
    function remove(id){
        $('#img_id_num_'+id).remove();
        var ids = ','+$("#photoIds").val();
        var ods = ids.replace(','+id+',', ',');
        var nid = ods.substring(1);
        $("#photoIds").val(nid);
    }

</script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<script src="/static/wall/mobile/build.js"></script>
</body>
</html>