<?php
/**
 * @Hoang Phuc
 * http://reportadsen1.0.localhost:8090 
 */
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
// Define file upload properties
// ini_set('post_max_size', '1536M');
// ini_set('upload_max_filesize', '1536M');
// ini_set('memory_limit', '1536M');

$filename_client_param = __DIR__.'/param.php';
$now_file = __DIR__.'/nowpr.php';

if( @file_exists($filename_client_param) || @file_exists($now_file)   ) {
	include $filename_client_param;
	include $now_file;
}else { die("Oops Error param");}

ini_set ( "error_reporting", E_ALL & ~ E_DEPRECATED & ~E_USER_DEPRECATED  & ~ E_STRICT );

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}



// Setup autoloading
require 'init_autoloader.php';


// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
