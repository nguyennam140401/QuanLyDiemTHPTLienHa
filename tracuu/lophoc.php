<?php
$title = 'Tra cứu lớp học';
require './../template/tpl_header.php';

$maLop = null;
$queryLop = null;
$classInfo = array();
if (!empty($_GET['maLop'])) {
	$maLop = (int)htmlspecialchars($_GET['maLop']);
	$queryLop = $mysqli->query('SELECT `maLop`, `tenLop`, `tenKhoiLop`, `namHoc`, `tenGV` FROM `lop` INNER JOIN `khoilop` ON `lop`.`maKhoiLop` = `khoilop`.`maKhoiLop` INNER JOIN `giaovien` ON `lop`.`maGV` = `giaovien`.`maGV` INNER JOIN `namhoc` ON `lop`.`maNH` = `namhoc`.`maNH`  WHERE `maLop`=' . $maLop . ';');
	if ($queryLop->num_rows > 0) {
		$classInfo = $queryLop->fetch_array(MYSQLI_ASSOC);
	}
}
//print_r($classInfo);
?>

<?php if (!empty($maLop) && isset($queryLop->num_rows) && $queryLop->num_rows > 0) : ?>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.css" integrity="sha512-hzvGZ3Tzqtdzskup1j2g/yc+vOTahFsuXp6X6E7xEel55qInqFQ6RzR+OzUc5SQ9UjdARmEP0g2LDcXA5x6jVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.5/responsive.bootstrap4.min.css" integrity="sha512-Yy2EzOvLO8+Vs9hwepJPuaRWpwWZ/pamfO4lqi6t9gyQ9DhQ1k3cBRa+UERT/dPzIN/RHZAkraw6Azs4pI0jNg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
				<div class="card card-info">
					<div class="card-body">
						<table class="table table-striped projects">
							<tr>
								<th>Mã lớp</th>
								<td><?php echo $classInfo['maLop']; ?></td>
							</tr>
							<tr>
								<th>Tên lớp</th>
								<td><?php echo $classInfo['tenLop']; ?></td>
							</tr>
							<tr>
								<th>Khối</th>
								<td><?php echo $classInfo['tenKhoiLop']; ?></td>
							</tr>
							<tr>
								<th>Chủ nhiệm</th>
								<td><?php echo $classInfo['tenGV']; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card card-default">
					<div class="card-header p-0 pt-1 border-bottom-0">
						<ul class="nav nav-tabs" id="HocKyTab" role="tablist">

						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="HocKyTabContent">
						</div>

					</div>
					<!-- /.card -->
				</div>
			</div>
		</section>
	</div>
	<!-- Datatables -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.7/dataTables.responsive.min.js" integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js" integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- Datatable Button -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/dataTables.buttons.min.js" integrity="sha512-PvgN2o+U/CTkCfOHqtSjTECpgUSY5kZm+VoMF4LN0M2QL8U9qGMrD+YGtpwyKUvhZ6jWNkk5Ldvtd4nucAtkow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.js" integrity="sha512-AijsNe5rDJjziesLO1SWgD0hmRWkETKzOCfEOoqt4l6Rpwfi1JC1WxLDV7eeSniCpRRPup2l+UnruRCA12ChVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js" integrity="sha512-xQBQYt9UcgblF6aCMrwU1NkVA7HCXaSN2oq0so80KO+y68M+n64FOcqgav4igHe6D5ObBLIf68DWv+gfBowczg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js" integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.min.js" integrity="sha512-BDZ+kFMtxV2ljEa7OWUu0wuay/PAsJ2yeRsBegaSgdUhqIno33xmD9v3m+a2M3Bdn5xbtJtsJ9sSULmNBjCgYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.print.min.js" integrity="sha512-UthH9WkvNUixebk8yKEFm3Sy+Rm8GbuvxiIMCDs9Cepl+YxhY+LUijPFZshcW7+PHa/HcSFLfSX3fGq1AcglWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.html5.min.js" integrity="sha512-33SxAOPhjjpLMmMGKqLwH2QNDmdxf038OFOq+fOI8p8ghCiOvfv3Bs2wqoj50USQkWBLpvy7+CzT5AHTZWGoNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


	<script>
		$(document).ready(function() {
			$.ajax({
				url: '/QuanLyDiemTHPTLienHa/ajax/tracuu/getHocKy.php',
				success: function(data) {
					$.each(data, function(index, row) {
						var active = '',
							selected = false;
						if (index == 0) {
							active = ' active';
							selected = 'true';
						}
						$('#HocKyTab').append('<li class="nav-item"> <a class="nav-link' + active + '" id="tab' + index + '_data-tab" data-toggle="pill" href="#tab' + index + '_data" role="tab" aria-controls="tab' + index + '_data" aria-selected="' + selected + '">' + row.tenHK + '</a> </li>');
						$('#HocKyTabContent').append('<div id="tab' + index + '_data" class="tab-pane cont' + active + '"> <table class="table table-bordered table-striped" id="LopHocTable' + index + '" width="100%">' + $('#HocSinhTemplate').html() + '</table></div>');
						FillTableLopHoc(index, <?php echo $maLop; ?>, row.maHK);
					});
				}
			});



		});

		function FillTableLopHoc(tableindex, maLop, maHK) {
			$('#LopHocTable' + tableindex).DataTable({
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {
					'url': '/QuanLyDiemTHPTLienHa/ajax/tracuu/lophoc/getLopHoc.php?maLop=' + maLop + '&maHK=' + maHK
				},
				pageLength: 50,
				'columns': [{
						data: 'hocsinh.maHS',
						searchable: false
					},
					{
						data: 'hocsinh.tenHS',
						fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
							$(nTd).html("<a href='/QuanLyDiemTHPTLienHa/tracuu/diem.php?maHS=" + oData.hocsinh.maHS + "'>" + oData.hocsinh.tenHS + "</a>");
						}
					},
					{
						data: 'hocsinh.ngaySinh'
					},
					{
						data: 'hocsinh.gioiTinh',
						render: function(data, type, row) {
							return data == 0 ? 'Nam' : 'Nữ';
						}
					},
					{
						data: 'hocsinh.noiSinh'
					}
				],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				},
				dom: "<'row'<'col-sm-12 col-md-8'Bl><'col-sm-12 col-md-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
				buttons: ['copy', 'excel', {
					extend: 'csv',
					charset: 'UTF-8'
				}, 'pdf', 'print'],
				initComplete: function() {
					$('#LopHocTable' + tableindex + '_length').css('display', 'inline-block');
					$('#LopHocTable' + tableindex + '_length').css('padding-left', '15px');


				}

			});
		}
	</script>

	<script type="text/template" id="HocSinhTemplate">
		<thead>
		<tr>
			<th width="20%">Mã học sinh</th>
			<th>Tên học sinh</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
			<th>Nơi sinh</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>#</th>
			<th>Tên học sinh</th>
			<th>Ngày sinh</th>
			<th>Giới tính</th>
			<th>Nơi sinh</th>
		</tr>
	</tfoot>
