<?php
session_start();
include "../connection/connection.php";

$id_dr = $_POST['id_dr'];
$receiving_dc = $_POST['receiving_dc'];

// ดึงข้อมูลปัจจุบันจากฐานข้อมูล
$sql_sl = $conn->prepare('SELECT * FROM doc_receiving WHERE id_dr = :id_dr');
$sql_sl->bindParam(":id_dr", $id_dr);
$sql_sl->execute();
$row = $sql_sl->fetch(PDO::FETCH_ASSOC);

// ปรับปรุง SQL UPDATE statement
$sql_up = $conn->prepare("UPDATE doc_receiving SET receiving_dc = :receiving_dc WHERE id_dr = :id_dr");

// ตรวจสอบการส่งค่า POST และการปรับปรุงข้อมูล
if (isset($id_dr, $receiving_dc)) {
    $sql_up->bindParam(":receiving_dc", $receiving_dc);
    $sql_up->bindParam(":id_dr", $id_dr);

    if ($sql_up->execute()) {
        $_SESSION["dc_ed"] = "01";
        header('Location: ../setting');
        exit();
    } else {
        echo "Error: " . implode(", ", $sql_up->errorInfo());
        exit();
    }
} else {
    echo "Error: id_dr or receiving_dc is empty";
    exit();
}
