<?php namespace ctl;
class music extends \clib\ctl
{

	public function dft()
	{
	   echo '<h1>Welcome to chuhangyu\'s music homepage!</h1>';
	}

	public function ydyrx()
	{
		$this->_model('愿得一人心，白首不分离', __FUNCTION__);
	}

	public function zdylx()
	{
		$this->_model('真的用了心', __FUNCTION__);
	}

	public function yjgyh()
	{
		$this->_model('又见高原红', __FUNCTION__);
	}


	private function _model($music_name_zh, $fun_name)
	{
        new \lib\assign('music', [
            'music_name_en'=>$fun_name,
            'music_name_zh'=>$music_name_zh,
            'web_title'=>'-'.$music_name_zh,
        ]);
		
	}

}




