<?php
$title = 'Trang chủ';
require './template/tpl_header.php';


$studentCount = $mysqli->query('SELECT COUNT(*) AS `count` FROM `hocsinh`;')->fetch_array(MYSQLI_ASSOC)['count'];
$teacherCount = $mysqli->query('SELECT COUNT(*) AS `count` FROM `giaovien`;')->fetch_array(MYSQLI_ASSOC)['count'];
$classCount = $mysqli->query('SELECT COUNT(*) AS `count` FROM `lop`;')->fetch_array(MYSQLI_ASSOC)['count'];
$userCount = $mysqli->query('SELECT COUNT(*) AS `count` FROM `taiKhoan`;')->fetch_array(MYSQLI_ASSOC)['count'];
?>
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
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?php echo $studentCount; ?></h3>

							<p>Học sinh</p>
						</div>
						<div class="icon">
							<i class="fas fa-book-reader"></i>
						</div>
						<a href="/quanly/hocsinh.php" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?php echo $teacherCount; ?></h3>

							<p>Cán bộ giáo viên</p>
						</div>
						<div class="icon">
							<i class="fas fa-graduation-cap"></i>
						</div>
						<a href="/quanly/giaovien.php" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?php echo $classCount; ?></h3>

							<p>Lớp học</p>
						</div>
						<div class="icon">
							<i class="fas fa-chalkboard-teacher"></i>
						</div>
						<a href="/quanly/lophoc.php" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?php echo $userCount; ?></h3>

							<p>Người dùng hệ thống</p>
						</div>
						<div class="icon">
							<i class="fas fa-users"></i>
						</div>
						<a href="/system/quanlytaikhoan.php" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->



			<!-- Calendar -->
			<div class="card bg-gradient-success">
				<div class="card-header border-0">

					<h3 class="card-title">
						<i class="far fa-calendar-alt"></i>
						Lịch
					</h3>
					<!-- tools card -->
					<div class="card-tools">
						<!-- button with a dropdown -->
						<button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
					<!-- /. tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body pt-0">
					<!--The calendar -->
					<div id="calendar" style="width: 100%"></div>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js" integrity="sha512-LvYVj/X6QpABcaqJBqgfOkSjuXv81bLz+rpz0BQoEbamtLkUF2xhPNwtI/xrokAuaNEQAMMA1/YhbeykYzNKWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		// The Calender
		$('#calendar').datetimepicker({
			format: 'L',
			inline: true
		})
	});
</script>
<?php
require './template/tpl_footer.php';
?>