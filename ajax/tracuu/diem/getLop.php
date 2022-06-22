<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = null;

if (!empty($_GET['maHS'])) {
	$maHS = (int)htmlspecialchars($_GET['maHS']);
	$hockyQuery = $mysqli->query('SELECT `maLop`, `tenLop`, `namHoc` FROM `lop` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH` WHERE `maLop` IN (SELECT DISTINCT `maLop` FROM `phan_lop_hocsinh` WHERE `maHS` = '.$maHS.');');
	if ($hockyQuery->num_rows > 0) {
		$response = $hockyQuery->fetch_all(MYSQLI_ASSOC);
	}
}


echo json_encode($response);