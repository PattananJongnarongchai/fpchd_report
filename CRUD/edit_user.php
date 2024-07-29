<?php
session_start();
include "../connection/connection.php";

$id_user = $_POST['id_user'];
$qd_user = $_POST['qd_user'];
$qd_pass = $_POST['qd_pass'];
$qd_name = $_POST['name'];
$qd_lname = $_POST['lname'];
$qd_role = $_POST['role'];
$qd_status = $_POST['us_status'];




// ดึงข้อมูลปัจจุบันจากฐานข้อมูล
$sql_sl = $conn->prepare('SELECT * FROM users WHERE id_user = :id_user');
$sql_sl->bindParam(":id_user", $id_user);
$sql_sl->execute();
$row = $sql_sl->fetch(PDO::FETCH_ASSOC);



// ปรับปรุง SQL UPDATE statement ตรงนี้

    $sql_up = $conn->prepare("UPDATE users SET
   qd_user = :qd_user ,
   qd_pass = :qd_pass ,
   name = :qd_name ,
   lname = :qd_lname ,
   role = :qd_role ,
   us_status = :qd_status
    WHERE id_user = :id_user");


// ... (ตรวจสอบไฟล์ และ อื่น ๆ)

$sql_up->bindParam(":qd_user", $qd_user);
$sql_up->bindParam(":qd_pass", $qd_pass);
$sql_up->bindParam(":qd_name", $qd_name);
$sql_up->bindParam(":qd_lname", $qd_lname);
$sql_up->bindParam(":qd_role", $qd_role);
$sql_up->bindParam(":qd_status", $qd_status);

$sql_up->bindParam(":id_user", $id_user);

// ทำการแสดงข้อความ error หากมีข้อผิดพลาดในการ execute SQL statement
if (!$sql_up->execute()) {
    echo "Error: " . implode(", ", $sql_up->errorInfo());
    exit();
}

// หลังจากปรับปรุงข้อมูล, สามารถทำการ Redirect ไปหน้าที่ต้องการ
$_SESSION["us_ed"] = "01";
sleep(1.5);
header("Location: ../manage_user");
exit();
