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
	
	if (!empty($_POST['email'])) {
		$email = htmlspecialchars($_POST['email']);
		$password = empty($_POST['password']) ? '' : htmlspecialchars($_POST['password']);
		$oldpassword = empty($_POST['oldpassword']) ? '' : htmlspecialchars($_POST['oldpassword']);
		$repassword = empty($_POST['repassword']) ? '' : htmlspecialchars($_POST['repassword']);


		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$response['error'][] = 'Địa chỉ email không hợp lệ!';
			}

			if (!empty($oldpassword)) {
				if (strlen($password) < 5 || strlen($password) > 50) {
					$response['error'][] = 'Độ dài mật khẩu không hợp lệ!';
				}
				if ($password != $repassword) {
					$response['error'][] = 'Mật khẩu nhập lại không trùng khớp!';
				}
				if (md5($oldpassword) != $taikhoan['password']) {
					$response['error'][] = 'Mật khẩu ncũ không trùng khớp!';
				}
			}

			if (empty($response['error'])) {

				$searchEmail = $mysqli->query('SELECT * FROM `taikhoan` WHERE `email`=\''.$email.'\' AND `id` != '.$taikhoan['id'].';');
				if ($searchEmail->num_rows > 0) {
					$response['error'][] = 'Email đã được sử dụng trên hệ thống!';
				} else {
					// insert DB
					$update = '';
					if (!empty($password)) {
						$update = $mysqli->query('UPDATE `taikhoan` SET `email` = \''.$email.'\', `password` = \''.md5($password).'\' WHERE `id` = '.$taikhoan['id'].';');
					} else {
						$update = $mysqli->query('UPDATE `taikhoan` SET `email` = \''.$email.'\' WHERE `id` = '.$taikhoan['id'].';');
					}
					
					if ($update) {
						$response['success'] = 'Sửa thông tin tài khoản thành công.';
						$response['returnURL'] = '/system/thongtintaikhoan.php';

						//Gửi email
					} else {
						$response['error'][] = 'Lỗi thêm dữ liệu!';
					}
				}

			}
			
		}
		else {
			$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
		}
	}
}

echo json_encode($response);