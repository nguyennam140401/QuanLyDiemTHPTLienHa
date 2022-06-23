<?php
$title = 'Quản lý tài khoản';
require './../template/tpl_header.php';

?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>


<style>
.toasts-top-right {
    z-index: 1060 !important;
}
</style>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
    integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
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
                        <li class="breadcrumb-item"><a href="/QuanLyDiemTHPTLienHa">Trang chủ</a></li>
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
                        <i class="far fa-user"></i>
                        Danh sách tài khoản
                    </h3>
                    <input type="search" placeholder="Nhập tên tài khoản, email muốn tìm" id="search">
                    <button type="button" class="btn btn-default btn-sm float-right p-0"
                        onclick="$('#ModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm
                        mới</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" width="100%">
                        <thead class="table-header">
                            <tr>
                                <th>#</th>
                                <th>Tài khoản</th>
                                <th>Vai trò</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="TaiKhoanTable">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
    integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>





<!-- MODAL CHO Edit -->

<div id="ModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Chỉnh sửa thông tin </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="EditForm" action="#" method="post">
                    <input type="hidden" name="id" id="id" value="" />
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="username">Tài khoản</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Tài khoản" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="role">Phân quyền tài khoản</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="student">Học sinh</option>
                                    <option value="teacher">Giáo viên</option>
                                    <option value="manager">Quản lý</option>
                                    <option value="admin">Quản trị viên</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Mật khẩu">
                                <small class="form-text text-muted text-alert">* Bỏ trống nếu không muốn sửa</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="repassword">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" id="repassword" name="repassword"
                                    placeholder="Nhập lại mật khẩu">
                                <small class="form-text text-muted text-alert">* Bỏ trống nếu không muốn sửa</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ Email"
                            required />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info float-right" id="EditSubmit">Lưu thông tin</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




<!-- TMODAL CHO Add -->

<div id="ModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Thêm tài khoản </strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="AddForm" action="#" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="username">Tài khoản</label>
                                <input type="text" class="form-control" name="username" placeholder="Tài khoản"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="role">Phân quyền tài khoản</label>
                                <select name="role" class="form-control">
                                    <option value="student">Học sinh</option>
                                    <option value="teacher">Giáo viên</option>
                                    <option value="manager">Quản lý</option>
                                    <option value="admin">Quản trị viên</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="repassword">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="repassword"
                                    placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Địa chỉ Email" required />
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
            url: `/QuanLyDiemTHPTLienHa/ajax/system/getTaiKhoan.php?length=${rowsPerPage}&draw=${page}&start=${rowsPerPage*(page-1)}&search=${$('input#search').val()}`,
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
                $('#TaiKhoanTable').empty()
                data.aaData.forEach((item, idx) => {
                    $('#TaiKhoanTable').append(
                        `<tr role="row" class="odd"><td class="sorting_1">${item.id}</td>
					<td>${item.username}</td><td>${item.role}</td>
					<td>${item.email|| ''}</td><td><button class="btn btn-danger btn-sm float-right deleteable" attr-id="${item.id}"><i class="fas fa-trash"></i>Xoá</button> 
		 <button class="btn btn-info btn-sm float-right editable" attr-id="${item.id}"><i class="fas fa-pencil-alt"></i>Sửa</button></td></tr>`
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
    $('#TaiKhoanTable').on('click', '.editable', function(e) {
        console.log(listData, e.target.getAttribute('attr-id'))
        var data = listData.find(item => item.id == e.target.getAttribute('attr-id'))
        if (data) {
            // đổ dữ liệu vào form
            $("#ModalEdit input#id").val(data['id']);
            $("#ModalEdit input#username").val(data['username']);
            $("#ModalEdit input#email").val(data['email']);
            $("#ModalEdit input#password").val('');
            $("#ModalEdit input#repassword").val('');
            $("#ModalEdit select#role").val(data['role']);
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
    $('#TaiKhoanTable').on('click', '.deleteable', function(e) {
        var data = listData.find(item => item.id == e.target.getAttribute('attr-id'))
        if (confirm('Bạn có muốn xoá bản ghi này?')) {
            $.ajax({
                url: '/QuanLyDiemTHPTLienHa/ajax/system/deleteTaiKhoan.php',
                type: 'POST',
                data: {
                    id: data['id']
                },
                success: function(result) {
                    if (result.success) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Thành công!',
                            body: result.success
                        });
                        //$('#ModalAdd').modal('hide'); //
                        handleGetListAccount()

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
            url: '/QuanLyDiemTHPTLienHa/ajax/system/editTaiKhoan.php',
            type: 'POST',
            data: Data,
            success: function(result) {
                if (result.success) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Thành công!',
                        body: result.success
                    });
                    $('#ModalEdit').modal('hide');
                    handleGetListAccount()
                    // setTimeout(function() {
                    // 	window.location.reload();
                    // }, 2000);
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
            url: '/QuanLyDiemTHPTLienHa/ajax/system/addTaiKhoan.php',
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