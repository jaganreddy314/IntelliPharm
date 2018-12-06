<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'intellipharma';
define('DB_SERVER', $dbhost);
//database login name
define('DB_USER', $dbuser);
//database login password
define('DB_PASS', $dbpass);
//database name
define('DB_DATABASE', $dbname);

//autoload function saves having to include all files individually
function my_autoloader($class) {
    include 'objects/' . $class . '.php';
}

spl_autoload_register('my_autoloader');

?>