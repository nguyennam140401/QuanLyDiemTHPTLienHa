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
			// Max select
			if ($rowperpage == -1) {
				$rowperpage = 99999999999;
			}

			##SortOrder 
			$columnIndex = empty($_GET['order'][0]['column']) ? 0 : htmlspecialchars($_GET['order'][0]['column']); // Column index
			$columnName =  'maHS'; // Column name

			$columnSortOrder = empty($_GET['order'][0]['dir']) ? 'asc' : htmlspecialchars($_GET['order'][0]['dir']); // asc or desc

			## Search 
			$searchValue = empty($_GET['search']) ? '' : htmlspecialchars($_GET['search']); // Search value
			$searchQuery = " ";
			if ($searchValue != '') {
				$searchQuery .= " AND (`tenHS` like '%" . $searchValue . "%') ";
			}



			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `hocsinh`  WHERE 1 " . $searchQuery);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];

			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `hocsinh` LEFT JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDUT` LEFT JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` LEFT JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD` WHERE 1 " . $searchQuery);
			//echo "SELECT count(*) AS `allcount` FROM `hocsinh` INNER JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` INNER JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD` INNER JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDT` WHERE 1 ".$searchQuery;
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			## Fetch records
			$empQuery = "SELECT *  FROM `hocsinh` LEFT JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDUT` LEFT JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` LEFT JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD`  WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);

			$data = array();

			while ($row = $empRecords->fetch_array(MYSQLI_ASSOC)) {
				$data[] = array(
					'maHS' => $row['maHS'],
					'tenHS' => $row['tenHS'],
					'ngaySinh' => $row['ngaySinh'],
					'gioiTinh' => $row['gioiTinh'],
					'noiSinh' => $row['noiSinh'],
					'dienuutien' => array(
						'maDUT' => $row['maDUT'],
						'dienUuTien' => $row['dienUuTien']
					),
					'dantoc' => array(
						'maDT' => $row['maDT'],
						'tenDT' => $row['tenDT']
					),
					'thanhphangiadinh' => array(
						'maTPGD' => $row['maTPGD'],
						'tenTPGD' => $row['tenTPGD']
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