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
	
	if (!empty($_POST['tenHS']) && !empty($_POST['ngaySinh']) && isset($_POST['gioiTinh']) && !empty($_POST['noiSinh']) && !empty($_POST['maDT']) && !empty($_POST['maTPGD']) ) {
		$tenHS = htmlspecialchars($_POST['tenHS']);
		$ngaySinh = htmlspecialchars($_POST['ngaySinh']);
		$gioiTinh = (int)$_POST['gioiTinh'] == '0'? 0 : 1;
		$noiSinh = htmlspecialchars($_POST['noiSinh']);
		$maDUT = !empty($_POST['maDUT']) ? htmlspecialchars($_POST['maDUT']) : 'NULL';
		$maDT = (int)htmlspecialchars($_POST['maDT']);
		$maTPGD = (int)htmlspecialchars($_POST['maTPGD']);

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {

				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `hocsinh` WHERE `tenHS`=\''.$tenHS.'\' AND `ngaySinh`=\''.$ngaySinh.'\' AND `gioiTinh`= '.$gioiTinh.' AND `noiSinh`=\''.$noiSinh.'\' AND  `maDT`= '.$maDT.';');
					if ($searchMa->num_rows > 0) {
						$response['error'][] = 'Học sinh đã tồn tại!';
					} else {
						// insert DB
						$insert = $mysqli->query('INSERT INTO `hocsinh`(`tenHS`, `ngaySinh`, `gioiTinh`, `noiSinh`, `maDUT`, `maDT`, `maTPGD`) VALUES (\''.$tenHS.'\', \''.$ngaySinh.'\', '.$gioiTinh.', \''.$noiSinh.'\', '.$maDUT.', '.$maDT.', '.$maTPGD.');');
						if ($insert) {
							$response['success'] = 'Thêm học sinh thành công.';

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