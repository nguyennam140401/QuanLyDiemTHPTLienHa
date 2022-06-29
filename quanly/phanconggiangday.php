<?php
$title = 'Phân công giảng dạy';
require './../template/tpl_header.php';

$maLop = null;
$queryLop = null;
$classInfo = array();
if (!empty($_GET['maLop'])) {
    $maLop = (int)htmlspecialchars($_GET['maLop']);
    $queryLop = $mysqli->query('SELECT `maLop`, `tenLop`, `tenKhoiLop`, `namHoc`, `tenGV` FROM `lop` INNER JOIN `khoilop` ON `lop`.`maKhoiLop` = `khoilop`.`maKhoiLop` INNER JOIN `giaovien` ON `lop`.`maGV` = `giaovien`.`maGV` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH`  WHERE `maLop`=' . $maLop . ';');
    if ($queryLop->num_rows > 0) {
        $classInfo = $queryLop->fetch_array(MYSQLI_ASSOC);
    }
}
//print_r($classInfo);
?>

<?php if (
    !empty($maLop) && isset($queryLop->num_rows) && $queryLop->num_rows > 0  &&
    in_array($taikhoan['role'], array('admin', 'manager'))
) :

    $table = '';
    // Lấy môn học
    $monhocQuery = $mysqli->query('SELECT * FROM `monhoc`;');
    if ($monhocQuery->num_rows > 0) {
        // Lay gioa vien day mon do
        while ($mon = $monhocQuery->fetch_array(MYSQLI_ASSOC)) {
            $table_row = '';
            $phancongQuery = $mysqli->query('SELECT * FROM `phanconggiaovien` INNER JOIN `giaovien` ON `phanconggiaovien`.`maGV` = `giaovien`.`maGV` WHERE `maLop`= ' . $maLop . ' AND `maMH` = ' . $mon['maMH'] . ';');
            if ($phancongQuery->num_rows > 0) {
                $gv = $phancongQuery->fetch_array(MYSQLI_ASSOC);
                $table_row = '<td>' . $mon['tenMH'] . '</td><td>' . $gv['tenGV'] . '</td><td><a class="btn btn-primary btn-sm float-right" href="#" onclick="DoiGiaoVien(\'' . $gv['id'] . '\', \'' . $mon['tenMH'] . '\', \'' . $gv['maGV'] . '\', \'' . $gv['tenGV'] . '\')"><i class="fas fa-user-edit"></i>Đổi giáo viên</a></td>';
            } else {
                $table_row = '<td>' . $mon['tenMH'] . '</td><td><span class="badge bg-gray">Chưa phân công</span></td><td><a class="btn btn-info btn-sm float-right" href="#" onclick="PhanCongGiaoVien(\'' . $mon['maMH'] . '\', \'' . $mon['tenMH'] . '\')"><i class="fas fa-user-edit"></i>Phân công giáo viên</a></td>';
            }
            $table_row = '<tr>' . $table_row . '</tr>';
            $table .= $table_row;
        }
    }



?>

