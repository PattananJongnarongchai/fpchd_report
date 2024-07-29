<?php 

session_start();
include './connection/connection.php';

$qd_status = $_POST['us_status'];

echo $qd_status;
exit();

?>