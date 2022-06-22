<?php
require './../../template/config.php';

$response = array();

if (!empty($_GET['oa']) && !empty($_GET['token'])) {
	$oa = htmlspecialchars($_GET['oa']);
	$token = htmlspecialchars($_GET['token']);

	$idTaiKhoan = (int)base64_decode($oa);

	$search = $mysqli->query('SELECT * FROM `taikhoan` WHERE `id`=\'' . $idTaiKhoan . '\';');
	if ($search->num_rows > 0) {
		$taikhoan = $search->fetch_array(MYSQLI_ASSOC);

		if ($token == hash('sha256', $taikhoan['password'])) {
			$newpass = rand_string(10);
			$update = $mysqli->query('UPDATE `taikhoan` SET `password` = MD5(\'' . $newpass . '\') WHERE `id`=\'' . $taikhoan['id'] . '\';');
			if ($update) {
				// Gửi email 
				$tieude = '[THPT Liên Hà] Mật khẩu mới';
				$noidung = "Xin chào, \n Mật khẩu mới của bạn là: " . $newpass . " ";

				require '../../plugin/PHPMailer.php';
				$res = SendEmailNofication($taikhoan['email'], $tieude, $noidung);
				if (isset($res['success'])) {
					$response['success'] = 'Hệ thống đã gửi mật khẩu mới đến email của bạn, vui lòng kiểm tra hòm thư!';
				} else {
					$response['success'] = isset($res['error']) ? $res['error'] : 'Lỗi gửi thư, vui lòng thử lại sau! Mật khẩu mới của bạn là: ' . $newpass;
				}
			} else {
				$response['error'] = 'Lấy lại mật khẩu không thành công!';
			}
		} else {
			$response['error'] = 'Token không hợp lệ!';
		}
	} else {
		$response['error'] = 'Không tìm thấy tài khoản!';
	}
} else {
	$response['error'] = 'Không đúng định dạng!';
}


echo json_encode($response);



function rand_string($length)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return substr(str_shuffle($chars), 0, $length);
}