<style>
.toasts-top-right {
    z-index: 1060 !important;
}
</style>

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
    integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.css"
    integrity="sha512-hzvGZ3Tzqtdzskup1j2g/yc+vOTahFsuXp6X6E7xEel55qInqFQ6RzR+OzUc5SQ9UjdARmEP0g2LDcXA5x6jVQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.5/responsive.bootstrap4.min.css"
    integrity="sha512-Yy2EzOvLO8+Vs9hwepJPuaRWpwWZ/pamfO4lqi6t9gyQ9DhQ1k3cBRa+UERT/dPzIN/RHZAkraw6Azs4pI0jNg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <h3 class="card-title">Phân công giáo viên cho lớp </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped dataTable" id="MonHocTable" width="100%">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th>Giáo viên giảng dạy</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo isset($table) ? $table : ''; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
    integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.7/dataTables.responsive.min.js"
    integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js"
    integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatable Button -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/dataTables.buttons.min.js"
    integrity="sha512-PvgN2o+U/CTkCfOHqtSjTECpgUSY5kZm+VoMF4LN0M2QL8U9qGMrD+YGtpwyKUvhZ6jWNkk5Ldvtd4nucAtkow=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.js"
    integrity="sha512-AijsNe5rDJjziesLO1SWgD0hmRWkETKzOCfEOoqt4l6Rpwfi1JC1WxLDV7eeSniCpRRPup2l+UnruRCA12ChVg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"
    integrity="sha512-xQBQYt9UcgblF6aCMrwU1NkVA7HCXaSN2oq0so80KO+y68M+n64FOcqgav4igHe6D5ObBLIf68DWv+gfBowczg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"
    integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.min.js"
    integrity="sha512-BDZ+kFMtxV2ljEa7OWUu0wuay/PAsJ2yeRsBegaSgdUhqIno33xmD9v3m+a2M3Bdn5xbtJtsJ9sSULmNBjCgYw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.print.min.js"
    integrity="sha512-UthH9WkvNUixebk8yKEFm3Sy+Rm8GbuvxiIMCDs9Cepl+YxhY+LUijPFZshcW7+PHa/HcSFLfSX3fGq1AcglWg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.html5.min.js"
    integrity="sha512-33SxAOPhjjpLMmMGKqLwH2QNDmdxf038OFOq+fOI8p8ghCiOvfv3Bs2wqoj50USQkWBLpvy7+CzT5AHTZWGoNA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>




<!-- MODAL Phân công -->


<div id="AssignModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Phân công giảng dạy</strong> <span id="TenMonHocAssign" class="text-danger"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="AssignForm" action="#" method="post">
                    <input type="hidden" name="maLop" value="<?php echo $classInfo['maLop']; ?>" required />
                    <input type="hidden" name="maMH" value="" required />
                    <div class="row">
                        <div class="col-xl-8">
                            <table class="table table-bordered table-striped" id="DanhSachGiaoVien1" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">Mã</th>
                                        <th>Tên giáo viên</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Địa chỉ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="maGV">Chọn giáo viên</label>
                                <select name="maGV" class="form-control" required>
                                </select>
                                <small class="form-text text-muted text-alert">* Chọn từ danh sách bên cạnh</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info float-right" id="AssignSubmit">Lưu thông
                                    tin</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL SỬA -->


