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
} else {

	// Xem phân quyền c
	$taikhoan = array();
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . htmlspecialchars($_SESSION['username']) . '\' AND `password`=\'' . htmlspecialchars($_SESSION['password']) . '\';');

	if ($result->num_rows > 0) {
		$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
		if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {

			$draw = empty($_GET['draw']) ? '' : htmlspecialchars($_GET['draw']);
			$row = empty($_GET['start']) ? 0 : htmlspecialchars($_GET['start']);
			$rowperpage = empty($_GET['length']) ? 10 : htmlspecialchars($_GET['length']);  // Rows display per page

			##SortOrder 
			$columnIndex = empty($_GET['order'][0]['column']) ? 0 : htmlspecialchars($_GET['order'][0]['column']); // Column index
			$columnName =  'maLop'; // Column name

			$columnSortOrder = empty($_GET['order'][0]['dir']) ? 'asc' : htmlspecialchars($_GET['order'][0]['dir']); // asc or desc

			## Search 
			$searchValue = empty($_GET['search']) ? '' : htmlspecialchars($_GET['search']); // Search value
			$searchQuery = " ";
			if ($searchValue != '') {
				$searchQuery .= " AND (`tenKhoiLop` like '%" . $searchValue . "%' OR
			            `tenLop` LIKE '%" . $searchValue . "%' OR `namHoc` LIKE '%" . $searchValue . "%' OR `tenGV` LIKE '%" . $searchValue . "%') ";
			}



			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `lop`");
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];

			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `lop` INNER JOIN `khoilop` ON `lop`.`maKhoiLop` = `khoilop`.`maKhoiLop` INNER JOIN `giaovien` ON `lop`.`maGV` = `giaovien`.`maGV` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH` WHERE 1 " . $searchQuery);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			## Fetch records
			$empQuery = "SELECT * FROM `lop` INNER JOIN `khoilop` ON `lop`.`maKhoiLop` = `khoilop`.`maKhoiLop` INNER JOIN `giaovien` ON `lop`.`maGV` = `giaovien`.`maGV` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH`  WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);

			$data = array();

			while ($row = $empRecords->fetch_array(MYSQLI_ASSOC)) {
				$data[] = array(
					'maLop' => $row['maLop'],
					'tenLop' => $row['tenLop'],
					'khoilop' => array(
						'maKhoiLop' => $row['maKhoiLop'],
						'tenKhoiLop' => $row['tenKhoiLop']
					),
					'namhoc' => array(
						'maNH' => $row['maNH'],
						'namHoc' => $row['namHoc']
					),
					'giaovien' => array(
						'maGV' => $row['maGV'],
						'tenGV' => $row['tenGV']
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