<?php 
session_start();
include('../connection/connection.php');

$qd_user = $_POST['qd_user'];
$qd_pass = $_POST['qd_pass'];
$qd_name = $_POST['name'];
$qd_lname = $_POST['lname'];
$qd_role = $_POST['role'];
$qd_status = $_POST['us_status'];
$sql = "INSERT into users (qd_user , qd_pass , name , lname , role , us_status) VALUE (:qd_user , :qd_pass ,:qd_name , :qd_lname , :qd_role ,:us_status)";


$stmt = $conn->prepare($sql);
$stmt->bindParam(":qd_user" , $qd_user);
$stmt->bindParam(":qd_pass", $qd_pass);
$stmt->bindParam(":qd_name", $qd_name);
$stmt->bindParam(":qd_lname", $qd_lname);
$stmt->bindParam(":qd_role", $qd_role);
$stmt->bindParam(":us_status", $qd_status);

echo $qd_status;



$stmt->execute();
$_SESSION["us_ad"] = "01";

sleep(1.5);
header('Location: ../manage_user')
?>