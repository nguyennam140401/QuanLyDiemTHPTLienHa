<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = null;

if (!empty($_GET['maHS']) && !empty($_GET['maLop'])) {
	$maHS = (int)htmlspecialchars($_GET['maHS']);
	$maLop = (int)htmlspecialchars($_GET['maLop']);

	$hockyQuery = $mysqli->query('SELECT `maHK`, `tenHK` FROM `hocky` WHERE `maHK` IN (SELECT DISTINCT `maHK` FROM `phan_lop_hocsinh` WHERE `maHS` = '.$maHS.' AND `maLop` = '.$maLop.');');
	if ($hockyQuery->num_rows > 0) {
		$response = $hockyQuery->fetch_all(MYSQLI_ASSOC);
	}
}


echo json_encode($response);