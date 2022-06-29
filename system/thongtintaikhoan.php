<?php
$title = 'Thông tin tài khoản';
require './../template/tpl_header.php';

?>
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
			<div class="row">
				<div class="col-md-6">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">
								<i class="far fa-edit"></i>
								Sửa thông tin
							</h3>
						</div>
						<div class="card-body">
							<form id="EditForm" action="#" method="post">
								<input type="hidden" name="id" id="id" value="" />
								<div class="form-group">
									<input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Mật khẩu cũ">
									<small class="form-text text-muted text-alert">* Bỏ trống nếu không muốn đổi mật khẩu</small>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
									<small class="form-text text-muted text-alert">* Bỏ trống nếu không muốn đổi mật khẩu</small>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Nhập lại mật khẩu">
									<small class="form-text text-muted text-alert">* Bỏ trống nếu không muốn đổi mật khẩu</small>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ Email" required value="<?php echo $taikhoan['email']; ?>" />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info float-right" id="EditSubmit">Lưu thông tin</button>
								</div>
							</form>
						</div>
						<!-- /.card -->
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">
								<i class="far fa-user"></i>
								Thông tài khoản
							</h3>
						</div>
						<div class="card-body">
							<ul class="list-group list-group-unbordered ">
								<li class="list-group-item">
									<b>Tài khoản</b> <span class="float-right"><?php echo $taikhoan['username']; ?></span>
								</li>
								<li class="list-group-item">
									<b>Phân quyền</b> <span class="badge bg-success float-right"><?php echo $taikhoan['role']; ?></span>
								</li>
								<li class="list-group-item">
									<b>Email</b> <span class="float-right"><?php echo $taikhoan['email']; ?></span>
								</li>
							</ul>
						</div>
						<!-- /.card -->
					</div>
				</div>
			</div>

		</div>
	</section>
</div>


<script>
	$(document).ready(function() {

		// Submit form sửa
		$("#EditForm").submit(function(event) {
			event.preventDefault();
			$("#EditSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
			var form = $(this);
			var Data = form.serialize();
			$.ajax({
				url: '/QuanLyDiemTHPT/ajax/system/usereditTaiKhoan.php',
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
	});
</script>




<?php
require './../template/tpl_footer.php';
?>