<?php
$title = 'Quản lý năm học - học kỳ - Khối lớp';
require '../../template/tpl_header.php';
require '../../template/config.php';
$nam_hocs = $mysqli->query('SELECT * FROM namhoc');
$khoi_lops = $mysqli->query('SELECT * FROM khoilop');
$hoc_kies = $mysqli->query('SELECT * FROM hocky');
?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>
    <style>
        .toasts-top-right {
            z-index: 1060 !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <?php if (isset($_GET['type']) && $_GET['type'] == 'nam_hoc') { ?>
                    <?php
                    if (isset($_GET['id_sua'])) {
                        $id_sua = $_GET['id_sua'];
                        $nam_hoc_sua = $mysqli->query("SELECT * FROM namhoc WHERE maNH = $id_sua");
                        $nam_hoc_sua_each = mysqli_fetch_array($nam_hoc_sua);
                    }
                    ?>
                    <a class="btn btn-primary" href="namhoc.php">Quay lại</a>
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="container-fluid">
                                <form action="<?php echo $_GET['action'] == 'them_nam_hoc' ?  'process_add_nam_hoc.php' :  'process_edit_nam_hoc.php' ?>" method="post">
                                    <div class="form-group">
                                        <?php if (isset($_GET['type']) &&  $_GET['type'] == "nam_hoc" &&  $_GET['action'] == 'sua_nam_hoc') { ?>
                                            <input name="maNH" type="hidden" value="<?= $nam_hoc_sua_each['maNH'] ?>">
                                        <?php } ?>
                                        <label for="namHoc">Năm học</label>
                                        <input type="text" class="form-control" name="namHoc" placeholder="Ví dụ 2020 - 2021" value="<?php if (isset($_GET['type']) &&  $_GET['type'] == "nam_hoc" &&  $_GET['action'] == 'sua_nam_hoc') {
                                                                                                                                            echo $nam_hoc_sua_each['namHoc'];
                                                                                                                                        } ?>" />
                                    </div>
                                    <div class=" form-group">
                                        <button type="submit" class="btn btn-info float-right" id="NamHocAddSubmit"><?php echo $_GET['action'] == 'them_nam_hoc' ?  'Thêm' :  'Sửa' ?>
                                            thông tin</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Danh sách năm học
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="NamHocTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="NamHocTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table class="table table-striped projects dataTable no-footer" id="NamHocTable" width="100%" role="grid" aria-describedby="NamHocTable_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th>#</th>
                                                                        <th>Năm học</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($nam_hocs as $nam_hoc) : ?>
                                                                        <tr role="row" class="odd">
                                                                            <td class="sorting_1"><?= $nam_hoc['maNH'] ?>
                                                                            </td>
                                                                            <td><?= $nam_hoc['namHoc'] ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                <?php } else if (isset($_GET['type']) && $_GET['type'] == 'khoi_lop') { ?>
                    <?php
                    if (isset($_GET['id_sua'])) {
                        $id_sua = $_GET['id_sua'];
                        $khoi_lop_sua = $mysqli->query("SELECT * FROM khoilop WHERE maKhoiLop = $id_sua");
                        $khoi_lop_sua_each = mysqli_fetch_array($khoi_lop_sua);
                    }
                    ?>
                    <a class="btn btn-primary" href="namhoc.php">Quay lại</a>
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="container-fluid">
                                <form action="<?php echo $_GET['action'] == 'them_khoi_lop' ?  'process_add_khoi_lop.php' :  'process_edit_khoi_lop.php' ?>" method="post">
                                    <div class="form-group">
                                        <?php if (isset($_GET['type']) &&  $_GET['type'] == "khoi_lop" &&  $_GET['action'] == 'sua_khoi_lop') { ?>
                                            <input name="maKhoiLop" type="hidden" value="<?= $khoi_lop_sua_each['maKhoiLop'] ?>">
                                        <?php } ?>
                                        <label for="tenKhoiLop">Khối Lớp</label>
                                        <input type="text" class="form-control" name="tenKhoiLop" placeholder="Ví dụ 10" value="<?php if (isset($_GET['type']) &&  $_GET['type'] == "khoi_lop" &&  $_GET['action'] == 'sua_khoi_lop') {
                                                                                                                                    echo $khoi_lop_sua_each['tenKhoiLop'];
                                                                                                                                } ?>" />
                                    </div>
                                    <div class=" form-group">
                                        <button type="submit" class="btn btn-info float-right" id="NamHocAddSubmit"><?php echo $_GET['action'] == 'them_khoi_lop' ?  'Thêm' :  'Sửa' ?>
                                            thông tin</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Khối lớp
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="KhoiLopTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-striped projects dataTable no-footer" id="KhoiLopTable" width="100%" role="grid" aria-describedby="KhoiLopTable_info" style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Khối lớp</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($khoi_lops as $khoi_lop) : ?>
                                                            <tr role="row" class="odd">
                                                                <td class="sorting_1"><?= $khoi_lop['maKhoiLop'] ?>
                                                                </td>
                                                                <td><?= $khoi_lop['tenKhoiLop'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <div id="KhoiLopTable_processing" class="dataTables_processing card" style="display: none;">Đang xử lý...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    <?php } else if (isset($_GET['type']) && $_GET['type'] == 'hoc_ky') { ?>
                        <?php
                        if (isset($_GET['id_sua'])) {
                            $id_sua = $_GET['id_sua'];
                            $hoc_ky_sua = $mysqli->query("SELECT * FROM hocky WHERE maHK = $id_sua");
                            $hoc_ky_sua_each = mysqli_fetch_array($hoc_ky_sua);
                        }
                        ?>
                        <a class="btn btn-primary" href="namhoc.php">Quay lại</a>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="container-fluid">
                                    <form action="<?php echo $_GET['action'] == 'them_hoc_ky' ?  'process_add_hoc_ky.php' :  'process_edit_hoc_ky.php' ?>" method="post">
                                        <div class="form-group">
                                            <?php if (isset($_GET['type']) &&  $_GET['type'] == "hoc_ky" &&  $_GET['action'] == 'sua_hoc_ky') { ?>
                                                <input name="maHK" type="hidden" value="<?= $hoc_ky_sua_each['maHK'] ?>">
                                            <?php } ?>
                                            <label for="tenHK">Học kỳ</label>
                                            <input type="text" class="form-control" name="tenHK" placeholder="Ví dụ Học kỳ I" value="<?php if (isset($_GET['type']) &&  $_GET['type'] == "hoc_ky" &&  $_GET['action'] == 'sua_hoc_ky') {
                                                                                                                                            echo $hoc_ky_sua_each['tenHK'];
                                                                                                                                        } ?>" />
                                        </div>
                                        <div class=" form-group">
                                            <button type="submit" class="btn btn-info float-right"><?php echo $_GET['action'] == 'them_hoc_ky' ?  'Thêm' :  'Sửa' ?>
                                                thông tin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Học kỳ
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="KhoiLopTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped projects dataTable no-footer" id="KhoiLopTable" width="100%" role="grid" aria-describedby="KhoiLopTable_info" style="width: 100%;">
                                                        <thead>
                                                            <tr role="row">
                                                                <th>#</th>
                                                                <th>Học kỳ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($hoc_kies as $hoc_ky) : ?>
                                                                <tr role="row" class="odd">
                                                                    <td class="sorting_1"><?= $hoc_ky['maHK'] ?>
                                                                    </td>
                                                                    <td><?= $hoc_ky['tenHK'] ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Danh sách năm học
                                            </h3>
                                            <button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1"><i class="fas fa-plus-circle"></i><a href="?type=nam_hoc&action=them_nam_hoc">Thêm
                                                    mới</a></button>
                                        </div>
                                        <div class="card-body">
                                            <div id="NamHocTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="NamHocTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <table class="table table-striped projects dataTable no-footer" id="NamHocTable" width="100%" role="grid" aria-describedby="NamHocTable_info" style="width: 100%;">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th>#</th>
                                                                                <th>Năm học</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($nam_hocs as $nam_hoc) : ?>
                                                                                <tr role="row" class="odd">
                                                                                    <td class="sorting_1"><?= $nam_hoc['maNH'] ?>
                                                                                    </td>
                                                                                    <td><?= $nam_hoc['namHoc'] ?></td>
                                                                                    <td><a class="btn btn-danger btn-sm float-right deleteable ml-2" href="process_delete_nam_hoc.php?id=<?= $nam_hoc['maNH'] ?>"><i class="fas fa-trash"></i>Xoá</a>
                                                                                        <a class="btn btn-info btn-sm float-right editable" href="?type=nam_hoc&action=sua_nam_hoc&id_sua=<?= $nam_hoc['maNH'] ?>"><i class="fas fa-pencil-alt"></i>Sửa</a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Khối lớp
                                            </h3>
                                            <button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1" onclick="$('#KhoiLopModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i>
                                                <a href="?type=khoi_lop&action=them_khoi_lop">Thêm
                                                    mới</a></button>
                                        </div>
                                        <div class="card-body">
                                            <div id="KhoiLopTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped projects dataTable no-footer" id="KhoiLopTable" width="100%" role="grid" aria-describedby="KhoiLopTable_info" style="width: 100%;">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th>#</th>
                                                                    <th>Khối lớp</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($khoi_lops as $khoi_lop) : ?>
                                                                    <tr role="row" class="odd">
                                                                        <td class="sorting_1"><?= $khoi_lop['maKhoiLop'] ?>
                                                                        </td>
                                                                        <td><?= $khoi_lop['tenKhoiLop'] ?></td>
                                                                        <td><a class="btn btn-danger btn-sm float-right deleteable ml-2" href="process_delete_khoi_lop.php?id=<?= $khoi_lop['maKhoiLop'] ?>"><i class="fas fa-trash"></i>Xoá</a>
                                                                            <a class="btn btn-info btn-sm float-right editable" href="?type=khoi_lop&action=sua_khoi_lop&id_sua=<?= $khoi_lop['maKhoiLop'] ?>"><i class="fas fa-pencil-alt"></i>Sửa</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                        <div id="KhoiLopTable_processing" class="dataTables_processing card" style="display: none;">Đang xử lý...</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Học kỳ
                                            </h3>
                                            <button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1"><i class="fas fa-plus-circle"></i>

                                                <a href="?type=hoc_ky&action=them_hoc_ky">Thêm
                                                    mới</a></button>
                                        </div>
                                        <div class="card-body">
                                            <div id="HocKyTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped projects dataTable no-footer" id="HocKyTable" width="100%" role="grid" aria-describedby="HocKyTable_info" style="width: 100%;">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th>#</th>
                                                                    <th>Học kỳ</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tbody>
                                                                <?php foreach ($hoc_kies as $hoc_ky) : ?>
                                                                    <tr role="row" class="odd">
                                                                        <td class="sorting_1"><?= $hoc_ky['maHK'] ?>
                                                                        </td>
                                                                        <td><?= $hoc_ky['tenHK'] ?></td>
                                                                        <td><a class="btn btn-danger btn-sm float-right deleteable ml-2" href="process_delete_hoc_ky.php?id=<?= $hoc_ky['maHK'] ?>"><i class="fas fa-trash"></i>Xoá</a>
                                                                            <a class="btn btn-info btn-sm float-right editable" href="?type=hoc_ky&action=sua_hoc_ky&id_sua=<?= $hoc_ky['maHK'] ?>"><i class="fas fa-pencil-alt"></i>Sửa</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
        </section>

    </div>
    <!-- Select2 -->
<?php endif; ?>

<?php require '../../template/tpl_footer.php'; ?>