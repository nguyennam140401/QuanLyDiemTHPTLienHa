<?php
$title = 'Quản lý điểm';
require './../template/tpl_header.php';

$maLop = null;
$queryLop = null;
$classInfo = array();
if (!empty($_GET['maLop']) && !empty($_GET['maHK']) && !empty($_GET['maMH'])) :
    $maLop = (int)htmlspecialchars($_GET['maLop']);
    $maHK = (int)htmlspecialchars($_GET['maHK']);
    $maMH = (int)htmlspecialchars($_GET['maMH']);

    $check = true;
    $queryHocKy = $mysqli->query('SELECT * FROM `hocky` WHERE `maHK` = ' . $maHK . '');
    if ($queryHocKy->num_rows > 0) {
        $hocky = $queryHocKy->fetch_array(MYSQLI_ASSOC);
    } else {
        $check = false;
    }


    $queryMon = $mysqli->query('SELECT * FROM `monhoc` WHERE `maMH` = ' . $maMH . '');
    if ($queryMon->num_rows > 0) {
        $monhoc = $queryMon->fetch_array(MYSQLI_ASSOC);
    } else {
        $check = false;
    }


    $queryLop = $mysqli->query('SELECT `maLop`, `tenLop`, `tenKhoiLop`, `namHoc`, `tenGV` FROM `lop` INNER JOIN `khoilop` ON `lop`.`maKhoiLop` = `khoilop`.`maKhoiLop` INNER JOIN `giaovien` ON `lop`.`maGV` = `giaovien`.`maGV` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH`  WHERE `maLop`=' . $maLop . ';');
    if ($queryLop->num_rows > 0) {
        $classInfo = $queryLop->fetch_array(MYSQLI_ASSOC);
    } else {
        $check = false;
    }


    // Get Phân lớp
    $queryPhanLop = $mysqli->query('SELECT * FROM `phan_lop_hocsinh` INNER JOIN `hocsinh` ON `hocsinh`.`maHS` = `phan_lop_hocsinh`.`maHS` WHERE `maLop` = ' . $maLop . ' AND `maHK` = ' . $maHK . ' ORDER BY `id` ');
    if ($queryPhanLop->num_rows > 0) {
        $dsHS = $queryPhanLop->fetch_all(MYSQLI_ASSOC);
    } else {
        $check = false;
    }



    if ($check) {
        // Đưa ra bảng nhập


        $table = '';
        $table_header = '
			<thead>
				<tr>
					<th>Mã HS</th>
					<th>Tên học sinh</th>
					<th>Điểm thường xuyên</th>
					<th>Điểm 15p</th>
					<th>Điểm 1 tiết</th>
					<th>Điểm học kỳ</th>
					<th>ĐTB môn</th>
				</tr>
			</thead>
		';
        $row = '';
        foreach ($dsHS as $index => $hocsinh) {
            $diemQuery = $mysqli->query('SELECT * FROM `diem` WHERE `hocsinh_phanlopID` = ' . $hocsinh['id'] . ' AND `maMH` = ' . $maMH . ' ');
            if ($diemQuery->num_rows == 1) {

                $diem = $diemQuery->fetch_array(MYSQLI_ASSOC);
                $row .= '
					<tr>
						<td>
							' . $hocsinh['maHS'] . ' 
							<input type="hidden" name="diem[' . $index . '][phanlopID]" value="' . $hocsinh['id'] . '" /> 
							<input type="hidden" name="diem[' . $index . '][maHS]" value="' . $hocsinh['maHS'] . '" />
							<input type="hidden" name="diem[' . $index . '][tenHS]" value="' . $hocsinh['tenHS'] . '" />
						</td>
						<td><a href="/QuanLyDiemTHPT/tracuu/diem.php?maHS=' . $hocsinh['maHS'] . '">' . $hocsinh['tenHS'] . '</a></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diemtx]" value="' . $diem['diemtx'] . '" placeholder="' . $diem['diemtx'] . '"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diem15p]" value="' . $diem['diem15p'] . '" placeholder="' . $diem['diem15p'] . '"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diem1t]" value="' . $diem['diem1t'] . '" placeholder="' . $diem['diem1t'] . '"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diemhk]" value="' . $diem['diemhk'] . '" placeholder="' . $diem['diemhk'] . '"/></td>
						<td>' . $diem['DTBmhk'] . '</td>
					</tr>
				';
            } else {
                $row .= '
					<tr>
						<td>
							' . $hocsinh['maHS'] . ' 
							<input type="hidden" name="diem[' . $index . '][phanlopID]" value="' . $hocsinh['id'] . '" /> 
							<input type="hidden" name="diem[' . $index . '][maHS]" value="' . $hocsinh['maHS'] . '" />
							<input type="hidden" name="diem[' . $index . '][tenHS]" value="' . $hocsinh['tenHS'] . '" />
						</td>
						<td><a href="/QuanLyDiemTHPT/tracuu/diem.php?maHS=' . $hocsinh['maHS'] . '">' . $hocsinh['tenHS'] . '</a></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diemtx]"  placeholder="Chưa nhập"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diem15p]" placeholder="Chưa nhập"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diem1t]" placeholder="Chưa nhập"/></td>
						<td><input class="form-control" type="number" step="0.25" name="diem[' . $index . '][diemhk]" placeholder="Chưa nhập"/></td>
						<td></td>
					</tr>
				';
            }
        }

        $table = $table_header . $row;
    }

