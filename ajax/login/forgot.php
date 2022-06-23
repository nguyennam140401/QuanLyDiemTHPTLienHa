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

	if (!empty($_POST['email'])) {
		$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$search = $mysqli->query('SELECT * FROM `taikhoan` WHERE `email`=\'' . $email . '\';');
			if ($search->num_rows > 0) {
				$taikhoan = $search->fetch_array(MYSQLI_ASSOC);

				// Gửi email 
				$tieude = '[THPT Liên Hà] Yêu cầu lấy lại mật khẩu';
				$noidung = "Xin chào, \nChúng tôi vừa nhận được yêu cầu lấy lại mật khẩu trang Hệ thống quản lý điểm Trường THPT Liên Hà. \nĐể cài lại mật khẩu, vui lòng truy cập đường đẫn sau: http://vnedu.vuiz.net/ajax/login/recover.php?oa=" . base64_encode($taikhoan['id']) . "&token=" . hash('sha256', $taikhoan['password']) . " \n Nếu bạn không gửi yêu cầu này, vui lòng bỏ qua tin nhắn này!\n Thân!";

				require '../../plugin/PHPMailer.php';
				$res = SendEmailNofication($email, $tieude, $noidung);
				if (isset($res['success'])) {
					$response['success'] = 'Hệ thống đã gửi 1 thư đến email của bạn, vui lòng kiểm tra hòm thư!';
				} else {
					$response['error'] = isset($res['error']) ? $res['error'] : 'Lỗi gửi thư, vui lòng thử lại sau!';
				}
			} else {
				$response['error'] = 'Email ' . $email . ' không được liên kết với tài khoản nào!';
			}
		} else {
			$response['error'] = 'Định dạng email không hợp lệ!';
		}
	} else {
		$response['error'] = 'Vui lòng nhập đầy đủ thông tin!';
	}
}

echo json_encode($response);
