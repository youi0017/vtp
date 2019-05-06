<?php
/**
 * vit 框架助理
 * 20161101 LM:20170703
 */

//开启所有错误报告
error_reporting(E_ALL);

//错误捕捉
set_error_handler('_get_err');

//注册__autoload
spl_autoload_register('_my_loader');


/**
 * 错误控制(一般性错误)
 * 20161101
 * 
 * 	配置说明：
	本配置由APP配置决定，需配置以下内容
	运行控制码： ERR_ON
		1		: 开发调试	(提示详细错误信息)
		0,-1	: 用户模式	(不显示任何错误)
	日志控制码：LOG_ON
		1		: 开发调试	(生成"错误信息"的日志)
		0,-1	: 用户模式	(不生成日志)
	
	一般性错误 和 编译性错误 均使用日志文件：ERROR_LOG_FILE
 */
function _get_err($errno, $errstr, $errfile, $errline)
{
	//一般错误(显示)
    if(ERR_ON>0)
    {
		echo '<p><b>Meet Error</b>!<br/>',$errstr,'<br/>Error on line ',$errline,'<p><br/>';
    }

	//一般错误(记录)
    if(LOG_ON>0)
    {
    	$log_msg = PHP_EOL."Meet Error[$errno]: ".date('Y-m-d G:i:s').PHP_EOL.$errstr.PHP_EOL."Error on line $errline in $errfile".PHP_EOL.'Uri is '.$_SERVER['REQUEST_URI'].PHP_EOL;
		error_log($log_msg, 3, ERROR_LOG_FILE);
    }
}


/**
 * 自动加载库 
 * 20161101
 * 
 * 更新
 * 20150930 将控制器类文件名的中间名由'ctl'更改为APP_CTL_MID
 * 20160612 使用空间加载方式
 * 20161101 去除加类的中间名
 */
function _my_loader($cls_name)
{
	$cls_name = str_replace('\\', '/', $cls_name);
	
    //优先加载 系统库, 系统库不存在则在 项目库 中查找
	$cls_path = FR_SYS.$cls_name.'.php';
	if(is_file($cls_path)) require_once $cls_path;
	else
	{
		//从 "项目目录" 中查找，不存在则抛出错误
		$cls_path = FR_APP.APP_NAME.'/'.$cls_name.'.php';
		
		if(is_file($cls_path)) include $cls_path;
		else
		{
			$cls_name = str_replace('ctl','', $cls_name);
			lib\rtn::mep('访问资源['.$cls_name.']不存在！');
			\lib\tools::note_err('loader class not exited! file path is'.$cls_path);
		}
	}
}

//错误(显示)控制 {开发:1 用户:0}
if(ERR_ON>0)
{
	//开启错误显示
	ini_set('display_errors', 1);
	//php启动错误信息：开(默认关)
	ini_set('display_startup_errors', 1);
	
	//以HTML形式显示到页面：开(默认开)
	ini_set('html_errors', 1);
}
else
{
	//关闭错误显示
	ini_set('display_errors', 0);
}


//错误(严重&编译等日志)控制 {关闭:0 开启:1} ，写入错误日志：ERROR_LOG_FILE
if(LOG_ON>0)
{
	//开启错误日志
	ini_set('log_errors', 'On');
	//严重&编译等 错误写入 日志
	ini_set('error_log', ERROR_LOG_FILE);
}
else
{
	//不开启日志，注意：没有此行 错误日志将写入到 php.ini的错误路径
	ini_set('log_errors', 'Off');
}


