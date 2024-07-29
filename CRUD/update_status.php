<?php
session_start();
include '../connection/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_dc']) && isset($_POST['action'])) {
        $id_dc = $_POST['id_dc'];
        $action = $_POST['action'];
        $created_by = $_POST['created_by'];
        $document_code = $_POST['document_code'];

        // ตรวจสอบ action เป็น 'accept' หรือ 'reject' และอัปเดตสถานะตามที่กำหนด
        if ($action === 'accept') {
            $dc_results = 'รับข้อร้องเรียน';
        } elseif ($action === 'reject') {
            $dc_results = 'ไม่รับข้อร้องเรียน';
        } else {
            // กรณี action ไม่ถูกต้อง
            echo json_encode(['status' => 'error', 'message' => 'การกระทำไม่ถูกต้อง']);
            exit();
        }

        // อัปเดตฐานข้อมูล
        try {
            $query = "UPDATE qd_documents SET dc_results = :dc_results, dc_status = 'รอจัดการ' , created_by = :created_by , document_code = :document_code WHERE id_dc = :id_dc";
            $statement = $conn->prepare($query);
            $statement->bindParam(':dc_results', $dc_results);
            $statement->bindParam(':id_dc', $id_dc);
            $statement->bindParam(':created_by', $created_by);
            $statement->bindParam(':document_code', $document_code);
            echo $dc_results;
            echo $id_dc;
            echo $created_by;
            echo $document_code;
            // exit();
            $statement->execute();

            // ทำการ redirect ไปยังหน้า home
            $_SESSION["cm_acpt"] = "01";
            header("Location: ../home");
            exit();
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดต: ' . $e->getMessage()]);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่มีการส่งข้อมูล']);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'เซิร์ฟเวอร์ไม่รองรับเมธอดนี้']);
    exit();
}