</script>




















<?php else : ?>
















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
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Danh sách lớp</h3>
					</div>
					<div class="card-body">
						<table class="table table-striped projects" id="LopHocTable" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Tên lớp</th>
									<th>Khối</th>
									<th>Năm học</th>
									<th>Chủ nhiệm</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Tên lớp</th>
									<th>Khối</th>
									<th>Năm học</th>
									<th>Chủ nhiệm</th>
								</tr>
							</tfoot>
						</table>

					</div>
					<!-- /.card -->
				</div>
			</div>
		</section>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			var listDataTable = $('#LopHocTable').DataTable({
				processing: true,
				serverSide: true,
				serverMethod: 'post',
				ajax: {
					'url': '/QuanLyDiemTHPTLienHa/ajax/tracuu/lophoc/getListLopHoc.php'
				},
				pageLength: 10,
				'columns': [{
						data: 'maLop',
						searchable: false,
						fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
							$(nTd).html("<a href='/QuanLyDiemTHPTLienHa/tracuu/lophoc.php?maLop=" + oData.maLop + "'>" + oData.maLop + "</a>");
						}
					},
					{
						data: 'tenLop',
						fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
							$(nTd).html("<a href='/QuanLyDiemTHPTLienHa/tracuu/lophoc.php?maLop=" + oData.maLop + "'>" + oData.tenLop + "</a>");
						}
					},
					{
						data: {
							_: "khoilop.tenKhoiLop",
							sort: "khoilop.maKhoiLop"
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
					}
				],

				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				}

			});
		});
	</script>



	<!-- Datatables -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.7/dataTables.responsive.min.js" integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js" integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>