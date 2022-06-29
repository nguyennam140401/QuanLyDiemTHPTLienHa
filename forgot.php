<?php
session_start();
ob_start();

if ((!empty($_SESSION['username']) && !empty($_SESSION['password'])) || (!empty($_COOKIE['username']) && !empty($_COOKIE['token']))) {
	header('Location: /QuanLyDiemTHPT/');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hệ thống quản lý điểm trường THPT Liên Hà</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="vuiz.net">
	<meta property="og:title" content="Hệ thống quản lý điểm trường THPT Liên Hà" />
	<meta property="og:image" content="assets/images/logo-truong.png" />
	<meta property="og:site_name" content="THPTLH" />
	<meta property="og:description" content="Hệ thống quản lý điểm trường THPT Liên Hà" />
	<meta property="og:url" content="https://vnedu.vuiz.net" />
	<!-- Favicon -->
	<link href="/assets/images/favicon.png" rel="icon" type="image/png">
	<link href="/assets/images/favicon.png" rel="shortcut icon" type="image/png">


	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Theme style -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="/QuanLyDiemTHPT" class="h1"><i class="fas fa-graduation-cap"></i> <b>VN</b>EDU</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Bạn quyên mật khẩu của mình?</p>
				<form id="ForgotPasswordForm" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email" required />
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" id="Submit" class="btn btn-primary btn-block">Yêu cầu mật khẩu mới</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<div class="card-footer">
				<p class="mt-1 mb-1">
					<a href="/QuanLyDiemTHPT/login.php">Quay lại trang Đăng nhập</a>
				</p>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
	<!-- jQuery UI 1.11.4 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- AdminLTE App -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- Bootstrap 4 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
		$(document).ready(function() {
			$("#ForgotPasswordForm").submit(function(event) {
				event.preventDefault();
				$("#Submit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Yêu cầu mật khẩu mới');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPT/ajax/login/forgot.php',
					type: 'POST',
					data: Data,
					success: function(result) {
						if (result.success) {
							$(document).Toasts('create', {
								class: 'bg-success',
								title: 'Thành công!',
								body: result.success
							});

						} else {
							$(document).Toasts('create', {
								class: 'bg-danger',
								title: 'Có lỗi xảy ra!',
								body: result.error
							});
						}

						$("#Submit").attr("disabled", false).html('Yêu cầu mật khẩu mới');
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#Submit").attr("disabled", false).html('Yêu cầu mật khẩu mới');
					}
				});
				return false;
			});
		});
	</script>
</body>

</html>