<?php
session_start();
include '../connection/connection.php';

// Retrieve form data with default values or handle the absence of values
$documentCode = $_POST["document_code"];
$createdAt = $_POST["created_at"] ?? date("d-m-Y H:i:s");
$numrand = (mt_rand());
$numrand1 = (mt_rand());
$name = $_POST['name'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$com_title = $_POST['com_title'];
$createdBy = $_POST["created_by"];
$document_path = ['document_path']; // Update this with your file handling logic
$dc_status = $_POST["dc_status"];
$updatedAt = $_POST['updated_at'] ?? date("d-m-Y H:i:s");

// Add these lines to retrieve other form values with default values or handle the absence of values
$dc_result = $_POST["dc_results"] ?? null;
$id_type = $_POST["id_type"] ?? null;
$document_path1 = ['document_path1']; // Update with a default value or handle accordingly
$dc_discription = $_POST["dc_discription"] ?? null;
$dc_manage = $_POST["dc_manage"] ?? null;
$id_receiving = $_POST["id_receiving"] ?? "default_receiving"; // Update with a default value or handle accordingly

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $upload = $_FILES['document_path'];
    $path = "../dis_files/";
    $type = strchr($_FILES['document_path']['name'], ".");
    $newnames_pdf = $numrand . $type;
    $path_copy = $path . $newnames_pdf;
    $path_link = "../dis_files/" . $newnames_pdf;
    move_uploaded_file($_FILES['document_path']['tmp_name'], $path_copy);

    // echo $newnames_pdf;
    // exit();
    if ($type == "") {
        $newnames_pdf = '';
    }

    $upload1 = $_FILES['document_path1'];
    $path1 = "../manage_files/";
    $type1 = strchr($_FILES['document_path1']['name'], ".");
    $newnames_pdf1 = $numrand1 . $type1;
    $path_copy1 = $path1 . $newnames_pdf1;
    $path_link1 = "../manage_files/" . $newnames_pdf1;
    move_uploaded_file($_FILES['document_path1']['tmp_name'], $path_copy1);

// echo $newnames_pdf;
    // exit();
    if ($type1 == "") {
        $newnames_pdf1 = '';
    }

    echo $documentCode . "<br>";
    echo $createdAt . "<br>";
    echo $createdBy . "<br>";
    echo $newnames_pdf . "<br>";
    echo $dc_status . "<br>";
    echo $updatedAt . "<br>";
    echo $dc_result . "<br>";
    echo $id_type . "<br>";
    echo $newnames_pdf1 . "<br>";
    echo $dc_discription . "<br>";
    echo $dc_manage . "<br>";
    echo $id_receiving . "<br>";

    // Insert data into the database

    $sql = "INSERT INTO qd_documents (com_title,name , lname , phone ,document_code, created_at, created_by, document_path, dc_status, updated_at, dc_results, document_path1, dc_discription, dc_manage, id_type, id_receiving)
VALUES (:com_title,:name , :lname , :phone ,:documentCode, :createdAt, :createdBy, :document_path, :dc_status, :updatedAt, :dc_result, :document_path1, :dc_discription, :dc_manage, :id_type, :id_receiving)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":documentCode", $documentCode);
    $stmt->bindParam(":com_title", $com_title);
    $stmt->bindParam(":createdAt", $createdAt);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":createdBy", $createdBy);
    $stmt->bindParam(":document_path", $newnames_pdf);
    $stmt->bindParam(":dc_status", $dc_status);
    $stmt->bindParam(":updatedAt", $updatedAt); // <-- ตำแหน่งนี้ไม่มีในคำสั่ง SQL
    $stmt->bindParam(":dc_result", $dc_result);
    $stmt->bindParam(":id_type", $id_type);
    $stmt->bindParam(":document_path1", $newnames_pdf1);
    $stmt->bindParam(":dc_discription", $dc_discription);
    $stmt->bindParam(":dc_manage", $dc_manage);
    $stmt->bindParam(":id_receiving", $id_receiving);

    $stmt->execute();
    $_SESSION["ar_su"] = "01";

    sleep(1.5);
    header('Location: ../home');
}
