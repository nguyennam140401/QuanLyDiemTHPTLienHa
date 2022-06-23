<?php
$title = 'Quản lý năm học - học kỳ - Khối lớp';
require './../template/tpl_header.php';

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
				<div class="row">
					<div class="col-xl-4">
						<div class="card card-info">
							<div class="card-header">
								<h3 class="card-title">
									Danh sách năm học
								</h3>
								<button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1" onclick="$('#NamHocModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm mới</button>
							</div>
							<div class="card-body">
								<table class="table table-striped projects" id="NamHocTable" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Năm học</th>
											<th></th>
										</tr>
									</thead>
								</table>
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
								<button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1" onclick="$('#KhoiLopModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm mới</button>
							</div>
							<div class="card-body">
								<table class="table table-striped projects" id="KhoiLopTable" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Khối lớp</th>
											<th></th>
										</tr>
									</thead>
								</table>
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
								<button type="button" class="btn btn-outline-success bg-light btn-xs btn-flat float-right p-1" onclick="$('#HocKyModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm mới</button>
							</div>
							<div class="card-body">
								<table class="table table-striped projects" id="HocKyTable" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Học kỳ</th>
											<th></th>
										</tr>
									</thead>
								</table>
							</div>
							<!-- /.card -->
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- Datatables -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- Select2 -->



	<!-- NĂM HỌC -->
	<!-- MODAL CHO Edit -->
	<div id="NamHocModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="NamHocModalEdit" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Chỉnh sửa thông tin </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="NamHocEditForm" action="#" method="post">
						<input type="hidden" name="maNH" id="maNH" value="" />
						<div class="form-group">
							<label for="namHoc">Năm học</label>
							<input type="text" class="form-control" id="namHoc" name="namHoc" placeholder="Tên năm học" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="NamHocEditSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- MODAL CHO Add -->
	<div id="NamHocModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="NamHocModalAdd" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Thêm mới </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="NamHocAddForm" action="#" method="post">
						<div class="form-group">
							<label for="namHoc">Năm học</label>
							<input type="text" class="form-control" name="namHoc" placeholder="Ví dụ 2020 - 2021" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="NamHocAddSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>



	<!-- KhoiLopModel -->
	<!-- MODAL CHO Edit -->
	<div id="KhoiLopModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="KhoiLopModalEdit" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Chỉnh sửa thông tin </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="KhoiLopEditForm" action="#" method="post">
						<input type="hidden" name="maKhoiLop" id="maKhoiLop" value="" />
						<div class="form-group">
							<label for="tenKhoiLop">Khối lớp</label>
							<input type="text" class="form-control" id="tenKhoiLop" name="tenKhoiLop" placeholder="Khối lớp" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="KhoiLopEditSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- MODAL CHO Add -->
	<div id="KhoiLopModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="KhoiLopModalAdd" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Thêm mới </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="KhoiLopAddForm" action="#" method="post">
						<div class="form-group">Khối lớp</label>
							<input type="text" class="form-control" name="tenKhoiLop" placeholder="Ví dụ Khối 12" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="KhoiLopAddSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- HocKyModel -->
	<!-- MODAL CHO Edit -->
	<div id="HocKyModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Chỉnh sửa thông tin </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="HocKyEditForm" action="#" method="post">
						<input type="hidden" name="maHK" id="maHK" value="" />
						<div class="form-group">
							<label for="tenHK">Học kỳ</label>
							<input type="text" class="form-control" id="tenHK" name="tenHK" placeholder="Học kỳ" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="HocKyEditSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- MODAL CHO Add -->
	<div id="HocKyModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<strong>Thêm mới </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="HocKyAddForm" action="#" method="post">
						<div class="form-group">
							<label for="tenHK">Học kỳ</label>
							<input type="text" class="form-control" name="tenHK" placeholder="Ví dụ 2020 - 2021" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="HocKyAddSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			var listDataTableNamHoc = $('#NamHocTable').DataTable({
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {
					'url': '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/getNamHoc.php'
				},
				pageLength: 10,
				'columns': [{
						data: 'maNH',
						searchable: false
					},
					{
						data: 'namHoc'
					},
					{
						targets: -1,
						data: null,
						orderable: false,
						searchable: false,
						defaultContent: "<a class=\"btn btn-danger btn-sm float-right deleteable\" href=\"#\"><i class=\"fas fa-trash\"></i>Xoá</a> \n <a class=\"btn btn-info btn-sm float-right editable\" href=\"#\"><i class=\"fas fa-pencil-alt\"></i>Sửa</a>"
					}
				],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				}

			});

			var listDataTableKhoiLop = $('#KhoiLopTable').DataTable({
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {
					'url': '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/getKhoiLop.php'
				},
				pageLength: 10,
				'columns': [{
						data: 'maKhoiLop',
						searchable: false
					},
					{
						data: 'tenKhoiLop'
					},
					{
						targets: -1,
						data: null,
						orderable: false,
						searchable: false,
						defaultContent: "<a class=\"btn btn-danger btn-sm float-right deleteable\" href=\"#\"><i class=\"fas fa-trash\"></i>Xoá</a> \n <a class=\"btn btn-info btn-sm float-right editable\" href=\"#\"><i class=\"fas fa-pencil-alt\"></i>Sửa</a>"
					}
				],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				}

			});

			var listDataTableHocKy = $('#HocKyTable').DataTable({
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {
					'url': '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/getHocKy.php'
				},
				pageLength: 10,
				'columns': [{
						data: 'maHK',
						searchable: false
					},
					{
						data: 'tenHK'
					},
					{
						targets: -1,
						data: null,
						orderable: false,
						searchable: false,
						defaultContent: "<a class=\"btn btn-danger btn-sm float-right deleteable\" href=\"#\"><i class=\"fas fa-trash\"></i>Xoá</a> \n <a class=\"btn btn-info btn-sm float-right editable\" href=\"#\"><i class=\"fas fa-pencil-alt\"></i>Sửa</a>"
					}
				],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				}

			});






			// Thêm sửa xoá năm học

			$('#NamHocTable tbody').on('click', '.editable', function() {
				var data = listDataTableNamHoc.row($(this).parents('tr')).data();
				if (data) {
					console.log(data);
					// đổ dữ liệu vào form
					$("#NamHocModalEdit input#maNH").val(data.maNH);
					$("#NamHocModalEdit input#namHoc").val(data.namHoc);
					$("#NamHocModalEdit").modal({
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
			$('#NamHocTable tbody').on('click', '.deleteable', function() {
				var data = listDataTableNamHoc.row($(this).parents('tr')).data();
				if (confirm('Bạn có muốn xoá bản ghi này?')) {
					$.ajax({
						url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/deleteNamHoc.php',
						type: 'POST',
						data: {
							maNH: data['maNH']
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
			$("#NamHocEditForm").submit(function(event) {
				event.preventDefault();
				$("#NamHocEditSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/editNamHoc.php',
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
							$("#NamHocEditSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#NamHocEditSubmit").attr("disabled", false).html('Lưu thông tin');
					}
				});
				return false;
			});


			// Submit form thêm
			$("#NamHocAddForm").submit(function(event) {
				event.preventDefault();
				$("#NamHocAddSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/addNamHoc.php',
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
							$("#NamHocAddSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#NamHocAddSubmit").attr("disabled", false).html('Lưu thông tin');
					}
				});
				return false;
			});





			// Thêm sửa xoá hocky

			$('#HocKyTable tbody').on('click', '.editable', function() {
				var data = listDataTableHocKy.row($(this).parents('tr')).data();
				if (data) {
					console.log(data);
					// đổ dữ liệu vào form
					$("#HocKyModalEdit input#maHK").val(data.maHK);
					$("#HocKyModalEdit input#tenHK").val(data.tenHK);
					$("#HocKyModalEdit").modal({
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
			$('#HocKyTable tbody').on('click', '.deleteable', function() {
				var data = listDataTableHocKy.row($(this).parents('tr')).data();
				if (confirm('Bạn có muốn xoá bản ghi này?')) {
					$.ajax({
						url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/deleteHocKy.php',
						type: 'POST',
						data: {
							maHK: data['maHK']
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
			$("#HocKyEditForm").submit(function(event) {
				event.preventDefault();
				$("#HocKyEditSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/editHocKy.php',
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
							$("#HocKyEditSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#HocKyEditSubmit").attr("disabled", false).html('Lưu thông tin');
					}
				});
				return false;
			});


			// Submit form thêm
			$("#HocKyAddForm").submit(function(event) {
				event.preventDefault();
				$("#AddSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/addHocKy.php',
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
							$("#HocKyAddSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#HocKyAddSubmit").attr("disabled", false).html('Lưu thông tin');
					}
				});
				return false;
			});






			// Thêm sửa xoá khối lớp

			$('#KhoiLopTable tbody').on('click', '.editable', function() {
				var data = listDataTableKhoiLop.row($(this).parents('tr')).data();
				if (data) {
					console.log(data);
					// đổ dữ liệu vào form
					$("#KhoiLopModalEdit input#maKhoiLop").val(data.maKhoiLop);
					$("#KhoiLopModalEdit input#tenKhoiLop").val(data.tenKhoiLop);
					$("#KhoiLopModalEdit").modal({
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
			$('#KhoiLopTable tbody').on('click', '.deleteable', function() {
				var data = listDataTableKhoiLop.row($(this).parents('tr')).data();
				if (confirm('Bạn có muốn xoá bản ghi này?')) {
					$.ajax({
						url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/deleteKhoiLop.php',
						type: 'POST',
						data: {
							maKhoiLop: data['maKhoiLop']
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
			$("#KhoiLopEditForm").submit(function(event) {
				event.preventDefault();
				$("#KhoiLopEditSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/editKhoiLop.php',
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
							$("#KhoiLopEditSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#KhoiLopEditSubmit").attr("disabled", false).html('Lưu thông tin');
					}
				});
				return false;
			});


			// Submit form thêm
			$("#KhoiLopAddForm").submit(function(event) {
				event.preventDefault();
				$("#KhoiLopAddSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/namhoc/addKhoiLop.php',
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
							$("#KhoiLopAddSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#KhoiLopAddSubmit").attr("disabled", false).html('Lưu thông tin');
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