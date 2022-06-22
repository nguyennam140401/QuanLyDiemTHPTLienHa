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
	
	if (!empty($_POST['tenLop']) && !empty($_POST['maKhoiLop']) && !empty($_POST['maNH']) && !empty($_POST['maGV']) ) {
		$maLop = (int)htmlspecialchars($_POST['maLop']);
		$tenLop = htmlspecialchars($_POST['tenLop']);
		$maKhoiLop = htmlspecialchars($_POST['maKhoiLop']);
		$maNH = htmlspecialchars($_POST['maNH']);
		$maGV = htmlspecialchars($_POST['maGV']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {
				if (strlen($tenLop) < 2 || strlen($tenLop) > 50) {
					$response['error'][] = 'Độ dài tên lớp từ 2-50 kí tự!';
				}
				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `lop` WHERE `maLop`='.$maLop.';');
					if ($searchMa->num_rows == 0) {
						$response['error'][] = 'Lớp học không tồn tại!';
					} else {
						$lopinfo = $searchMa->fetch_array(MYSQLI_ASSOC);
						if ($lopinfo['tenLop'] == $tenLop && $lopinfo['maKhoiLop'] == $maKhoiLop && $lopinfo['maNH'] == $maNH && $lopinfo['maGV'] == $maGV) {
							$response['error'][] = 'Bạn chưa sửa đổi dữ liệu!';
						} else {
							$searchTen = $mysqli->query('SELECT * FROM `lop` WHERE `tenLop`=\''.$tenLop.'\' AND `maNH`='.$maNH.' AND `maKhoiLop`='.$maKhoiLop.' AND `maGV` != '.$maGV.';');
							if ($searchTen->num_rows > 0) {
								$response['error'][] = 'Có một lớp cùng học kỳ trùng tên với tên lớp bạn chọn!';
							} else {
								// insert DB
								$update = $mysqli->query('UPDATE `lop` SET `tenLop` = \''.$tenLop.'\', `maNH` = '.$maNH.', `maKhoiLop` = '.$maKhoiLop.', `maGV` = '.$maGV.' WHERE `maLop` = '.$maLop.';');
								
								if ($update) {
									$response['success'] = 'Cập nhập thông tin môn học thành công.';

									//Gửi email
								} else {
									$response['error'][] = 'Lỗi cập nhập dữ liệu!';
								}
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