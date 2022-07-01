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