<?php
$title = 'Quản lý học sinh';
require './../template/tpl_header.php';

?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) : ?>


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


<!-- Datepicker -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"
    integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg=="
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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        Danh sách học sinh
                    </h3>
                    <input type="search" placeholder="Nhập tên tài khoản, email muốn tìm" id="search">
                    <button type="button" class="btn btn-warning btn-xs float-right"
                        onclick="$('#ModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm
                        mới</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" width="100%">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Họ tên học sinh</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Nơi sinh</th>
                                <th>Diện ưu tiên</th>
                                <th>Dân tộc</th>
                                <th>TP Gia Đình</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="HocSinhTable"></tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center">
                            <div class="text-secondary">

                                Các hàng tên mỗi trang: <select name="length" id="length" class="custom-select w-25">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <div class="text-secondary mx-3"> <span id="start">1</span> đến <span id="end">5</span> của
                                <span id="total">100</span>
                            </div>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination" attr-value="1">

                            </ul>
                        </nav>

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>



<!-- Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
    integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js"
    integrity="sha512-LvYVj/X6QpABcaqJBqgfOkSjuXv81bLz+rpz0BQoEbamtLkUF2xhPNwtI/xrokAuaNEQAMMA1/YhbeykYzNKWg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"
    integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>s


<!-- MODAL CHO Edit -->

<div id="ModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Chỉnh sửa thông tin </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="EditForm" action="#" method="post">
                    <input type="hidden" name="maHS" id="maHS" value="" required />
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="tenHS">Tên học sinh</label>
                                <input type="text" class="form-control" id="tenHS" name="tenHS"
                                    placeholder="Tên học sinh" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ngaySinh">Ngày sinh</label>
                                <div class="input-group date" id="ngaySinh" data-target-input="nearest">

                                    <input type="text" class="form-control datetimepicker-input" id="ngaySinh"
                                        name="ngaySinh" data-toggle="datetimepicker" data-target="#ngaySinh" required>
                                    <div class="input-group-append" data-target="#ngaySinh"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="gioiTinh">Giới tính</label>
                            <select name="gioiTinh" id="gioiTinh" class="form-control" required>
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="noiSinh">Nơi sinh</label>
                                <input type="text" class="form-control" id="noiSinh" name="noiSinh"
                                    placeholder="nơi sinh" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maDUT">Diện ưu tiên</label>
                                <select name="maDUT" id="maDUT" class="form-control">
                                    <option value="NULL">Không</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maDT">Dân tộc</label>
                                <select name="maDT" id="maDT" class="form-control" required />
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maTPGD">Thành phần gia đình</label>
                                <select name="maTPGD" id="maTPGD" class="form-control" required />
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info float-right" id="EditSubmit">Lưu thông tin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




<!-- MODAL CHO Add -->

