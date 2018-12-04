<?php namespace ctl;
class index extends \clib\ctl
{
	public function dft()
	{
		//轻型输出
		//\lib\rtn::mep('这是默认页，但没有内容！');

		//加载视图
		include \lib\assign::load('index');

	}
	
}