<div id="EditAssignModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Phân công giảng dạy</strong> <span id="TenMonHocAssign2" class="text-danger"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="EditAssignForm" action="#" method="post">
                    <input type="hidden" name="id" value="" required />
                    <div class="row">
                        <div class="col-xl-8">
                            <table class="table table-bordered table-striped" id="DanhSachGiaoVien2" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">Mã</th>
                                        <th>Tên giáo viên</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Địa chỉ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="maGV">Chọn giáo viên</label>
                                <select name="maGV" class="form-control" required>
                                </select>
                                <small class="form-text text-muted text-alert">* Chọn từ danh sách bên cạnh</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info float-right" id="EditAssignSubmit">Lưu thông
                                    tin</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {


    // Submit form phân công
    $("#AssignForm").submit(function(event) {
        event.preventDefault();
        $("#AssignSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/phancong/addphanconggiangday.php',
            type: 'POST',
            data: Data,
            success: function(result) {
                if (result.success) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Thành công!',
                        body: result.success
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    $.each(result.error, function(id, errorMessage) {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Có lỗi xảy ra!',
                            body: errorMessage
                        });
                    });

                    $("#AssignSubmit").attr("disabled", false).html('Lưu thông tin');
                }

            },
            error: function(xhr, status, error) {
                alert(error);
                $("#AssignSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });

    // Submit form sửa phân công
    $("#EditAssignForm").submit(function(event) {
        event.preventDefault();
        $("#EditAssignSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/phancong/editphanconggiangday.php',
            type: 'POST',
            data: Data,
            success: function(result) {
                if (result.success) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Thành công!',
                        body: result.success
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    $.each(result.error, function(id, errorMessage) {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Có lỗi xảy ra!',
                            body: errorMessage
                        });
                    });

                    $("#EditAssignSubmit").attr("disabled", false).html('Lưu thông tin');
                }

            },
            error: function(xhr, status, error) {
                alert(error);
                $("#EditAssignSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });

    // // ĐƯa data vào bảng trong modal thêm giáo viên giảng dạy
    $('#DanhSachGiaoVien1').DataTable().destroy();
    var dataTableHS = $('#DanhSachGiaoVien1').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/QuanLyDiemTHPT/ajax/quanly/giaovien/getListGiaoVien.php'
        },
        pageLength: 10,
        'columns': [{
                data: 'maGV',
                searchable: false
            },
            {
                data: 'tenGV'
            },
            {
                data: 'ngaySinh'
            },
            {
                data: 'gioiTinh',
                render: function(data, type, row) {
                    return data == 0 ? 'Nam' : 'Nữ';
                }
            },
            {
                data: 'diaChi'
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
        }

    });

    $('#DanhSachGiaoVien1 tbody').on('click', 'tr', function() {
        var giaovien = dataTableHS.row(this).data();
        console.log(giaovien);
        $('#AssignForm select[name=maGV]').html('<option value="' + giaovien.maGV + '">' + giaovien
            .tenGV + '</option>');
        if ($(this).hasClass('bg-olive')) {
            $(this).removeClass('bg-olive');
        } else {
            dataTableHS.$('tr.bg-olive').removeClass('bg-olive');
            $(this).addClass('bg-olive');
        }
    });




    // ĐƯa data vào bảng trong modal sửa giáo viên giảng dạy
    $('#DanhSachGiaoVien2').DataTable().destroy();
    var dataTableGV = $('#DanhSachGiaoVien2').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/QuanLyDiemTHPT/ajax/quanly/giaovien/getListGiaoVien.php'
        },
        pageLength: 10,
        'columns': [{
                data: 'maGV',
                searchable: false
            },
            {
                data: 'tenGV'
            },
            {
                data: 'ngaySinh'
            },
            {
                data: 'gioiTinh',
                render: function(data, type, row) {
                    return data == 0 ? 'Nam' : 'Nữ';
                }
            },
            {
                data: 'diaChi'
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
        }

    });

    $('#DanhSachGiaoVien2 tbody').on('click', 'tr', function() {
        var giaovien = dataTableGV.row(this).data();
        console.log(giaovien);
        $('#EditAssignModal select[name=maGV]').html('<option value="' + giaovien.maGV + '">' + giaovien
            .tenGV + '</option>');
        if ($(this).hasClass('bg-olive')) {
            $(this).removeClass('bg-olive');
        } else {
            dataTableGV.$('tr.bg-olive').removeClass('bg-olive');
            $(this).addClass('bg-olive');
        }
    });





});



// Hiện model phân công giáo viên
function PhanCongGiaoVien(maMH, tenMH) {
    $("#AssignModal input[name=maMH]").val(maMH);
    $("#AssignModal span#TenMonHocAssign").html(tenMH);
    $('#AssignForm select[name=maGV]').html('<option>Chọn một giáo viên trong bảng bên cạnh</option>');
    $("#AssignModal").modal({
        show: true
    });
    $('#DanhSachGiaoVien1').DataTable().$('tr.bg-olive').removeClass('bg-olive');

}

// Hiện model sửa phân công
function DoiGiaoVien(maPhanCong, monhoc, maGV, tenGV) {
    $("#EditAssignForm input[name=id]").val(maPhanCong);
    $("#EditAssignForm span#TenMonHocAssign2").html(monhoc);
    $('#EditAssignForm select[name=maGV]').html('<option value="' + maGV + '">' + tenGV + '</option>');
    $("#EditAssignModal").modal({
        show: true
    });

    $('#DanhSachGiaoVien2').DataTable().$('tr.bg-olive').removeClass('bg-olive');

}
</script>


<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>