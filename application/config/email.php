<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['mailpath']             = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
$config['useragent']            = "CodeIgniter";
$config['smtp_host']            = 'mail.vbsbs.com.br';

$config['smtp_port']            = 465;
$config['smtp_user']            = 'comercial@vbsbs.com.br';
$config['smtp_pass']            = 'comercial12';
$config['smtp_keepalive']       = TRUE;

$config['protocol']             = 'sendmail';
$config['validate']             = TRUE;
$config['mailtype']             = 'html';
$config['charset']              = 'UTF-8';
$config['newline']              = "\r\n";
$config['crlf']                 = "\r\n";
?>