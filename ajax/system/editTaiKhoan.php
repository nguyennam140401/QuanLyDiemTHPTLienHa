<?php
session_start();
ob_start();
require './../../template/config.php';

header('Content-Type: application/json');


$response = [];

if((empty($_SESSION['username']) && empty($_SESSION['password']))) {
	$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
}
else {
	
	if (!empty($_POST['id']) && !empty($_POST['email'])) {
		$id = (int)htmlspecialchars($_POST['id']);
		$role = htmlspecialchars($_POST['role']);
		$email = htmlspecialchars($_POST['email']);
		$password = empty($_POST['password']) ? '' : htmlspecialchars($_POST['password']);
		$repassword = empty($_POST['repassword']) ? '' : htmlspecialchars($_POST['repassword']);


		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (!in_array($role, array('student', 'teacher', 'manager', 'admin'))) {
					$response['error'][] = 'Phân quyền không hợp lệ!';
				}
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$response['error'][] = 'Địa chỉ email không hợp lệ!';
				}

				if (!empty($password)) {
					if (strlen($password) < 5 || strlen($password) > 50) {
						$response['error'][] = 'Độ dài mật khẩu không hợp lệ!';
					}
					if ($password != $repassword) {
						$response['error'][] = 'Mật khẩu nhập lại không trùng khớp!';
					}
				}

				if (empty($response['error'])) {
					$searchUser = $mysqli->query('SELECT * FROM `taikhoan` WHERE `id`='.$id.';');
					if ($searchUser->num_rows == 0) {
						$response['error'][] = 'Tài khoản không tồn tại!';
					} else {
						$searchEmail = $mysqli->query('SELECT * FROM `taikhoan` WHERE `email`=\''.$email.'\' AND `id` != '.$id.';');
						if ($searchEmail->num_rows > 0) {
							$response['error'][] = 'Email đã được sử dụng trên hệ thống!';
						} else {
							// insert DB
							$update = '';
							if (!empty($password)) {
								$update = $mysqli->query('UPDATE `taikhoan` SET `role` = \''.$role.'\', `email` = \''.$email.'\', `password` = \''.md5($password).'\' WHERE `id` = '.$id.';');
							} else {
								$update = $mysqli->query('UPDATE `taikhoan` SET `role` = \''.$role.'\', `email` = \''.$email.'\' WHERE `id` = '.$id.';');
							}
							
							if ($update) {
								$response['success'] = 'Sửa thông tin tài khoản thành công.';

								//Gửi email
							} else {
								$response['error'][] = 'Lỗi thêm dữ liệu!';
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