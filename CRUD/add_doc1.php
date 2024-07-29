<?php
// เริ่ม session
session_start();


date_default_timezone_set('asia/bangkok');


?>


<?php
include '../connection/connection.php';

$doc_type = $_POST['type_qd'];



    // เพิ่มข้อมูลทั้งในตาราง doc_types และ doc_receiving
    $sql = "INSERT INTO doc_types (type_qd) VALUES (:type_qd)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type_qd", $doc_type);
    $stmt->execute();

    

$_SESSION["dc_ad"] = "01";
sleep(1.5);
header('Location: ../setting');
?>