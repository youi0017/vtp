<?php namespace lib;

class cookie
{
	private $ckName;//cookie索引名称
	private static $meer;

	const HHMK='__hhmk';

	public function __construct($ckKey)
	{
		$this->ckName=$ckKey;
	}

	//自实例化对象方法 20180703
	public static function meer($ckKey)
	{
		if(!isset(self::$meer)) self::$meer=new self($ckKey);
		return self::$meer;
	}

	//20180725
	public static function GET($ckName)
	{
		return isset($_COOKIE[$ckName]) ? $_COOKIE[$ckName] : false;
	}

	//20180725
	public static function SET($ckName, $value='', $time=0)
	{
		if($value!=='')
		{
			//设置、更新
			if( $time===0 )
				return setcookie( $ckName, $value, 0, '/');
			else
				return setcookie( $ckName, $value, time()+$time, '/');
		}
		else
		{
			//删除
			return setcookie( $ckName, null, time()-3600, '/');
		}

	}

	

	//cookie取值
	public function get_cookie()
	{
		return self::GET($this->ckName);
	}

	/*
	 * cookie的设置/更新/删除
	 * @value string [选] cookie的值 
	 * @time int [选] 有效的时间(秒数)
	 * @return bool true||false
	 * 
	 * 示例：
		设置：set_cookie(5); 或 set_cookie(5, 3600);
		更新：set_cookie(6); 或 set_cookie(6, 3600);
		删除：set_cookie();
	 * 20180606
	 * LM:20180615 $time由时间戳更改为有效的秒数
	*/
	public function set_cookie($value='', $time=0)
	{
		return self::SET($this->ckName, $value, $time);
	}



	//生成会话标记
	// $val 没有设置，值为time()； 有设置，则使传入的值
	public static function set_hh($hhk='a1', $val='', $time=0)
	{
		$ck=new self( $hhk );
		if($val=='') $val=time();
		$ck->set_cookie($val, $time);
	}


	//验证会话
	//$val不为空时，与 取得会话值 进行比较：相等?true:false
	//$val为空时, 取得会话值：有值?true:false;
	
	public static function get_hh($hhk='a1', $val='')
	{
		$ck=new self( $hhk );
		$ckVal = $ck->get_cookie();

		//验证会话
		//会话值$ckVal  与 传入值$val 的比较
		if($ckVal===false)
		{
			$b=false;
		}
		else
		{
			if($val==='')
			{
				$b=true;
			}
			else
			{
				$b = $ckVal==$val ? true : false;
			}
		}

		//清除
		$ck->set_cookie();
		
		//返回验证结果
		return $b;
		
	}


	

}


