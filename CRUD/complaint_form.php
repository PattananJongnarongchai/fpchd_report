<?php
include '../connection/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numrand = mt_rand();

    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $id_type = $_POST['id_type'];
    $dc_discription = $_POST['dc_discription'];
    $com_title = $_POST['com_title'];
    $id_receiving = $_POST['id_receiving'];
    $created_at = $_POST['created_at'];
    $dc_status = $_POST['dc_status']; // รับค่า dc_status จากฟอร์ม
    $updatedAt = date("Y-m-d H:i:s"); // กำหนดค่า updated_at เป็นปัจจุบันหากไม่ได้รับค่าจากฟอร์ม

    // ตรวจสอบว่ามีการอัพโหลดไฟล์ document_path หรือไม่
    if (isset($_FILES['document_path']) && $_FILES['document_path']['error'] === UPLOAD_ERR_OK) {
        $upload = $_FILES['document_path'];
        $path = "../dis_files/";
        $type = strchr($_FILES['document_path']['name'], ".");
        $newnames_pdf = $numrand . $type;
        $path_copy = $path . $newnames_pdf;
        $path_link = "../dis_files/" . $newnames_pdf;

        // ย้ายไฟล์ที่อัพโหลดไปยังโฟลเดอร์ปลายทาง
        move_uploaded_file($_FILES['document_path']['tmp_name'], $path_copy);

        // กำหนดค่า $document_path ให้เป็นชื่อของไฟล์ที่อัพโหลด
        $document_path = $newnames_pdf;
    } else {
        // ถ้าไม่มีการอัพโหลดไฟล์ กำหนดให้ $document_path เป็นค่าว่าง
        $document_path = '';
    }

    $sql = "INSERT INTO qd_documents (id_receiving,com_title ,updated_at, name, lname, phone, id_type, dc_discription, document_path, created_at, dc_status) 
            VALUES (:id_receiving,:com_title ,:updatedAt, :name, :lname, :phone, :id_type, :dc_discription, :document_path, :created_at, :dc_status)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":id_type", $id_type);
    $stmt->bindParam(":dc_discription", $dc_discription);
    $stmt->bindParam(":document_path", $document_path); // แก้ไขจาก $newnames_pdf เป็น $document_path
    $stmt->bindParam(":created_at", $created_at);
    $stmt->bindParam(":dc_status", $dc_status);
    $stmt->bindParam(":updatedAt", $updatedAt);
    $stmt->bindParam(":com_title", $com_title);
    $stmt->bindParam(":id_receiving" , $id_receiving);
    $stmt->execute();

    $_SESSION['cm_scc'] = "01";

    // ทำการดึงชื่อของประเภทของข้อร้องเรียน (doc_type) จากตาราง doc_types
    $stmt_doc_type = $conn->prepare("SELECT type_qd FROM doc_types WHERE id_dt = :id_type");
    $stmt_doc_type->bindParam(":id_type", $id_type);
    $stmt_doc_type->execute();
    $doc_type_result = $stmt_doc_type->fetch(PDO::FETCH_ASSOC);

    if ($doc_type_result) {
        $doc_type_name = $doc_type_result['type_qd']; // เก็บชื่อของประเภทของข้อร้องเรียนไว้

        // รับ Token จาก LINE Notify
        $token = 'mi2PTLYvFPNfNGcF4tNvaIGh6ZpB8G0OI5YIl0AJxhs';

        // สร้างข้อความที่ต้องการส่งผ่าน LINE Notify
        $message = 'มีการส่งข้อมูลข้อร้องเรียนมาใหม่' . "\n" .
            'ชื่อ - นามสกุล: ' . $name . ' ' . $lname . "\n" .
            'เบอร์โทรศัพท์: ' . $phone . "\n" .
            'เรื่อง: ' . $com_title . "\n" .
            'ประเภทของข้อร้องเรียน: ' . $doc_type_name . "\n" . // นำชื่อประเภทของข้อร้องเรียนมาแสดง
            'รายละเอียด: ' . $dc_discription;

        // URL สำหรับส่งข้อความผ่าน LINE Notify
        $url = 'https://notify-api.line.me/api/notify';

        // ข้อมูลที่จะส่งไปยัง LINE Notify
        $data = array(
            'message' => $message
        );

        // ตั้งค่า Header สำหรับการส่งข้อมูล
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        );

        // สร้างคำขอ cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // ส่งคำขอและรับข้อมูลการตอบกลับ
        $result = curl_exec($ch);

        // ตรวจสอบการส่งข้อความ
        if ($result === FALSE) {
            echo 'Error: ' . curl_error($ch);
        } else {
            echo 'Notification sent successfully';
        }

        // ปิดการใช้งาน cURL
        curl_close($ch);
    }

    sleep(1.5);
    header('Location: ../complaint');
} else {
    // กรณีไม่ใช่เมธอด POST ให้ทำอย่างอื่นที่นี่
    // เช่น แสดงข้อความผิดพลาด หรือ redirect ไปหน้าอื่น
}
