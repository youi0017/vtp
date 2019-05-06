<?php namespace lib;
/**
 * 数据库的操作类db
 * 说明：完成数据库相关的基础操作
 * ver1.0 初版
 * ver1.1 增加 P()函数 20180713
 * ver1.2 增加 meer\D\D2\I\U\UI函数 20180720
 * 20180606
 */
class db4
{
	private $err='ok';
	private $pdo;

	private static $meer;

	//自实例化
	public static function meer()
	{
		if(!isset(self::$meer)) self::$meer=new self;
		return self::$meer;
	}
	
	//pdo基础设置
	public function __construct()
	{
		try
		{
			//1. 连接数据库
			$this->pdo=new \PDO(DNS_DB, USR_DB, PWD_DB);
			$this->pdo->exec('set names utf8');
			
			//开启错误，抛出错误
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		catch( \PDOException $err )
		{
			$this->err=$err->getMessage();
		}		
	}

	/*
	 * 取得转换后的字串 20180720
	 	示例：
		$arr=['id'=>13, 'tit'=>'第13行的标题', 'grp'=>2];
		$r=\lib\db::get_cvt_string($arr);
		var_dump($r);
	 */
	public static function get_cvt_string(array $arr, $mk=',')
	{
		$r=[];
		
		foreach( $arr as $k => $v )
		{
			$r[]=" `$k`=:$k ";
		}

		return implode($mk, $r);		
	}

	/**
	 * D方法一
	 * @param tblName string 表名
	 * @param row mix 待删除的条件：数组(优先)或字串
	 * @param mk 当$whr为数据时的条件连接符
	 * 
	 	示例一：
		$c = \lib\db::meer()->D('t_qy_dgtbl', ['id'=>9, 'grp'=>14], 'or');
		var_dump($c);
		$c>0 ? rtn::okk() : rtn::err();
	 	示例二：
		$c = \lib\db::meer()->D('t_qy_dgtbl',  'id in (110,150,170)');
		var_dump($c);
		$c>0 ? rtn::okk() : rtn::err();
	 * 
	 * 20180720
	 */
	public function D($tblName, $row, $mk='and')
	{
		$whr=is_array($row) ? self::get_cvt_string($row, $mk) : $row;
		$sql="delete from {$tblName} where {$whr};";

		//var_dump($sql);exit;
		//执行sql语句
		$stmt=$this->get_stmt($sql, $row);
		//返回影响条数
		return $stmt ? $stmt->rowCount() : false;
	}

	/**
	 * D方法二
	 * @param tblName string 表名
	 * @param whr mix 待删除的条件字串
	 * 
	 	示例：
		$c = \lib\db::meer()->D2('t_qy_dgtbl', 'id in(15,16,17)');
		var_dump($c);
		$c>0 ? rtn::okk() : rtn::err();
	 * 
	 * 20180720
	 */
	public function D2($tblName, $whr)
	{
		return $this->D($tblName, $whr);
	}

	public function I($tblName, array $row)
	{
		return $this->I2($tblName, $row);
	}


	/**
	 * I2方法
	 * @param tblName string 表名
	 * @param dArr array 待插入的一维数组数据
	 * 注：使用与update相似的语法
	 * 
	 	示例：
		$row=['tit'=>'I insert tit', 'cnt'=>'I insert cnt', 'grp'=>4];
		$c = \lib\db::meer()->I('t_qy_dgtbl', $row);
		var_dump($c);
	 */
	public function I2($tblName, array $row)
	{
		$fields=self::get_cvt_string($row, ',');
		$sql='insert into '.$tblName.' set '.$fields;
		//var_dump($sql);exit;

		//执行sql语句
		$stmt=$this->get_stmt($sql, $row);
		//返回影响条数
		return $stmt ? $stmt->rowCount() : false;
	}


	/**
	 * U方法
	 * @param tblName string 表名
	 * @param dArr array 待更新的一维数组数据
	 * @pk tblName string 主键名称
	 * 
	 	示例：
		$arr=['id'=>'2', 'tit'=>'第2行标题', 'grp'=>1];
		$c=db::U('t_qy_dgtbl', $arr, 'id');
		$c>0 ? rtn::okk() : rtn::err();
		exit;
	 */
	public function U($tblName, array $row, $pk='id')
	{
		if(!isset($row[$pk]))
		{
			$this->err='更新数据中不存在主键，请检查数据！';
			return false;
		}

		$pk="$pk='{$row[$pk]}'";
		unset($row[$pk]);
		
		
		$fields=self::get_cvt_string($row, ',');
		$sql='update '.$tblName.' set '.$fields.' where '.$pk;
		//var_dump($sql);exit;

		//执行sql语句
		$stmt=$this->get_stmt($sql, $row);
		
		//返回影响条数
		return $stmt ? $stmt->rowCount() : false;
	}

	/**
	 * IU方法
	 * @param tblName string 表名
	 * @param dArr array 待更新/插入的一维数组数据
	 * @pk tblName string 主键名称
	 * 说明: 如果 pkName在数据中则更新，不在则插入
	 * 
	 	示例：
		$arr=['id'=>'2', 'tit'=>'第2行标题', 'grp'=>1];
		$c=db::U('t_qy_dgtbl', $arr, 'id');
		$c>0 ? rtn::okk() : rtn::err();
		exit;
	 */

	public function IU($tblName, array $row, $pk='id')
	{
		
		if(empty($row[$pk]))
		{
			return $this->I2($tblName, $row);
		}
		else
		{
			return $this->U($tblName, $row, $pk);
		}
		
	}

	//分页
	/*
		分页
		示例：
		$r=[];
		$rows=self::P($sql, [], $r);
		$r['rows']=$rows;
	*/
	public function P($sql, $row=[], &$pgInf=[])
	{
		//显示条数(传入优先，配置其次)
		if(isset($_GET['sn']) && $_GET['sn']>0)
			$pgInf['show']=$_GET['sn'];
		else
			$pgInf['show'] = isset($pgInf['show']) ? $pgInf['show'] : 5;
		//强制显示条数为整数
		$pgInf['show']=(int)$pgInf['show'];
		
		//当前页码
		$pgInf['pn'] = isset($_GET['pn']) && $_GET['pn']>1 ? $_GET['pn'] : 1;

		//总页数
		$sql_t=preg_replace('/^select .* from/i', 'select count(*) as t from', $sql);
		$pgInf['total']=(int)$this->R($sql_t, $row, 0);//总条数
		//总页数= 向上取整(总条数/显示条数) 
		$pgInf['tp'] = ceil($pgInf['total']/$pgInf['show']);//总页数
		
		//启始条数 = (页数-1)*显示条数
		$limit=($pgInf['pn']-1)*$pgInf['show'];
		$limit=" limit {$limit}, {$pgInf['show']}";

		return $this->R($sql.$limit, $row);
	}

	/** 事务C-U：[写入]或[更新]多条数据
	 * 
	 * @param tbl 表名
	 * @param arr 待写入数据库的二维数组
	 * @param pk 数据对应的主键值，一般为ID
	 * @return bool count|false
	 * 
	 * 注意：20161121
	 	1. $pk==null，执行插入操作，且$pk必需为自增字段，否则SQL报错
	 	2. $pk建议填写：当$row[$pk]判定为真则执行更新；当判定假不存在时为新增
	 * 
	 * 示例：
	 	$arr =[
			['usr'=>'u001', 'sex'=>'nan', 'age'=>16]
			,['usr'=>'u002', 'sex'=>'nv', 'age'=>21]
		];
		$c = \lib\db2::meer()->T('t_cs', $arr);
		$c===false ? rtn::err() : rtn::okk('', db2::meer()->last_id() );
	 * 
	 */
	public function T($tbl, array $arr, $pk=null)
	{

		//var_dump($tbl);
		//var_dump($arr);
		//var_dump( $pk);
		//exit;
		
		$i=0;//记录事务处理次数
		try
		{
			//1. 开启标准事务
			$this->pdo->beginTransaction();

			//2. 执行数据处理
			foreach($arr as $row)
			{
				//调用单条处理(注：对U方法，有一条没有更新也返回失败20180121)
				$c = ($pk && isset($row[$pk])) ? $this->U($tbl, $row, $pk) : $this->I($tbl, $row);
				
				//出错则抛出错误
				if($c===false) throw new \PDOException( $this->get_err() );
				$i+=$c;
			}

			//3. 提交事务
			$this->pdo->commit();
			return $i;
		}
		catch(\PDOException $e) 
		{
			//var_dump($e);
			//3. 回滚事务
			$this->pdo->rollBack();
			$this->err=$e->getMessage();
			return false;
		}
	}


	//返回错误信息 20180614
	public function get_err()
	{
		return $this->err;
	}

	/**
	 * 取得sql的查询结果
	 * $sql string [必] sql语句
	 * $row array [选] 作为sql语句的数据
	 * retrurn array|false 如果是false，则sql语句错误，如是空数组则代表未查到任何数据
	 * 
	 * 20180601 chy
	 * lm: 加入 错误判断 20180614
	 * lm: 加入 单值的输出 20180715
	 * 注：二维时未查到返回空数组，其它返回false，所以对结果的判断用empty
	 	20181213 一、二维时未查到返回空数组，单值没找到返回空字串，语句错误返回false
	 */
	public function R($sql, $row=[], $fetchType=2, $rType='object')
	{
		//执行sql语句
		$stmt=$this->get_stmt($sql, $row);
		if(!$stmt) return false;
		//var_dump($stmt, $stmt->fetchAll(\PDO::FETCH_OBJ));
		
		switch($fetchType)
		{
			//返回 二维数组
			case 2:
				return $stmt->fetchAll($this->get_rtnType($rType))?:[];
			//返回 一维数组
			case 1:
				return $stmt->fetch($this->get_rtnType($rType))?:[];
			//返回 单值
			default:
				return $stmt->fetchColumn()?:'';
		}

	}

	/*
	 * 返回影响条数
	 * @sql
	 * @dArr
	 * @return int 数值型sql语句无误， false则sql语句错误
	 *
	 * lm: 加入错误判断 20180614
	 */
	public function exec($sql, $row=[])
	{
		//执行sql语句
		$stmt=$this->get_stmt($sql, $row);
		//返回影响条数
		return $stmt ? $stmt->rowCount() : false;
	}


	//执行sql语句，返回pdo::sth对象
	private function get_stmt($sql, array $row)
	{
		if(!$this->pdo) return false;
		
		try
		{
			//预执行sql语句
			$stmt=$this->pdo->prepare($sql);

			//绑定数据[]
			if(!empty($row))
			{
				//数值型数组
				if( isset($row[0]) && $row[0]===reset($row) )
				{
					$i=0;
					foreach( $row as $val)
					{
						$stmt->bindValue(++$i, $val);
					}
				}
				//关联型数组
				else
				{
					foreach( $row as $key => $val)
					{
						$stmt->bindValue(':'.$key, $val);
					}
				}
			}

			//执行
			$stmt->execute();

			//返回sth对象
			return $stmt;
			
		}
		catch( \PDOException $err )
		{
			$this->err=$err->getMessage();
			return false;
		}
		
	}

	/**
	 * 设置结果类型
	 * 20170715
	 */
	private function get_rtnType($rType='object')
	{
		switch($rType)
		{
			case 'object': return \PDO::FETCH_OBJ;
			case 'array': return \PDO::FETCH_ASSOC;
			case 'both': return \PDO::FETCH_BOTH;
			default: return \PDO::FETCH_OBJ;
		}
	}


	public function __destruct()
	{
		$this->pdo=null;
	}

}


