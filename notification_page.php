<?php
// เชื่อมต่อกับฐานข้อมูล
include './connection/connection.php';
include './components/navbar.php';

// กำหนดจำนวนข้อมูลต่อหน้า
$records_per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// คำนวณ offset ของข้อมูล
$offset = ($current_page - 1) * $records_per_page;

// ดึงข้อมูลข้อร้องเรียนจากฐานข้อมูล
$query = "SELECT * FROM qd_documents WHERE dc_results = '' LIMIT $offset, $records_per_page";
$statement = $conn->query($query);

// คำนวณจำนวนหน้า
$total_query = "SELECT COUNT(*) AS total FROM qd_documents WHERE dc_results = ''";
$total_statement = $conn->query($total_query);
$total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
$total_records = $total_result['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการข้อร้องเรียนทั้งหมด</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding: 20px;
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">รายการข้อร้องเรียนทั้งหมด</h2>
        <a href="home" class="btn btn-primary mb-2">กลับสู่หน้าหลัก</a>

        <div class="row">
            <?php
            if ($statement->rowCount() > 0) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-md-6">
                        <div class="card shadow shadow-intensity-xl">
                            <div class="card-body">
                                <h5 class="card-title">ชื่อ - นามสกุล: <?= $row['name'] ?> <?= $row['lname'] ?></h5>
                                <p class="card-text">เบอร์โทรศัพท์: <?= $row['phone'] ?></p>
                                <p class="card-text">ชื่อเรื่อง: <?= $row['com_title'] ?></p>
                                <p class="card-text">รายละเอียด: <?= $row['dc_discription'] ?></p>
                                <!-- เพิ่มลิงก์ไปยังหน้า complaint_show โดยส่งพารามิเตอร์ id ของข้อร้องเรียน -->
                                <a href="./complaint_show?id=<?= $row['id_dc'] ?>" class="btn btn-primary">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>ไม่มีข้อร้องเรียนใหม่</p>';
            }
            ?>
        </div>

        <!-- Pagination -->
        <div aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- ปุ่ม Previous -->
                <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <!-- วนลูปแสดงหน้า -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <!-- ปุ่ม Next -->
                <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>