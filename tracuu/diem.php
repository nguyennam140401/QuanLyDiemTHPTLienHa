<?php
$title = 'Tra cứu điểm';
require './../template/tpl_header.php';

$maHS = null;
$queryHS = null;
$hsInfo = array();
if (!empty($_GET['maHS'])) {
    $maHS = (int)htmlspecialchars($_GET['maHS']);
    $queryHS = $mysqli->query('SELECT * FROM `hocsinh` LEFT JOIN `dantoc` ON `dantoc`.`maDT` = `hocsinh`.`maHS` LEFT JOIN `dienuutien` ON `dienuutien`.`maDUT` = `hocsinh`.`maDUT` LEFT JOIN `thanhphangiadinh` ON `thanhphangiadinh`.`maTPGD`=`hocsinh`.`maTPGD` WHERE `maHS` = ' . $maHS . ';');
    if ($queryHS->num_rows > 0) {
        $hsInfo = $queryHS->fetch_array(MYSQLI_ASSOC);
    }
}
?>

<?php if (!empty($maHS) && isset($queryHS->num_rows) && $queryHS->num_rows > 0) : ?>


<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
    integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.css"
    integrity="sha512-hzvGZ3Tzqtdzskup1j2g/yc+vOTahFsuXp6X6E7xEel55qInqFQ6RzR+OzUc5SQ9UjdARmEP0g2LDcXA5x6jVQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.5/responsive.bootstrap4.min.css"
    integrity="sha512-Yy2EzOvLO8+Vs9hwepJPuaRWpwWZ/pamfO4lqi6t9gyQ9DhQ1k3cBRa+UERT/dPzIN/RHZAkraw6Azs4pI0jNg=="
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
                <div class="card-body">
                    <table class="table table-striped projects">
                        <tr>
                            <th>Mã học sinh</th>
                            <td><?php echo $hsInfo['maHS']; ?></td>
                        </tr>
                        <tr>
                            <th>Tên học sinh</th>
                            <td><?php echo $hsInfo['tenHS']; ?></td>
                        </tr>
                        <tr>
                            <th>Ngày sinh</th>
                            <td><?php echo $hsInfo['ngaySinh']; ?></td>
                        </tr>
                        <tr>
                            <th>Giới tính</th>
                            <td><?php echo $hsInfo['gioiTinh'] == 0 ? 'Nam' : 'Nữ'; ?></td>
                        </tr>
                        <tr>
                            <th>Nơi sinh</th>
                            <td><?php echo $hsInfo['noiSinh']; ?></td>
                        </tr>
                        <tr>
                            <th>Dân tộc</th>
                            <td><?php echo $hsInfo['tenDT']; ?></td>
                        </tr>
                        <tr>
                            <th>Thành phần gia đình</th>
                            <td><?php echo $hsInfo['tenTPGD']; ?></td>
                        </tr>
                        <tr>
                            <th>Diện ưu tiên</th>
                            <td><?php echo $hsInfo['dienUuTien']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="LopTab" role="tablist">
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="LopTabContent">
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>
<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
    integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
    integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.7/dataTables.responsive.min.js"
    integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js"
    integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Datatable Button -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/dataTables.buttons.min.js"
    integrity="sha512-PvgN2o+U/CTkCfOHqtSjTECpgUSY5kZm+VoMF4LN0M2QL8U9qGMrD+YGtpwyKUvhZ6jWNkk5Ldvtd4nucAtkow=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.0.0/buttons.bootstrap4.min.js"
    integrity="sha512-AijsNe5rDJjziesLO1SWgD0hmRWkETKzOCfEOoqt4l6Rpwfi1JC1WxLDV7eeSniCpRRPup2l+UnruRCA12ChVg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"
    integrity="sha512-xQBQYt9UcgblF6aCMrwU1NkVA7HCXaSN2oq0so80KO+y68M+n64FOcqgav4igHe6D5ObBLIf68DWv+gfBowczg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"
    integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.min.js"
    integrity="sha512-BDZ+kFMtxV2ljEa7OWUu0wuay/PAsJ2yeRsBegaSgdUhqIno33xmD9v3m+a2M3Bdn5xbtJtsJ9sSULmNBjCgYw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.print.min.js"
    integrity="sha512-UthH9WkvNUixebk8yKEFm3Sy+Rm8GbuvxiIMCDs9Cepl+YxhY+LUijPFZshcW7+PHa/HcSFLfSX3fGq1AcglWg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.0.0/js/buttons.html5.min.js"
    integrity="sha512-33SxAOPhjjpLMmMGKqLwH2QNDmdxf038OFOq+fOI8p8ghCiOvfv3Bs2wqoj50USQkWBLpvy7+CzT5AHTZWGoNA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
