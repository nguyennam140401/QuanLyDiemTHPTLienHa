<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

if((empty($_SESSION['username']) && empty($_SESSION['password']))) {
	$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
}
else {
	
	if (!empty($_POST['maLop']) && !empty($_POST['maMH']) && !empty($_POST['maGV']) ) {
		$maLop = htmlspecialchars($_POST['maLop']);
		$maMH = htmlspecialchars($_POST['maMH']);
		$maGV = htmlspecialchars($_POST['maGV']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				$searchLop = $mysqli->query('SELECT * FROM `lop` WHERE `maLop`= '.$maLop.';');
				$searchMonHoc = $mysqli->query('SELECT * FROM `monhoc` WHERE `maMH`= '.$maMH.';');
				$searchGV = $mysqli->query('SELECT * FROM `giaovien` WHERE `maGV`='.$maGV.';');
				$searchPhanCong = $mysqli->query('SELECT * FROM `phanconggiaovien` WHERE `maLop`='.$maLop.' AND `maGV`= '.$maGV.' AND `maMH`= '.$maMH.';');
				if ($searchLop->num_rows == 0) {
					$response['error'][] = 'Lớp học không tồn tại trong hệ thống!';
				} else if ($searchMonHoc->num_rows == 0) {
					$response['error'][] = 'Môn học không tồn tại trên hệ thống!';
				}else if ($searchGV->num_rows == 0) {
					$response['error'][] = 'Giáo viên bạn chọn không tồn tại trên hệ thống!';
				}else if ($searchPhanCong->num_rows > 0) {
					$response['error'][] = 'Môn học này đã được phân công giáo viên rồi!';
				} else {

					// insert DB
					$insert = $mysqli->query('INSERT INTO `phanconggiaovien`(`maGV`, `maLop`, `maMH`) VALUES ('.$maGV.', '.$maLop.', '.$maMH.');');
					if ($insert) {
						$response['success'] = 'Phân công giảng dạy thành công.';

						//Gửi email
					} else {
						$response['error'][] = 'Lỗi cập nhập dữ liệu!';
					}	
				}

			} else {
				$response['error'][] = 'Bạn không có quyền!';
			}
		}
		else {
			$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
		}
	} else {

			$response['error'][] = 'Vui lòng nhập đầy đủ thông tin!';
	}
}

echo json_encode($response);