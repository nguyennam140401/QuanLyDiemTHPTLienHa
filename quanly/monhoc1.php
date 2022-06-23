<?php
$title = 'Quản lý môn học';
require './../template/tpl_header.php';

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
                    <h3 class="card-title">
                        <i class="far fa-user"></i>
                        Danh sách môn học
                    </h3>
                    <input type="search" placeholder="Nhập tên môn học muốn tìm" id="search">
                    <button type="button" class="btn btn-default btn-sm float-right p-0"
                        onclick="$('#ModalAdd').modal({show: true});"><i class="fas fa-plus-circle"></i> Thêm
                        mới</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" width="100%">
                        <thead class="table-header">
                            <tr>
                                <th>#</th>
                                <th>Tên môn</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="MonHocTable">

                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
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

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
    integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>





<!-- MODAL CHO Edit -->

<div id="ModalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<strong>Chỉnh sửa thông tin </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="EditForm" action="#" method="post">
						<input type="hidden" name="maMH" id="maMH" value="" />
						<div class="form-group">
							<label for="email">Tên môn học</label>
							<input type="text" class="form-control" id="tenMH" name="tenMH" placeholder="Tên môn học" required />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="EditSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>



<!-- TMODAL CHO Add -->

<div id="ModalAdd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<strong>Thêm môn học </strong>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<form id="AddForm" action="#" method="post">
						<div class="form-group">
							<label for="email">Tên môn học</label>
							<input type="text" class="form-control" id="tenMH" name="tenMH" placeholder="Tên môn học" required />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info float-right" id="AddSubmit">Lưu thông tin</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			var listDataTable = $('#MonHocTable').DataTable({
				'processing': true,
				'serverSide': true,
				'serverMethod': 'post',
				'ajax': {
					'url': '/QuanLyDiemTHPTLienHa/ajax/quanly/monhoc/getMonHoc.php'
				},
				pageLength: 10,
				'columns': [{
						data: 'maMH'
					},
					{
						data: 'tenMH'
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

			$('#MonHocTable tbody').on('click', '.editable', function() {
				var data = listDataTable.row($(this).parents('tr')).data();
				if (data) {
					// đổ dữ liệu vào form
					$("#ModalEdit input#maMH").val(data['maMH']);
					$("#ModalEdit input#tenMH").val(data['tenMH']);
					$("#ModalEdit").modal({
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
			$('#MonHocTable tbody').on('click', '.deleteable', function() {
				var data = listDataTable.row($(this).parents('tr')).data();
				if (confirm('Bạn có muốn xoá bản ghi này?')) {
					$.ajax({
						url: '/QuanLyDiemTHPTLienHa/ajax/quanly/monhoc/deleteMonHoc.php',
						type: 'POST',
						data: {
							maMH: data['maMH']
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
			$("#EditForm").submit(function(event) {
				event.preventDefault();
				$("#EditSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/monhoc/editMonHoc.php',
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


			// Submit form thêm
			$("#AddForm").submit(function(event) {
				event.preventDefault();
				$("#AddSubmit").attr("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Lưu thông tin');
				var form = $(this);
				var Data = form.serialize();
				$.ajax({
					url: '/QuanLyDiemTHPTLienHa/ajax/quanly/monhoc/addMonHoc.php',
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
							$("#AddSubmit").attr("disabled", false).html('Lưu thông tin');
						}
					},
					error: function(xhr, status, error) {
						alert(error);
						$("#AddSubmit").attr("disabled", false).html('Lưu thông tin');
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