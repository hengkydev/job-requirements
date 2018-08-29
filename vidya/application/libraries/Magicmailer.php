<?php

class Magicmailer extends \PHPMailer{

	function __construct() {
		parent::__construct();

		$config 	= ConfigModel::first();

		$this->isSMTP();                                      // Set mailer to use SMTP
		$this->setFrom(EMAIL_USER, $config->name);
		$this->Host = EMAIL_HOST;  // Specify main and backup SMTP servers
		$this->SMTPAuth = true;                               // Enable SMTP authentication
		$this->Username = EMAIL_USER;                 // SMTP username
		$this->Password = EMAIL_PASS;                           // SMTP password
		$this->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$this->isHTML(true); 
		$this->Port = EMAIL_PORT;
	}
}