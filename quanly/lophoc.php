<?php
$title = 'Quản lý lớp học';
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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        Danh sách lớp học
                    </h3>
                    <button type="button" class="btn btn-warning btn-xs float-right"
                        onclick="$('#ModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm
                        mới</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" id="LopHocTable" width="100%">
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
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Khối</th>
                                <th>Tên lớp</th>
                                <th>Năm học</th>
                                <th>Chủ nhiệm</th>
                                <th></th>
                            </tr>
                        </tfoot>
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

    var listDataTable = $('#LopHocTable').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
        ajax: {
            'url': '/QuanLyDiemTHPT/ajax/quanly/lophoc/getLopHoc.php'
        },
        pageLength: 50,
        'columns': [{
                data: 'maLop',
                searchable: false
            },
            {
                data: {
                    _: "khoilop.tenKhoiLop",
                    sort: "khoilop.maKhoiLop"
                }
            },
            {
                data: 'tenLop',
                fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<a href='/QuanLyDiemTHPT/quanly/hocsinhtronglop.php?maLop=" +
                        oData.maLop + "'>" + oData.tenLop + "</a>");
                }
            },
            {
                data: {
                    _: "namhoc.namHoc",
                    sort: "namhoc.maNH"
                }
            },
            {
                data: {
                    _: "giaovien.tenGV",
                    sort: "giaovien.maGV"
                }
            },
            {
                targets: -1,
                data: null,
                orderable: false,
                searchable: false,
                defaultContent: "<a class=\"btn btn-danger btn-sm float-right deleteable\" href=\"#\"><i class=\"fas fa-trash\"></i>Xoá</a> \n <a class=\"btn btn-info btn-sm float-right editable\" href=\"#\"><i class=\"fas fa-pencil-alt\"></i>Sửa</a>"
            }
        ],
        order: [
            [3, "desc"]
        ],
        orderCellsTop: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
        },
        dom: "<'row'<'col-sm-12 col-md-8'Bl><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [{
                extend: 'copy',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            }
        ],
        initComplete: function() {
            var footer = this;
            var i = 0;
            footer.api().columns().every(function() {
                if (classFillData[i] != null) {
                    var column = this;
                    var title = $(column.footer()).text();
                    var select = $('<select class="form-control"><option value="">' +
                            title + '</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '' + val + '' : '', true, false)
                                .draw();
                        });
                    $.each(classFillData[i], function(index, row) {
                        select.append('<option value="' + row.value + '">' + row
                            .value + '</option>')
                    });
                }
                i++;
            });
            $('#LopHocTable_length').css('display', 'inline-block');
            $('#LopHocTable_length').css('padding-left', '15px');


        }

    });



    $('#LopHocTable tbody').on('click', '.editable', function() {
        var data = listDataTable.row($(this).parents('tr')).data();
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
    $('#LopHocTable tbody').on('click', '.deleteable', function() {
        var data = listDataTable.row($(this).parents('tr')).data();
        if (confirm('Bạn có muốn xoá bản ghi này?')) {
            $.ajax({
                url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/deleteLopHoc.php',
                type: 'POST',
                data: {
                    maLop: data['maLop']
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