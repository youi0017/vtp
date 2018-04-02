<?php namespace clib;
/*
 * 控制器基类
 * CM: 20160321
 * LM: 20161007 在构造函数中加入unset，删除构架的参数__dir 和 __prm
 * 20160925 加入act()，用于处理不存在的影响器
 * 20170731 更改命名空间为clib
 *
*/

class ctl
{
	protected $prms;

	function __construct($prms=null){ unset($_GET['__dir'], $_GET['__prm']); $this->prms = $prms;}

	//默认控制器
	public function dft(){ \lib\rtn::mep('无效执行 - A'); }

	//影响重置器: 默认影响器
	public function act(){ \lib\rtn::mep('无效执行 - B'); }

	function __destruct(){}
}