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
		if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {

			$draw = empty($_POST['draw']) ? '' : htmlspecialchars($_POST['draw']);  
			$row = empty($_POST['start']) ? 0 : htmlspecialchars($_POST['start']); 
			$rowperpage =empty($_POST['length']) ? 10 : htmlspecialchars($_POST['length']);  // Rows display per page
			// Max select
			if ($rowperpage == -1) {
				$rowperpage = 99999999999;
			}

			##SortOrder 
			$columnIndex = empty($_POST['order'][0]['column']) ? 0 : htmlspecialchars($_POST['order'][0]['column']); // Column index
			$columnName =  'maHS'; // Column name
			if (is_array($_POST['columns'][$columnIndex]['data'])) {
				$columnName = empty($_POST['columns'][$columnIndex]['data']['sort']) ? 'maHS' : htmlspecialchars($_POST['columns'][$columnIndex]['data']['sort']);
			} else {
				$columnName = empty($_POST['columns'][$columnIndex]['data']) ? 'maHS' : htmlspecialchars($_POST['columns'][$columnIndex]['data']);
			}
			$columnSortOrder = empty($_POST['order'][0]['dir']) ? 'asc' : htmlspecialchars($_POST['order'][0]['dir']); // asc or desc
			 
			## Search 
			$searchValue = empty($_POST['search']['value']) ? '' : htmlspecialchars($_POST['search']['value']); // Search value
			$searchQuery = " ";
			if($searchValue != ''){
			   $searchQuery .= " AND (`tenHS` like '%".$searchValue."%' OR `ngaySinh` LIKE '%".$searchValue."%' OR `noiSinh` LIKE '%".$searchValue."%' OR `dienUuTien` LIKE '%".$searchValue."%' OR `tenDT` LIKE '%".$searchValue."%' OR `tenTPGD` LIKE '%".$searchValue."%') ";
			}

			## ColumnSearch
			foreach ($_POST['columns'] as $column) {
				if (isset($column['searchable']) && $column['searchable'] && !empty($column['search']['value'])) {
					$columnSearchTable = is_array($column['data']) ? htmlspecialchars($column['data']['_']) : htmlspecialchars($column['data']);
					$searchValue = htmlspecialchars($column['search']['value']);
					$searchValue = str_replace(array('$','^'), '', $searchValue);
					$searchQuery .= ' AND '.$columnSearchTable.' = \''.$searchValue.'\' ';
				}
			}
			
			## Total number of records without filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `hocsinh`");
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecords = $records['allcount'];
			 
			## Total number of records with filtering
			$sel = $mysqli->query("SELECT count(*) AS `allcount` FROM `hocsinh` LEFT JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDUT` LEFT JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` LEFT JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD` WHERE 1 ".$searchQuery);
			//echo "SELECT count(*) AS `allcount` FROM `hocsinh` INNER JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` INNER JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD` INNER JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDT` WHERE 1 ".$searchQuery;
			$records = $sel->fetch_array(MYSQLI_ASSOC);
			$totalRecordwithFilter = $records['allcount'];
			 
			## Fetch records
			$empQuery = "SELECT *  FROM `hocsinh` LEFT JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDUT` LEFT JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maDT` LEFT JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD` = `hocsinh`.`maTPGD`  WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;
			//echo $empQuery;
			$empRecords = $mysqli->query($empQuery);
			 
			$data = array();
			 
			while($row = $empRecords->fetch_array(MYSQLI_ASSOC)){
			    $data[] = array(
			    		'maHS' => $row['maHS'],
			    		'tenHS' => $row['tenHS'],
			    		'ngaySinh' => $row['ngaySinh'],
			    		'gioiTinh' => $row['gioiTinh'],
			    		'noiSinh' => $row['noiSinh'],
			            'dienuutien'=> array(
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