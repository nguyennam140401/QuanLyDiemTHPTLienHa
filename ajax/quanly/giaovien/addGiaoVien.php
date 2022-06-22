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
	
	if (!empty($_POST['tenGV']) && !empty($_POST['ngaySinh']) && isset($_POST['gioiTinh']) && !empty($_POST['diaChi']) ) {
		$tenGV = htmlspecialchars($_POST['tenGV']);
		$ngaySinh = htmlspecialchars($_POST['ngaySinh']);
		$gioiTinh = (int)$_POST['gioiTinh'] == '0'? 0 : 1;
		$diaChi = htmlspecialchars($_POST['diaChi']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager'))) {

				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `giaovien` WHERE `tenGV`= \''.$tenGV.'\' AND `ngaySinh`= \''.$ngaySinh.'\' AND `gioiTinh`= '.$gioiTinh.' AND `diaChi`= \''.$diaChi.'\';');
					if ($searchMa->num_rows > 0) {
						$response['error'][] = 'Giáo viên đã tồn tại!';
					} else {
						// insert DB
						$insert = $mysqli->query('INSERT INTO `giaovien`(`tenGV`, `ngaySinh`, `gioiTinh`, `diaChi`) VALUES (\''.$tenGV.'\', \''.$ngaySinh.'\', '.$gioiTinh.', \''.$diaChi.'\');');
						if ($insert) {
							$response['success'] = 'Thêm giáo viên thành công.';

							//Gửi email
						} else {
							$response['error'][] = 'Lỗi cập nhập dữ liệu!';
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