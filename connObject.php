<?php
include 'Connect.php';
$a = $_GET['db'];
$con = new Connect();
$c = $con->getData($a);
echo json_encode($c);
?>