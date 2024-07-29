<?php
session_start();
include "../connection/connection.php";

$id_dt = $_POST['id_dt'];
$type_qd = $_POST['type_qd'];

// ดึงข้อมูลปัจจุบันจากฐานข้อมูล
$sql_sl = $conn->prepare('SELECT * FROM doc_types WHERE id_dt = :id_dt');
$sql_sl->bindParam(":id_dt", $id_dt);
$sql_sl->execute();
$row = $sql_sl->fetch(PDO::FETCH_ASSOC);

// ปรับปรุง SQL UPDATE statement
$sql_up = $conn->prepare("UPDATE doc_types SET type_qd = :type_qd WHERE id_dt = :id_dt");

// ตรวจสอบการส่งค่า POST และการปรับปรุงข้อมูล
if (isset($id_dt, $type_qd)) {
    $sql_up->bindParam(":type_qd", $type_qd);
    $sql_up->bindParam(":id_dt", $id_dt);

    if ($sql_up->execute()) {
        $_SESSION["dc_ed"] = "01";
        header('Location: ../setting');
        exit();
    } else {
        echo "Error: " . implode(", ", $sql_up->errorInfo());
        exit();
    }
} else {
    echo "Error: id_dt or type_qd is empty";
    exit();
}
