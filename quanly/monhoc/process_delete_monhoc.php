<?php
session_start();
require '../../template/config.php';
$id = $_GET['id'];
$query = $mysqli->query("DELETE FROM `monhoc` WHERE maMH = '$id'");
if ($query) {
    $_SESSION['delete_monhoc_success'] = 'Xóa thành công môn học !';
    header('location:monhoc.php');
} else {
    $_SESSION['delete_monhoc_error'] = 'Môn học này đã có lớp, không thể xóa !';
    header('location:monhoc.php');
}
