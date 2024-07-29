<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php

// ดึงข้อมูลการเชื่อมต่อฐานข้อมูล
include '../connection/connection.php';

// คำสั่ง SQL สำหรับดึงข้อมูลข้อร้องเรียนใหม่
$query = "SELECT * FROM qd_documents dc LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type WHERE dc_results = '' ";

// เรียกใช้คำสั่ง SQL
$result = $conn->query($query);

// ตรวจสอบว่ามีข้อมูลหรือไม่
// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->rowCount() > 0) {
    // กำหนดตัวแปร count ให้เริ่มต้นที่ 0
    $count = 0;
    // วนลูปแสดงรายการข้อร้องเรียน
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // เพิ่มเงื่อนไขเพื่อให้แสดงเฉพาะรายการข้อร้องเรียน 5 รายการเท่านั้น
        if ($count < 5) { ?>
            <li>
                <a href="./complaint_show?id=<?= $row['id_dc'] ?>" class="dropdown-item mt-2" type="button">
                    <?= $row['name'] ?> <?= $row['lname'] ?> <?= $row['type_qd'] ?>
                </a>
            </li>
        <?php
            // เพิ่มค่า count เมื่อแสดงรายการข้อร้องเรียนไปแล้ว
            $count++;
        } else {
            // หยุดการวนลูปหากเลขรายการข้อร้องเรียนเกิน 5 รายการและเพิ่มปุ่มแสดงรายการทั้งหมด
        ?>
            <hr>
            <li><a href="./notification_page.php" class="dropdown-item" id="showAllComplaintsBtn">แสดงรายการทั้งหมด</a></li>
    <?php
            break;
        }
    }
} else {
    ?>
    <li><span class="dropdown-item disabled">ไม่มีข้อร้องเรียน</span></li>
<?php } ?>