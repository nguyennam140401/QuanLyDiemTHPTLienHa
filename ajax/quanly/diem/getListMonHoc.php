<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];


if(!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
	// Xem phân quyền c
	$taikhoan = array();
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

	if ($result->num_rows > 0) {
		
		$Query = $mysqli->query('SELECT * FROM `monhoc`;');
		if ($Query->num_rows > 0) {
			$response = $Query->fetch_all(MYSQLI_ASSOC);
		}

	}
}


echo json_encode($response);