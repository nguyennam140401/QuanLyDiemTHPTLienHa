<?php
session_start();
ob_start();
require './../../template/config.php';

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
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . ($_SESSION['username']) . '\' AND `password`=\'' . ($_SESSION['password']) . '\';');
	if ($result->num_rows > 0) {
		$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
		if (in_array($taikhoan['role'], array('admin', 'manager'))) {
			$draw = empty($_GET['draw']) ? '' : ($_GET['draw']); //Trang thứ bao nhiêu
			$row = empty($_GET['start']) ? 0 : ($_GET['start']); // Số bản ghi bỏ qua (phân trang)
			$rowperpage = empty($_GET['length']) ? 50 : ($_GET['length']);  // Số bản ghi 1 trang

			$columnSortOrder = empty($_GET['order'][0]['dir']) ? 'asc' : ($_GET['order'][0]['dir']); // asc or desc
			$searchValue = empty($_GET['search']) ? '' : ($_GET['search']); // Search value

			## Search 
			$searchQuery = " ";
			if ($searchValue != '') {
				$searchQuery .= " and (username like '%" . $searchValue . "%' or
			            email like '%" . $searchValue . "%' or
			            role like'%" . $searchValue . "%' ) ";
			}

			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `taikhoan`");
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];

			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `taikhoan` WHERE 1 " . $searchQuery);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			## Fetch records
			$empQuery = "SELECT * FROM `taikhoan` WHERE 1 " . $searchQuery . " ORDER BY id"  . " " . $columnSortOrder . " LIMIT " . $row . "," . $rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);

			$data = array();

			while ($row = $empRecords->fetch_array(MYSQLI_ASSOC)) {
				$data[] = array(
					"id" => $row['id'],
					"username" => $row['username'],
					"role" => $row['role'],
					"email" => $row['email']
				);
			}

			## Response
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords, //Tổng số bản ghi
				"iTotalDisplayRecords" => $totalRecordwithFilter, //Số bản ghi lấy ra
				"aaData" => $data // Danh sách bản ghi
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