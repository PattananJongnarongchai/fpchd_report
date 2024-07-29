<?php
// กำหนด HTTP header ให้แสดง HTTP/1.1 404 Not Found
header("HTTP/1.1 404 Not Found");

// กำหนด content type เป็น HTML
header("Content-Type: text/html; charset=UTF-8");

// ส่วนของ HTML ที่แสดงข้อความ error 404
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Internal Server Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #d9534f;
        }
    </style>
</head>

<body>
    <h1>Error 500 - เชื่อมต่อเซิร์ฟเวอร์ล้มเหลว</h1>
    <p>ไม่พบหน้าที่ท่านกำลังค้นหา</p>
    <p>กลับไปยังหน้าหลัก
        <button id="closeTabButton" class="btn-sm btn-primary" style="text-decoration: none;">Back</button>
    </p>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // เมื่อ DOM โหลดเสร็จแล้ว

        // หากคุณใช้ Bootstrap Tooltip
        // $('[data-bs-toggle="tooltip"]').tooltip();

        // เมื่อคลิกที่ปุ่มปิดแท็ป
        document.getElementById("closeTabButton").addEventListener("click", function() {
            // ปิดแท็ป
            window.close();
        });
    });
</script>

</html>