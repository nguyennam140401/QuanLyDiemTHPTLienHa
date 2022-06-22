<?php
session_start();
ob_start();
require './../../Template/config.php';

header('Content-Type: application/json');


$response = [];
$draw = empty($_POST['draw']) ? '' : htmlspecialchars($_POST['draw']);  

if((empty($_SESSION['username']) && empty($_SESSION['password']))) {

	$response = [
	    "draw" => intval($draw),
	    "iTotalRecords" => 0,
	    "iTotalDisplayRecords" => 0,
	    "aaData" => []
	];
	echo 1;
}
else {
	
	$maLop = empty($_GET['maLop']) ? null : htmlspecialchars($_GET['maLop']);

	if (!empty($maLop)) {
		$queryLop = $mysqli->query('SELECT `maLop` FROM `lop` WHERE `maLop` = '.$maLop.'');
		if ($queryLop->num_rows > 0) {

			
			
			$Info = [];

			$hocsinhQuery = $mysqli->query('SELECT * FROM `hocsinh` INNER JOIN `phan_lop_hocsinh` ON `phan_lop_hocsinh`.`maHS` = `hocsinh`.`maHS` WHERE `maLop` = '.$maLop.' ');
			if ($hocsinhQuery->num_rows > 0) {
				$hockyQuery = $mysqli->query('SELECT * FROM `hocky`');
				$hockyAll = [];
				if ($hockyQuery->num_rows > 0) {
					$hockyAll  = $hockyQuery->fetch_all(MYSQLI_ASSOC);
				}
				$diem = [];
				while ($hocsinh = $hocsinhQuery->fetch_array(MYSQLI_ASSOC)) {
					$diem = []; 
					foreach ($hockyAll as $hocky) {
						$queryDiem = $mysqli->query('SELECT AVG(`DTBmhk`) as `DTBhk` FROM `diem` WHERE `hocsinh_phanlopID` IN (SELECT `id` AS `hocsinh_phanlopID` FROM `phan_lop_hocsinh` WHERE `maHS` = '.$hocsinh['maHS'].' AND `maHK` = '.$hocky['maHK'].' AND `maLop` = '.$maLop.')');
						if ($queryDiem->num_rows > 0) {
							$diem[] = $queryDiem->fetch_array(MYSQLI_ASSOC)['DTBhk'];
						} else {
							$diem[] = '';
						}
						
					}
					if ($diem[0] !== NULL && $diem[1] !== NULL) {
						$diemCN = round(($diem[0] + $diem[1] * 2)/3, 2); // lấy 2 số thập phân
					}else {
						$$diemCN = null;
					}
					
					$Info[] = [
						'hocsinh' => [
							'maHS' => $hocsinh['maHS'],
							'tenHS' => $hocsinh['tenHS'],
							'ngaySinh' => $hocsinh['ngaySinh'],
							'gioiTinh' => $hocsinh['gioiTinh'],
							'noiSinh' => $hocsinh['noiSinh']
						],
						'diem' => [
							'hk1' => round($diem[0], 2),
							'hk2' => round($diem[1], 2),
							'CN' => $diemCN
						]
					];
					$diem = [];
				}

				## Response
				$response = array(
				    "draw" => intval($draw),
				    "iTotalRecords" => 0,
				    "iTotalDisplayRecords" => 0,
				    "aaData" => $Info
				);
			} else {
				$response = [
				    "draw" => intval($draw),
				    "iTotalRecords" => 0,
				    "iTotalDisplayRecords" => 0,
				    "aaData" => []
				];
			}

			 
			
		} else {

			$response = [
			    "draw" => intval($draw),
			    "iTotalRecords" => 0,
			    "iTotalDisplayRecords" => 0,
			    "aaData" => []
			];
		}
	} else {

		$response = [
		    "draw" => intval($draw),
		    "iTotalRecords" => 0,
		    "iTotalDisplayRecords" => 0,
		    "aaData" => []
		];
	}
}

echo json_encode($response);