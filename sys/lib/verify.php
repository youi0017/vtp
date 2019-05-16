<?php
class Verify{   
/**
 * 验证用户名
 * @param string $value
 * @param int $length
 * @return boolean
 */
    public static function isNames($value, $minLen=6, $maxLen=16, $charset='ALL'){
        if(empty($value))
            return false;
        switch($charset){
            case 'EN': $match = '/^[_\w\d]{'.$minLen.','.$maxLen.'}$/iu';
                break;
            case 'CN':$match = '/^[_\x{4e00}-\x{9fa5}\d]{'.$minLen.','.$maxLen.'}$/';
                break;
            default:$match = '/^[_\w\d\x{4e00}-\x{9fa5}]{'.$minLen.','.$maxLen.'}$/iu';
        }
        return preg_match($match,$value);
    }
 
    /**
     * 验证密码
     * @param string $value
     * @param int $length
     * @return boolean
     */
    public static function isPWD($value,$minLen=6,$maxLen=16){
        $match='/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{'.$minLen.','.$maxLen.'}$/';
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
 
    /**
     * 验证eamil
     * @param string $value
     * @param int $length
     * @return boolean
     */
    public static function isEmail($value,$match='/^[\w!#$%&*+/=?^_`{|}~-]+(?:\.[\w!#$%&*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?$/'){
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
 
    /**
     * 验证电话号码
     * @param string $value
     * @return boolean
     */
    public static function isTelephone($value,$match='/^0[0-9]{2,3}[-]?\d{7,8}$/'){
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
 
    /**
     * 验证手机
     * @param string $value
     * @param string $match
     * @return boolean
     */
    public static function isMobile($value,$match='/^[(86)|0]?(1[3|4|5|7|8][0-9]{9})$/'){
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
    /**
     * 验证邮政编码
     * @param string $value
     * @param string $match
     * @return boolean
     */
    public static function isPostcode($value,$match='/[1-9]\d{5}(?!\d)/'){
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
    /**
     * 验证IP
     * @param string $value
     * @param string $match
     * @return boolean
     */
    public static function isIP($value,$match='/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/'){
        $v = trim($value);
        if(empty($v))
            return false;
        return preg_match($match,$v);
    }
 
    /**
     * 验证身份证号码
     * @param string $value
     * @param string $match
     * @return boolean
     */
    public static function isIDcard($value,$match='/^\d{6}((1[89])|(2\d))\d{2}((0\d)|(1[0-2]))((3[01])|([0-2]\d))\d{3}(\d|x|X)$/'){
        $v = trim($value);
        if(empty($v)) 
            return false;
        else if(strlen($v)>18) 
            return false;
        return preg_match($match,$v);
    }
 
    /**
     * *
     * 验证URL
     * @param string $value
     * @param string $match
     * @return boolean
     */
    public static function isURL($value,$match='/^(http:\/\/)?(https:\/\/)?([\w\d-]+\.)+[\w-]+(\/[\d\w-.\/?%&=]*)?$/'){
        $v = strtolower(trim($value));
        if(empty($v)) 
            return false;
        return preg_match($match,$v);   
    }

    /**
     * *
     * 验证QQ
     * @param string $value
     * @param string $match
     * @return boolean
     */

    public static function isQQ($value,$match='/^[1-9][0-9]{4,}$/'){
        $v = strtolower(trim($value));
        if(empty($v)) 
            return false;
        return preg_match($match,$v);   
    }

      /**
     * *
     * 验证QQ
     * @param string $value
     * @param string $match
     * @return boolean
     */

    public static function isDate($value,$match='/^([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))$/'){
        $v = strtolower(trim($value));
        if(empty($v)) 
            return false;
        return preg_match($match,$v);   
    }
 
 
 
    // 18位身份证校验码有效性检查
    public static function check18IDCard($IDCard) {
    if (strlen($IDCard) != 18) {
        return false;
    }
    $IDCardBody = substr($IDCard, 0, 17); //身份证主体
    $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码
    if (calcIDCardCode($IDCardBody) != $IDCardCode) {
            return false;
        } else {
           return true;
      }
    }
 
 
/**
 * 金额格式化
 * @param string $number 数字
 */
  public static function format_money($number)
  {
    return number_format($number,2,'.','');
   }
 
 /**
 * 校验金额格式
 * @param  [type] $accountPrice 金额值
 * @return [type]               [description]
 */
   public static function check_money_format($accountPrice)
   {
    if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $accountPrice)) return false;
    return true;
   }
  
//    1.验证用户名和密码：^[a-zA-Z]\w{5,15}$   正确格式："[A-Z][a-z]_[0-9]"组成,并且第一个字必须为字母6~16位
//    2.验证电话号码：^(\d{3,4}-)\d{7,8}$    正确格式：xxx/xxxx-xxxxxxx/xxxxxxxx
//    3.验证手机号码：^1[3|4|5|7|8][0-9]{9}$
//    4.验证身份证号（15位）：^\d{14}[[0-9],0-9xX]$ （18位）：^\d{17}(\d|X|x)$
//    5.验证Email地址：^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$ 或 \w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}
//    6.只能输入由数字和26个英文字母组成的字符串：^[A-Za-z0-9]+$
//    7.整数或者小数：^[0-9]+([.][0-9]+){0,1}$
//    8.只能输入数字：^[0-9]*$
//    9.只能输入n位的数字：^\d{n}$
//    10.只能输入至少n位的数字：^\d{n,}$
//    11.只能输入m~n位的数字：^\d{m,n}$
//    12.只能输入零和非零开头的数字：^(0|[1-9][0-9]*)$
//    13.只能输入有两位小数的正实数：^[0-9]+(\.[0-9]{2})?$
//    14.只能输入有1~3位小数的正实数：^[0-9]+(\.[0-9]{1,3})?$
//    15.只能输入非零的正整数：^\+?[1-9][0-9]*$
//    16.只能输入非零的负整数：^\-[1-9][0-9]*$
//    17.只能输入长度为3的字符：^.{3}$
//    18.只能输入由26个英文字母组成的字符串：^[A-Za-z]+$
//    19.只能输入由26个大写英文字母组成的字符串：^[A-Z]+$
//    20.只能输入由26个小写英文字母组成的字符串：^[a-z]+$
//    21.验证是否含有^%&',;=?$\"等字符：[%&',;=?$\\^]+
//    22.只能输入汉字：^[\u4e00-\u9fa5]{0,}$"。
//    23.验证URL：^http://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?$  
//    24.验证一年的12个月：^(0?[1-9]|1[0-2])$   正确格式为："01"～"09"和"10"～"12"
//    25.验证一个月的31天：^((0?[1-9])|((1|2)[0-9])|30|31)$ 正确格式为；"01"～"09"、"10"～"29"和“30”~“31”
//    26.获取日期正则表达式：\\d{4}[年|\-|\.]\d{\1-\12}[月|\-|\.]\d{\1-\31}日?
//    评注：可用来匹配大多数年月日信息。
//    27.匹配双字节字符(包括汉字在内)：[^\x00-\xff]
//    评注：可以用来计算字符串的长度（一个双字节字符长度计2，ASCII字符计1）
//    28.匹配空白行的正则表达式：\n\s*\r
//    评注：可以用来删除空白行
//    29.匹配HTML标记的正则表达式：<(\S*?)[^>]*>.*?</>|<.*? />
//    评注：网上流传的版本太糟糕，上面这个也仅仅能匹配部分，对于复杂的嵌套标记依旧无能为力
//    30.匹配首尾空白字符的正则表达式：^\s*|\s*$
//    评注：可以用来删除行首行尾的空白字符(包括空格、制表符、换页符等等)，非常有用的表达式
//    31.匹配网址URL的正则表达式：[a-zA-z]+://[^\s]*
//    评注：网上流传的版本功能很有限，上面这个基本可以满足需求
//    32.匹配帐号是否合法(字母开头，允许5-16字节，允许字母数字下划线)：^[a-zA-Z][a-zA-Z0-9_]{4,15}$
//    评注：表单验证时很实用
//    33.匹配腾讯QQ号：[1-9][0-9]{4,}
//    评注：腾讯QQ号从10 000 开始
//    34.匹配中国邮政编码：[1-9]\\d{5}(?!\d)
//    评注：中国邮政编码为6位数字
//    35.匹配ip地址：([1-9]{1,3}\.){3}[1-9]。
//    评注：提取ip地址时有用
//    36.匹配MAC地址：([A-Fa-f0-9]{2}\:){5}[A-Fa-f0-9]
 
}
