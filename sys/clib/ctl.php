<?php namespace clib;
/*
 * 控制器基类
 * CM: 20160321
 * LM: 20161007 在构造函数中加入unset，删除构架的参数__dir 和 __prm
 * 20160925 加入act()，用于处理不存在的影响器
 * 20170731 更改命名空间为clib
 *
*/

abstract class Ctl
{
	protected $prms;

	function __construct($prms=null)
	{
		$this->prms = $prms;

		//注：$prms不确定是否会被 dFun函数 注入 20190228
		if(!empty($_GET) || isset($prms)) \lib\route::disDfun();
	}

	/*
	//默认控制器
	public function _dft()
	{
		exit('不存在的执行器:'.CTL.'-'.ACT);
		//\lib\rtn::mep('无效执行 - A');
	}
	*/	

	//影响重置器: 默认影响器
	public function _index(){ \lib\rtn::mep('404 无效执行 - '.ACT); }

	function __destruct(){}
}