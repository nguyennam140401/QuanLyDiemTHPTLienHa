<?php
$title = 'Quản lý điểm';
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
    in_array($taikhoan['role'], array('admin', 'manager', 'teacher', 'student'))
) : ?>

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
                            <td><?php echo $classInfo['tenGV']; ?><?php echo in_array($taikhoan['role'], array('admin', 'manager', 'teacher')) ? '<a class="btn btn-info btn-sm" href="#"
                                    onclick="DoiChuNhiem()"><i class="fas fa-user-edit"></i>Thay đổi</a>' : '' ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="HocKyTab" role="tablist">
                    </ul>
                    <button type="button"
                        class="btn btn-warning btn-flat float-right  <?php echo in_array($taikhoan['role'], array('admin', 'manager', 'teacher')) ? '' : 'hidden' ?>"
                        onclick="AddHocSinh()"><i class="fas fa-plus-circle"></i>
                        Thêm mới</button>
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
<!-- MODAL Thêm học sinh vô lớp -->

<div id="AddHocSinhModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="maHS">Chọn học sinh</label>
                                <select name="maHS" id="maHS" class="form-control" required>
                                </select>
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
    var listMonHoc = null;
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/quanly/diem/getListMonHoc.php',
        success: function(data) {
            listMonHoc = data;
        }
    });
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
                    '"> <div class="row"><div class="col-sm-12 p-1 <?php echo in_array($taikhoan['role'], array('admin', 'manager', 'teacher')) ? '' : 'hidden'; ?>">' +
                    MonHocButton(
                        listMonHoc, <?php echo $maLop; ?>, row.maHK) +
                    '</div><div class="col-sm-12"><table class="table table-bordered table-striped" id="LopHocTable' +
                    index + '" width="100%">' + `<thead>
		<tr>
			<th width="20%">Mã học sinh</th>
			<th>Tên học sinh</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
			<th>Nơi sinh</th>
		</tr>
	</thead>
    <tbody></tbody>` +
                    '</table></div></div></div>');
                fillToLop(index, <?php echo $maLop; ?>, row.maHK);
            });
        }
    });



});

function fillToLop(tableindex, maLop, maHK) {
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/tracuu/lophoc/getLopHoc.php?maLop=' + maLop + '&maHK=' + maHK +
            '&length=100',
        success: function(data) {
            console.log(data)
            data.aaData.forEach((item, idx) => {
                $(`#LopHocTable${tableindex} tbody`).append(
                    `<tr role="row" class="odd">
                            <td class="sorting_1">${item.hocsinh.maHS}</td>
                            <td><a href="/QuanLyDiemTHPT/tracuu/diem.php?maHS=${item.hocsinh.maHS}">${item.hocsinh.tenHS}</a></td>
                            <td>${item.hocsinh.ngaySinh}</td>
                            <td>${item.hocsinh.gioiTinh==0?'Nam':'Nữ'}</td>
                            <td>${item.hocsinh.noiSinh}</td>
                            </tr>`)
            })
        }
    });
}

function MonHocButton(listmonHoc, maLop, maHK) {
    var listButton = '';
    $.each(listmonHoc, function(index, monhoc) {
        listButton += '<a class="btn btn-primary m-1" href="/QuanLyDiemTHPT/quanly/nhapdiem.php?maLop=' +
            maLop + '&maHK=' +
            maHK + '&maMH=' + monhoc.maMH + '">Nhập điểm ' + monhoc.tenMH + '</button>';
    });
    return listButton;
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
$("#EditTeacherForm").submit(function(event) {
    event.preventDefault();
    $("#EditTeacherSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
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
// Hiện model thêm HS vô lớp
function AddHocSinh() {

    $("#AddHocSinhModal").modal({
        show: true
    });



}
// Submit form thêm lớp
$("#AddHocSinhForm").submit(function(event) {
    event.preventDefault();
    $("#AddHocSinhSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
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

function getListHocSinh() {
    $.ajax({
        url: `/QuanLyDiemTHPT/ajax/quanly/lophoc/getHocSinh.php`,
        dataType: "json",
        type: "POST",
        async: true,
        data: {
            length: 9999
        },
        success: function(data) {

            $('#maHS').empty()
            data.aaData.forEach(hocsinh => {

                $('#maHS').append('<option value="' + hocsinh.maHS + '">' + hocsinh.tenHS +
                    '</option>');
            })
        },
        error: function(xhr, exception) {
            var msg = "";
            if (xhr.status === 0) {
                msg = "Not connect.\n Verify Network." + xhr.responseText;
            } else if (xhr.status == 404) {
                msg = "Requested page not found. [404]" + xhr.responseText;
            } else if (xhr.status == 500) {
                msg = "Internal Server Error [500]." + xhr.responseText;
            } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed.";
            } else if (exception === "timeout") {
                msg = "Time out error." + xhr.responseText;
            } else if (exception === "abort") {
                msg = "Ajax request aborted.";
            } else {
                msg = "Error:" + xhr.status + " " + xhr.responseText;
            }
            alert(msg)
        }
    });
}
getListHocSinh()
$.ajax({
    url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getHocKy.php',
    success: function(data) {
        $('#maHK').html('');
        $.each(data, function(index, row) {
            $('#maHK').append('<option value="' + row.maHK + '">' + row.tenHK + '</option>');
        });
    }
});
</script>
<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>