<?php
/**
* 项目配置
* 20170726
*/

//APP控制器目录
const APP_CTL = 'ctl';
//APP模版目录
const APP_TPL = 'tpl';
//APP用户控制
const APP_USR = 'usrs';

//错误(显示)控制 {开发:1 用户:0}
const ERR_ON = 1;
//错误(日志)控制 {关闭:0 开启:1}
const LOG_ON = 0;
//定义存储日志(错误)文件的位置
define('ERROR_LOG_FILE', FR_PUB.'logs/'.APP_NAME.'_err_'.date('Ymd').'.txt');

//项目名称
const APP_NAME_ZH='vtp-xinhua system';


//数据库配置信息-local
const DNS_DB='mysql:host=localhost;port=33067;dbname=chy;';
const USR_DB='chyDB';
const PWD_DB='123456';
