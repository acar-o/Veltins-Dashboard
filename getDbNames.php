<?php
include 'Create.php';
$con = new Create();
$c = $con->showDB();
echo json_encode($c);
?>