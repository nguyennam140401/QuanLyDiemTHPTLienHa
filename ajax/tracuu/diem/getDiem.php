<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

if ((empty($_SESSION['username']) && empty($_SESSION['password']))) {

	$response = [
		"draw" => 0,
		"iTotalRecords" => 0,
		"iTotalDisplayRecords" => 0,
		"aaData" => []
	];
	echo 1;
} else {

	$maHS = empty($_GET['maHS']) ? null : htmlspecialchars($_GET['maHS']);
	$maLop = empty($_GET['maLop']) ? null : htmlspecialchars($_GET['maLop']);
	$maHK = empty($_GET['maHK']) ? null : htmlspecialchars($_GET['maHK']);

	if (!empty($maHS) && !empty($maLop) && !empty($maHK)) {
		$queryHS = $mysqli->query('SELECT `maHS` FROM `hocsinh` WHERE `maHS` = ' . $maHS . '');
		$queryLop = $mysqli->query('SELECT `maLop` FROM `lop` WHERE `maLop` = ' . $maLop . '');
		$queryHK = $mysqli->query('SELECT `maHK` FROM `hocky` WHERE `maHK` = ' . $maHK . '');
		if ($queryHK->num_rows > 0 && $queryLop->num_rows > 0 && $queryHS->num_rows > 0) {

			$draw = empty($_POST['draw']) ? '' : htmlspecialchars($_POST['draw']);
			$row = empty($_POST['start']) ? 0 : htmlspecialchars($_POST['start']);
			$rowperpage = empty($_POST['length']) ? 10 : htmlspecialchars($_POST['length']);  // Rows display per page

			##SortOrder 
			$columnIndex = empty($_POST['order'][0]['column']) ? 0 : htmlspecialchars($_POST['order'][0]['column']); // Column index
			$columnName =  '`monhoc`.`maMH`'; // Column name
			// if (is_array($_POST['columns'][$columnIndex]['data'])) {
			// 	$columnName = empty($_POST['columns'][$columnIndex]['data']['sort']) ? '`monhoc`.`maMH`' : htmlspecialchars($_POST['columns'][$columnIndex]['data']['sort']);
			// } else {
			// 	$columnName = empty($_POST['columns'][$columnIndex]['data']) ? '`monhoc`.`maMH`' : htmlspecialchars($_POST['columns'][$columnIndex]['data']);
			// }
			$columnSortOrder = 'asc';

			## Search 
			$TimKiem = ' WHERE `phan_lop_hocsinh`.`maLop` = ' . $maLop . ' AND `phan_lop_hocsinh`.`maHK` = ' . $maHK . '  AND `phan_lop_hocsinh`.`maHS` = ' . $maHS . ' ';
			$searchQuery = ' ';
			$searchValue = empty($_POST['search']) ? '' : htmlspecialchars($_POST['search']); // Search value
			if ($searchValue != '') {
				$searchQuery .= " AND (`tenMH` like '%" . $searchValue . "%') ";
			}

			## Total number of records without filtering
			$sql1 = 'SELECT count(*) AS `allcount` FROM (SELECT `diem`.`id` FROM `diem` LEFT JOIN `monhoc` ON `monhoc`.`maMH` = `diem`.`maMH` WHERE `hocsinh_phanlopID` IN( SELECT DISTINCT `id` AS `hocsinh_phanlopID` FROM `phan_lop_hocsinh` ' . $TimKiem . ' ) UNION SELECT `diem`.`id` FROM `diem` RIGHT JOIN `monhoc` ON `monhoc`.`maMH` = `diem`.`maMH` WHERE `hocsinh_phanlopID` IN( SELECT DISTINCT `id` AS `hocsinh_phanlopID` FROM `phan_lop_hocsinh` ' . $TimKiem . ' )) AS `count`';
			$sel = $mysqli->query($sql1);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];
			## Total number of records with filtering
			$sql2 = 'SELECT count(*) AS `allcount` FROM (SELECT `diem`.`id` FROM `diem` LEFT JOIN `monhoc` ON `monhoc`.`maMH` = `diem`.`maMH` WHERE `hocsinh_phanlopID` IN( SELECT DISTINCT `id` AS `hocsinh_phanlopID` FROM `phan_lop_hocsinh` ' . $TimKiem . ' ) ' . $searchQuery . ' UNION SELECT `diem`.`id` FROM `diem` RIGHT JOIN `monhoc` ON `monhoc`.`maMH` = `diem`.`maMH` WHERE `hocsinh_phanlopID` IN( SELECT DISTINCT `id` AS `hocsinh_phanlopID` FROM `phan_lop_hocsinh` ' . $TimKiem . ' ) ' . $searchQuery . ') AS `count`';
			$sel = $mysqli->query($sql2);

			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			## Fetch records
			$empQuery = 'SELECT * FROM `diem` LEFT JOIN monhoc on diem.maMH = monhoc.maMH left JOIN phan_lop_hocsinh on diem.hocsinh_phanlopID = phan_lop_hocsinh.id WHERE phan_lop_hocsinh.maHS = ' . $maHS . ' and phan_lop_hocsinh.maLop =' . $maLop . ' and phan_lop_hocsinh.maHK=' . $maHK;

			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);

			$data = array();

			while ($row = $empRecords->fetch_array(MYSQLI_ASSOC)) {
				$data[] = array(
					'tenMH' => $row['tenMH'],
					'diemtx' => $row['diemtx'],
					'diem15p' => $row['diem15p'],
					'diem1t' => $row['diem1t'],
					'diemhk' => $row['diemhk'],
					'DTBmhk' => $row['DTBmhk']
				);
			}

			## Response
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordwithFilter,
				"aaData" => $data
			);
		} else {

			$response = [
				"draw" => 0,
				"iTotalRecords" => 0,
				"iTotalDisplayRecords" => 0,
				"aaData" => []
			];
		}
	} else {

		$response = [
			"draw" => 0,
			"iTotalRecords" => 0,
			"iTotalDisplayRecords" => 0,
			"aaData" => []
		];
	}
}

echo json_encode($response);