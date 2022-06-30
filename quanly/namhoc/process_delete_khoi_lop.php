<?php
require '../../template/config.php';
$id = $_GET['id'];
$query = $mysqli->query("DELETE FROM `khoilop` WHERE maKhoiLop = '$id'");
if ($query) {
    header('location:namhoc.php');
} else {
    header('location:namhoc.php');
}
