<?php
session_start();
define("IS_LIVE",false);

if(IS_LIVE){
	define("DB_HOST", "localhost");
	define("DB_NAME", "");
	define("DB_CHARSET", "utf8");
	define("DB_USER", "");
	define("DB_PASSWORD", "");
}else{
	define("DB_HOST", "localhost");
	define("DB_NAME", "thirdeye_onle");
	define("DB_CHARSET", "utf8");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
}

define("DB_PREFIX", "sms_");
define("PAGINATION", "50");
date_default_timezone_set('Asia/Kolkata');
define("SITE_NAME", "ONLE");
define("SITE_URL", "ONLE");
define("WEBSERVICE_URL", "");

define("SMTP_DEBUG", 0);
define("SMTP_DEBUG_OUTPUT", "html");
define("SMTP_HOST", "mail.thirdeyeinfo.com");
define("SMTP_PORT", 587);
define("SMTP_SECURE", "tls");
define("SMTP_AUTH", true);
define("SMTP_USERNAME", "lovek468@gmail.com");
define("SMTP_PASSWORD", "lovek468@");
define("SMTP_MAIL_FROM_EMAIL", "lovek468@gmail.com");
define("SMTP_MAIL_FROM_NAME", "lovek468@");
define("SMTP_MAIL_REPLY_FROM_EMAIL", "lovek468@gmail.com");
define("SMTP_MAIL_REPLY_FROM_NAME", "lovek468@");

define("SYSTEM_DEFAULT_YEAR", 2020);
define("DEVELOPER_EMAIL", "lovek468@gmail.com");
// FOR DEVELOPMENT
/*error_reporting(E_ERROR);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
// ---------------------- //
?>
