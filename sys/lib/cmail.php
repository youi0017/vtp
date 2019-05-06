<?php namespace lib;
/**
 * 邮件库 PHPMailer
 * 20170104 v0.0
 *
 * 说明：PHPMailer-master 20170103版
 *
 */
class cmail
{
	//调试控制：0关闭，1开启
	const BUG=1;

	//邮件服务器
	//public $mailHost = 'smtp.exmail.qq.com';
	public $mailHost = 'smtp.qq.com';
	public $myUsr = '';//帐户名12345678@qq.com
	public $myPwd = '';//密钥，如Zf2xT4wr7rgysrosAwj000R
	public $myNick = '';//发件人昵称

	
	//记录错误
	private $err;

	public function __construct(array $dArr=[])
	{
		foreach($dArr as $k=>$v)
		{
			if(isset($this->$k)) $this->$k=$v;
		}
	}

	public function get_err(){return $this->err;}



	/**
	 * 发送邮件的方法
	 * 
	 * 
	 * 
	 * 20170104
	 */
    public function sendMail($revUsr, $tit, $html)
    {
	    require_once(FR_PUB.'/php/PHPMailer/class.phpmailer.php');
		require_once(FR_PUB.'/php/PHPMailer/class.smtp.php');

		$mail = new \PHPMailer(true); 
		
		//是否启用smtp的debug进行调试
		$mail->SMTPDebug = self::BUG;
		//使用smtp鉴权方式发送邮件
		$mail->isSMTP();
		//smtp需要鉴权 这个必须是true
		$mail->SMTPAuth=true;

		//链接qq域名邮箱的服务器地址
		$mail->Host = $this->mailHost;
		//设置使用ssl加密方式登录鉴权
		$mail->SMTPSecure = 'ssl';
		//smtp服务器的远程服务器端口号 SSL:465或587;非SSL:25
		$mail->Port = '465';

		//设置smtp的helo消息头 这个可有可无 内容任意
		//$mail->Helo = 'Hello I am YOHALL Server';
		
		//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
		$mail->CharSet = 'UTF-8';
		//设置发件人姓名（昵称），显示在收件人邮件的发件人邮箱地址前的发件人姓名
		$mail->FromName = $this->myNick;
		//smtp登录的账号，邮箱帐号
		$mail->Username = $this->myUsr;
		//smtp登录的密码，某些服务商为授权码
		$mail->Password = $this->myPwd;
		//设置发件人邮箱地址,这里与“发件人邮箱”一致
		$mail->From = $this->myUsr;

		//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
		$mail->isHTML(true);
		//设置收件人邮箱地址 该方法有两个参数:收件人邮箱地址 和 该地址设置的昵称，这里第二个参数的意义不大
		$mail->addAddress($revUsr);//'接收者'.date('Y-m-d h:i:s', time())
		//添加多个收件人 则多次调用方法即可
		// $mail->addAddress('xxx@163.com', '接收者'.date('Y-m-d h:i:s'));
		//添加该邮件的主题
		$mail->Subject = $tit;
		//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		$mail->Body = $html;
		//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
		// $mail->addAttachment('./d.jpg', 'mm.jpg');
		//同样该方法可以多次调用 上传多个附件
		// $mail->addAttachment('./Jlib-1.1.0.js', 'Jlib.js');

		//echo '<br/><br/><br/>';
		//print_r($mail);
		//echo '<br/><br/><br/>';

		//执行并输出结果
		if($mail->send()) return true;
		else
		{
			$this->err=$mail->getError();
			\lib\tools::note_err($this->err, __FILE__);
			return false;
		}

	}

 

}