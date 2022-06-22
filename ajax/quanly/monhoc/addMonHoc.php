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
	
	if (!empty($_POST['tenMH'])) {
		$tenMH = htmlspecialchars($_POST['tenMH']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `monhoc` WHERE `tenMH`=\''.$tenMH.'\';');
					if ($searchMa->num_rows > 0) {
						$response['error'][] = 'Môn học đã tồn tại!';
					} else {
						// insert DB
						$insert = $mysqli->query('INSERT INTO `monhoc`(`tenMH`) VALUES (\''.$tenMH.'\');');
						
						if ($insert) {
							$response['success'] = 'Thêm môn học thành công.';

							//Gửi email
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