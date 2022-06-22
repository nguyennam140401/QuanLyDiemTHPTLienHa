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
	
	if (!empty($_POST['id']) && !empty($_POST['maLop'])) {
		$maLop = (int)htmlspecialchars($_POST['maLop']);
		$PhanLopID = htmlspecialchars($_POST['id']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (empty($response['error'])) {
					$searchPhanLop = $mysqli->query('SELECT * FROM `phan_lop_hocsinh` WHERE `id`='.$PhanLopID.';');
					if ($searchPhanLop->num_rows == 0) {
						$response['error'][] = 'Mã phân lớp không tồn tại!';
					} else {
						$lopCu = $mysqli->query('SELECT * FROM `lop` WHERE `maLop` IN (SELECT DISTINCT `maLop` FROM `phan_lop_hocsinh` WHERE `id` = '.$PhanLopID.');')->fetch_array(MYSQLI_ASSOC);
						$searchLop = $mysqli->query('SELECT * FROM `lop` WHERE `maLop`='.$maLop.' AND `maLop` != '.$lopCu['maLop'].' AND `maNH` = '.$lopCu['maNH'].' AND `maKhoiLop` = '.$lopCu['maKhoiLop'].';');
						if ($searchLop->num_rows == 0) {
							$response['error'][] = 'Lóp bạn chọn không hợp lệ!';
						} else {
							// insert DB
							$update = $mysqli->query('UPDATE `phan_lop_hocsinh` SET `maLop` ='.$maLop.' WHERE `id` = '.$PhanLopID.';');
							
							if ($update) {
								$response['success'] = 'Cập nhập thông tin thành công.';
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