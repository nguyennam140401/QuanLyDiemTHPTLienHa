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
	
	if (!empty($_POST['id']) && !empty($_POST['maGV']) ) {
		$maPhanCong = htmlspecialchars($_POST['id']);
		$maGV = htmlspecialchars($_POST['maGV']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				$searchGV = $mysqli->query('SELECT * FROM `giaovien` WHERE `maGV`='.$maGV.';');
				$searchPhanCong = $mysqli->query('SELECT * FROM `phanconggiaovien` WHERE `id`='.$maPhanCong.';');
				if ($searchGV->num_rows == 0) {
					$response['error'][] = 'Lớp học không tồn tại trong hệ thống!';
				} else if ($searchPhanCong->num_rows == 0) {
					$response['error'][] = 'Phân công trước đó không tồn tại trên hệ thống!';
				}else if ($searchPhanCong->fetch_array(MYSQLI_ASSOC)['maGV'] == $maGV) {
					$response['error'][] = 'Bạn chưa thay đổi gì!';
				} else {

					// update DB
					$update = $mysqli->query('UPDATE `phanconggiaovien` SET `maGV` = '.$maGV.' WHERE `id` = '.$maPhanCong.';');
					 
					if ($update) {
						$response['success'] = 'Phân công giảng dạy thành công!';

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