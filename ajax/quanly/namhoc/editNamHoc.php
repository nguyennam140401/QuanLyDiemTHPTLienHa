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
	
	if (!empty($_POST['maNH']) && !empty($_POST['namHoc'])) {
		$maNH = (int)htmlspecialchars($_POST['maNH']);
		$namHoc = htmlspecialchars($_POST['namHoc']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (strlen($namHoc) < 2 || strlen($namHoc) > 50) {
					$response['error'][] = 'Độ dài tên năm học từ 2-50 kí tự!';
				}
				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `namhoc` WHERE `maNH`='.$maNH.';');
					if ($searchMa->num_rows == 0) {
						$response['error'][] = 'Môn học không tồn tại!';
					} else {
						$searchTen = $mysqli->query('SELECT * FROM `namhoc` WHERE `namHoc`=\''.$namHoc.'\' AND `maNH` != '.$maNH.';');
						if ($searchTen->num_rows > 0) {
							$response['error'][] = 'Tên môn học đã tồn tại!';
						} else {
							// insert DB
							$update = $mysqli->query('UPDATE `namhoc` SET `namHoc` = \''.$namHoc.'\' WHERE `maNH` = '.$maNH.';');
							
							if ($update) {
								$response['success'] = 'Cập nhập thông tin năm học thành công.';

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