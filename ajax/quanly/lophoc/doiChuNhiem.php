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
	
	if (!empty($_POST['maGV']) && !empty($_POST['maLop'])) {
		$maLop = (int)htmlspecialchars($_POST['maLop']);
		$maGV = htmlspecialchars($_POST['maGV']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				$searchLop = $mysqli->query('SELECT * FROM `lop` WHERE `maLop`='.$maLop.';');
				if ($searchLop->num_rows == 0) {
					$response['error'][] = 'Lớp học không tồn tại, vui lòng kiểm tra lại!';
				} else {
					$searchGV = $mysqli->query('SELECT * FROM `giaovien` WHERE `maGV`='.$maGV.';');
					if ($searchLop->num_rows == 0) {
						$response['error'][] = 'Giáo viên bạn chọn không hợp lệ!';
					} else {
						// update DB
						$update = $mysqli->query('UPDATE `lop` SET `maGV` ='.$maGV.' WHERE `maLop` = '.$maLop.';');
						
						if ($update) {
							$response['success'] = 'Cập nhập thông tin thành công.';
						} else {
							$response['error'][] = 'Lỗi cập nhập dữ liệu!';
						}
					}
				}

			} else {
				$response['error'][] = 'Bạn không có quyền sửa bản ghi này!';
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