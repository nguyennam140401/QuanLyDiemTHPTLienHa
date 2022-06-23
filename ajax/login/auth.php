<?php
session_start();
ob_start();
require './../../template/config.php';

header('Content-Type: application/json');


$response = [];

if ((!empty($_SESSION['username']) && !empty($_SESSION['password'])) || (isset($_COOKIE['username']) && isset($_COOKIE['token']))) {

	$response['success'] = 'Chuyển hướng!';
	$response['returnURL'] = '/QuanLyDiemTHPTLienHa';
} else {

	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		$username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
		$password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

		if (strlen($username) > 4 && strlen($username) < 50 && strlen($password) > 4 && strlen($password) < 50) {
			$search = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . $username . '\';');
			if ($search->num_rows > 0) {
				$taikhoan = $search->fetch_array(MYSQLI_ASSOC);
				if ($taikhoan['password'] == md5($password)) {
					// Lưu thông tin vào session và cookie
					if (isset($_POST['remember']) && $_POST['remember'] == "true") {
						setcookie('username', $taikhoan['username'], time() + (30 * 86400), "/"); // save 30 days
						setcookie('token', md5($taikhoan['password']), time() + (30 * 86400), "/"); // save 30 days
					}

					$_SESSION['username'] = $taikhoan['username'];
					$_SESSION['password'] = $taikhoan['password'];


					$response['success'] = 'Đăng nhập thành công! Chúng tôi sẽ chuyển hướng bạn sau giây lát!';
					$response['returnURL'] = '/QuanLyDiemTHPTLienHa';
				} else {
					$response['error'] = 'Mật khẩu bạn nhập không hợp lệ!';
				}
			} else {
				$response['error'] = 'Tài khoản của bạn không tồn tại trên hệ thống!';
			}
		} else {
			$response['error'] = 'Độ dài của tài khoản hoặc mật khẩu không hợp lệ!';
		}
	} else {
		$response['error'] = 'Vui lòng nhập đầy đủ thông tin!';
	}
}

echo json_encode($response);