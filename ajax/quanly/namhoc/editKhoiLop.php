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
	
	if (!empty($_POST['maKhoiLop']) && !empty($_POST['maKhoiLop'])) {
		$maKhoiLop = (int)htmlspecialchars($_POST['maKhoiLop']);
		$tenKhoiLop = htmlspecialchars($_POST['tenKhoiLop']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (strlen($tenKhoiLop) < 2 || strlen($tenKhoiLop) > 50) {
					$response['error'][] = 'Độ dài tên khối lớp từ 2-50 kí tự!';
				}
				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `khoilop` WHERE `maKhoiLop`='.$maKhoiLop.';');
					if ($searchMa->num_rows == 0) {
						$response['error'][] = 'Bản ghi không tồn tại!';
					} else {
						$searchTen = $mysqli->query('SELECT * FROM `khoilop` WHERE `tenKhoiLop`=\''.$tenKhoiLop.'\' AND `maKhoiLop` != '.$maKhoiLop.';');
						if ($searchTen->num_rows > 0) {
							$response['error'][] = 'Bản ghi bị trùng!';
						} else {
							// insert DB
							$update = $mysqli->query('UPDATE `khoilop` SET `tenKhoiLop` = \''.$tenKhoiLop.'\' WHERE `maKhoiLop` = '.$maKhoiLop.';');
							
							if ($update) {
								$response['success'] = 'Cập nhập thông tin thành công.';

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