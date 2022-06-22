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
	
	if (!empty($_POST['maLop']) && !empty($_POST['maHS']) && !empty($_POST['maHK']) ) {
		$maLop = htmlspecialchars($_POST['maLop']);
		$maHS = htmlspecialchars($_POST['maHS']);
		$maHK = htmlspecialchars($_POST['maHK']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				$searchPhanLop = $mysqli->query('SELECT * FROM `phan_lop_hocsinh` WHERE `maHS`='.$maHS.' AND `maLop`= '.$maLop.' AND `maHK`= '.$maHK.';');
				$searchHS = $mysqli->query('SELECT * FROM `hocsinh` WHERE `maHS`='.$maHS.';');
				$searchHK = $mysqli->query('SELECT * FROM `hocky` WHERE `maHK`= '.$maHK.';');
				$searchLop = $mysqli->query('SELECT * FROM `lop` WHERE `maLop`= '.$maLop.';');
				if ($searchPhanLop->num_rows > 0) {
					$response['error'][] = 'Học sinh đã tồn tại trong lớp này!';
				} else if ($searchHS->num_rows == 0) {
					$response['error'][] = 'Học sinh không tồn tại trên hệ thống!';
				}else if ($searchHK->num_rows == 0) {
					$response['error'][] = 'Học kỳ không tồn tại trên hệ thống!';
				}else if ($searchLop->num_rows == 0) {
					$response['error'][] = 'Lớp không tồn tại trên hệ thống!';
				} else {

					$lop =$searchLop->fetch_array(MYSQLI_ASSOC);

					$checkHocKy = $mysqli->query('SELECT * FROM `phan_lop_hocsinh` INNER JOIN `lop` ON `lop`.`maLop` = `phan_lop_hocsinh`.`maLop` WHERE `maHS`='.$maHS.' AND `maNH`= '.$lop['maNH'].' AND `maHK`= '.$maHK.';');

					if ($checkHocKy->num_rows > 0) {
						$response['error'][] = 'Học sinh này đang/đã học một lớp khác trong cùng học kỳ cùng năm học với lớp bạn muốn thêm vào!';
					} else {
						// Lấy lớp cuỗi sùng học
						$checkKhoiLop = $mysqli->query('SELECT * FROM `lop` WHERE `maLop` = (SELECT `maLop` FROM `phan_lop_hocsinh` WHERE `maHS`='.$maHS.' ORDER BY `id` DESC LIMIT 1);');
						if ($checkKhoiLop->num_rows > 0 && $checkKhoiLop->fetch_array(MYSQLI_ASSOC)['maNH'] <= $lop['maNH'] ) {
							
							// insert DB
							$insert = $mysqli->query('INSERT INTO `phan_lop_hocsinh`(`maHS`, `maLop`, `maHK`) VALUES ('.$maHS.', '.$maLop.', '.$maHK.');');
							if ($insert) {
								$response['success'] = 'Thêm học sinh vào lớp học thành công.';

								//Gửi email
							} else {
								$response['error'][] = 'Lỗi cập nhập dữ liệu!';
							}
						}
						else {
							$response['error'][] = 'Học sinh chưa hoàn thành chương trình để lên lớp!';
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