<?php namespace lib;

/* 
 * 会话session
 * 20180606
 * 
 * 
 */
class session
{
	//自实例对象
	private static $meer;
	public static function meer($sessKey)
	{
		if( !isset(self::$meer) ) self::$meer=new self($sessKey);
		return self::$meer;
	}

	protected $sessName;
	public function __construct($sessKey)
	{
		$this->sessName=$sessKey;
		if(!isset($_SESSION)) session_start();
	}

	//取得session_id 20180725
	public static function SID()
	{
		if(!isset($_SESSION)) session_start();
		return session_id();
	}

	//摧毁 20180725
	public static function DES()
	{
		self::SID();
		session_destroy();
	}

	//20180725
	public static function GET($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
	}

	//20180725
	public static function SET($key, $val)
	{
		$_SESSION[$key]=$val;
		return $val;
	}

	//20180725
	public static function DEL($key)
	{
		if(isset($_SESSION[$key]))
			unset($_SESSION[$key]);
	}
	

	//设置（创建+更新）
	public function set_sess($value)
	{
		$_SESSION[ $this->sessName ]=$value;
	}

	//取值
	public function get_sess()
	{
		return isset($_SESSION[ $this->sessName ]) ? $_SESSION[ $this->sessName ] : false;
	}
	
}
