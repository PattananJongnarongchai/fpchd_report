<?php

include("./components/navbar.php");
date_default_timezone_set('asia/bangkok');


if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'admin') {
    // ถ้าไม่ใช่ admin, ส่งกลับไปหน้าหลักหรือทำการ redirect ไปที่หน้าที่เหมาะสม
    $_SESSION["ar_wr"] = "01";
    header("location: home");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/index.js?v=5"></script>
</head>

<style>
    table {
        counter-reset: tableCount;
    }

    .counterCell:before {
        content: counter(tableCount);
        counter-increment: tableCount;
    }
</style>

<body>

    <div class="container mt-2">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto mt-2">
                <h2 class="mb-4">รายชื่อผู้ใช้งาน</h2>
            </div>
            <div class="col-auto">
                <a href="./home" class="btn btn-danger"><i class="fa-solid fa-arrow-left"></i> กลับไปหน้าหลัก</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insert_user">
                    <i class="fa-solid fa-plus"></i>
                    เพิ่มผู้ใช้งาน
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="myTable01" class="table table-hover mt-4">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>ตำแหน่ง</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>

                    <?php


                    $stmt = $conn->prepare("SELECT * FROM users ");


                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    foreach ($result as $k) {
                    ?>
                        <tr>
                            <td style="vertical-align: middle; width: 30px;" class="counterCell"></td>
                            <td style="vertical-align: middle; width: 120px;"><?= $k['name'] ?></td>
                            <td style="vertical-align: middle; width: 120px;"><?= $k['lname'] ?></td>
                            <td style="vertical-align: middle; width: 120px;"><?= $k['qd_user'] ?></td>
                            <td style="vertical-align: middle; width: 120px;"><?= $k['qd_pass'] ?></td>
                            <td style="vertical-align: middle; width: 120px;"><?= $k['role'] ?></td>
                            
                            <?php
                            if ($k['us_status'] == 'ใช้งาน') {
                                $badgeClass = 'bg-success';
                            } elseif ($k['us_status'] == 'ไม่ได้ใช้งาน') {
                                $badgeClass = 'bg-danger';
                            } ?>
                            <td style="vertical-align: middle; width: 120px;">
                                <!-- <label class='card <?= $badgeClass; ?> text-white'><?= $k['us_status'] ?></label> -->
                                <center>
                                    <div class="form-check form-switch">

                                        <?php if ($k['us_status'] == 'active') : ?>
                                            <input class="form-check-input" style="width: 40px; background-color :#00bf00" type="checkbox" role="switch" name="us_status[]" checked data-user-id="<?= $k['id_user'] ?>">
                                        <?php else : ?>
                                            <input class="form-check-input switch-inactive" style="width: 40px; " type="checkbox" role="switch" name="us_status[]" data-user-id="<?= $k['id_user'] ?>">
                                        <?php endif; ?>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('.form-check-input').on('change', function() {
                                                var userId = $(this).data('user-id');
                                                var usStatus = this.checked ? 'active' : 'inactive';
                                                var switchElement = $(this); // เก็บอ้างอิง element switch

                                                $.ajax({
                                                    type: 'POST',
                                                    url: './CRUD/process_switch.php',
                                                    data: {
                                                        id_user: userId,
                                                        us_status: usStatus
                                                    },
                                                    success: function(response) {
                                                        console.log(response); // Log the response from the server
                                                        // ถ้าการร้องขอสำเร็จและสถานะเปลี่ยนเป็น 'inactive' เปลี่ยนสี switch เป็นสีแดง
                                                        if (usStatus === 'inactive') {
                                                            switchElement.closest('.form-check').find('.form-check-input').css('background-color', 'transparent');
                                                        } else {
                                                            switchElement.closest('.form-check').find('.form-check-input').css('background-color', '#00bf00');
                                                        }

                                                    },
                                                    error: function(error) {
                                                        console.error('Error:', error);
                                                    }
                                                });
                                            });
                                        });
                                    </script>



                                </center>
                            </td>

                            <td style="vertical-align: middle; width: 120px;">
                                <button class="btn btn-warning" type="button" data-bs-toggle='modal' data-bs-target='#editModal<?= $k['id_user']; ?>'>แก้ไขข้อมูล</button>
                            </td>
                        </tr>
                        <!-- Modal เพิ่มข้อมูล -->
                        <div class="modal fade" id="insert_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <!-- ส่วนที่เปลี่ยน -->
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <b class="modal-title fs-4" id="exampleModalLabel">เพิ่มผู้ใช้งาน</b>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="CRUD/add_user" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label for=""><b>ชื่อ</b></label>
                                                    <input type="text" name="name" class="form-control" placeholder="กรุณากรอกชื่อจริง">

                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>นามสกุล</b></label>
                                                    <input type="text" name="lname" class="form-control" placeholder="กรุณากรอกนามสกุล">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>Username</b></label>
                                                    <input type="text" name="qd_user" class="form-control" placeholder="กรุณากรอกชื่อผู้ใช้">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>Password</b></label>
                                                    <input type="text" name="qd_pass" class="form-control" placeholder="กรุณากรอกรหัสผ่าน">
                                                </div>
                                                <div class="col-md-6" hidden>
                                                    <label for=""><b>ระดับผู้ใช้งาน</b></label>
                                                    <input type="text" name="role" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" value="user">
                                                </div>
                                                <div class="col-md-6" hidden>
                                                    <label for=""><b>สถานะผู้ใช้งาน</b></label>
                                                    <input type="text" name="us_status" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" value="active" readonly>
                                                </div>
                                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>



                        <!-- Modal แก้ไขข้อมูล -->
                        <div class="modal fade" id="editModal<?= $k['id_user'] ?>" tabindex='-1' aria-labelledby="editModalLabel<?= $k['id_user'] ?>" aria-hidden='true'>
                            <!-- ส่วนที่เปลี่ยน -->
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <b class="modal-title fs-4" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้งาน</b>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="CRUD/edit_user" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <input type="hidden" name="id_user" value="<?= $k['id_user'] ?>">
                                                <div class="col-md-6">
                                                    <label for=""><b>ชื่อ</b></label>
                                                    <input type="text" name="name" class="form-control" placeholder="กรุณากรอกชื่อจริง" value="<?= $k['name'] ?>">

                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>นามสกุล</b></label>
                                                    <input type="text" name="lname" class="form-control" placeholder="กรุณากรอกนามสกุล" value="<?= $k['lname'] ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>Username</b></label>
                                                    <input type="text" name="qd_user" class="form-control" placeholder="กรุณากรอกชื่อผู้ใช้" value="<?= $k['qd_user'] ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for=""><b>Password</b></label>
                                                    <input type="text" name="qd_pass" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" value="<?= $k['qd_pass'] ?>">
                                                </div>

                                                <div class="col-md-6" hidden>
                                                    <label for=""><b>ระดับผู้ใช้งาน</b></label>
                                                    <input type="text" name="role" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" value="<?= $k['role'] ?>">
                                                </div>
                                                <div class="col-md-6" hidden>
                                                    <label for=""><b>สถานะ</b></label>
                                                    <input type="text" name="us_status" class="form-control" placeholder="กรุณากรอกรหัสผ่าน" value="<?= $k['us_status'] ?>">
                                                </div>
                                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- JavaScript -->

        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
                $("#myTable01").DataTable({
                    dom: 'Qlfrtip',
                    searchBuilder: {
                        depthLimit: 2
                    },
                    buttons: [{
                            extend: 'csv',
                            split: ['pdf', 'excel'],
                        }

                    ],

                    pagingType: "full_numbers", // ให้ใช้ Bootstrap 5 Pagination
                    lengthMenu: [
                        [10, -1],
                        [10, "All"],
                    ],

                    language: {
                        lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                        zeroRecords: "ไม่พบรายการคำร้องเรียน",
                        info: "แสดงหน้า _PAGE_ จาก _PAGES_",
                        infoEmpty: "ไม่มีรายการที่แสดง",
                        infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                        paginate: {
                            first: "<i class='bi bi-skip-backward-fill'></i>",
                            last: "<i class='bi bi-skip-forward-fill'></i>",
                            next: "<i class='bi bi-caret-right-fill'></i>",
                            previous: "<i class='bi bi-caret-left-fill'></i>",
                        },
                        search: "คำค้นหา:",
                    },
                })
            });
        </script>
        <?php include('./components/footer.php') ?>
</body>

<?php
if (isset($_SESSION['us_ad']) && $_SESSION['us_ad'] == 01) {
    $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!!";
    echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'เพิ่มผู้ใช้สำเร็จ!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['us_ad']);
?>
<?php
if (isset($_SESSION['us_ed']) && $_SESSION['us_ed'] == 01) {
    $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!!";
    echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'แก้ไขผู้ใช้สำเร็จ!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['us_ed']);
?>


</html>