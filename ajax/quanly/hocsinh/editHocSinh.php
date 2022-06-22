<?php
session_start();
ob_start();
require './../../../template/config.php';

header('Content-Type: application/json');


$response = [];

if ((empty($_SESSION['username']) && empty($_SESSION['password']))) {
	$response['error'][] = 'Xin lỗi, Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại!';
} else {

	if (!empty($_POST['maHS']) && !empty($_POST['tenHS']) && !empty($_POST['ngaySinh']) && isset($_POST['gioiTinh']) && !empty($_POST['noiSinh']) && !empty($_POST['maDT']) && !empty($_POST['maTPGD'])) {
		$maHS = (int)($_POST['maHS']);
		$tenHS = ($_POST['tenHS']);
		$ngaySinh = ($_POST['ngaySinh']);
		$gioiTinh = (int)$_POST['gioiTinh'] == '0' ? 0 : 1;
		$noiSinh = ($_POST['noiSinh']);
		$maDUT = !empty($_POST['maDUT']) ? ($_POST['maDUT']) : 'NULL';
		$maDT = (int)($_POST['maDT']);
		$maTPGD = (int)($_POST['maTPGD']);


		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . htmlspecialchars($_SESSION['username']) . '\' AND `password`=\'' . htmlspecialchars($_SESSION['password']) . '\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {

				if (empty($response['error'])) {
					$searchMa = $mysqli->query('SELECT * FROM `hocsinh` WHERE `maHS`=' . $maHS . ';');
					if ($searchMa->num_rows == 0) {
						$response['error'][] = 'Học sinh không tồn tại!';
					} else {
						$hs = $searchMa->fetch_array(MYSQLI_ASSOC);
						if ($hs['tenHS'] == $tenHS && $hs['ngaySinh'] == $ngaySinh && $hs['gioiTinh'] == $gioiTinh && $hs['noiSinh'] == $noiSinh && $hs['maDUT'] == $maDUT && $hs['maTPGD'] == $maTPGD && $hs['maDT'] == $maDT) {
							$response['error'][] = 'Bạn chưa sửa đổi dữ liệu!';
						} else {
							$update = $mysqli->query('UPDATE `hocsinh` SET `tenHS` = \'' . $tenHS . '\', `ngaySinh` = \'' . $ngaySinh . '\' , `gioiTinh` = ' . $gioiTinh . ' , `noiSinh` = \'' . $noiSinh . '\' , `maDUT` = ' . $maDUT . ' , `maTPGD` = ' . $maTPGD . ' , `maDT` = ' . $maDT . ' WHERE `maHS` = ' . $maHS . ';');

							if ($update) {
								$response['success'] = 'Cập nhập thông tin học sinh thành công.';

								//Gửi email
							} else {
								$response['error'][] = 'Lỗi cập nhập dữ liệu!';
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