$(document).ready(function() {
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/tracuu/diem/getLop.php',
        data: {
            maHS: _GET_URL('maHS')
        },
        success: function(data) {
            console.log(data)
            $.each(data, function(indexLop, rowLop) {
                var activeTab = '',
                    activeContent = '',
                    selected = false;
                if (indexLop == 0) {
                    activeTab = ' active';
                    activeContent = ' show active';
                    selected = 'true';
                }
                //THem tab cho cac lop
                $('#LopTab').append('<li class="nav-item"> <a class="nav-link' + activeTab +
                    '" id="tab' + indexLop +
                    '_Lopdata-tab" data-toggle="pill" href="#tab' + indexLop +
                    '_Lopdata" role="tab" aria-controls="tab' + indexLop +
                    '_Lopdata" aria-selected="' + selected + '">' + rowLop.tenLop +
                    ' (' + rowLop.namHoc + ')</a> </li>');
                $('#LopTabContent').append('<div id="tab' + indexLop +
                    '_Lopdata" class="tab-pane cont' + activeContent +
                    '"><div class="row"><div class="col-7 col-md-10"><div class="tab-content" id="HocKy' +
                    indexLop +
                    '-tabContent"></div></div><div class="col-5 col-md-2"><div class="nav flex-column nav-tabs nav-tabs-right h-100" id="HocKy' +
                    indexLop +
                    '-tab" role="tablist" aria-orientation="vertical"></div></div></div></div>'
                );

                $.ajax({
                    url: '/QuanLyDiemTHPT/ajax/tracuu/diem/getHocKy.php',
                    data: {
                        maHS: _GET_URL('maHS'),
                        maLop: rowLop.maLop
                    },
                    success: function(data) {
                        //THem cac tab cho hoc ky
                        $.each(data, function(indexHocKy, rowHocKy) {
                            var activeTab = '',
                                activeContent = '',
                                selected = false;
                            if (indexHocKy == 0) {
                                activeTab = ' active';
                                activeContent = ' show active';
                                selected = 'true';
                            }

                            $('#HocKy' + indexLop + '-tab').append(
                                '<a class="nav-link' + activeTab +
                                '" id="tab' + indexLop + '' +
                                indexHocKy +
                                '_HocKy_tab" data-toggle="pill" href="#tab' +
                                indexLop + '' + indexHocKy +
                                '_HocKy" role="tab" aria-controls="tab' +
                                indexLop + '' + indexHocKy +
                                '_HocKy" aria-selected="' +
                                selected + '">' + rowHocKy.tenHK +
                                '</a>');
                            $('#HocKy' + indexLop + '-tabContent')
                                .append('<div class="tab-pane fade' +
                                    activeContent + '" id="tab' +
                                    indexLop + '' + indexHocKy +
                                    '_HocKy" role="tabpanel" aria-labelledby="tab' +
                                    indexHocKy +
                                    '_HocKy"><table class="table table-bordered table-striped" id="Lop' +
                                    indexLop + '_HocKy' + indexHocKy +
                                    '_Table" width="100%">' + $(
                                        '#HocSinhTemplate').html() +
                                    '</table></div>');
                            fillToTable(indexLop, indexHocKy, _GET_URL(
                                    'maHS'), rowLop.maLop, rowHocKy
                                .maHK);

                        });
                    }
                });

            });
        }
    });



});

function fillToTable(indexLop, indexHocKy, maHS, maLop, maHK) {
    $.ajax({
        url: '/QuanLyDiemTHPT/ajax/tracuu/diem/getDiem.php?maHS=' + maHS + '&maLop=' + maLop + '&maHK=' +
            maHK,
        success: function(data) {
            console.log(data)
            data.aaData.forEach((item, idx) => {
                console.log(item)
                $('#Lop' + indexLop + '_HocKy' + indexHocKy + '_Table tbody').append(
                    `<tr ><td >${item.tenMH}</td>
							<td>${item.diemtx}</td>
							<td>${item.diem15p}</td>
							<td>${item.diem1t}</td>
							<td>${item.diemhk}</td>
							<td>${item.DTBmhk}</td>
							</tr>`)
            })
        }
    });
}

function _GET_URL(value) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    return urlParams.get(value);
}
</script>

<script type="text/template" id="HocSinhTemplate">
    <thead>
		<tr>
			<th>Tên môn học</th>
			<th>Điểm thường xuyên</th>
			<th>Điểm 15 phút</th>
			<th>Điểm 1 tiết</th>
			<th>Điểm thi học kỳ</th>
			<th>Điểm TB</th>
		</tr>
	</thead>
	<tbody></tbody>
</script>
<?php endif; ?>
<?php
require './../template/tpl_footer.php';
?>