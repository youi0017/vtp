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

//APP管理控制//const APP_ADM = 'adm';

//错误(显示)控制 {开发:1 用户:0}
const ERR_ON = 1;
//错误(日志)控制 {关闭:0 开启:1}
const LOG_ON = 1;
//定义存储日志(错误)文件的位置
define('ERROR_LOG_FILE', FR.APP_NAME.'/log/err_'.date('Ymd').'.txt');


//local
//$new='{"dns":"mysql:host=localhost;port=3306;dbname=yohall_2017","usr":"root","pwd":"123456"}';
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PWxvY2FsaG9zdDtwb3J0PTMzMDY7ZGJuYW1lPXlvaGFsbF8yMDE3IiwidXNyIjoicm9vdCIsInB3ZCI6IjEyMzQ1NiJ9';

/*
//local
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PWxvY2FsaG9zdDtwb3J0PTMzMDY7ZGJuYW1lPXlvaGFsbF8yMDE3IiwidXNyIjoicm9vdCIsInB3ZCI6IiJ9';

//aliyun
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PWJkbTI2MjQwNDYubXkzdy5jb207cG9ydD0zMzA2O2RibmFtZT1iZG0yNjI0MDQ2X2RiIiwidXNyIjoiYmRtMjYyNDA0NiIsInB3ZCI6InkxNkNodTIzMDY4NiJ9';

//zzidc
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PXN6cjN4Y3d3Lnp6Y2RiLmRuc3Rvby5jb207cG9ydD00MDA1O2RibmFtZT1jaHVqaWF5ZSIsInVzciI6ImNodWppYXllX2YiLCJwd2QiOiJqYTIzMDY4NiJ9';

//laoxue 只能上传后使用
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PWxvY2FsaG9zdDtwb3J0PTMzMDY7ZGJuYW1lPXZpdGhlbmNvX3lvaGFsbCIsInVzciI6InZpdGhlbmNvX2FueW9uZSIsInB3ZCI6Imx4Q2h1MjMwNjg2In0=';

//laoxue 待测试 更改为IP
const SQLCNF='eyJkbnMiOiJteXNxbDpob3N0PTExOC4xODQuNDEuNjg7cG9ydD0zMzA2O2RibmFtZT12aXRoZW5jb195b2hhbGwiLCJ1c3IiOiJ2aXRoZW5jb19hbnlvbmUiLCJwd2QiOiJseENodTIzMDY4NiJ9';
*/
