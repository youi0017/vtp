<?php
if(!isset($err_msg)) $err_msg=null;
/*

var_dump($msg);
var_dump($code);
var_dump($adv);
exit;
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>错误<?=' ['.$err_msg['code'],']：',$err_msg['msg']?></title>
<link href="/pub/css/comm.css" rel="stylesheet" type="text/css" />
<style type="text/css">
html, body{height:100%;}
body{background-color:#F0F0F0;}
#content_box_outer{position:absolute; padding:0 20px 0 200px; margin-left:-350px; left:50%; top:25%; background:#FFFFFD url("/pub/pic/<?=$err_msg['img']?>.jpg") 30px center no-repeat; border:1px #CCC solid; border-radius:10px; box-shadow:2px 2px 8px #999;}
#content_box_inner{ display:table-cell; min-width:500px; max-width:600px; height:300px; vertical-align:middle;}/* text-align:center;*/
h1{font-size:50px; line-height:90px; letter-spacing:5px; }
</style>
</head>
<body>
<div id='content_box_outer'>
	<div id="content_box_inner">
		<h2 id='tit'><?=$err_msg['msg']?></h2>
		<h1 id='code' class="color_red"><?=$err_msg['code']?></h1>
	    <h4><?=$err_msg['adv']?></h4>
   </div>
</div>

<script type='text/javascript'>
(function(){
	return;
	//put content_box_outer valign
	var o = document.getElementById('content_box_outer');
	var h = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
	var str=o.style.height;
	var n1 = str.indexOf('px');
	var n = str.substr(0, n1);
	var r = (h-n)/2>0 ? (h-n)/2 : '25%';
	o.style.top=parseInt(r)+'px';
	
})()
</script>
</body>
</html>