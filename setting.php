<?php
// เริ่ม session


include("./components/navbar.php");
date_default_timezone_set('asia/bangkok');
include('./connection/connection.php');
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

    .nav-tabs .nav-link {
        background-color: #fff;
        color: #000;
    }

    /* สีพื้นหลังของแท็บที่เลือก */
    .nav-tabs .nav-link.active {
        background-color: #257060;
        color: #fff;
        /* ปรับสีตัวอักษรให้สว่างขึ้นเมื่อแท็บเลือก */
    }

    /* เมื่อเอาเม้าส์ไปชี้ที่แท็บ */
    .nav-tabs .nav-link:hover {
        background-color: #46a591;
        color: #fff;
        /* ปรับสีตัวอักษรให้สว่างขึ้นเมื่อชี้ที่แท็บ */
    }
</style>


<body>

    <!-- index.php -->

    <div class="mx-2  mb-2">
        <div class="row">
            <div class="col-md-3 border border-2 " style="margin-top: 54px; padding-top :10px; border-radius:5px">
                <ul class="nav nav-tabs flex-column gap-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <li>

                        <a class="nav-link text-center active " aria-disabled="true" id="one-tab" data-bs-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="true">ช่องทางการรับเรื่อง</a>
                    </li>
                    <li>
                        <a class="nav-link  text-center" id="two-tab" data-bs-toggle="tab" href="#two" role="tab" aria-controls="two" aria-selected="false">ประเภทของข้อร้องเรียน</a>

                    </li>
                    <!-- ช่องที่ 3 -->
                    <!-- <li>
                        <a class="nav-link" id="three-tab" data-bs-toggle="tab" href="#three" role="tab" aria-controls="three" aria-selected="false">Three</a>
                    </li> -->

                    <a href="./home" class="btn btn-danger"><i class="fa-solid fa-arrow-left"></i> กลับไปหน้าหลัก</a>

                </ul>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
                        <div class="container">
                            <div class="row">
                                <div class="container-fluid mt-2">
                                    <!-- เนื้อหาของแท็บ One อยู่ที่นี่ -->
                                    <h2>ช่องทางการรับเรื่อง</h2>
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="modal-body">
                                                <div class="row g-3">

                                                    <div class="col-md-8">

                                                        <label for="receiving_dc" class="form-label">เพิ่มช่องทางการรับเรื่อง</label>
                                                        <div class="d-flex gap-2">
                                                            <form id="addDataForm" action="./CRUD/add_doc.php" method="post" enctype="multipart/form-data">
                                                                <div class="col-16">
                                                                    <input type="text" name="receiving_dc" class="form-control" placeholder="เพิ่มช่องทางการรับเรื่อง">
                                                                </div>
                                                            </form>
                                                            <button class="btn btn-success" id="confirmAddData"><i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล</button>
                                                        </div>

                                                    </div>

                                                    <div class="mt-2">

                                                    </div>


                                                    <table class="table table-hover text-center" style="width:100%; text-align:30px;">
                                                        <thead class="table table-success mt-1">
                                                            <th>#</th>
                                                            <th>ช่องทางการรับเรื่อง</th>
                                                            <th>การจัดการ</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $stmt = $conn->prepare('SELECT * From doc_receiving');
                                                            $stmt->execute();
                                                            $result = $stmt->fetchAll();
                                                            foreach ($result as $k) {
                                                                $id = $k['id_dr']; // ใส่ค่า id ของแต่ละ row ที่ต้องการ
                                                                $receiving_dc_value = $k['receiving_dc']; // ใส่ค่า receiving_dc ของแต่ละ row

                                                            ?>
                                                                <tr>
                                                                    <td hidden><?= $k['id_dr'] ?></td>
                                                                    <td class="counterCell"></td>
                                                                    <td><?= $k['receiving_dc'] ?></td>
                                                                    <td style="width: 10%;">
                                                                        <!-- <a href="./edit_doc.php?id=<?= $k['id_dr'] ?>" class='btn btn-warning'>
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </a> -->
                                                                        <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal<?= $k['id_dr']; ?>'>
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </button>
                                                                        <!-- <button class="btn btn-warning" onclick="confirmEdit(<?= $k['id_dr']; ?>, '<?= $k['receiving_dc']; ?>')">
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </button> -->

                                                                        <!-- <button class="btn btn-warning" onclick="confirmEdit(<?= $k['id_dr']; ?>)">
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </button> -->


                                                                        <!-- ปุ่มลบข้อมูล -->
                                                                        <!-- <a href="./CRUD/del_doc.php?id=<?= $k['id_dr'] ?>" class='btn btn-danger'>
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a> -->
                                                                        <button class='btn btn-danger' onclick="confirmDelete(<?= $k['id_dr']; ?>)">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>
                                                                        <!-- <button class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#deldocModal<?= $k['id_dr']; ?>">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button> -->

                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                // อ่านข้อมูลเอกสารจากฐานข้อมูล
                                                                $sql = "SELECT * FROM doc_receiving";
                                                                $result = $conn->query($sql);
                                                                ?>
                                                                <?php include './components/delete_doc.php' ?>
                                                                <?php include './components/update_doc.php' ?>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                        <div class="container">
                            <div class="row">
                                <div class="container-fluid mt-2">
                                    <!-- เนื้อหาของแท็บ Two อยู่ที่นี่ -->
                                    <h2>ประเภทของข้อร้องเรียน</h2>
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="modal-body">
                                                <div class="row g-3">

                                                    <div class="col-md-8">
                                                        <label for="type_qd" class="form-label">เพิ่มประเภทของข้อร้องเรียน</label>
                                                        <div class="d-flex gap-2">
                                                            <form id="addDataForm1" action="./CRUD/add_doc1.php" method="post" enctype="multipart/form-data">
                                                                <div class="col-16">
                                                                    <input type="text" name="type_qd" class="form-control" placeholder="เพิ่มประเภทของข้อร้องเรียน">
                                                                </div>
                                                            </form>
                                                            <button class="btn btn-success" id="confirmAddData1"><i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล</button>

                                                        </div>
                                                    </div>



                                                    <table class="table table-hover text-center" style="width:100%; text-align:30px;">
                                                        <thead class="table table-success mt-1">
                                                            <th>#</th>
                                                            <th>ช่องทางการรับเรื่อง</th>
                                                            <th>การจัดการ</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $stmt = $conn->prepare('SELECT * From doc_types');
                                                            $stmt->execute();
                                                            $result = $stmt->fetchAll();
                                                            foreach ($result as $k) {
                                                                $id1 = $k['id_dt']; // ใส่ค่า id ของแต่ละ row ที่ต้องการ
                                                                $receiving_dc_value1 = $k['type_qd']; // ใส่ค่า receiving_dc ของแต่ละ row

                                                            ?>
                                                                <tr>
                                                                    <td hidden><?= $k['id_dt'] ?></td>
                                                                    <td class="counterCell"></td>
                                                                    <td><?= $k['type_qd'] ?></td>
                                                                    <td style="width: 10%;">
                                                                        <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal1<?= $k['id_dt']; ?>'>
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </button>
                                                                        <!-- <button class="btn btn-warning" onclick="confirmEdit1(<?= $k['id_dt']; ?>, '<?= $k['type_qd']; ?>')">
                                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                                        </button> -->
                                                                        <!-- ปุ่มลบข้อมูล -->
                                                                        <!-- <button class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#deldocModal1<?= $k['id_dt']; ?>">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button> -->
                                                                        <button class='btn btn-danger' onclick="confirmDelete1(<?= $k['id_dt']; ?>)">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>

                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                // อ่านข้อมูลเอกสารจากฐานข้อมูล
                                                                $sql = "SELECT * FROM doc_types";
                                                                $result = $conn->query($sql);
                                                                ?>
                                                                <?php include './components/delete_doc1.php' ?>
                                                                <?php include './components/update_doc1.php' ?>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ช่องที่ 3 -->
                    <!-- <div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
                        <p>three!</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>





    <!-- SweetAlert Library -->


    <script>
        document.getElementById('confirmAddData').addEventListener('click', function() {
            // ทำการแสดง SweetAlert เพื่อยืนยันการเพิ่มข้อมูล
            Swal.fire({
                title: 'ต้องการเพิ่มข้อมูลใช่หรือไม่?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่ใช่'
            }).then((result) => {
                // หากผู้ใช้กด "ใช่" ให้ส่งคำร้องข้อมูลไปยัง add_doc.php
                if (result.isConfirmed) {
                    document.getElementById('addDataForm').submit();
                }
            });
        });
        document.getElementById('confirmAddData1').addEventListener('click', function() {
            // ทำการแสดง SweetAlert เพื่อยืนยันการเพิ่มข้อมูล
            Swal.fire({
                title: 'ต้องการเพิ่มข้อมูลใช่หรือไม่?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่ใช่'
            }).then((result) => {
                // หากผู้ใช้กด "ใช่" ให้ส่งคำร้องข้อมูลไปยัง add_doc.php
                if (result.isConfirmed) {
                    document.getElementById('addDataForm1').submit();
                }
            });
        });

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
                    window.location.href = './CRUD/del_doc.php?id=' + id;
                }
            });
        }
        var receiving_dc_value = document.getElementById(`receiving_dc${id}`).value;

        function confirmDelete1(id) {
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
                    window.location.href = './CRUD/del_doc1.php?id=' + id;
                }
            });
        }

        function confirmEdit(id, receiving_dc_value) {
            Swal.fire({
                title: 'ต้องการแก้ไขข้อมูลใช่หรือไม่?',
                icon: 'info',
                html: `
            <form id="editForm${id}" action="./CRUD/edit_doc.php" method="post">
                <input type="hidden" name="id_dr" value="${id}">
                <div class="form-group">
                    <label for="receiving_dc">แก้ไขข้อมูล:</label>
                    <input type="text" class="form-control" name="receiving_dc" id="receiving_dc${id}" value="${receiving_dc_value}">
                </div>
            </form>
        `,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, แก้ไขข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // หากผู้ใช้กด "ใช่" ให้ submit ฟอร์ม
                    document.getElementById(`editForm${id}`).submit();
                }
            });
        }

        function confirmEdit1(id, receiving_dc_value1) {
            Swal.fire({
                title: 'ต้องการแก้ไขข้อมูลใช่หรือไม่?',
                icon: 'info',
                html: `
            <form id="editForm${id}" action="./CRUD/edit_doc1.php" method="post">
                <input type="hidden" name="id_dt" value="${id}">
                <label>แก้ไขข้อมูล</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="type_qd" id="type_qd${id}" value="${receiving_dc_value1}">
                </div>
            </form>
        `,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, แก้ไขข้อมูล',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // หากผู้ใช้กด "ใช่" ให้ submit ฟอร์ม
                    document.getElementById(`editForm${id}`).submit();
                }
            });
        }
    </script>

    <?php
    if (isset($_SESSION['dc_dl']) && $_SESSION['dc_dl'] == 01) {
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
    unset($_SESSION['dc_dl']);
    ?>
    <?php
    if (isset($_SESSION['dc_ad']) && $_SESSION['dc_ad'] == "01") {
        $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!!";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'สำเร็จ',
                text: 'เพิ่มข้อมูลสำเร็จ!!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        });
        </script>";
    }
    unset($_SESSION['dc_ad']);
    ?>
    <?php
    if (isset($_SESSION['dc_ed']) && $_SESSION['dc_ed'] == "01") {
        $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!!";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'สำเร็จ',
                text: 'แก้ไขข้อมูลสำเร็จ!!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
                
            });
           

        });
        </script>";
    }
    unset($_SESSION['dc_ed']);
    ?>
    <?php include './components/footer.php'; ?>
</body>

</html>