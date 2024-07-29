<?php
session_start();
include "../connection/connection.php";

$id_dc = $_POST['id_dc'];
$created_by = $_POST['created_by'];
$newCreatedAt = $_POST['created_at'];
$document_path = $_FILES['document_path'] ?? null;
$document_path1 = $_FILES['document_path1'] ?? null;
$numrand = (mt_rand());
$numrand1 = (mt_rand());
$newStatus = $_POST['dc_status'];
$updated_at =  date("Y-m-d H:i:s");
$newResults = $_POST['dc_results'];
$newTypes = $_POST['id_type'];
$newDiscription = $_POST['dc_discription'];
$newManagement = $_POST['dc_manage'];
$id_receiving = $_POST['id_receiving'];

$name = $_POST['name'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$com_title = $_POST['com_title'];
// echo $newReceiving;
// exit();
// ดึงข้อมูลปัจจุบันจากฐานข้อมูล
$sql_sl = $conn->prepare('SELECT * FROM qd_documents WHERE id_dc = :id_dc');
$sql_sl->bindParam(":id_dc", $id_dc);
$sql_sl->execute();
$row = $sql_sl->fetch(PDO::FETCH_ASSOC);

$old_doc = $row['document_path'];
$old_doc1 = $row['document_path1'];

// ตรวจสอบว่าไฟล์ document_path ถูกส่งมาหรือไม่
if ($document_path && $document_path['error'] == 0) {
    
    $path_link = "../dis_files/" . $old_doc;
    // ลบไฟล์เดิมถ้ามีการอัปโหลดไฟล์ใหม่
    // ตรวจสอบว่าไฟล์เดิมอยู่ในโฟลเดอร์ที่ถูกต้องหรือไม่ก่อนลบ
    if (file_exists($path_link)) {
        unlink($path_link); // ลบไฟล์เดิม
    }


    $path = "../dis_files/";
    $type = strchr($document_path['name'], ".");
    $newnames_pdf =  $numrand . $type;
    $path_copy = $path . $newnames_pdf;
    

    // ตรวจสอบว่าสามารถย้ายไฟล์ได้หรือไม่
    if (!move_uploaded_file($document_path['tmp_name'], $path_copy)) {
        echo "Error: Unable to move uploaded file.";
        
        exit();
    }
    
   

    echo $newnames_pdf;
    if ($type == "") {
        $newnames_pdf = '';
    }
}

// ตรวจสอบว่าไฟล์ document_path1 ถูกส่งมาหรือไม่
if ($document_path1 && $document_path1['error'] == 0) {

    
    $path_link2 = "../manage_files/" . $old_doc1;
    // ลบไฟล์เดิมถ้ามีการอัปโหลดไฟล์ใหม่
    // ตรวจสอบว่าไฟล์เดิมอยู่ในโฟลเดอร์ที่ถูกต้องหรือไม่ก่อนลบ
    if (file_exists($path_link2)) {
        unlink($path_link2); // ลบไฟล์เดิม
        
    }


    $path1 = "../manage_files/";
    $type1 = strchr($document_path1['name'], ".");
    $newnames_pdf1 =  $numrand1 . $type1;
    $path_copy1 = $path1 . $newnames_pdf1;
    

    // ตรวจสอบว่าสามารถย้ายไฟล์ได้หรือไม่
    if (!move_uploaded_file($document_path1['tmp_name'], $path_copy1)) {
        echo "Error: Unable to move uploaded file.";
        // ลบไฟล์เดิมถ้ามีการอัปโหลดไฟล์ใหม่
        // ตรวจสอบว่าไฟล์เดิมอยู่ในโฟลเดอร์ที่ถูกต้องหรือไม่ก่อนลบ
        
        exit();
    }

    
    

    echo $newnames_pdf1;
    if ($type1 == "") {
        $newnames_pdf1 = '';
    }
}


echo $newnames_pdf;

echo $newnames_pdf1;








// ปรับปรุง SQL UPDATE statement ตรงนี้
if (empty($newnames_pdf1) && empty($newnames_pdf)) {
    $sql_up = $conn->prepare("UPDATE qd_documents SET
    created_by = :created_by,
    created_at = :created_at,
    dc_status = :dc_status,
    updated_at = :updated_at,
    dc_results = :dc_results,
    dc_discription = :dc_discription,
    dc_manage = :dc_manage,
    id_type = :id_type,
   id_receiving = :id_receiving,
    name = :name,
    lname = :lname,
    phone = :phone,
    com_title = :com_title
    WHERE id_dc = :id_dc");

    
}

elseif (empty($newnames_pdf1) && !empty($newnames_pdf)) {
    $sql_up = $conn->prepare("UPDATE qd_documents SET
    created_by = :created_by,
    created_at = :created_at,
    dc_status = :dc_status,
    updated_at = :updated_at,
    document_path = :document_path,
    dc_results = :dc_results,
    dc_discription = :dc_discription,
    dc_manage = :dc_manage,
    id_type = :id_type,
   id_receiving = :id_receiving,
    name = :name,
    lname = :lname,
    phone = :phone,
    com_title = :com_title
    WHERE id_dc = :id_dc");

    $sql_up->bindParam(":document_path", $newnames_pdf);
} elseif (!empty($newnames_pdf1) && empty($newnames_pdf)) {
    $sql_up = $conn->prepare("UPDATE qd_documents SET
    created_by = :created_by,
    created_at = :created_at,
    dc_status = :dc_status,
    updated_at = :updated_at,
    document_path1 = :document_path1,
    dc_results = :dc_results,
    dc_discription = :dc_discription,
    dc_manage = :dc_manage,
    id_type = :id_type,
  id_receiving = :id_receiving,
    name = :name,
    lname = :lname,
    phone = :phone,
    com_title = :com_title
    WHERE id_dc = :id_dc");

    $sql_up->bindParam(":document_path1", $newnames_pdf1);
} elseif (!empty($newnames_pdf1) && !empty($newnames_pdf)) {
    $sql_up = $conn->prepare("UPDATE qd_documents SET
    created_by = :created_by,
    created_at = :created_at,
    dc_status = :dc_status,
    updated_at = :updated_at,
    document_path = :document_path,
    document_path1 = :document_path1,
    dc_results = :dc_results,
    dc_discription = :dc_discription,
    dc_manage = :dc_manage,
    id_type = :id_type,
 id_receiving = :id_receiving,
    name = :name,
    lname = :lname,
    phone = :phone,
    com_title = :com_title
    WHERE id_dc = :id_dc");

    // ผูกค่าตัวแปร document_path กับคำสั่ง SQL
    $sql_up->bindParam(":document_path", $newnames_pdf);

    // ผูกค่าตัวแปร document_path1 กับคำสั่ง SQL
    $sql_up->bindParam(":document_path1", $newnames_pdf1);
}


// exit();
// ... (ตรวจสอบไฟล์ และ อื่น ๆ)

$sql_up->bindParam(":created_by", $created_by);
$sql_up->bindParam(":created_at", $newCreatedAt);
$sql_up->bindParam(":dc_status", $newStatus);
$sql_up->bindParam(":updated_at" , $updated_at);
$sql_up->bindParam(":dc_results", $newResults);
$sql_up->bindParam(":dc_discription", $newDiscription);
$sql_up->bindParam(":dc_manage", $newManagement);
$sql_up->bindParam(":id_type", $newTypes);
$sql_up->bindParam(":id_receiving", $id_receiving);
$sql_up->bindParam(":name", $name);
$sql_up->bindParam(":lname", $lname);
$sql_up->bindParam(":phone", $phone);
$sql_up->bindParam(":com_title", $com_title);
$sql_up->bindParam(":id_dc", $id_dc);

echo $id_dc . '<br>';
echo $updated_at;
// exit();
// ทำการแสดงข้อความ error หากมีข้อผิดพลาดในการ execute SQL statement
if (!$sql_up->execute()) {
    echo "Error: " . implode(", ", $sql_up->errorInfo());
    exit();
}

// หลังจากปรับปรุงข้อมูล, สามารถทำการ Redirect ไปหน้าที่ต้องการ
$_SESSION["ar_su"] = "01";
sleep(1.5);
header("Location: ../home");
exit();
