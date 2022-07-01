<?php
$title = 'Phân công giảnng dạy';
require './../template/tpl_header.php';

?>

<?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>


<style>
.toasts-top-right {
    z-index: 1060 !important;
}
</style>
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
                        Danh sách lớp học
                    </h3>
                    <input type="search" placeholder="Nhập tên lớp học" id="search">
                </div>
                <div class="card-body">
                    <table class="table table-striped projects" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Khối</th>
                                <th>Tên lớp</th>
                                <th>Năm học</th>
                                <th>Chủ nhiệm</th>
                            </tr>
                        </thead>
                        <tbody id="LopHocTable"></tbody>
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
            </div>
            <!-- /.card -->
        </div>
</div>
</section>
</div>


<script>
$(document).ready(function() {

    var listData = []
    var totalRecords = 0

    function handleGetListLopHoc() {
        var page = $('#pagination').attr('attr-value')
        const rowsPerPage = $('select#length').val()
        $.ajax({
            url: `/QuanLyDiemTHPT/ajax/quanly/lophoc/getLopHoc.php?length=${rowsPerPage}&draw=${page}&start=${rowsPerPage*(page-1)}&search=${$('input#search').val()}`,
            dataType: "json",
            type: "GET",
            async: true,
            data: {},
            success: function(data) {
                console.log(data)
                listData = data.aaData
                $('span#start').text(rowsPerPage * (page - 1) + 1)
                $('span#end').text(rowsPerPage * page < data.iTotalDisplayRecords ? rowsPerPage *
                    page :
                    data.iTotalDisplayRecords)
                $('span#total').text(data.iTotalDisplayRecords)
                $('#LopHocTable').empty()
                data.aaData.forEach((item, idx) => {
                    $('#LopHocTable').append(
                        `<tr role="row" class="odd"><td>${item.maLop}</td><td>${item.khoilop.tenKhoiLop}</td><td><a href="/QuanLyDiemTHPT/quanly/phanconggiangday.php?maLop=${item.maLop}">${item.tenLop}</a></td><td class="sorting_1">${item.namhoc.namHoc}</td><td>${item.giaovien.tenGV}</td></tr>`
                    )
                })
                totalRecords = data.iTotalDisplayRecords

                $('#pagination').empty();
                for (let i = 1; i < 1 + totalRecords / rowsPerPage; i++) {
                    $('#pagination').append(
                        `<li class="page-item ${i==data.draw?'active':''}"><a class="btn page-link" attr-value="${i}">${i}</a></li>`
                    )
                }
                $('.page-link').click(e => {
                    e.preventDefault();
                    $('#pagination').attr('attr-value', e.target.getAttribute('attr-value'))
                    handleGetListLopHoc()
                })
            },
            error: function(xhr, exception) {
                var msg = "";
                if (xhr.status === 0) {
                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                } else if (xhr.status == 404) {
                    msg = "Requested page not found. [404]" + xhr.responseText;
                } else if (xhr.status == 500) {
                    msg = "Internal Server Error [500]." + xhr.responseText;
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error." + xhr.responseText;
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else {
                    msg = "Error:" + xhr.status + " " + xhr.responseText;
                }
            }
        });
    }
    handleGetListLopHoc()

    $('select#length').change((e) => {
        console.log('count' + e.target.value);
        handleGetListLopHoc()

    })
    $('input#search').keyup(e => {
        if (e.keyCode == '13') {
            handleGetListLopHoc()
        }
    })
});
</script>




<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>