<?php namespace lib;
/**
 * @author chy
 * 返回结果(json字符)
 *
 * new result(1, '成功', 'src=...', '200');
 * result::OK('成功', 'src=...', '200');
 * result::OK('错误', 'src=...', '200');
 * result::OK('成功', ['d1'=>'dd1', 'd2'=>'dd2'], '200');
 * 
 * 
 */

 
class rtn
{
/* 阻断返回：简单结果输出 */
    /**
     * 类静态函数，直接返回TRUE的快键方式.
     * @param string $msg 提示信息
     * @param Object $data 实际的数据
     * @return Result Result对象
     * @throws 
     */    
	public static function okk($msg='success', $data='')
	{
		exit(json_encode(['status'=>1, 'msg'=>$msg, 'data'=>$data], JSON_UNESCAPED_UNICODE));
	}

	public static function err($msg='fail', $data='')
	{
		//header("http/1.1 404 Not Found");
		exit(json_encode(['status'=>0, 'msg'=>$msg, 'data'=>$data], JSON_UNESCAPED_UNICODE));
	}



/*阻断返回：视图输出*/
	/**
	 * 错误输出 ep:error page
	 * 20170711
	 */
	public static function ep($code='404', $msg='', $adv='')
	{
		$funName = 'ep'.$code;
		method_exists('\lib\rtn', $funName) ? self::$funName($msg,$adv) : self::epxxx($code,$msg,$adv);
		exit;
	}
	

	//msg page 20170726
	public static function mep($msg='')
	{
		header("http/1.1 404 Not Found");
		if($msg=='') $msg='系统捕获错误，已阻止运行！';
		exit('<h2 style="color:brown; font-weight:600; padding:20px; border:1px solid #a5b6c8; background-color:#eef3f7;">错误: '.$msg.'</h2>');
	}

	//404
	public static function ep404($msg='', $adv='')
	{
		$err_msg = array(
			'code'=>'404'
			,'msg'=>$msg?:'受访内容不存在'
			,'adv'=>$adv?:'您访问的内容不存在 或 因改版已转移，到【<a href="/" target="_self">首页</a>】看看吧！'
			,'img'=>'404'
		);
		
		header("http/1.1 404 Not Found");
		//加载模版
		include assign::load('err/dft', 'tpl', true);
		exit;
	}

	//403
	public static function ep403($msg='', $adv='')
	{
		$err_msg = array(
			'code'=>'403'
			,'msg'=>$msg?:'服务器拒绝'
			,'adv'=>$adv?:'服务器拒绝处理请求, 您可能没有访问权限！'
			,'img'=>'403'
		);
		
		header("http/1.1 403 Forbidden");
		//加载模版
		include assign::load('err/dft', 'tpl', true);
		exit;
	}

	//403
	public static function epxxx($code='XXX', $msg='', $adv='')
	{		
		$err_msg = array(
			'code'=>$code
			,'msg'=>$msg?:'工程输出模式'
			,'adv'=>$adv?:'这是工程设定的输出模式，用以维护工程运行！'
			,'img'=>'xxx'
		);
		
		header("http/1.1 500 manMade Err");
		//加载模版
		include assign::load('err/dft', 'tpl', true);
		exit;
	}




    

    //== js执行的静态方法 =======================================
    //输出js代码
    public static function jscript($js_code='')
    {
        if(!$js_code) $js_code='alert("JS_STR is null!")';

        exit('<script type="text/javascript">'.$js_code.'</script>');
    }
    
    //输出js调试值
    public static function jslog($jsVar)
    {
        exit('<script type="text/javascript">console.log("'.$jsVar.'")</script>');
    }



    



    

}
