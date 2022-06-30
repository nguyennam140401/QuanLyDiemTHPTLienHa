<?php
$title = 'Thêm giáo viên mới';
require '../../template/tpl_header.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $giao_vien = $mysqli->query("SELECT * FROM `giaovien` WHERE maGV = $id");
    $giao_vien_each = mysqli_fetch_array($giao_vien);
}
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
        <div class="container">
            <form id="AddForm" action="process_update_giaovien.php" method="post">
                <input type="hidden" name="maGV" value="<?php echo $giao_vien_each['maGV'] ?>" />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tenGV">Tên giáo viên</label>
                            <input type="text" class="form-control" name="tenGV" placeholder="Tên giáo viên"
                                value="<?php echo $giao_vien_each['tenGV'] ?>" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ngaySinh">Ngày sinh</label>
                            <div class="input-group date" id="ngaySinhAdd" data-target-input="nearest">
                                <input type="date" class="form-control datetimepicker-input" name="ngaySinh"
                                    data-toggle="datetimepicker" data-target="#ngaySinhAdd"
                                    value="<?php echo $giao_vien_each['ngaySinh'] ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="gioiTinh">Giới tính</label>
                            <select name="gioiTinh" class="form-control">
                                <option value="0"
                                    selected="<?php if ($giao_vien_each['gioiTinh'] == 0) echo 'selected'; ?>">Nam
                                </option>
                                <option value="1"
                                    selected="<?php if ($giao_vien_each['gioiTinh'] == 1) echo 'selected'; ?>">Nữ
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="diaChi">Địa chỉ</label>
                            <input type="text" class="form-control" name="diaChi" placeholder="Địa chỉ"
                                value="<?php echo $giao_vien_each['diaChi'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info float-right" id="AddSubmit">Lưu thông
                        tin</button>
                </div>

            </form>
        </div>

    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
    integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<?php endif; ?>
<?php
require '../../template/tpl_footer.php';
?>