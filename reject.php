<!DOCTYPE html>
<html lang="th">
<?php include "./components/navbar.php";



?>

<body>
    <div class="warpper">
        <?php
        // index.php
        // // ตรวจสอบ Session ว่ามีข้อมูลผู้ใช้หรือไม่
        if (!isset($_SESSION['admin_login_rp'])) {
            // ถ้าไม่มีให้ Redirect ไปที่หน้า Login
            header('Location: index');
            exit;
        }
        // ตรวจสอบข้อมูลผู้ใช้ที่ได้จาก Session
        $username = $_SESSION['admin_login_rp'];

        $user_id = $_SESSION['user_id'];
        // แสดงข้อมูลผู้ใช้
        // เพิ่มลิงค์หรือปุ่ม Logout
        ?>
        <?php
        // ตั้งค่า
        $recordsPerPage = 5;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $recordsPerPage;
        ?>
        <style>
            table {
                counter-reset: tableCount;
            }

            .counterCell:before {
                content: counter(tableCount);
                counter-increment: tableCount;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .col-md-auto {
                flex: 0 0 auto;
                width: auto;
                margin-bottom: 10px;
                /* เพิ่มระยะห่างระหว่างข้อมูล */
            }

            @media only screen and (max-width: 1024px) {
                .col-md-auto {
                    width: 100%;
                }
            }
        </style>
    </div>
    <div class="card border-0">
        <div class="container-fluid">
            <div class="card-body ">
                <div class="container">
                    <div class="row justify-content-between">
                        <!-- Date Filter Section -->
                        <div class="px-4 col-md-6 col-sm-12">
                            <form action="" method="post">
                                <div class="row">
                                    <label class="col-md-auto col-sm-12 mt-2"><b>เริ่มต้น</b></label>
                                    <div class="col-md-auto col-sm-12 mb-2">
                                        <input type="date" name="start_date" data-date-format="dd-mm-Y" class="form-control">
                                    </div>
                                    <label class="col-md-auto col-sm-12 mt-2"><b>ถึง</b></label>
                                    <div class="col-md-auto col-sm-12 mb-2">
                                        <input type="date" name="end_date" data-date-format="dd-mm-Y" value="<?= $date; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-auto col-sm-12">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <div><i class="fa-solid fa-magnifying-glass"></i> ค้นหาข้อมูล</div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container">
                <div class="row pt-3" style="padding-left: 15px;">
                    <div class="col-6 col-sm-3">
                        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <i class="fa-solid fa-globe text-dark"></i>
                                <a id="allButton" class="stretched-link filter-button" data-status="all" style="text-decoration: none; color: #000; cursor: pointer;">จำนวนข้อร้องเรียนทั้งหมด</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php
                                    try {
                                        $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_status != 'ใหม่' AND dc_results = 'รับข้อร้องเรียน'";
                                        $result = $conn->query($query);
                                        $k = $result->fetch(PDO::FETCH_ASSOC);
                                        $totalRows = $k['total_rows'];
                                        echo "$totalRows";
                                    } catch (PDOException $e) {
                                        echo "Connection failed: " . $e->getMessage();
                                    }
                                    ?>
                                    เรื่อง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <i class="fa-solid fa-hourglass-start text-dark"></i>
                                <a id="allButton" class="stretched-link filter-button" data-status="รอจัดการ" style="text-decoration: none; color: #000; cursor: pointer;">เรื่องที่รอจัดการ</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php
                                    try {
                                        $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_status = 'รอจัดการ'AND dc_results = 'รับข้อร้องเรียน'";
                                        $result = $conn->query($query);
                                        $k = $result->fetch(PDO::FETCH_ASSOC);
                                        $totalRows = $k['total_rows'];
                                        echo "$totalRows";
                                    } catch (PDOException $e) {
                                        echo "Connection failed: " . $e->getMessage();
                                    }
                                    ?>
                                    เรื่อง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <i class="fa-solid fa-bars-progress text-dark"></i>
                                <a id="processingButton" class="stretched-link filter-button" data-status="อยู่ระหว่างการจัดการ" style="text-decoration: none; color: #000; cursor: pointer;">เรื่องที่กำลังจัดการ</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php
                                                        try {
                                                            $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_status = 'อยู่ระหว่างการจัดการ'AND dc_results = 'รับข้อร้องเรียน'";
                                                            $result = $conn->query($query);
                                                            $k = $result->fetch(PDO::FETCH_ASSOC);
                                                            $totalRows = $k['total_rows'];
                                                            echo "$totalRows";
                                                        } catch (PDOException $e) {
                                                            echo "Connection failed: " . $e->getMessage();
                                                        }
                                                        ?> เรื่อง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <i class="fa-solid fa-circle-check text-dark"></i>
                                <a id="cancelledButton" class="stretched-link filter-button" data-status="ยุติเรื่อง" style="text-decoration: none; color: #000; cursor: pointer;">เรื่องที่ยุติ</a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> <?php
                                                        try {
                                                            $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_status = 'ยุติเรื่อง'AND dc_results = 'รับข้อร้องเรียน'";
                                                            $result = $conn->query($query);
                                                            $k = $result->fetch(PDO::FETCH_ASSOC);
                                                            $totalRows = $k['total_rows'];
                                                            echo "$totalRows";
                                                        } catch (PDOException $e) {
                                                            echo "Connection failed: " . $e->getMessage();
                                                        }
                                                        ?> เรื่อง</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div> //row -->
        </div>
        <!-- <hr> -->
        <main>
            <div class="row">
                <div class="card border-0">
                    <div class="container" style="overflow-x:auto;">
                        <div class="card-body">
                            <span class="d-flex justify-content-between">
                                <b class="display-6 ">รายการเอกสารร้องเรียนที่ไม่ได้อนุมัติ</b>
                                <!-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#insert_data">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    ส่งเรื่องร้องเรียน
                                </button> -->
                            </span>
                        </div>
                        </span>
                        <!-- ตารางแสดงข้อมูลเอกสารร้องเรียน -->
                        <table id="myTable" class="table table-hover shadow shadow-intensity-xl" style="width:100%; text-align:30px;">
                            <thead class="table table-success mt-1">
                                <tr>
                                    <th>การจัดการ</th>
                                    <th>เรื่องที่</th>
                                    <th>วันที่รับ</th>
                                    <th>ผู้ร้องเรียน</th>
                                    <th>เรื่องร้องเรียน</th>
                                    <th hidden>ผลพิจารณา</th>
                                    <th>ประเภท</th>
                                    <th hidden>สถานะการร้องเรียน</th>
                                    <th>ผู้ตรวจสอบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['start_date']) && $_POST['start_date'] !== '' && isset($_POST['end_date']) && $_POST['end_date'] !== '') {
                                    $start_date = $_POST['start_date'];
                                    $end_date = $_POST['end_date'];
                                    $stmt = $conn->prepare("SELECT * FROM qd_documents dc
                            LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type
                            LEFT OUTER JOIN doc_receiving dr ON dr.id_dr = dc.id_receiving
                            WHERE created_at BETWEEN :start_date AND :end_date
                            ORDER BY YEAR(dc.created_at) DESC, MONTH(dc.created_at) DESC, DAY(dc.created_at) DESC ,updated_at DESC ");

                                    // แปลงค่าวันที่เป็นรูปแบบที่ถูกต้องสำหรับ SQL query
                                    $start_date = date("Y-m-d", strtotime($start_date));
                                    $end_date = date("Y-m-d", strtotime($end_date));

                                    $stmt->bindParam(':start_date', $start_date);
                                    $stmt->bindParam(':end_date', $end_date);
                                } else {
                                    $stmt = $conn->prepare("SELECT * FROM qd_documents dc 
                            LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type
                            LEFT OUTER JOIN doc_receiving dr ON dr.id_dr = dc.id_receiving
                            ORDER BY YEAR(dc.created_at) DESC, MONTH(dc.created_at) DESC, DAY(dc.created_at) DESC , updated_at DESC");
                                }

                                $stmt->execute();
                                $result = $stmt->fetchAll();
                                foreach ($result as $k) {
                                    // $formattedDate = date("d-m-", strtotime($k['created_at'])) . (date("Y", strtotime($k['created_at'])) + 543);
                                    $strDate2 = $k['created_at'];
                                    // ทำสิ่งที่คุณต้องการทำกับ $formattedDate
                                    if ($k['dc_results'] !== 'รับข้อร้องเรียน' && $k['dc_status'] !== 'ใหม่') {
                                ?>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                // เลือกทุกแถวในตาราง
                                                var rows = document.querySelectorAll("tr[data-id]");
                                                // วนลูปผ่านแต่ละแถว
                                                rows.forEach(function(row) {
                                                    // เมื่อคลิกที่แถว
                                                    row.addEventListener("click", function() {
                                                        // ดึงค่า id ของแถว
                                                        var id = this.getAttribute("data-id");
                                                        // สร้าง id ของ modal โดยใช้ id ของแถว
                                                        var modalId = "dataModal" + id;
                                                        // เปิด modal ที่เกี่ยวข้อง
                                                        var modal = new bootstrap.Modal(document.getElementById(modalId));
                                                        modal.show();
                                                    });
                                                });
                                            });
                                        </script>
                                        <tr>
                                            <td style="vertical-align: middle; width: 150px;">
                                                <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#editModal<?= $k['id_dc']; ?>'>
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <!-- ปุ่มลบข้อมูล -->
                                                <!-- <button class='btn btn-sm btn-danger' data-bs-toggle="modal" data-bs-target="#delModal<?= $k['id_dc']; ?>">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button> -->
                                                <button class='btn btn-danger btn-sm' onclick="confirmDelete(<?= $k['id_dc']; ?>)">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                                <a type="button" class='btn btn-sm' style="background-color: gray;" id='buttons' href="javascript:void(0);" onclick="openPdfViewer(<?php echo $k['id_dc']; ?>)"><i class="fa-solid fa-eye"></i></a>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?= $k['document_code'] ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?= DateThai2($strDate2); ?>
                                            </td>
                                            </a>
                                            <td style="vertical-align: middle;">
                                                <?= $k['name']; ?> <?= $k['lname']; ?>
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">

                                                <?= $k['com_title']; ?><br>
                                                <a class="link" data-bs-toggle="modal" data-bs-target="#dataModal<?= $k['id_dc'] ?>" style="cursor: pointer;">
                                                    รายละเอียด
                                                </a>
                                            </td>
                                            <td style="vertical-align: middle;" hidden><?= $k['dc_results']; ?></td>
                                            <td style="vertical-align: middle;"><?= $k['type_qd']; ?></td>
                                            <?php
                                            $createdAt = new DateTime($k['created_at']);
                                            $sevenDaysLater = clone $createdAt;
                                            $sevenDaysLater->add(new DateInterval('P7D'));
                                            $thirtyDaysLater = clone $createdAt;
                                            $thirtyDaysLater->add(new DateInterval('P30D'));
                                            $currentDate = new DateTime();
                                            // แปลงวันที่เป็นรูปแบบ "วัน-เดือน-ปี (d-m-Y)" และปี พ.ศ.
                                            $formattedCreatedAt = $createdAt->format('d-m-') . ($createdAt->format('Y') + 543);
                                            $formattedSevenDaysLater = $sevenDaysLater->format('d-m-') . ($sevenDaysLater->format('Y') + 543);
                                            $formattedThirtyDaysLater = $thirtyDaysLater->format('d-m-') . ($thirtyDaysLater->format('Y') + 543);
                                            $formattedCurrentDate = $currentDate->format('d-m-') . ($currentDate->format('Y') + 543);
                                            if ($k['dc_status'] == 'รอจัดการ') {
                                                $badgeClass = 'bg-warning text-dark';
                                                $statusDuration = 'รอการจัดการ';
                                            } elseif ($k['dc_status'] == 'อยู่ระหว่างการจัดการ') {
                                                $daysDifference = $currentDate->diff($sevenDaysLater)->days;
                                                if ($daysDifference > 0) {
                                                    $badgeClass = 'bg-success';
                                                    $statusDuration = "ภายในวันที่ " . $formattedSevenDaysLater;
                                                } else {
                                                    $badgeClass = 'bg-success';
                                                    $statusDuration = "ถึงวันที่ " . $formattedSevenDaysLater;
                                                }
                                            } elseif ($k['dc_status'] == 'ยุติเรื่อง') {
                                                $daysDifference = $currentDate->diff($thirtyDaysLater)->days;
                                                $badgeClass = 'bg-danger';
                                                $statusDuration = "ภายในวันที่ " . $formattedThirtyDaysLater;
                                            } else {
                                                $badgeClass = ''; // ใส่ค่าที่ต้องการสำหรับสถานะอื่น ๆ
                                                $statusDuration = '';
                                            }
                                            ?>
                                            <style>
                                                .card .bg-danger {
                                                    color: white;
                                                }

                                                .card .bg-success {
                                                    color: white;
                                                }
                                            </style>
                                            <!-- ตรวจสอบการเลือก checkbox และ dropdown -->
                                            <td style=" align-items: center; vertical-align: middle;" hidden>
                                                <span class='card <?= $badgeClass; ?> text-center' data-toggle="tooltip" data-placement="top" title="<?= $statusDuration; ?>">
                                                    <?= $k['dc_status']; ?>
                                                </span>
                                            </td>
                                            <td style="vertical-align: middle;"><?= $k['created_by'] ?></td>
                                            <script>
                                                function openPdfViewer(id_dc) {
                                                    // สร้าง URL ที่ต้องการเปิด
                                                    var pdfViewerUrl = 'pdfviewer?id_dc=' + id_dc;
                                                    // เปิดในแท็บใหม่
                                                    window.open(pdfViewerUrl, '_blank');
                                                }
                                            </script>
                                        </tr>
                                        <?php
                                        // อ่านข้อมูลเอกสารจากฐานข้อมูล
                                        $sql = "SELECT * FROM qd_documents";
                                        $result = $conn->query($sql);
                                        ?>
                                        <?php include './components/datashow.php' ?>
                                        <?php include './components/delete.php' ?>
                                        <?php include './components/update.php' ?>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </main>
        <?php include './components/footer.php' ?>
        <?php include './components/insert.php' ?>
</body>
<script>
    // ตรวจสอบว่าหน้าถูกโหลดเนื่องจากเกิดข้อผิดพลาด 404 หรือไม่
    if (document.title === "404 Not Found") {
        // แสดง alert
        alert("ไม่พบหน้าที่คุณกำลังค้นหา");

        // กลับไปที่หน้า home.php
        window.location.href = "home.php";
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'ต้องการลบข้อมูลใช่หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // หากผู้ใช้กด "ใช่" ให้ redirect ไปยัง URL พร้อม ID ของเอกสารที่ต้องการลบ
                window.location.href = './CRUD/delete.php?id=' + id;
            }
        });
    }
</script>

</div>
<?php
if (isset($_SESSION['ar_ed']) && $_SESSION['ar_ed'] == 01) {
    $_SESSION['success'] = "ลบข้อมูลสำเร็จ!!";
    echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'ลบข้อมูลสำเร็จ!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['ar_ed']);
?>
<?php
if (isset($_SESSION['ar_su']) && $_SESSION['ar_su'] == 01) {
    $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!!";
    echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'แก้ไขข้อมูลสำเร็จ!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['ar_su']);
?>
<?php
$ar_lg = isset($_SESSION['ar_lo']) ? $_SESSION['ar_lo'] : '';
if ($ar_lg === "01") {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'เข้าสู่สำเร็จ',
                text: 'ยินดีต้อนรับ ',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        });
    </script>";
    unset($_SESSION['ar_lo']);
}
?>

<?php
if (isset($_SESSION['us_lgo']) && $_SESSION['us_lgo'] == 01) {
    $_SESSION['success'] = "ออกจากระบบแล้ว!!";
    echo "<script>
            $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'ออกจากระบบแล้ว!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['us_lgo']);
?>

</html>