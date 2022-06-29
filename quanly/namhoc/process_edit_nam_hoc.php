<?php
require '../../template/config.php';
$maNH = $_POST['maNH'];
$namHoc = $_POST['namHoc'];
$mysqli->query("UPDATE `namhoc` SET `namHoc`='$namHoc' WHERE maNH = $maNH");
header("location:namHoc.php");