<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

$khoilop = [];
$lop = [];
$namhoc = [];
$giaovien = [];

if(!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
	// Xem phân quyền c
	$taikhoan = array();
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

	if ($result->num_rows > 0) {
		$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
		if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {
			$khoilopQuery = $mysqli->query('SELECT `maKhoiLop` AS `id`, `tenKhoiLop` AS `value` FROM `khoilop`;');
			if ($khoilopQuery->num_rows > 0) {
				$khoilop = $khoilopQuery->fetch_all(MYSQLI_ASSOC);
			}
			$lopQuery = $mysqli->query('SELECT `maLop` AS `id`, `tenLop` AS `value` FROM `lop`;');
			if ($lopQuery->num_rows > 0) {
				$lop = $lopQuery->fetch_all(MYSQLI_ASSOC);
			}
			$namhocQuery = $mysqli->query('SELECT `maNH` AS `id`, `namHoc` AS `value` FROM `namhoc`;');
			if ($namhocQuery->num_rows > 0) {
				$namhoc = $namhocQuery->fetch_all(MYSQLI_ASSOC);
			}
			$giaovienQuery = $mysqli->query('SELECT `maGV` AS `id`, `tenGV` as `value` FROM `giaovien`;');
			if ($giaovienQuery->num_rows > 0) {
				$giaovien = $giaovienQuery->fetch_all(MYSQLI_ASSOC);
			}
		}
	}
}


$response[] = null;
$response[] = $khoilop;
$response[] = $lop;
$response[] = $namhoc;
$response[] = $giaovien;

echo json_encode($response);