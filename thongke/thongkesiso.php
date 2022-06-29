<?php
$title = 'Thống kê sĩ số lớp';
require './../template/tpl_header.php';

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
							Thống kê sĩ số theo lớp
						</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-striped projects" id="LopHocTable" width="100%">
									<thead>
										<tr>
											<th>Lớp</th>
											<th>Khối</th>
											<th>Năm học</th>
											<th>Học kỳ</th>
											<th>Chủ nhiệm</th>
											<th>Sĩ số</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Lớp</th>
											<th>Khối</th>
											<th>Năm học</th>
											<th>Học kỳ</th>
											<th>Chủ nhiệm</th>
											<th>Sĩ số</th>
										</tr>
									</tfoot>
								</table>
							</div>
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
			var classFillData = null,
				hocky = null;
			$.ajax({
				url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getInfo.php',
				success: function(data) {
					classFillData = data;

				}
			});
			$.ajax({
				url: '/QuanLyDiemTHPT/ajax/quanly/lophoc/getHocKy.php',
				success: function(data) {
					hocky = data;

				}
			});

			var listDataTable = $('#LopHocTable').DataTable({
				processing: true,
				serverSide: true,
				seaching: false,
				lengthChange: false,
				serverMethod: 'post',
				ajax: {
					'url': '/QuanLyDiemTHPT/ajax/thongke/getSiSoLopHoc.php'
				},
				pageLength: -1,
				'columns': [{
						data: 'tenLop',
						fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
							$(nTd).html("<a href='/QuanLyDiemTHPT/quanly/hocsinhtronglop.php?maLop=" + oData.maLop + "'>" + oData.tenLop + "</a>");
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
							_: "hocky.tenHK",
							sort: "hocky.maHK"
						}
					},
					{
						data: {
							_: "giaovien.tenGV",
							sort: "giaovien.maGV"
						}
					},
					{
						data: 'siso'
					}
				],
				order: [
					[2, "desc"]
				],
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
				},
				dom: "<'row'<'col-sm-12 col-md-8'B><'col-sm-12 col-md-4'F>>" +
					"<'row'<'col-sm-12'tr>>" +
					"",
				buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
				initComplete: function() {
					var footer = this;
					var i = 0;
					footer.api().columns().every(function() {
						var column = this;
						if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
							var title = $(column.footer()).text();
							var select = $('<select class="form-control"><option value="">' + title + '</option></select>')
								.appendTo($(column.footer()).empty())
								.on('change', function() {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);

									column
										.search(val ? '' + val + '' : '', true, false)
										.draw();
								});

							if (i != 3) {
								var j;
								if (i == 0) j = 2;
								if (i == 1) j = 1;
								if (i == 2) j = 3;
								if (i == 4) j = 4;
								$.each(classFillData[j], function(index, row) {
									select.append('<option value="' + row.value + '">' + row.value + '</option>')
								});
							} else {
								$.each(hocky, function(index, row) {
									//console.log(row);
									select.append('<option value="' + row.tenHK + '">' + row.tenHK + '</option>')
								});
							}
						}
						i++;
					});
					$('#LopHocTable_length').css('display', 'inline-block');
					$('#LopHocTable_length').css('padding-left', '15px');


				}

			});



		});
	</script>




<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>