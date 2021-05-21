<?php
include 'Create.php';
$a = $_POST['db'];
$create = new Create();
$db = $create->createDb($a);
echo json_encode($db);
?>