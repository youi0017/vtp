<?php namespace lib;
/**
 * 模版解析与加载
 * V2.0 2015年8月24日
 * 
 * 功能：实例化类时直接载入模版	
 * 举例：
 *	new assign(array('name'=>'abc'), 'news_daily', 'html', false);
 *	new assign(array('name'=>'abc', 'date'=>'20150801'), 'news_week', 'tpl', false);
 *
 * 说明：
 * $data_arr 必需为键值对形式的数据
 * $is_sys_view 为系统视图解析控制，用户视图可留空
 *
 * 更新：
 * 2016年2月3日 加入load｜static方法，可以不输入数据直接使用准备好的数据加载并解析模版
 *
 *
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



		//如果编译文件不存在，则返回空模板地址
		//return is_file($tpl_file) ? $tpl_file : FR_SYS.'view/err/null.tpl';
		//throw new excp('编译文件不存在: '.$tpl_name);

		/*

		if(is_file($tpl_file)) return $tpl_file;
		else
		{
			echo '[编译文件:$tpl_name.$tpl_ext;]不存在！';			
			return '';
		}
		*/
    }

}