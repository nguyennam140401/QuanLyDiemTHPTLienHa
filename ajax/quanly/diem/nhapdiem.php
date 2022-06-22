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
	
	if (!empty($_POST['maMH']) && !empty($_POST['diem']) && is_array($_POST['diem']) && count($_POST['diem']) > 0) {
		$maMH = htmlspecialchars($_POST['maMH']);
		$listdiem = $_POST['diem'];

		// Xem phân quyền có cho phép sửa không
		$taikhoan = array();
		$result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\''.htmlspecialchars($_SESSION['username']).'\' AND `password`=\''.htmlspecialchars($_SESSION['password']).'\';');
		if ($result->num_rows > 0) {
			$taikhoan = $result->fetch_array(MYSQLI_ASSOC);
			if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) {

				$monhocQuery = $mysqli->query('SELECT * FROM `monhoc` WHERE `maMH`= '.$maMH.' ');
				if ($monhocQuery->num_rows > 0) {
					
					foreach ($listdiem as $diem) {

						$phanlopID = $diem['phanlopID'];
						$diemtx = $diem['diemtx'];
						$diem15p = $diem['diem15p'];
						$diem1t = $diem['diem1t'];
						$diemhk = $diem['diemhk'];
						$diemTBmhk = 'NULL';


						// Check phân lớp ID có tồn tại
						$phanlopQuery = $mysqli->query('SELECT * FROM `phan_lop_hocsinh` WHERE `id`='.$phanlopID.' ');
						if ($phanlopQuery->num_rows > 0) {

							// Tính điểm TBHK nếu đủ thông tin
							if (!empty($diemtx) && !empty($diem15p) && !empty($diem1t) && !empty($diemhk) ) {
								$diemTBmhk = round((($diemtx+$diem15p)/2 + $diem1t*2 + $diemhk * 3)/6, 2);
							}

							// Lấy lại điểm  check NULL
							$diemtx = !empty($diem['diemtx']) ? round((float)$diem['diemtx'], 2) : 'NULL';
							$diem15p = !empty($diem['diem15p']) ? round((float)$diem['diem15p'], 2) : 'NULL';
							$diem1t = !empty($diem['diem1t']) ? round((float)$diem['diem1t'], 2) : 'NULL';
							$diemhk = !empty($diem['diemhk']) ? round((float)$diem['diemhk'], 2) : 'NULL';


							// check bản ghi điểm của môn có hay chưa

							$diemQuery = $mysqli->query('SELECT * FROM `diem` WHERE `hocsinh_phanlopID` = '.$phanlopID.' AND `maMH`='.$maMH.' ');
							if ($diemQuery->num_rows > 0) {
								// Update
								$record = $diemQuery->fetch_array(MYSQLI_ASSOC);
								if ($record['diemtx'] == $diemtx && $record['diem15p'] == $diem15p && $record['diem1t'] == $diem1t && $record['diemhk'] == $diemhk ) {
									$response['error'][999] = 'Không có dữ liệu được cập nhập!';
								} else {
									// Update lại điểm
									$update = $mysqli->query('UPDATE `diem` SET `diemtx` = '.$diemtx.', `diem15p` = '.$diem15p.', `diem1t` = '.$diem1t.', `diemhk` = '.$diemhk.', `DTBmhk` = '.$diemTBmhk.'  WHERE `id`='.$record['id'].' ');
									if ($update) {
										$response['success'][] = 'Cập nhập dữ liệu cho học sinh '.htmlspecialchars($diem['tenHS']).' có mã '.htmlspecialchars($diem['maHS']).' thành công!';
									} else {
										$response['error'][] = 'Cập nhập dữ liệu cho học sinh '.htmlspecialchars($diem['tenHS']).' có mã '.htmlspecialchars($diem['maHS']).' thất bại!';
									}
								}
							} else {
								$insert = $mysqli->query('INSERT INTO `diem`(`hocsinh_phanlopID`, `maMH`, `diemtx`, `diem15p`, `diem1t`, `diemhk`, `DTBmhk`) VALUES ('.$phanlopID.', '.$maMH.', '.$diemtx.', '.$diem15p.', '.$diem1t.', '.$diemhk.', '.$diemTBmhk.' )');
								if ($insert) {
									$response['success'][] = 'Thêm dữ liệu cho học sinh '.htmlspecialchars($diem['tenHS']).' có mã '.htmlspecialchars($diem['maHS']).' thành công!';
								} else {
									$response['error'][] = 'Thêm dữ liệu cho học sinh '.htmlspecialchars($diem['tenHS']).' có mã '.htmlspecialchars($diem['maHS']).' thất bại!';
								}
							}

						} else {
							$response['error'][] = 'Có lỗi xảy ra, một học sinh chưa được phân lớp!';
						}
						
					}
				}
				else {
					$response['error'][] = 'Môn học không tồn tại!';
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