<?php
$title = 'Quản lý điểm';
require './../template/tpl_header.php';

?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher', 'student'))) : ?>


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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        Danh sách lớp học
                    </h3>
                    <input type="search" placeholder="Nhập tên lớp học" id="search">
                    <?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>
                    <button type="button" class="btn btn-warning btn-xs float-right"
                        onclick="$('#ModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm
                        mới</button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Khối</th>
                                <th>Tên lớp</th>
                                <th>Năm học</th>
                                <th>Chủ nhiệm</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="LopHocTable">

                        </tbody>
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


<!-- MODAL CHO Edit -->

<div id="ModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <strong>Chỉnh sửa thông tin </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="EditForm" action="#" method="post">
                    <input type="hidden" name="maLop" id="maLop" value="" />
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="tenLop">Tên lớp</label>
                                <input type="text" class="form-control" id="tenLop" name="tenLop"
                                    placeholder="Tên lớp" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="maKhoiLop">Khối lớp</label>
                                <select name="maKhoiLop" id="maKhoiLop" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="maNH">Năm học</label>
                                <select name="maNH" id="maNH" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="maGV">Giáo viên chủ nhiệm</label>
                                <select name="maGV" id="maGV" class="form-control">
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
    <div class="modal-dialog" role="document">
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
                                <label for="tenLop">Tên lớp</label>
                                <input type="text" class="form-control" name="tenLop" placeholder="Tên lớp" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="maKhoiLop">Khối lớp</label>
                                <select name="maKhoiLop" id="maKhoiLop2" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="maNH">Năm học</label>
                                <select name="maNH" id="maNH2" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="maGV">Giáo viên chủ nhiệm</label>
                                <select name="maGV" id="maGV2" class="form-control">
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
    var classFillData = null;
    var listData = []
    var totalRecords = 0

    function handleGetListLopHoc() {
        var page = $('#pagination').attr('attr-value')
        const rowsPerPage = $('select#length').val()
        $.ajax({
            url: `/QuanLyDiemTHPT/ajax/quanly/lophoc/getLopHoc.php?length=${rowsPerPage}&draw=${page}&start=${rowsPerPage*(page-1)}&search=${$('input#search').val()}`,
            dataType: "json",
            type: "GET",
            async: true,
            data: {},
            success: function(data) {
                console.log(data)
                listData = data.aaData
                $('span#start').text(rowsPerPage * (page - 1) + 1)
                $('span#end').text(rowsPerPage * page < data.iTotalDisplayRecords ? rowsPerPage *
                    page :
                    data.iTotalDisplayRecords)
                $('span#total').text(data.iTotalDisplayRecords)
                $('#LopHocTable').empty()
                data.aaData.forEach((item, idx) => {
                    $('#LopHocTable').append(
                        `<tr role="row" class="odd"><td>${item.maLop}</td><td>${item.khoilop.tenKhoiLop}</td>
                        <td><a href="/QuanLyDiemTHPT/quanly/diem_viewclass.php?maLop=${item.maLop}">${item.tenLop}</a></td>
                        <td class="sorting_1">${item.namhoc.namHoc}</td><td>${item.giaovien.tenGV}</td>
                        
                        <td><?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?><a class="btn btn-danger btn-sm float-right deleteable" attr-id="${item.maLop}" href="#"><i class="fas fa-trash"></i>Xoá</a> 
 <a class="btn btn-info btn-sm float-right editable" attr-id="${item.maLop}" href="#"><i class="fas fa-pencil-alt"></i>Sửa</a></td> <?php endif; ?></tr>
                       
                        `
                    )
                })
                totalRecords = data.iTotalDisplayRecords

                $('#pagination').empty();
                for (let i = 1; i < 1 + totalRecords / rowsPerPage; i++) {
                    $('#pagination').append(
                        `<li class="page-item ${i==data.draw?'active':''}"><a class="btn page-link" attr-value="${i}">${i}</a></li>`
                    )
                }
                $('.page-link').click(e => {
                    e.preventDefault();
                    $('#pagination').attr('attr-value', e.target.getAttribute('attr-value'))
                    handleGetListLopHoc()
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
    handleGetListLopHoc()
    $('select#length').change((e) => {
        console.log('count' + e.target.value);
        handleGetListLopHoc()

    })
    $('input#search').keyup(e => {
        if (e.keyCode == '13') {
            handleGetListLopHoc()
        }
    })
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getInfo.php',
        success: function(data) {
            classFillData = data;

            // Fill dữ liệu vào select
            var chiso = 1; // khối
            $.each(classFillData[chiso], function(index, row) {
                $('#maKhoiLop').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maKhoiLop2').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
            var chiso = 3; // năm học
            $.each(classFillData[chiso].reverse(), function(index, row) {
                $('#maNH').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maNH2').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
            var chiso = 4; //Chủ nhiệm
            $.each(classFillData[chiso], function(index, row) {
                $('#maGV').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
                $('#maGV2').append('<option value="' + row.id + '">' + row.value +
                    '</option>');
            });
        }
    });


    $('#LopHocTable').on('click', '.editable', function(e) {
        var data = listData.find(item => item.maLop == e.target.getAttribute('attr-id'))
        console.log(e.target.getAttribute('attr-id'), listData)
        if (data) {
            console.log(data);
            // đổ dữ liệu vào form
            $("#ModalEdit input#maLop").val(data.maLop);
            $("#ModalEdit input#tenLop").val(data.tenLop);
            $("#ModalEdit select#maKhoiLop").val(data.khoilop.maKhoiLop);
            $("#ModalEdit select#maNH").val(data.namhoc.maNH);
            $("#ModalEdit select#maGV").val(data.giaovien.maGV);
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
    $('#LopHocTable').on('click', '.deleteable', function(e) {
        var data = listData.find(item => item.maLop == e.target.getAttribute('attr-id'))
        if (confirm('Bạn có muốn xoá bản ghi này?')) {
            $.ajax({
                url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/deleteLopHoc.php',
                type: 'POST',
                data: {
                    maLop: e.target.getAttribute('attr-id')
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
            url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/editLopHoc.php',
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
            url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/addLopHoc.php',
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

});
</script>




<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>