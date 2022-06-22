<?php
session_start();
ob_start();
require './../../template/config.php';

header('Content-Type: application/json');


$response = [];

if ((empty($_SESSION['username']) && empty($_SESSION['password']))) {
	$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
} else {

	if (!empty($_POST['username']) && !empty($_POST['role']) && !empty($_POST['password'])  && !empty($_POST['repassword']) && !empty($_POST['email'])) {
		$username = ($_POST['username']);
		$role = ($_POST['role']);
		$email = ($_POST['email']);
		$password = empty($_POST['password']) ? '' : ($_POST['password']);
		$repassword = empty($_POST['repassword']) ? '' : ($_POST['repassword']);


		// Xem phân quyền có cho phép thêm không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . ($_SESSION['username']) . '\' AND `password`=\'' . ($_SESSION['password']) . '\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (!preg_match('/^[a-zA-Z0-9]{5,30}$/', $username)) {
					$response['error'][] = 'Tài khoản chỉ được chứa ký tự chữ và số. Độ dài từ 5 - 30 ký tự!';
				}
				if (!in_array($role, array('student', 'teacher', 'manager', 'admin'))) {
					$response['error'][] = 'Phân quyền không hợp lệ!';
				}
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$response['error'][] = 'Địa chỉ email không hợp lệ!';
				}

				if (strlen($password) < 5 || strlen($password) > 50) {
					$response['error'][] = 'Độ dài mật khẩu không hợp lệ!';
				}
				if ($password != $repassword) {
					$response['error'][] = 'Mật khẩu nhập lại không trùng khớp!';
				}

				if (empty($response['error'])) {
					$searchUser = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . $username . '\';');
					if ($searchUser->num_rows > 0) {
						$response['error'][] = 'Tên tài khoản đã tồn tại!';
					} else {
						$searchEmail = $mysqli->query('SELECT * FROM `taikhoan` WHERE `email`=\'' . $email . '\';');
						if ($searchEmail->num_rows > 0) {
							$response['error'][] = 'Email đã được sử dụng trên hệ thống!';
						} else {
							// insert DB
							$update = $mysqli->query('INSERT INTO `taikhoan`(`username`, `password`, `email`, `role`) VALUES (\'' . $username . '\', \'' . md5($password) . '\', \'' . $email . '\', \'' . $role . '\');');
							if ($update) {
								$response['success'] = 'Thêm tài khoản thành công! BHệ thống sẽ tải lại trang sau giây lát!';
							} else {
								$response['error'][] = 'Lỗi thêm dữ liệu!';
							}
						}
					}
				}
			} else {
				$response['error'][] = 'Bạn không có quyền sửa bản ghi này!';
			}
		} else {
			$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
		}
	} else {

		$response['error'][] = 'Vui lòng nhập đầy đủ thông tin!';
	}
}

echo json_encode($response);