<?php
session_start();
ob_start();
require './../../template/config.php';

header('Content-Type: application/json');


$response = [];

if((!empty($_SESSION['username']) && !empty($_SESSION['password'])) || (isset($_COOKIE['username']) && isset($_COOKIE['token']))) {

	$response['success'] = 'Chuyển hướng!';
	$response['returnURL'] = '/';
}
else {
	
	if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['agreeTerms'])) {

		$username = htmlspecialchars(trim($_POST['username']));
		$email = htmlspecialchars(trim($_POST['email']));
		$password = htmlspecialchars(trim($_POST['password']));
		$repassword = htmlspecialchars(trim($_POST['repassword']));
		$terms = htmlspecialchars(trim($_POST['agreeTerms']));

		if (!preg_match('/^[a-zA-Z0-9]{5,30}$/', $username)) {
			$response['error'][] = 'Tài khoản chỉ được chứa ký tự chữ và số. Độ dài từ 5 - 30 ký tự!';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response['error'][] = 'Định dạng email không hợp lệ!';
		}
		if (strlen($password) < 5) {
			$response['error'][] = 'Độ dài mật khẩu không hợp lệ!';
		}
		if ($password != $repassword) {
			$response['error'][] = 'Mật khẩu nhập lại không trùng khớp!';
		}
		if ($terms != "agree") {
			$response['error'][] = 'Vui lòng đồng ý với điều khoản của chúng tôi!';
		}

		if (empty($response['error'])) {
			$searchUsername = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.$username.'\';');
			if ($searchUsername->num_rows > 0) {
				$response['error'][] = 'Tài khoản đã tồn tại, vui lòng chọn một tài khoản khác!';
			} else {
				$searchEmail = $mysqli->query('SELECT * FROM `taikhoan` WHERE `email`=\''.$email.'\';');
				if ($searchEmail->num_rows > 0) {
					$response['error'][] = 'Email đã được sử dụng trên hệ thống!';
				} else {
					// insert DB
					$update = $mysqli->query('INSERT INTO `taikhoan`(`username`, `password`, `email`) VALUES (\''.$username.'\', \''.md5($password).'\', \''.$email.'\');');
					if ($update) {
						$response['success'] = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập với tài khoản của mình.';
						$response['returnURL'] = '/';

						//Gửi email
					} else {
						$response['error'][] = 'Lỗi thêm dữ liệu!';
					}
				}
			}
		}

	}
	else {
		$response['error'][] = 'Vui lòng nhập đầy đủ thông tin!';
	}
}

echo json_encode($response);