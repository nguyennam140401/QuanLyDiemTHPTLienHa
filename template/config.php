<?php
$configs = array(
    'hostname' => 'localhost',
    'dbuser' => 'root',
    'dbpass' => '',
    'dbname' => 'vnedu'
);

$mysqli = new mysqli($configs['hostname'], $configs['dbuser'], $configs['dbpass'], $configs['dbname']);

//Kiểm tra kết nối
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	exit();
}
$mysqli->query('SET NAMES `utf8`');
date_default_timezone_set('Asia/Ho_Chi_Minh');
