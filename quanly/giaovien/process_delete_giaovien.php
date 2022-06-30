<?php
require '../../template/config.php';
$maGV = $_GET['id'];
$mysqli->query("DELETE FROM `giaovien` WHERE maGV = $maGV");
header('location:giaovien.php');