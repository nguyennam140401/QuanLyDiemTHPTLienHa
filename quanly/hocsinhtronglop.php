<?php
$title = 'Quản lý lớp học';
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
) : ?>

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
                            <th>Chủ nhiệm <a class="btn btn-info btn-sm" href="#" onclick="DoiChuNhiem()"><i
                                        class="fas fa-user-edit"></i>Thay đổi</a></th>
                            <td><?php echo $classInfo['tenGV']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="HocKyTab" role="tablist">

                    </ul>
                    <button type="button" class="btn btn-warning btn-flat float-right" onclick="AddHocSinh()"><i
                            class="fas fa-plus-circle"></i> Thêm mới</button>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="HocKyTabContent">
                    </div>

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



<!-- MODAL Thêm học sinh vô lớp -->

<div id="AddHocSinhModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Thêm học sinh vào lớp </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="AddHocSinhForm" action="#" method="post">
                    <input type="hidden" name="maLop" value="<?php echo $classInfo['maLop']; ?>" required />
                    <div class="row">
                        <div class="col-xl-8">
                            <table class="table table-bordered table-striped" id="DanhSachHocSinh" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">Mã</th>
                                        <th>Tên học sinh</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Nơi sinh</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="maHS">Chọn học sinh</label>
                                <select name="maHS" id="maHS" class="form-control" required>
                                </select>
                                <small class="form-text text-muted text-alert">* Chọn từ danh sách</small>
                            </div>
                            <div class="form-group">
                                <label for="maHK">Chọn học kỳ</label>
                                <select name="maHK" id="maHK" class="form-control" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info float-right" id="AddHocSinhSubmit">Lưu thông
                                    tin</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>



<!-- MODAL CHO Chuyển lớp -->

<div id="ModalTransferClass" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Chuyển lớp </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="TransferClassForm" action="#" method="post">
                    <input type="hidden" name="id" id="id" value="" required />
                    <!-- select -->
                    <div class="form-group">
                        <label for="maLop">Lớp</label>
                        <select name="maLop" id="maLop" class="form-control" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info float-right" id="TranferClassEditSubmit">Lưu thông
                            tin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL Sua Giao Vien chu nhiem -->

