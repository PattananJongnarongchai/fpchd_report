<?php
// เริ่ม session
session_start();


date_default_timezone_set('asia/bangkok');


?>


<?php
include '../connection/connection.php';

$doc_type = $_POST['type_qd'];
$doc_receiving = $_POST['receiving_dc'];

if (!empty($doc_receiving) && !empty($doc_type)) {
    // เพิ่มข้อมูลทั้งในตาราง doc_types และ doc_receiving
    $sql = "INSERT INTO doc_types (type_qd) VALUES (:type_qd)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type_qd", $doc_type);
    $stmt->execute();

    $sql = "INSERT INTO doc_receiving (receiving_dc) VALUES (:receiving_dc)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":receiving_dc", $doc_receiving);
    $stmt->execute();
} else if (!empty($doc_receiving)) {
    // เพิ่มข้อมูลเฉพาะในตาราง doc_receiving
    $sql = "INSERT INTO doc_receiving (receiving_dc) VALUES (:receiving_dc)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":receiving_dc", $doc_receiving);
    $stmt->execute();
} else if (!empty($doc_type)) {
    // เพิ่มข้อมูลเฉพาะในตาราง doc_types
    $sql = "INSERT INTO doc_types (type_qd) VALUES (:type_qd)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type_qd", $doc_type);
    $stmt->execute();
}

$_SESSION["dc_ad"] = "01";
sleep(1.5);
header('Location: ../setting');
?>