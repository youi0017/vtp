<?php namespace lib;
/*
 * 用户操作核心库
 */
class usr
{
	
	/*
	 * 登陆验证 yz_usr
	 * 需求：从数据库中判断($usr, $pwd), 匹配：true；不匹配：false 
	 * @usr [必] string 用户名
	 * @pwd [必] string 密码
	 * return bool true｜false
	 * 20180620 chy
	 */
	public static function yz_login($usr, $pwd)
	{
		//echo ('select id,usr,nick,email,stat,grp,last from t_usrs where usr='.$usr.' and pwd='.$pwd);exit;
		//select id,usr,stat,ga             rp,last
		$db=new \lib\db();
		$r=$db->get_one('select id,usr,nick,email,stat,grp,last from t_usrs where usr=? and pwd=?', [$usr, $pwd]);

		if( empty($r) )
		{
			return [0, '用户或密码不匹配'];
		}
		else
		{
			if($r['stat']>0)
			{
				//更新登陆状态
				$last = json_encode(['time'=>time(), 'ip'=>$_SERVER['REMOTE_ADDR']]);
				$db->exc('update t_usrs set last=? where id=?', [$last, $r['id']]);
				
				//设置（登陆）会话
				self::_set_login_hh($r);
				//var_dump($r);exit;
				
				return [1, '正常登陆'];
			}
			else
			{
				return [0, '用户失效 或 未激活'];
			}
		}
	}

	/*
	 * 设置用户的会话信息
	 * @usrRow [必] array 一条用户信息的数组
	 	如：['id','nick']
	 * 
	 * 
	 */
	private static function _set_login_hh($usrRow)
	{
		\lib\cookie::SET('uid', $usrRow['id'], 3600);
		\lib\cookie::SET('inf', json_encode($usrRow), 3600);
	}


	/*
	 * 生成验证码
	 * 20180621
	 */
	public static function set_yzm()
	{
		//1.生成一个 数学表达式的字符串$cal， 如'5+9'
		$cal = rand(1,9).'*'.rand(1,9);
		$val=eval( " return $cal; " );
		//return $cal. ' = '.$r;
		
		//2.生成一个会话， 将 $cal的计算值 作为会话的值
		\lib\cookie::set_hh($val);
		return $cal;
	}

	//取得当前用户id
	public static function get_uid()
	{
		$ck = new \lib\cookie('uid');
		return $ck->get_cookie();
	}

	//取得当前用户inf值
	public static function get_inf($k)
	{
		//$ck = new \lib\cookie('inf');
		//$inf = $ck->get_cookie();

		$inf=\lib\cookie::GET('inf');
		//var_dump($inf);exit;

		if($inf===false)
		{
			return false;
		}
		else
		{
			$inf = json_decode($inf);
			//var_dump($inf);
			return isset($inf->$k) ? $inf->$k : false;
		}
	}

	//取得登陆状态 20180622
	public static function get_loginSt()
	{
		if(self::get_uid()===false)
		{
			return array(0, '未登陆  或 登陆超时');
		}
		else
		{
			return array(1, '正常');
		}
	}


	//用户退出 20180623
	public static function set_logout($loginPage='')
	{
		//清除login会话
		$ck = new \lib\cookie('uid');
		$ck->set_cookie();

		$ck = new \lib\cookie('inf');
		$ck->set_cookie();
		
		//后续操作：显示一个 a标签，指向用户登陆	
		//exit('<a href="'.$loginPage.'">请重新登陆</a>');
		header('location: '.$loginPage);		
	}

	

	


	//生成验证码
	public static function _set_yzm()
	{
		//1. 准备验证码数据
		$cal=rand(0,9).' + '.rand(0,9);
		//2. 设置验证码会话标记
		$yzm = eval("return $cal;");


		//会话
		$ck=new \lib\cookie('loginYzm');
		$ck->set_cookie($yzm);


		//3. 生成验证码图片
		//声明图片
		header('Content-Type: image/png');
		
		//创建一幅图片
		$im = imagecreatetruecolor(100, 30);
		//imagecolorallocatealpha 

		$imgBg = imagecolorallocate($im, 255, 255, 255);//拾色器-白色 
		$fontBg = imagecolorallocate($im, rand(150,250), rand(50,200), rand(100,250));//拾色器-红色
		
		//背景色填充
		imagefill($im, 0, 0, $imgBg);
		
		//写入字串
		//imagestring($im, 5, 5, 5, $cal.' = ?', $fontBg);
		imagettftext($im, 15, rand(-5, 10), 10, 25 , $fontBg, 'C:/Windows/Fonts/Arial.ttf', $cal.' =');

		imagepng($im);
		imagedestroy($im);
	}

	

	
}























