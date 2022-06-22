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
	if (!empty($_POST['maHS'])) {
		$maHS = (int)htmlspecialchars($_POST['maHS']);

		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');

		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {
				$searchUser = $mysqli->query('SELECT * FROM `hocsinh` WHERE `maHS`='.$maHS.';');
				if ($searchUser->num_rows == 0) {
					$response['error'] = 'Học sinh không tồn tại!';
				} else {
					$delete = $mysqli->query('DELETE FROM `hocsinh` WHERE `maHS` = '.$maHS.';');
					
					if ($delete) {
						$response['success'] = 'Xoá thành công.';

						//Gửi email
					} else {
						$response['error'] = 'Lỗi xoá dữ liệu! Đảm bảo rằng xoá hết danh sách học sinh của lớp trước khi xoá!';
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