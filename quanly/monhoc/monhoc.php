<?php
$title = 'Quản lý môn học';
require '../../template/tpl_header.php';
require "../../template/config.php";
$sql = 'SELECT * FROM monhoc';
$result = $mysqli->query('SELECT * FROM monhoc');
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
							Danh sách môn học
						</h3>
						<button type="button" class="btn btn-default btn-sm float-right p-0">
							<a href="add_monhoc.php" class="btn btn-primary">Thêm mới</a>
						</button>
					</div>
					<div class="col-md-3 mt-3">
						<input class="form-control" type="search" placeholder="Nhập tên môn học muốn tìm" id="search">
						<button class="btn btn-primary mt-3">Tìm kiếm</button>
					</div>
					<?php if (isset($_SESSION['delete_monhoc_error'])) { ?>
						<h4 class="text-danger mt-3"><?php echo $_SESSION['delete_monhoc_error'] ?></h4>
					<?php }
					unset($_SESSION['delete_monhoc_error']) ?>
					<?php if (isset($_SESSION['delete_monhoc_success'])) { ?>
						<h4 class="text-success mt-3"><?php echo $_SESSION['delete_monhoc_success'] ?></h4>
					<?php }
					unset($_SESSION['delete_monhoc_success']) ?>
					<div class="card-body">
						<table class="table table-striped projects" width="100%">
							<thead class="table-header">
								<tr>
									<th>#</th>
									<th>Tên môn</th>
									<th style="text-align:center">Sửa</th>
									<th style="text-align:center">Xóa</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $item) : ?>
									<tr>
										<td><?= $item['maMH'] ?></td>
										<td><?= $item['tenMH'] ?></td>
										<td style="text-align:center">
											<a href="edit_monhoc.php?id=<?= $item['maMH'] ?>" class="btn btn-info btn-sm editable">
												<i class="fas fa-pencil-alt"></i>Sửa
											</a>
										</td>
										</button>
										<td style="text-align:center">
											<a class="btn btn-danger btn-sm deleteable" href="process_delete_monhoc.php?id=<?= $item['maMH'] ?>">
												<i class="fas fa-trash"></i>
												Xóa
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<!-- <div class="d-flex justify-content-between align-items-center mt-3">
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

						</div> -->
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