<?php namespace lib;
/**
 * 模版解析与加载
 * V2.0 2015年8月24日
 */
class assign
{

	/**
	 * 加载模版文件
	 * 说明：返回待解析文件的地址，直接使用include进行加载解析
	 * 
	 * 2016年2月3日
	 * 
	 * 注意：
	 * 1. 不用实例化，
	 * 2. 用输入数据
	 * 3. 只能调用用户模版
	 * 
	 * 示例：
	 * include assign::load('cs')
	 * 
	 */
    public static function load($tpl_name, $tpl_ext='', $is_sys_view=false)
    {
	    //扩展名：优先使用输入，留空则调用用户配置的扩展名（默认是tpl），
		if( !$tpl_ext ) $tpl_ext = 'tpl';

		//判断加载：模版文件地址
		if($is_sys_view)
			$tpl_file = FR_SYS.'/view/'.$tpl_name.'.'.$tpl_ext;
		else
			$tpl_file = FR_APP.'/'.APP_NAME.'/'.APP_TPL.'/'.$tpl_name.'.'.$tpl_ext;

		if(is_file($tpl_file)) return $tpl_file;
		else
		{
			echo '<div style="color:#F00">[编译文件{'.$tpl_name.'.'.$tpl_ext.'}不存在]</div>';
			return FR_SYS.'view/err/null.tpl';
		}
    }

}