?>

    <?php if ($check && in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) : ?>

        <style>
            .toasts-top-right {
                z-index: 1060 !important;
            }
        </style>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo $title; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/QuanLyDiemTHPT">Trang chủ</a></li>
                                <li class="breadcrumb-item active"><?php echo $title; ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-body">
                            <table class="table table-striped projects">
                                <tr>
                                    <th>Mã lớp</th>
                                    <td><?php echo $classInfo['maLop']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tên lớp</th>
                                    <td><?php echo $classInfo['tenLop']; ?></td>
                                </tr>
                                <tr>
                                    <th>Khối</th>
                                    <td><?php echo $classInfo['tenKhoiLop']; ?></td>
                                </tr>
                                <tr>
                                    <th>Năm học</th>
                                    <td><?php echo $classInfo['namHoc']; ?></td>
                                </tr>
                                <tr>
                                    <th>Chủ nhiệm </th>
                                    <td><?php echo $classInfo['tenGV']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Nhập điểm môn <?php echo $monhoc['tenMH'] . ' - ' . $hocky['tenHK']; ?> </h3>
                        </div>
                        <div class="card-body">
                            <form id="NhapDiem" method="post" action="#">
                                <input type="hidden" name="maMH" value="<?php echo $maMH; ?>" required />
                                <table class="table table-bordered table-striped dataTable" id="LopHocTable0" width="100%">
                                    <?php echo $table; ?>
                                </table>
                                <button type="submit" class="btn btn-info btn-flat float-right" id="LuuDiem">Lưu điểm</button>
                            </form>

                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </div>



        <script>
            $(document).ready(function() {

                $('#NhapDiem').submit(function(event) {
                    event.preventDefault();
                    $("#LuuDiem").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu điểm');
                    var form = $(this);
                    var Data = form.serialize();
                    $.ajax({
                        url: '/QuanLyDiemTHPT/ajax/quanly/diem/nhapdiem.php',
                        type: 'POST',
                        data: Data,
                        success: function(result) {
                            if (result.success) {
                                $.each(result.success, function(id, successMessage) {
                                    $(document).Toasts('create', {
                                        class: 'bg-success',
                                        title: 'Thành công!',
                                        body: successMessage
                                    });
                                });
                                if (!result.error) {
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }

                            } else {
                                $.each(result.error, function(id, errorMessage) {
                                    $(document).Toasts('create', {
                                        class: 'bg-danger',
                                        title: 'Có lỗi xảy ra!',
                                        body: errorMessage
                                    });
                                });
                                $("#LuuDiem").attr("disabled", false).html('Lưu điểm');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert(error);
                            $("#LuuDiem").attr("disabled", false).html('Lưu điểm');
                        }
                    });
                    return false;
                });


            });
        </script>




    <?php endif;  // endif kiểm sql và quyền
    ?>
<?php endif;  // endif kiểm tra rỗng
?>
<?php
require './../template/tpl_footer.php';
?>