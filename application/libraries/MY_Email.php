<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jemoonjong
 * Date: 13. 2. 27.
 * Time: 오후 5:28
 * To change this template use File | Settings | File Templates.
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email
{
	protected $_ci;

	function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();
	}


	public function sendmail($to_mail, $subject, $body, $from_mail, $from_name)
	{
		$this->_ci->load->library('phpmailer/phpmailer');
		$mail = new PHPMailer();

		$mail->IsHTML(true);
		$mail->CharSet = "UTF-8";

		// 1 = errors and messages
		// 2 = messages only+
		$mail->SMTPDebug	=	config_item('mail_debug');				// enables SMTP debug information (for testing)

		/**
		 * 자체 메일서버를 이용한 메일전송을 원한다면
		 * 해당 메일서버 셋팅값 지정하기
		 */
		if(config_item('mail_type') == 'smtp')
		{
			$mail->IsSMTP();
			$mail->SMTPAuth		=	config_item('mail_auth');				// enable SMTP authentication
			$mail->SMTPSecure	=	config_item('mail_secure');				// sets the prefix to the servier
			$mail->Host			=	config_item('mail_host');				// sets GMAIL as the SMTP server
			$mail->Port			=	config_item('mail_port');				// set the SMTP port for the GMAIL server
			$mail->Username		=	config_item('mail_user');				// GMAIL username
			$mail->Password		=	config_item('mail_pass');				// GMAIL password
		}
		else if(config_item('mail_type') == 'mail')
		{
			$mail->IsMail();
		}
		else{
			$mail->IsSendmail();
		}

		$mail->SetFrom($from_mail, $from_name);
		$mail->Subject = $subject;
		$mail->MsgHTML($body);
		$mail->AddAddress($to_mail);

		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

		return $mail->Send();

	}
}