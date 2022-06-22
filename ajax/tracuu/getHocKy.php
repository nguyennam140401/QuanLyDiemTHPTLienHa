<?php
session_start();
ob_start();
require './../../template/config.php';

header('Content-Type: application/json');


$response = null;

$hockyQuery = $mysqli->query('SELECT * FROM `hocky`;');
if ($hockyQuery->num_rows > 0) {
	$response = $hockyQuery->fetch_all(MYSQLI_ASSOC);
}

echo json_encode($response);