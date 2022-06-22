<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

if((empty($_SESSION['username']) && empty($_SESSION['password']))) {

	$response = [
	    "draw" => 0,
	    "iTotalRecords" => 0,
	    "iTotalDisplayRecords" => 0,
	    "aaData" => []
	];
}
else {
	
	// Xem phân quyền c
	$taikhoan = array();
	$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

	if ($result->num_rows > 0) {
		$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
		if (in_array($taikhoan['role'], array('admin', 'manager'))) {

			$draw = empty($_POST['draw']) ? '' : htmlspecialchars($_POST['draw']);  
			$row = empty($_POST['start']) ? 0 : htmlspecialchars($_POST['start']); 
			$rowperpage =empty($_POST['length']) ? 5 : htmlspecialchars($_POST['length']);  // Rows display per page
			$columnIndex = empty($_POST['order'][0]['column']) ? 0 : htmlspecialchars($_POST['order'][0]['column']); // Column index
			$columnName = empty($_POST['columns'][$columnIndex]['data']) ? 'maMH' : htmlspecialchars($_POST['columns'][$columnIndex]['data']); // Column name

			$columnSortOrder = empty($_POST['order'][0]['dir']) ? 'asc' : htmlspecialchars($_POST['order'][0]['dir']); // asc or desc
			$searchValue = empty($_POST['search']['value']) ? '' : htmlspecialchars($_POST['search']['value']); // Search value
			 
			## Search 
			$searchQuery = " ";
			if($searchValue != ''){
			   $searchQuery .= " AND (`maMH` like '%".$searchValue."%' OR
			            `tenMH` LIKE '%".$searchValue."%' ) ";
			}
			 
			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `monhoc`");
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];
			 
			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `monhoc` WHERE 1 ".$searchQuery);
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];
			 
			## Fetch records
			$empQuery = "SELECT * FROM `monhoc` WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);
			 
			$data = array();
			 
			while($row = $empRecords->fetch_array(MYSQLI_ASSOC)){
			    $data[] = array(
			    		"maMH" => $row['maMH'],
			            "tenMH"=>$row['tenMH']
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