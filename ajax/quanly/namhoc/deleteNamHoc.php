<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

if((empty($_SESSION['username']) && empty($_SESSION['password']))) {
	$response['error'] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
}
else {
	if (!empty($_POST['maNH'])) {
		$maNH = (int)htmlspecialchars($_POST['maNH']);

		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {
				$searchUser = $mysqli->query('SELECT * FROM `namhoc` WHERE `maNH`='.$maNH.';');
				if ($searchUser->num_rows == 0) {
					$response['error'] = 'Môn học không tồn tại!';
				} else {
					$delete = $mysqli->query('DELETE FROM `namhoc` WHERE `maNH` = '.$maNH.';');
					
					if ($delete) {
						$response['success'] = 'Xoá thành công.';

						//Gửi email
					} else {
						$response['error'] = 'Lỗi xoá dữ liệu!';
					}
				}
			}else {
				$response['error'] = 'Bạn không có quyền xoá bản ghi này!';
			}
		}
		else {
			$response['error'] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
		}
	} else {
		$response['error'] = 'Lỗi dữ liệu!';
	}
	

}

echo json_encode($response);