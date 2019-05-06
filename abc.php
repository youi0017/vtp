<?php
header("Content-type: text/html; charset=utf-8");

//var_dump($_SERVER['PATH_INFO'], $_SERVER);
//exit;

//载入 框架基础配置
require './sys/core/conf.php';
//载入 项目配置
require FR_APP.APP_NAME.'/conf.php';

//引入框架助理
require FR_SYS.'core/assistant.php';

try{
	//载入核心
	core\vit::exc();
}
catch(\Exception  $e)
{
	\lib\rtn::mep('捕获信息：'.$e->getMessage());
}
