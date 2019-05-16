<?php namespace ctl;
use \lib\db4 as db;
use \lib\assign;

class Index extends \clib\ctl
{
	public function index()
	{
		//轻型输出
		//\lib\rtn::mep('这是默认页，但没有内容！');

		//加载视图
		include assign::load('index');
	}

	public function cs()
	{
		//轻型输出
		\lib\rtn::mep('默认控制器下的cs方法！');
	}
	
}




