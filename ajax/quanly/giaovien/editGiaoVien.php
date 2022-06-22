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
	
	if (!empty($_POST['maGV']) && !empty($_POST['tenGV']) && !empty($_POST['ngaySinh']) && isset($_POST['gioiTinh'])  && !empty($_POST['diaChi']) ) {
		$maGV = htmlspecialchars($_POST['maGV']);
		$tenGV = htmlspecialchars($_POST['tenGV']);
		$ngaySinh = htmlspecialchars($_POST['ngaySinh']);
		$gioiTinh = (int)$_POST['gioiTinh'] == '0'? 0 : 1;
		$diaChi = htmlspecialchars($_POST['diaChi']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `giaovien` WHERE `maGV`='.$maGV.';');
					if ($searchMa->num_rows == 0) {
						$response['error'][] = 'Giáo viên không tồn tại!';
					} else {
						$giaovien = $searchMa->fetch_array(MYSQLI_ASSOC);
						if ($giaovien['tenGV'] == $tenGV && $giaovien['ngaySinh'] == $ngaySinh && $giaovien['gioiTinh'] == $gioiTinh && $giaovien['diaChi'] == $diaChi) {
							$response['error'][] = 'Bạn chưa sửa đổi dữ liệu gì!';
						} else {
							// insert DB
							$update = $mysqli->query('UPDATE `giaovien` SET `tenGV` = \''.$tenGV.'\', `ngaySinh` = \''.$ngaySinh.'\', `gioiTinh` = '.$gioiTinh.', `diaChi` = \''.$diaChi.'\' WHERE `maGV` = '.$maGV.';');
							
							if ($update) {
								$response['success'] = 'Cập nhập thông tin giáo viên thành công.';

								//Gửi email
							} else {
								$response['error'][] = 'Lỗi cập nhập dữ liệu!';
							}
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