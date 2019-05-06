<?php namespace lib;
/*
 * 处理外部数据请求
 */
class request
{
	private static $emsg='';
	const brk=true;

	// 取get数据 
	public static function _query($data, $vName, $vType='string')
	{
		$data = array_change_key_case($data, CASE_LOWER);
		$vName=strtolower($vName);
		$vType=strtolower($vType);

		// var_dump($data, $vName, $vType);

		if(isset($data[$vName])==false)
		{
			if(self::brk) \lib\rtn::mep('SomeType Not Allowed!');
			return null;
		}

		switch ($vType)
		{
			case 'string':
				return (string)$data[$vName];
			case 'int':
			case 'float':
			{
				if(is_numeric($data[$vName])==false)
					\lib\rtn::mep('SomeType Not Allowed!');

				return $data[$vName]-0;
			}

			default:
			{
				\lib\rtn::mep('SomeType Not Allowed!');
			}
		}
	}

	// 取get数据 
	public static function get($vName, $vType='string')
	{
		return self::_query($_GET, $vName, $vType);
	}
	
	// 取post数据
	public static function post($vName, $vType='string')
	{
		return self::_query($_POST, $vName, $vType);
	}

}


