<div id="EditTeacherClass" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Chuyển lớp </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="EditTeacherForm" action="#" method="post">
                    <input type="hidden" name="maLop" value="<?php echo $classInfo['maLop']; ?>" required />
                    <!-- select -->
                    <div class="form-group">
                        <label for="maGV">Chọn giáo viên mới</label>
                        <select name="maGV" id="maGV" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info float-right" id="EditTeacherSubmit">Lưu thông
                            tin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/tracuu/getHocKy.php',
        success: function(data) {
            $.each(data, function(index, row) {
                var active = '',
                    selected = false;
                if (index == 0) {
                    active = ' active';
                    selected = 'true';
                }
                $('#HocKyTab').append('<li class="nav-item"> <a class="nav-link' + active +
                    '" id="tab' + index + '_data-tab" data-toggle="pill" href="#tab' +
                    index + '_data" role="tab" aria-controls="tab' + index +
                    '_data" aria-selected="' + selected + '">' + row.tenHK +
                    '</a> </li>');
                $('#HocKyTabContent').append('<div id="tab' + index +
                    '_data" class="tab-pane cont' + active +
                    '"> <table class="table table-bordered table-striped" id="LopHocTable' +
                    index + '" width="100%">' + $('#HocSinhTemplate').html() +
                    '</table></div>');
                FillTableLopHoc(index, <?php echo $maLop; ?>, row.maHK);
            });
        }
    });

    // Submit form thêm lớp
    $("#AddHocSinhForm").submit(function(event) {
        event.preventDefault();
        $("#AddHocSinhSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/themHocSinhvaoLop.php',
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

                    $("#AddHocSinhSubmit").attr("disabled", false).html('Lưu thông tin');
                }

            },
            error: function(xhr, status, error) {
                alert(error);
                $("#AddHocSinhSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });

    // Submit form chuyển lớp
    $("#TransferClassForm").submit(function(event) {
        event.preventDefault();
        $("#TranferClassEditSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/chuyenLop.php',
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

                    $("#TranferClassEditSubmit").attr("disabled", false).html(
                        'Lưu thông tin');
                }

            },
            error: function(xhr, status, error) {
                alert(error);
                $("#TranferClassEditSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });


    // Submit form đổi chủ nhiệm
    $("#EditTeacherForm").submit(function(event) {
        event.preventDefault();
        $("#EditTeacherSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/doiChuNhiem.php',
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

                    $("#EditTeacherSubmit").attr("disabled", false).html('Lưu thông tin');
                }

            },
            error: function(xhr, status, error) {
                alert(error);
                $("#EditTeacherSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });


    // ĐƯa danh sách học sinh vào table
    $('#DanhSachHocSinh').DataTable().destroy();
    var dataTableHS = $('#DanhSachHocSinh').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/QuanLyDiemTHPT/ajax/quanly/lophoc/getHocSinh.php'
        },
        pageLength: 10,
        'columns': [{
                data: 'maHS',
                searchable: false
            },
            {
                data: 'tenHS'
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
                data: 'noiSinh'
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
        }

    });

    $('#DanhSachHocSinh tbody').on('click', 'tr', function() {
        console.log(dataTableHS.row(this).data());
        var hocsinh = dataTableHS.row(this).data();
        $('#maHS').html('<option value="' + hocsinh.maHS + '">' + hocsinh.tenHS + '</option>');
        if ($(this).hasClass('bg-olive')) {
            $(this).removeClass('bg-olive');
        } else {
            dataTableHS.$('tr.bg-olive').removeClass('bg-olive');
            $(this).addClass('bg-olive');
        }
    });
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getHocKy.php',
        success: function(data) {
            $('#maHK').html('');
            $.each(data, function(index, row) {
                $('#maHK').append('<option value="' + row.maHK + '">' + row.tenHK +
                    '</option>');
            });
        }
    });


});



// Hiện model thêm HS vô lớp
function AddHocSinh() {

    $("#AddHocSinhModal").modal({
        show: true
    });



}

// Hiện model sửa chủ nhiệm
function DoiChuNhiem() {
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getInfo.php',
        success: function(data) {
            $('#maGV').html('');
            $.each(data[4], function(index, row) {
                $('#maGV').append('<option value="' + row.id + '">' + row.value + '</option>');
            });
        }
    });
    $("#EditTeacherClass").modal({
        show: true
    });

}



function FillTableLopHoc(tableindex, maLop, maHK) {
    var dataTable = $('#LopHocTable' + tableindex).DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '/QuanLyDiemTHPT/ajax/tracuu/lophoc/getLopHoc.php?maLop=' + maLop + '&maHK=' + maHK
        },
        pageLength: 50,
        'columns': [{
                data: 'hocsinh.maHS',
                searchable: false
            },
            {
                data: 'hocsinh.tenHS'
            },
            {
                data: 'hocsinh.ngaySinh'
            },
            {
                data: 'hocsinh.gioiTinh',
                render: function(data, type, row) {
                    return data == 0 ? 'Nam' : 'Nữ';
                }
            },
            {
                data: 'hocsinh.noiSinh'
            },
            {
                targets: -1,
                data: null,
                orderable: false,
                searchable: false,
                defaultContent: '<a class="btn btn-info btn-sm float-right editable" href="#"><i class="fas fa-exchange-alt"></i>Chuyển lớp</a>'
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
        },
        dom: "<'row'<'col-sm-12 col-md-8'Bl><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: ['copy', 'excel', {
            extend: 'csv',
            charset: 'UTF-8'
        }, 'pdf', 'print'],
        initComplete: function() {
            $('#LopHocTable' + tableindex + '_length').css('display', 'inline-block');
            $('#LopHocTable' + tableindex + '_length').css('padding-left', '15px');


        }

    });

    $('#LopHocTable' + tableindex + ' tbody').on('click', '.editable', function() {
        var data = dataTable.row($(this).parents('tr')).data();
        if (data) {
            $.ajax({
                url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getLopHocByPhanLop.php',
                data: {
                    id: data.phan_lop_hocsinh.id
                },
                success: function(data) {
                    $('#maLop').html('');
                    $.each(data, function(index, row) {
                        $('#maLop').append('<option value="' + row.maLop + '">' + row
                            .tenLop + '</option>');
                    });
                }
            });
            // đổ dữ liệu vào form
            $("#ModalTransferClass input#id").val(data.phan_lop_hocsinh.id);
            $("#ModalTransferClass").modal({
                show: true
            });
        } else {
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Có lỗi xảy ra!',
                body: 'Không tìm thấy dữ liệu'
            });
        }
    });

}
</script>

<script type="text/template" id="HocSinhTemplate">
    <thead>
		<tr>
			<th width="20%">Mã học sinh</th>
			<th>Tên học sinh</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
			<th>Nơi sinh</th>
			<th></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>#</th>
			<th>Tên học sinh</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
			<th>Nơi sinh</th>
			<th></th>
		</tr>
	</tfoot>
</script>


<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>