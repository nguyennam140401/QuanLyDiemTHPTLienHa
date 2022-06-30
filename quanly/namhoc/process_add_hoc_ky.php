<?php
require '../../template/config.php';
$tenHK = $_POST['tenHK'];
$mysqli->query("INSERT INTO `hocky`(`tenHK`) VALUES ('$tenHK')");
header('location:namhoc.php');