<div id="ModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Thêm mới </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="AddForm" action="#" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="tenHS1">Tên học sinh</label>
                                <input type="text" class="form-control" name="tenHS" id="tenHS1"
                                    placeholder="Tên học sinh" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ngaySinh1">Ngày sinh</label>
                                <div class="input-group date" id="ngaySinh1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="ngaySinh1"
                                        name="ngaySinh" data-mask data-toggle="datetimepicker" data-target="#ngaySinh1"
                                        required>
                                    <div class="input-group-append" data-target="#ngaySinh1"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="gioiTinh1">Giới tính</label>
                            <select name="gioiTinh" id="gioiTinh1" class="form-control" required>
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="noiSinh1">Nơi sinh</label>
                                <input type="text" class="form-control" id="noiSinh1" name="noiSinh"
                                    placeholder="nơi sinh" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maDUT1">Diện ưu tiên</label>
                                <select name="maDUT" id="maDUT1" class="form-control">
                                    <option value="NULL">Không</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maDT1">Dân tộc</label>
                                <select name="maDT" id="maDT1" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="maTPGD1">Thành phần gia đình</label>
                                <select name="maTPGD" id="maTPGD1" class="form-control" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info float-right" id="AddSubmit">Lưu thông tin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var listData = []
    var totalRecords = 0

    function handleGetListAccount() {
        var page = $('#pagination').attr('attr-value')
        const rowsPerPage = $('select#length').val()
        $.ajax({
            url: `/QuanLyDiemTHPT/ajax/quanly/hocsinh/getListHocSinh.php?length=${rowsPerPage}&draw=${page}&start=${rowsPerPage*(page-1)}&search=${$('input#search').val()}`,
            dataType: "json",
            type: "GET",
            async: true,
            data: {},
            success: function(data) {
                console.log(data)
                listData = data.aaData
                $('span#start').text(rowsPerPage * (page - 1) + 1)
                $('span#end').text(rowsPerPage * page < data.iTotalRecords ? rowsPerPage * page :
                    data.iTotalRecords)
                $('span#total').text(data.iTotalRecords)
                $('#HocSinhTable').empty()
                data.aaData.forEach((item, idx) => {
                    $('#HocSinhTable').append(
                        `<tr role="row" class="odd">
                                    <td class="sorting_1">${item.maHS}</td>
                                    <td>${item.tenHS}</td>
                                    <td>${item.ngaySinh}</td>
                                    <td>${item.gioiTinh == 1?'Nữ' : 'Nam'}</td>
                                    <td>${item.noiSinh}</td>
                                    <td>${item.dienuutien.dienUuTien || "Không có"}</td>
                                    <td>${item.dantoc.tenDT}</td>
                                    <td>${item.thanhphangiadinh.tenTPGD}</td>
                                    <td><button class="btn btn-danger btn-sm float-right deleteable" attr-id="${item.maHS}"><i class="fas fa-trash"></i>Xoá</button> 
                                    <button class="btn btn-info btn-sm float-right editable" attr-id="${item.maHS}"><i class="fas fa-pencil-alt"></i>Sửa</button></td>
                                    </tr>`
                    )
                })
                totalRecords = data.iTotalRecords

                $('#pagination').empty();
                for (let i = 1; i < 1 + totalRecords / rowsPerPage; i++) {
                    $('#pagination').append(
                        `<li class="page-item ${i==data.draw?'active':''}"><a class="btn page-link" attr-value="${i}">${i}</a></li>`
                    )
                }
                $('.page-link').click(e => {
                    e.preventDefault();
                    $('#pagination').attr('attr-value', e.target.getAttribute('attr-value'))
                    handleGetListAccount()
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
            }
        });
    }

    handleGetListAccount()
    $('select#length').change((e) => {
        console.log('count' + e.target.value);
        handleGetListAccount()

    })
    $('input#search').keyup(e => {
        if (e.keyCode == '13') {
            handleGetListAccount()
        }
    })
    var classFillData = null;
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/quanly/hocsinh/getInfoHS.php',
        success: function(data) {
            console.log(data)
            classFillData = data;

            // Fill dữ liệu vào select
            var chiso = 0; // DIện ưu tiện
            $.each(classFillData[chiso], function(index, row) {
                $('#maDUT').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maDUT1').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
            var chiso = 1; // Dân tộc
            $.each(classFillData[chiso].reverse(), function(index, row) {
                $('#maDT').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maDT1').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
            var chiso = 2; // TP Gia Đình
            $.each(classFillData[chiso], function(index, row) {
                $('#maTPGD').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maTPGD1').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
        }
    });


    $('#HocSinhTable').on('click', '.editable', function(e) {
        var data = listData.find(item => item.maHS == e.target.getAttribute('attr-id'))
        console.log(listData, e.target.getAttribute('attr-id'))
        if (data) {
            console.log(data);
            // đổ dữ liệu vào form
            $("#ModalEdit input#maHS").val(data.maHS);
            $("#ModalEdit input#tenHS").val(data.tenHS);
            $("#ModalEdit input#ngaySinh").val(data.ngaySinh);
            $("#ModalEdit select#gioiTinh").val(data.gioiTinh);
            $("#ModalEdit input#noiSinh").val(data.noiSinh);
            $("#ModalEdit select#maDUT").val(data.dienuutien.maDUT);
            $("#ModalEdit select#maDT").val(data.dantoc.maDT);
            $("#ModalEdit select#maTPGD").val(data.thanhphangiadinh.maTPGD);
            $("#ModalEdit").modal({
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
    $('#HocSinhTable').on('click', '.deleteable', function(e) {
        var data = listData.find(item => item.maHS == e.target.getAttribute('attr-id'))
        if (confirm('Bạn có muốn xoá bản ghi này?')) {
            $.ajax({
                url: '/QuanLyDiemTHPT/ajax/quanly/hocsinh/deleteHocSinh.php',
                type: 'POST',
                data: {
                    maHS: e.target.getAttribute('attr-id')
                },
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
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Có lỗi xảy ra!',
                            body: result.error
                        });
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });


    // Submit form sửa
    $("#EditForm").submit(function(event) {
        event.preventDefault();
        $("#EditSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/hocsinh/editHocSinh.php',
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
                    $("#EditSubmit").attr("disabled", false).html('Lưu thông tin');
                }
            },
            error: function(xhr, status, error) {
                alert(error);
                $("#EditSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });


    // Submit form thêm
    $("#AddForm").submit(function(event) {
        event.preventDefault();
        $("#AddSubmit").attr("disabled", true).html(
            '<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: '/QuanLyDiemTHPT/ajax/quanly/hocsinh/addHocSinh.php',
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
                    $("#AddSubmit").attr("disabled", false).html('Lưu thông tin');
                }
            },
            error: function(xhr, status, error) {
                alert(error);
                $("#AddSubmit").attr("disabled", false).html('Lưu thông tin');
            }
        });
        return false;
    });


    //Date picker
    $('#ngaySinh').datetimepicker({
        //format: 'L',
        format: 'YYYY-MM-DD'
    });
    $('#ngaySinh1').datetimepicker({
        //format: 'L',
        format: 'YYYY-MM-DD'
    });


});
</script>




<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>