<?php
$title = 'Quản lý giáo viên';
require '../../template/tpl_header.php';
require '../../template/config.php';
$sql = 'SELECT * FROM giaovien';
$result = $mysqli->query($sql);

if (isset($_GET['q'])) {
    $search = $_GET['q'];
    $sql = "SELECT * FROM giaovien WHERE tenGV like '%$search%'";
    $giaoviens_search = $mysqli->query($sql);
}

?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>


    <style>
        .toasts-top-right {
            z-index: 1060 !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.css" integrity="sha512-hzvGZ3Tzqtdzskup1j2g/yc+vOTahFsuXp6X6E7xEel55qInqFQ6RzR+OzUc5SQ9UjdARmEP0g2LDcXA5x6jVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.5/responsive.bootstrap4.min.css" integrity="sha512-Yy2EzOvLO8+Vs9hwepJPuaRWpwWZ/pamfO4lqi6t9gyQ9DhQ1k3cBRa+UERT/dPzIN/RHZAkraw6Azs4pI0jNg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                            Danh sách giáo viên
                        </h3>
                        <button type="button" class="btn btn-default btn-sm float-right p-0">
                            <a href="add_giaovien.php" class="btn btn-primary">Thêm mới</a>
                        </button>

                    </div>
                    <div class="col-md-3 mt-3">
                        <?php if (isset($_GET['q'])) { ?>
                            <a href="giaovien.php" class="btn btn-secondary">Quay lại</a>
                        <?php } else { ?>
                            <form>
                                <input class="form-control" type="text" name="q" placeholder="Nhập tên giao vien muốn tìm" id="search">
                                <button class="btn btn-primary mt-3" type="submit">Tìm kiếm</button>
                            </form>
                        <?php } ?>
                    </div>ch 
                    <?php if (isset($_SESSION['delete_giaovien_error'])) { ?>
                        <h4 class="text-danger mt-3"><?php echo $_SESSION['delete_giaovien_error'] ?></h4>
                    <?php }
                    unset($_SESSION['delete_giaovien_error']) ?>
                    <?php if (isset($_SESSION['delete_giaovien_success'])) { ?>
                        <h4 class="text-success mt-3"><?php echo $_SESSION['delete_giaovien_success'] ?></h4>
                    <?php }
                    unset($_SESSION['delete_giaovien_success']) ?>
                    <div class="card-body">
                        <?php if (isset($_GET['q'])) { ?>
                            <h3>Kết quả tìm kiếm: "<?= $_GET['q'] ?>"</h3>
                            <?php if (mysqli_num_rows($giaoviens_search) == 0) { ?>
                                <h4>Không tìm thấy dữ liệu</h4>
                            <?php } else { ?>
                                <table class="table table-striped projects" id="GiaoVienTable" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Giáo viên</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Địa chỉ</th>
                                            <th style="text-align:center">Sửa</th>
                                            <th style="text-align:center">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <?php foreach ($giaoviens_search as $giaovien_search) : ?>
                                            <tr>
                                                <td><?= $giaovien_search['maGV'] ?></td>
                                                <td><?= $giaovien_search['tenGV'] ?></td>
                                                <td><?= $giaovien_search['ngaySinh'] ?></td>
                                                <td><?php if ($giaovien_search['gioiTinh'] == 0) {
                                                        echo 'Nam';
                                                    } else {
                                                        echo 'Nữ';
                                                    } ?></td>
                                                <td><?= $giaovien_search['diaChi'] ?></td>
                                                <td style="text-align:center">
                                                    <a href="edit_giaovien.php?id=<?= $giaovien_search['maGV'] ?>" class="btn btn-info btn-sm editable">
                                                        <i class="fas fa-pencil-alt"></i>Sửa
                                                    </a>
                                                </td>
                                                </button>
                                                <td style="text-align:center">
                                                    <a class="btn btn-danger btn-sm deleteable" href="process_delete_giaovien.php?id=<?= $giaovien_search['maGV'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                        Xóa
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tfoot>
                                </table>
                            <?php } ?>
                        <?php } else { ?>
                            <table class="table table-striped projects" id="GiaoVienTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Giáo viên</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Địa chỉ</th>
                                        <th style="text-align:center">Sửa</th>
                                        <th style="text-align:center">Xóa</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <?php foreach ($result as $item) : ?>
                                        <tr>
                                            <td><?= $item['maGV'] ?></td>
                                            <td><?= $item['tenGV'] ?></td>
                                            <td><?= $item['ngaySinh'] ?></td>
                                            <td><?php if ($item['gioiTinh'] == 0) {
                                                    echo 'Nam';
                                                } else {
                                                    echo 'Nữ';
                                                } ?></td>
                                            <td><?= $item['diaChi'] ?></td>
                                            <td style="text-align:center">
                                                <a href="edit_giaovien.php?id=<?= $item['maGV'] ?>" class="btn btn-info btn-sm editable">
                                                    <i class="fas fa-pencil-alt"></i>Sửa
                                                </a>
                                            </td>
                                            </button>
                                            <td style="text-align:center">
                                                <a class="btn btn-danger btn-sm deleteable" href="process_delete_giaovien.php?id=<?= $item['maGV'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                    Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tfoot>
                            </table>
                        <?php } ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>

    </div>

    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js" integrity="sha512-LvYVj/X6QpABcaqJBqgfOkSjuXv81bLz+rpz0BQoEbamtLkUF2xhPNwtI/xrokAuaNEQAMMA1/YhbeykYzNKWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- MODAL CHO Edit -->

    <div id="ModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <strong>Chỉnh sửa thông tin </strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="EditForm" action="#" method="post">
                        <input type="hidden" name="maGV" id="maGV" value="" />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tenGV">Tên giáo viên</label>
                                    <input type="text" class="form-control" id="tenGV" name="tenGV" placeholder="Tên giáo viên" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ngaySinh">Ngày sinh</label>
                                    <div class="input-group date" id="ngaySinhEdit" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="ngaySinh" name="ngaySinh" data-toggle="datetimepicker" data-target="#ngaySinhEdit">
                                        <div class="input-group-append" data-target="#ngaySinhEdit" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gioiTinh">Giới tính</label>
                                    <select name="gioiTinh" id="gioiTinh" class="form-control">
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="diaChi">Địa chỉ</label>
                                    <input type="text" class="form-control" id="diaChi" name="diaChi" placeholder="Địa chỉ" />
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

    <div id="ModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <strong>Thêm mới </strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="AddForm" action="#" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tenGV">Tên giáo viên</label>
                                    <input type="text" class="form-control" name="tenGV" placeholder="Tên giáo viên" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ngaySinh">Ngày sinh</label>
                                    <div class="input-group date" id="ngaySinhAdd" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="ngaySinh" data-toggle="datetimepicker" data-target="#ngaySinhAdd">
                                        <div class="input-group-append" data-target="#ngaySinhAdd" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="gioiTinh">Giới tính</label>
                                    <select name="gioiTinh" class="form-control">
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="diaChi">Địa chỉ</label>
                                    <input type="text" class="form-control" name="diaChi" placeholder="Địa chỉ" />
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



<?php endif; ?>
<?php
require '../../template/tpl_footer.php';
?>