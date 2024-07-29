<?php
session_start();
include './connection/connection.php';
$user_id = $_SESSION['user_id'];
date_default_timezone_set('asia/bangkok');
$date = date('Y-m-d');
if ($_SESSION['user_status'] !== 'active') {
    $_SESSION["error"] = "บัญชีของคุณไม่ได้รับอนุญาตให้เข้าสู่ระบบ";
    header("location: index");
    exit();
}
function getLastDocumentCode($conn, $year)
{
    $stmt = $conn->prepare("SELECT MAX(document_code) AS last_code FROM qd_documents WHERE SUBSTRING(document_code, 1, 2) = :year");
    $stmt->bindParam(":year", $year);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['last_code'];
}
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

function DateThai2($strDate2)
{
    $strYear = date("Y", strtotime($strDate2)) + 543;
    $strMonth = date("n", strtotime($strDate2));
    $strDay = date("j", strtotime($strDate2));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

// ปีปัจจุบัน
$year = date('y') + 43;

// ดึงข้อมูลล่าสุดจากฐานข้อมูล
$lastDocumentCode = getLastDocumentCode($conn, $year);

// แยกปีและเลขที่ใช้ไปแล้ว
list($lastYear, $lastCounter) = explode('-', $lastDocumentCode);

// กำหนดค่าเริ่มต้นในกรณีที่ไม่มีข้อมูล
$lastYear = ($lastYear == $year) ? $lastYear : $year;
$lastCounter = (int)$lastCounter;

// เช็คเงื่อนไขเปลี่ยนปี
if ($year != $lastYear) {
    $lastCounter = 0; // ถ้าปีเปลี่ยนให้เริ่ม counter ใหม่
}

// เพิ่มขึ้นทุกรอบ
$lastCounter++;

// สร้างรหัสใหม่
$document_code = $year . '-' . sprintf('%03d', $lastCounter);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPDCH E-Complaint</title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css?v=1">
    <link rel="stylesheet" href="./css/navbar.css?v=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://kit.fontawesome.com/c3bc32620a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
    @media (max-width: 431px) {

        /* ถ้าอยู่ในขนาดจอขนาดเล็ก (sm หรือน้อยกว่า) ให้แสดงโปรไฟล์และปุ่มแจ้งเตือน */
        .profile {
            display: block !important;
        }

        .dropdown.d-lg-flex {
            display: none !important;
        }

        .d-flex .profile1 {
            display: none !important;
        }

        .d-flex .noti1 {
            display: none !important;
        }

        .pic1 {
            display: none !important;
        }
    }

    @media (min-width: 432px) {

        /* ถ้าอยู่ในขนาดจอขนาดใหญ่ขึ้น (md ขึ้นไป) ให้แสดงโปรไฟล์ */
        .profile {
            display: none !important;
        }

        .d-flex .profile1 {
            display: block !important;
        }

        .d-flex .noti {
            display: none !important;
        }

        .collapse .navbar-collapse {
            display: none !important;
        }

        .navbar-toggler {
            display: none !important;
        }
    }

    body {
        overflow-x: hidden;
        /* ปิดการแสดง scrollbar แนวนอน */
    }

    /* สำหรับ Firefox */
    html {
        overflow-x: hidden;
        /* ปิดการแสดง scrollbar แนวตั้ง */
        scrollbar-width: none;
        /* ซ่อน scrollbar ใน Firefox */
    }

    /* สำหรับ Chrome, Safari, และ Edge */
    body::-webkit-scrollbar {
        display: none;
        /* ซ่อน scrollbar ใน Chrome, Safari, และ Edge */
    }
</style>


<body>

    <nav class="navbar navbar-expand-lg shadow shadow-intensity-xl">

        <div class="container-fluid d-flex justify-content-between align-items-center">


            <!-- ปุ่มแจ้งเตือน noti -->
            <div class="dropdown me-3 mt1">
                <button class="noti btn btn-secondary dropdown-toggle-split d-flex align-items-center shadow shadow-intensity-xl" type="button" id="complaintDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount">
                        <?php
                        try {
                            $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_results = '' ";
                            $result = $conn->query($query);
                            $k = $result->fetch(PDO::FETCH_ASSOC);
                            $totalRows = $k['total_rows'];
                            echo "$totalRows";
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        ?>
                    </span>
                </button>

                <ul class="btncomId dropdown-menu " aria-labelledby="complaintDropdown1" id="complaintDropdownContent">
                    <label class="dropdown-header">เรื่องร้องเรียนใหม่</label>
                    <hr class="dropdown-divider">

                    <?php if ($totalRows > 0) : ?>
                        <?php
                        // ดึงข้อมูลข้อร้องเรียนที่มี dc_results เป็นค่าว่าง
                        $query = "SELECT * FROM qd_documents dc LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type WHERE dc_results = '' ";
                        $result = $conn->query($query);

                        if ($result->rowCount() > 0) :
                        ?>
                            <ul>
                                <?php while ($k = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <style>
                                        /* สไตล์เมื่อโฮเวอร์ลิงก์ */
                                        .dropdown-item:hover {
                                            background-color: #f0f0f0;
                                            /* สีพื้นหลังเมื่อโฮเวอร์ */
                                            color: #333;
                                            /* สีข้อความเมื่อโฮเวอร์ */
                                        }
                                    </style>
                                    <li>
                                        <button class="dropdown-item mt-2" type="button" data-bs-toggle="modal" data-bs-target="#basicModal<?= $k['id_dc'] ?>" data-complaint-id="<?= $k['id_dc'] ?>">
                                            <?= $k['name'] ?> <?= $k['lname'] ?> <?= $k['type_qd'] ?>
                                        </button>
                                    </li>

                                <?php endwhile; ?>
                            </ul>
                        <?php else : ?>
                            <li><span class="dropdown-item disabled">ไม่มีข้อร้องเรียน</span></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li><span class="dropdown-item disabled">ไม่มีข้อร้องเรียน</span></li>
                    <?php endif; ?>


                </ul>
            </div>

            <!-- Logo and title -->
            <div class="menu_center text-center">
                <img class="pic1" src="./image/title_logo.png" alt="logo" srcset="" width="60px">
                <b>
                    <a href="home" class="fs-1" style="text-decoration: none; color: white; font-size: 60px;">FPCDH E-complaint</a>
                </b>
            </div>






            <!-- Toggle button for navbar menu -->
            <button class="navbar-toggler ms-2 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>    
            </button>
            <!-- Navbar menu -->
            <div class="collapse navbar-collapse" style="padding-right: 90px;" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                </ul>
                <!-- Profile dropdown -->
                <div class="profile dropdown" style="vertical-align: middle;">
                    <a class="btn dropdown-toggle text-white" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" style="background-color: transparent; border: none;">
                        <?php echo $_SESSION['admin_login_nm']; ?>
                        <?php echo "&nbsp"; ?>
                        <?php echo $_SESSION['admin_login_lnm']; ?>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <?php if ($_SESSION['admin_role'] == 'admin') { ?>
                            <li><a href='manage_user' style='text-decoration: none; color: #000;' class='dropdown-item'><i class="fa-solid fa-user-gear"></i> จัดการผู้ใช้งาน</a></li>
                            <li><a href="setting" style='text-decoration: none; color: #000;' class='dropdown-item'><i class="bi bi-gear-fill"></i> ตั้งค่าระบบ</a></li>
                        <?php } ?>
                        <li><a href="reject" style='text-decoration: none; color: #000;' class='dropdown-item'><i class="fa-solid fa-circle-xmark"></i> รายการที่ยังไม่ได้อนุมัติ</a></li>

                        <li>
                            <hr class='dropdown-divider'>
                        </li>


                        <li>
                            <button class='btn btn-danger margin-end dropdown-item' onclick='logoutWithAlert()'>
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> ออกจากระบบ
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-flex">
                <div class="dropdown me-3 mt1">
                    <button class="noti1 btn btn-secondary dropdown-toggle-split d-flex align-items-center shadow shadow-intensity-xl" type="button" id="complaintDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount1">
                            <?php
                            try {
                                $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_results = '' ";
                                $result = $conn->query($query);
                                $k = $result->fetch(PDO::FETCH_ASSOC);
                                $totalRows = $k['total_rows'];
                                echo "$totalRows";
                            } catch (PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            ?>
                        </span>
                    </button>

                    <ul class="btncomId1 dropdown-menu " aria-labelledby="complaintDropdown1" id="complaintDropdownContent1">
                        <label class="dropdown-header">เรื่องร้องเรียนใหม่</label>
                        <hr class="dropdown-divider">

                        <?php if ($totalRows > 0) : ?>
                            <?php
                            // ดึงข้อมูลข้อร้องเรียนที่มี dc_results เป็นค่าว่าง
                            $query = "SELECT * FROM qd_documents dc LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type WHERE dc_results = '' ";
                            $result = $conn->query($query);

                            if ($result->rowCount() > 0) :
                            ?>
                                <ul>
                                    <?php while ($k = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                                        <style>
                                            /* สไตล์เมื่อโฮเวอร์ลิงก์ */
                                            .dropdown-item:hover {
                                                background-color: #f0f0f0;
                                                /* สีพื้นหลังเมื่อโฮเวอร์ */
                                                color: #333;
                                                /* สีข้อความเมื่อโฮเวอร์ */
                                            }
                                        </style>
                                        <li>
                                            <button class="dropdown-item mt-2" type="button" data-bs-toggle="modal" data-bs-target="#basicModal<?= $k['id_dc'] ?>" data-complaint-id="<?= $k['id_dc'] ?>">
                                                <?= $k['name'] ?> <?= $k['lname'] ?> <?= $k['type_qd'] ?>
                                            </button>
                                        </li>

                                    <?php endwhile; ?>
                                </ul>
                            <?php else : ?>
                                <li><span class="dropdown-item disabled">ไม่มีข้อร้องเรียน</span></li>
                            <?php endif; ?>
                        <?php else : ?>
                            <li><span class="dropdown-item disabled">ไม่มีข้อร้องเรียน</span></li>
                        <?php endif; ?>


                    </ul>
                </div>



                <!-- Profile dropdown -->
                <div class="profile1 dropdown " style="vertical-align: middle; margin-right:50px ;">
                    <a class="btn dropdown-toggle text-white" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" style="background-color: transparent; border: none;">
                        <!-- <img src="./image/blank-profile-picture-973460_960_720.webp" width="40px"> -->
                        <?php echo $_SESSION['admin_login_nm']; ?>
                        <?php echo "&nbsp"; ?>
                        <?php echo $_SESSION['admin_login_lnm']; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu2">
                        <?php if ($_SESSION['admin_role'] == 'admin') { ?>
                            <!-- <li><a href='profile.php?id=<?php echo $_SESSION['user_id']; ?>' style='text-decoration: none; color: #000;' class='dropdown-item'><i class="fa-solid fa-user-gear"></i> โปรไฟล์ผู้ใช้</a></li> -->
                            <li><a href='manage_user' style='text-decoration: none; color: #000;' class='dropdown-item'><i class="fa-solid fa-user-gear"></i> จัดการผู้ใช้งาน</a></li>
                            <li><a href="setting" style='text-decoration: none; color: #000;' class='dropdown-item'><i class="bi bi-gear-fill"></i> ตั้งค่าระบบ</a></li>
                        <?php } ?>
                        <li><a href="reject" style='text-decoration: none; color: #000;' class='dropdown-item'><i class="fa-solid fa-circle-xmark"></i> รายการที่ยังไม่ได้อนุมัติ</a></li>
                        <li>
                            <hr class='dropdown-divider'>
                        </li>


                        <li>
                            <button class='btn btn-danger margin-end dropdown-item' onclick='logoutWithAlert()'>
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> ออกจากระบบ
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>









    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="./js/index.js?v=1"></script>
    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                $('.dropdown-item').click(function() {
                    var complaintId = $(this).data('complaint-id');

                    $.ajax({
                        type: 'GET',
                        url: './CRUD/get_complaints.php?id=' + complaintId,
                        success: function(response) {
                            $('#complaintDetails').html(response);
                            $('#complaintModal').modal('show');
                        }
                    });
                });
            });

            $(document).ready(function() {
                // ฟังก์ชันสำหรับอัปเดตจำนวนข้อร้องเรียนใหม่
                function updateNotificationCount() {
                    $.ajax({
                        url: "./CRUD/get_notification_count.php",
                        method: "GET",
                        success: function(data) {
                            $("#notificationCount1").text(data);
                        }
                    });
                }

                // อัปเดตจำนวนข้อร้องเรียนใหม่เมื่อโหลดหน้าเว็บ
                updateNotificationCount();

                // ตรวจสอบจำนวนข้อร้องเรียนใหม่ทุก 5 วินาที
                setInterval(updateNotificationCount, 5000);

                // ฟังก์ชันสำหรับแสดงรายการข้อร้องเรียนใหม่
                function showNotificationList() {
                    $.ajax({
                        url: "./CRUD/get_complaints.php",
                        method: "GET",
                        success: function(data) {
                            $("#complaintDropdownContent").html(data);
                            $("#complaintDropdownContent1").html(data);

                        }
                    });
                }

                // แสดงรายการข้อร้องเรียนใหม่เมื่อคลิกปุ่ม
                $("#complaintDropdown").click(function() {
                    showNotificationList();
                });
                // แสดงรายการข้อร้องเรียนใหม่เมื่อคลิกปุ่ม
                $("#complaintDropdown1").click(function() {
                    showNotificationList();
                });
            });



            // เมื่อคลิกที่ปุ่มรับหรือปฏิเสธ
            $('.btn-success, .btn-danger').click(function() {
                var id_dc = $(this).closest('.modal').attr('id').replace('basicModal', '');
                var action = $(this).val();
                updateStatus(id_dc, action);
            });

            // เมื่อคลิกที่ปุ่มรับหรือปฏิเสธ
            $('.btn-info').click(function() {
                var id_dc = $(this).closest('.modal').attr('id').replace('basicModal', '');
                var action = $(this).val();
                updateStatus(id_dc, action);
            });

            function updateStatus(id_dc, action) {
                $.ajax({
                    url: './CRUD/update_status.php',
                    type: 'POST',
                    data: {
                        id_dc: id_dc,
                        action: action
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // แสดงข้อความเมื่อดำเนินการเสร็จสิ้น
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function() {
                                // รีโหลดหน้าเพื่อแสดงข้อมูลที่ถูกอัปเดต
                                loadNotifications(btnId);
                            });

                        } else {
                            // แสดงข้อความเมื่อเกิดข้อผิดพลาด
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // สร้าง function เพื่อโหลดข้อมูลเรื่องร้องเรียนเมื่อหน้าเว็บโหลดเสร็จ
            $(document).ready(function() {
                loadComplaintsAndOpenModal();
                setInterval(loadNotifications, 1000); // โหลดจำนวนข้อร้องเรียนใหม่ทุกๆ 1 วินาที
            });


        });
        // สร้าง function เพื่อโหลดข้อมูลเมื่อหน้าเว็บโหลดเสร็จ
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications(btnId);
        });
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                var data = xhr.responseText;
                // Check if the element with ID 'complaintDropdownContent1' exists
                var complaintDropdownContent = document.getElementById('complaintDropdownContent1');
                if (complaintDropdownContent) {
                    // Check if the element has classList property before accessing it
                    if (complaintDropdownContent.classList) {
                        // Proceed with the code that uses classList
                        // Example: complaintDropdownContent.classList.add('some-class');
                    }
                } else {
                    console.log("Element with ID 'complaintDropdownContent1' not found.");
                }
            } else {
                console.log('Request failed. Status: ' + xhr.status);
            }
        };
    </script>
</body>

</html>