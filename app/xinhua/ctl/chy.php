<?php namespace ctl;
class chy extends \clib\ctl
{
	public function dft()
	{
		//直接返回内容
		return '<h1>欢迎来到chy的主页</h1>';
	}

	public function cs()
	{
		//轻型输出
		\lib\rtn::ep('chy自定误页');
	}
	
}




