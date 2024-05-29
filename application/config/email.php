<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
	'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'protocol'    => 'smtp',                          // 'mail', 'sendmail', or 'smtp'
    'smtp_host'    => 'zimbramail.optiktunggal.com',
    // 'smtp_user'    => 'no-reply@optiktunggal.com',
	'smtp_user'    => 'no-reply@optiktunggal.com',
    'smtp_pass'    => 'L03t03y3?!',

	// 'smtp_host' 	=> 'smtp.gmail.com',
	// 'smtp_user' 	=> '@gmail.com',  // Email gmail
	// 'smtp_pass'   	=> '',

    'smtp_port'    => '465',
    'smtp_crypto'  => 'ssl',                           //can be 'ssl' or 'tls' for example
    // 'mailtype'     => 'text',                          //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4',                             //in seconds
    // 'charset'      => 'iso-8859-1',
    // 'mailtype'     => 'html',
    'wordwrap'     => TRUE
);


$config22 = array(
	'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'protocol'    => 'smtp',                          // 'mail', 'sendmail', or 'smtp'
    'smtp_host'    => '192.168.11.76',
    // 'smtp_user'    => 'no-reply@optiktunggal.com',
	'smtp_user'    => 'no-reply@optiktunggal.co.id',
    'smtp_pass'    => 'L03t03y3?!',

	// 'smtp_host' 	=> 'smtp.gmail.com',
	// 'smtp_user' 	=> '@gmail.com',  // Email gmail
	// 'smtp_pass'   	=> '',

    'smtp_port'    => '587',
    // 'smtp_crypto'  => 'ssl',                           //can be 'ssl' or 'tls' for example
    // 'mailtype'     => 'text',                          //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4',                             //in seconds
    // 'charset'      => 'iso-8859-1',
    // 'mailtype'     => 'html',
    'wordwrap'     => TRUE
);



