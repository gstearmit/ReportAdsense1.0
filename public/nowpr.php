<?php
chdir(dirname(__DIR__));
define('DB_CONFIG_LBC', 'FALSE');
define('DOMAIN_DIR'	, ""); 
define('APPLICATION_PATH23', realpath(dirname(__DIR__)));
define('PUPLICH_HTML_DATA', APPLICATION_PATH23.'/public_html/uploads/user/'); 
define('WEBPATH_NO_HTTP', $_SERVER['SERVER_NAME']);
 
define('ROOT_PATH', dirname(__DIR__));

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
   define('WEBPATH', 'https://'.$_SERVER['SERVER_NAME'].':8090');
else
   define('WEBPATH', 'http://'.$_SERVER['SERVER_NAME'].':8090');
  

define('CACHE', dirname(__DIR__).'/cache');
 
define('LIBRARY_PATH', realpath(APPLICATION_PATH23 . '/library/'));
define('PUBLIC_PATH'	, realpath(APPLICATION_PATH23 . '/public_html'));
define('TEMPLATE_PATH'	, realpath(PUBLIC_PATH . '/templates'));
define('DIR_UPLOAD_NEW'	, realpath(PUBLIC_PATH.'/uploadnews'));
 
define('FILES_PATH'	, realpath(PUBLIC_PATH . '/files'));
define('MZIMG_PATH'	, realpath(PUBLIC_PATH . '/images'));


define('IP_SERVER_TEST', '127.0.0.1');
define('IP_SERVER_TEST2', '192.168.5.101:1993');
define('IP_SERVER_TEST3', '192.168.10.11');
define('ENVIRONMENT', 'development');
/*
 if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		    break; 
		case 'testing':
		case 'production':
			error_reporting(0);
		    break; 
		default:
			exit('The application environment is not set correctly.');
	}
}
 */

define('CPANEL_USR', 'host3');
define('CPANEL_PASS', '');
define('CPANEL_IP', '212..198');
define('CPANEL_DOMAIN_PRIMARY', '@host3.vn');  
define('IP_VIDEO_PRIMARY', '212.1');

define('PUBLIC_ALAT', realpath(APPLICATION_PATH23 . '/public/html/'));

define('UPLOAD_PATH_IMG', ROOT_PATH.'/public_html/uploads/');
 

define('WEB_MEDIA',  str_replace("\\","/",__DIR__));
define('WEB_DIR',  str_replace("\\","/",dirname(__DIR__)));
define('WEB_PATH', WEBPATH);
define('WEB_PUBLIC', realpath(APPLICATION_PATH23 .'/public/'));
define('WEB_UPLOAD', realpath(APPLICATION_PATH23 .'/upload/'));
 

define('EXPORT_FILE_DIR', ROOT_PATH.'/public/export');
  
//Facebook-----------------------------
define('FB_APP_ID', '168444390237908');
define('FB_APP_SECRET', 'c18c9b767eea44ba7c67cdb2293377a5');
//End Facebook ------------------------
 
