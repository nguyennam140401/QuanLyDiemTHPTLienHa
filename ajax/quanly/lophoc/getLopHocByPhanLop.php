<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

$lop = [];
if (!empty($_GET['id'])) {
	$phanlopID = (int)htmlspecialchars($_GET['id']);
	if(!empty($_SESSION['username']) && !empty($_SESSION['password'])) {
		// Xem phân quyền c
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				$getQuery = $mysqli->query('SELECT * FROM `lop` WHERE `maLop` IN (SELECT DISTINCT `maLop` FROM `phan_lop_hocsinh` WHERE `id` = '.$phanlopID.');');
				if ($getQuery->num_rows > 0) {
					$lopCu = $getQuery->fetch_array(MYSQLI_ASSOC);

					$newQuery = $mysqli->query('SELECT * FROM `lop` WHERE `maLop` != '.$lopCu['maLop'].' AND `maNH` = '.$lopCu['maNH'].' AND `maKhoiLop` = '.$lopCu['maKhoiLop'].';');
					if ($newQuery->num_rows > 0) {
						$lop = $newQuery->fetch_all(MYSQLI_ASSOC);
					}
				}

			}
		}
	}
}


$response = $lop;
echo json_encode($response);