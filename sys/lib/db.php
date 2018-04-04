<?php namespace lib;
/**
 * 数据库接口类
 * chy
 * 20180403
 */
class db
{
	private $pdo;

	/*
	private static $meer;
	public static function meer()
	{
		if(!isset(self::$meer)) self::$meer=new self;
		return self::$meer;
	}
	*/

	
	//
	public function __construct()
	{
		//完成数据库的连接
		
	}

	//执行[查询]并返回结果
	public function get_result($sql, $dArr)
	{
		
	}

	//执行[增添、删除、修改]，并返回影响行数
	public function get_excNmb($sql, $dArr)
	{
		
	}


	//增、删、改、查 都是使用prepare预处理sql语句，并完成参数绑定，并返回PDOStatement
	private function get_sth($sql, $dArr)
	{
		//

		
	}
	


	



	
}
