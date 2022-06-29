<?php
$title = 'Chỉnh sửa môn học';
require '../../template/tpl_header.php';
$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM `monhoc` WHERE maMH = $id"); // return array
$each = mysqli_fetch_array($result);
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
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">
							<i class="far fa-user"></i>
							Chỉnh sửa môn học
						</h3>
					</div>
					<div class="card-body">
						<form action="process_edit_monhoc.php" method="post" enctype="multipart/form" class="form col-md-6">
							<input type="hidden" name="id" value="<?php echo $each['maMH']; ?>" />
							<div class="form-group">
								<label for="nameMonHoc">Tên môn học</label>
								<input type="text" class="form-control" id="nameMonHoc" name="name" value="<?php echo $each['tenMH']; ?>">
							</div>
							<button type="submit" class="btn btn-primary">Chỉnh sửa</button>
						</form>
					</div>
					<!-- /.card -->
				</div>
			</div>
		</section>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php endif; ?>
<?php
require '../../template/tpl_footer.php';
?>