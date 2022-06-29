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

	$maLop = empty($_GET['maLop']) ? null : htmlspecialchars($_GET['maLop']);
	$maHK = empty($_GET['maHK']) ? null : htmlspecialchars($_GET['maHK']);

	if (!empty($maLop) && !empty($maHK)) {
		$queryLop = $mysqli->query('SELECT `maLop` FROM `lop` WHERE `maLop` = ' . $maLop . '');
		$queryHK = $mysqli->query('SELECT `maHK` FROM `hocky` WHERE `maHK` = ' . $maHK . '');
		if ($queryHK->num_rows > 0 && $queryLop->num_rows > 0) {

			$draw = empty($_GET['draw']) ? '' : htmlspecialchars($_GET['draw']);
			$row = empty($_GET['start']) ? 0 : htmlspecialchars($_GET['start']);
			$rowperpage = empty($_GET['length']) ? 10 : htmlspecialchars($_GET['length']);  // Rows display per page

			##SortOrder 

			$columnName =  '`hocsinh`.`maHS`'; // Column name


			## Search 
			$TimKiem = ' WHERE `phan_lop_hocsinh`.`maLop` = ' . $maLop . ' AND `phan_lop_hocsinh`.`maHK` = ' . $maHK . ' ';
			$searchQuery = ' ';
			$searchValue = empty($_GET['search']) ? '' : htmlspecialchars($_GET['search']); // Search value
			if ($searchValue != '') {
				$searchQuery .= " AND (`tenHS` like '%" . $searchValue . "%' OR
			            `noiSinh` LIKE '%" . $searchValue . "%' OR `ngaySinh` LIKE '%" . $searchValue . "%') ";
			}



			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `phan_lop_hocsinh`" . $TimKiem);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];
			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `phan_lop_hocsinh` INNER JOIN `lop` ON `lop`.`maLop` = `phan_lop_hocsinh`.`maLop` INNER JOIN `hocsinh` ON `hocsinh`.`maHS` = `phan_lop_hocsinh`.`maHS` INNER JOIN `hocky` ON `hocky`.`maHK` = `phan_lop_hocsinh`.`maHK`" . $TimKiem . $searchQuery);

			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			## Fetch records
			$empQuery = "SELECT * FROM `phan_lop_hocsinh` INNER JOIN `lop` ON `lop`.`maLop` = `phan_lop_hocsinh`.`maLop` INNER JOIN `hocsinh` ON `hocsinh`.`maHS` = `phan_lop_hocsinh`.`maHS` INNER JOIN `hocky` ON `hocky`.`maHK` = `phan_lop_hocsinh`.`maHK`" . $TimKiem . $searchQuery . " ORDER BY " . $columnName . " LIMIT " . $row . "," . $rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);

			$data = array();

			while ($row = $empRecords->fetch_array(MYSQLI_ASSOC)) {
				$data[] = array(
					'phan_lop_hocsinh' => array('id' => $row['id']),
					'hocsinh' => array(
						'maHS' => $row['maHS'],
						'tenHS' => $row['tenHS'],
						'ngaySinh' => $row['ngaySinh'],
						'gioiTinh' => $row['gioiTinh'],
						'noiSinh' => $row['noiSinh']
					)
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