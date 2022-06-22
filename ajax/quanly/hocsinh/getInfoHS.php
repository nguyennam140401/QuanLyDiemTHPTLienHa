<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

$dienuutien = [];
$dantoc = [];
$tpgiadinh = [];

if(!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
	// Xem phân quyền c
	$taikhoan = array();
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

	if ($result->num_rows > 0) {
		
		$utQuery = $mysqli->query('SELECT `maDUT` AS `id`, `dienUuTien` AS `value` FROM `dienuutien`;');
		if ($utQuery->num_rows > 0) {
			$dienuutien = $utQuery->fetch_all(MYSQLI_ASSOC);
		}
		$dtQuery = $mysqli->query('SELECT `maDT` AS `id`, `tenDT` AS `value` FROM `dantoc`;');
		if ($dtQuery->num_rows > 0) {
			$dantoc = $dtQuery->fetch_all(MYSQLI_ASSOC);
		}
		$gdQuery = $mysqli->query('SELECT `maTPGD` AS `id`, `tenTPGD` AS `value` FROM `thanhphangiadinh`;');
		if ($gdQuery->num_rows > 0) {
			$tpgiadinh = $gdQuery->fetch_all(MYSQLI_ASSOC);
		}

	}
}


$response[] = $dienuutien;
$response[] = $dantoc;
$response[] = $tpgiadinh;
echo json_encode($response);