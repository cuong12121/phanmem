<?php
include_once 'phpmailer.php';
class Email extends PHPMailer
{	
	/**
	 * @return mixed True if successful, a JError object otherwise
	 */
	function &Send()
	{
		

		// config to user gmail
//		$this -> Mailer = 'smtp';
//		$this -> useSMTP(true,'ssl://smtp.gmail.com','methongthai.vn@gmail.com','methongthai','ssl',465);
		$this -> Mailer = 'smtp';
		$this -> useSMTP(true,'ssl://smtp.gmail.com','cskh.hailinh@gmail.com','','ssl',465);		
		if ( ( $this->Mailer == 'mail' ) && ! function_exists('mail') )
		{
			Errors::setError(FSText :: _('MAIL_FUNCTION_DISABLED'),'alert');
			return false;
		}

		@ $result = parent::Send();
		
		if ($result == false){
			 echo "Mailer Error: " . $this->ErrorInfo;
			// TODO: Set an appropriate error number
//			$result =Errors::setError('Not send mail','error');
		}
		return $result;
	}
	/**
	 * Set the E-Mail sender
	 *
	 * @param array $from E-Mail address and Name of sender
	 * 		<pre>
	 * 			array( [0] => E-Mail Address [1] => Name )
	 * 		</pre>
	 */
	function setSender($from)
	{
		// If $from is an array we assume it has an address and a name
		if (is_array($from))
		{
			$this->From 	= $from[0] ;
			$this->FromName = $this -> cleanLine( $from[1] );
		// If it is a string we assume it is just the address
		} elseif (is_string($from)) {
			$this->From = $this -> cleanLine( $from );
		// If it is neither, we throw a warning
		} else {
			Errors::setError('Email invalid');
		}
	}
	
	/**
	 * Set the E-Mail subject
	 * @param string $subject Subject of the e-mail
	 */
	function setSubject($subject) {
		$this->Subject = $this -> cleanLine( $subject );
	}
	/**
	 * Set the E-Mail body
	 * @param string $content Body of the e-mail
	 */
	function setBody($content)
	{
		$this->Body = $this -> cleanText( $content );
	}
	
	/**
	 * Add recipients to the email
	 * @param mixed $recipient Either a string or array of strings [e-mail address(es)]
	 */
//	function addRecipient($recipient)
//	{
//		// If the recipient is an aray, add each recipient... otherwise just add the one
//		if (is_array($recipient))
//		{
//			foreach ($recipient as $to) {
//				$to = $this -> cleanLine( $to );
//				$this->AddAddress($to);
//			}
//		} else {
//			$recipient =  $this ->cleanLine( $recipient );
//			$this->AddAddress($recipient);
//		}
//	}
	

	/**
	 * Add carbon copy recipients to the email
	 * @param mixed $cc Either a string or array of strings [e-mail address(es)]
	 */
//	function addCC($cc)
//	{
//		//If the carbon copy recipient is an aray, add each recipient... otherwise just add the one
//		if (isset ($cc))
//		{
//			if (is_array($cc)) {
//				foreach ($cc as $to) {
//					$to = $this ->cleanLine( $to );
//					parent::AddCC($to);
//				}
//			} else {
//				$cc = $this ->cleanLine( $cc );
//				parent::AddCC($cc);
//			}
//		}
//	}
/**
	 * Add blind carbon copy recipients to the email
	 * @param mixed $cc Either a string or array of strings [e-mail address(es)]
	 */
//	function addBCC($bcc)
//	{
//		// If the blind carbon copy recipient is an aray, add each recipient... otherwise just add the one
//		if (isset ($bcc))
//		{
//			if (is_array($bcc)) {
//				foreach ($bcc as $to) {
//					$to = $this ->cleanLine( $to );
//					parent::AddBCC($to);
//				}
//			} else {
//				$bcc = $this ->cleanLine( $bcc );
//				parent::AddBCC($bcc);
//			}
//		}
//	}

	/**
	 * Add file attachments to the email
	 * @param mixed $attachment Either a string or array of strings [filenames]
	 */
	function _addAttachment($attachment)
	{
		// If the file attachments is an aray, add each file... otherwise just add the one
		if (isset ($attachment))
		{
			if (is_array($attachment)) {
				foreach ($attachment as $file) {
					parent::AddAttachment($file);
				}
			} else {
				parent::AddAttachment($attachment);
			}
		}
	}

	/**
	 * Add Reply to e-mail address(es) to the e-mail
	 *
	 * @param array $reply Either an array or multi-array of form
	 * 		<pre>
	 * 			array( [0] => E-Mail Address [1] => Name )
	 * 		</pre>
	 */
	function addReplyTo($replyto,$name='')
	{
		// Take care of reply email addresses
		if (is_array($replyto[0]))
		{
			foreach ($replyto as $to) {
				$to0 = $this ->cleanLine( $to[0] );
				$to1 = $this ->cleanLine( $to[1] );
				parent::AddReplyTo($to0, $to1);
			}
		} else {
			$replyto0 = $this ->cleanLine( $replyto[0] );
			$replyto1 = $this ->cleanLine( $replyto[1] );
			parent::AddReplyTo($replyto0, $replyto1);
		}
	}

	/**
	 * Use sendmail for sending the e-mail
	 *
	 * @param string $sendmail Path to sendmail [optional]
	 * @return boolean True on success
	 */
	function useSendmail($sendmail = null)
	{
		$this->Sendmail = $sendmail;

		if (!empty ($this->Sendmail)) {
			$this->IsSendmail();
			return true;
		} else {
			$this->IsMail();
			return false;
		}
	}

	/**
	 * Use SMTP for sending the e-mail
	 *
	 * @access public
	 * @param string $auth SMTP Authentication [optional]
	 * @param string $host SMTP Host [optional]
	 * @param string $user SMTP Username [optional]
	 * @param string $pass SMTP Password [optional]
	 * @param string $secure SMTP Secure ssl,tls [optinal]
	 * @param string $port SMTP Port [optional]
	 * @return boolean True on success
	 */
	function useSMTP($auth = null, $host = null, $user = null, $pass = null,$secure = null, $port = 25)
	{
		$this->SMTPAuth = $auth;
		$this->Host 	= $host;
		$this->Username = $user;
		$this->Password = $pass;
		$this->Port     = $port;
		if ($secure == 'ssl' || $secure == 'tls') {
			$this->SMTPSecure = $secure;
		}

		if ($this->SMTPAuth !== null && $this->Host !== null && $this->Username !== null && $this->Password !== null) {
			$this->IsSMTP();
		}
	}
	/************** HELPER **********************************/
	
	/**
	 * Cleans single line inputs.
	 * @param string $value String to be cleaned.
	 * @return string Cleaned string.
	 */
	function cleanLine( $value ) {
		return trim( preg_replace( '/(%0A|%0D|\n+|\r+)/i', '', $value ) );
	}
	
	/**
	 * Cleans multi-line inputs.
	 * @param string $value Multi-line string to be cleaned.
	 * @return string Cleaned multi-line string.
	 */
	function cleanText( $value ) {
		return trim( preg_replace( '/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i', '', $value ) );
	}
	
}