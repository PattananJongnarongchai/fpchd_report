<?php
include './connection/connection.php';
date_default_timezone_set('asia/bangkok');


?>


<?php
session_start();


date_default_timezone_set('asia/bangkok');
$date = date('Y-m-d');
$date1 = date('m-d-Y:H:m:s');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อร้องเรียน</title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css?v=1">
    <link rel="stylesheet" href="./css/navbar.css?v=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Data Tables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://kit.fontawesome.com/c3bc32620a.js" crossorigin="anonymous"></script>
</head>





</head>



<body class="">
    <center>
        <nav class="shadow shadow-intensity-xl">
            <div class="mb-2">
                <img class="pic1 mb-2" src="./image/title_logo.png" alt="logo" srcset="" width="60px">
                <b>
                    <label class="fs-1 mt-2" style="text-decoration: none; color: white; font-size: 60px;">FPCDH E-complaint</label>
                </b>
            </div>
        </nav>
    </center>



    <div class="container " style="max-width: 800px; margin-top:20px;">
        <div class="card shadow shadow-intensity-xl">
            <div class="card-header"><b class="fs-2">แจ้งเรื่องร้องเรียน</b></div>
            <div class="card-body">
                <form action="./CRUD/complaint_form.php" method="post" enctype="multipart/form-data">
                    <div class="hidden">

                        <div class="col-6" hidden>
                            <label for="datetime"><b>วันที่รับข้อร้องเรียน</b></label>
                            <input class="form-control" type="date" name="created_at" id="created_at" value="<?= $date; ?>">
                        </div>
                        <div class="col-6" hidden>
                            <label for="datetime"><b>สถานะ</b></label>
                            <input class="form-control" type="text" name="dc_status" value="ใหม่" readonly hidden>

                        </div>
                        <div class="col-6" hidden>
                            <label for="datetime"><b>ช่องทางการรับเรื่อง</b></label>
                            <input class="form-control" type="text" name="id_receiving" value="9" readonly hidden>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="firstName" class="form-label"><b>ชื่อ</b></label>
                            <input type="text" class="form-control" name="name" placeholder="ชื่อ" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="lastName" class="form-label"><b>นามสกุล</b></label>
                            <input type="text" class="form-control" name="lname" placeholder="นามสกุล" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phoneNumber" class="form-label"><b>เบอร์โทรศัพท์</b></label>
                            <input type="text" class="form-control" name="phone" placeholder="เบอร์โทรศัพท์" required>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phoneNumber" class="form-label"><b>ร้องเรียนเรื่อง</b></label>
                            <input type="text" class="form-control" name="com_title" placeholder="ร้องเรียนเรื่อง" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phoneNumber" class="form-label"><b>ประเภทของเรื่องร้องเรียน</b></label>
                            <select class="form-select js-example-basic-single" id="exampleFormControlSelect1" aria-label="Default select example" name="id_type" onchange="toggleInput()" required>
                                <option value="" disabled selected>กรุณาเลือก</option>
                                <?php
                                $stmt_dmall = $conn->query("SELECT * from doc_types ");
                                $stmt_dmall->execute();
                                $rs_dmall = $stmt_dmall->fetchAll();

                                foreach ($rs_dmall as $dmselected) {

                                    echo '<option value="' . $dmselected['id_dt'] . '" ' . '>' . $dmselected['type_qd'] . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for=""><b>รายละเอียด</b></label>
                            <textarea name="dc_discription" cols="30" rows="10" placeholder="รายละเอียด" class="form-control"></textarea required>
                        </div>
                        <div class="col-md-6 mb-3">

                            <label for="formFileMultiple" class="form-label"><b>แนบไฟล์</b></label>
                            <input class="form-control" type="file" name="document_path">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">ส่งเรื่องร้องเรียน</button>
                </form>

            </div>
        </div>
    </div>

    <?php include "./components/footer.php"; ?>

<?php
if (isset($_SESSION['cm_scc']) && $_SESSION['cm_scc'] == 01) {
    $_SESSION['success'] = "ส่งเรื่องสำเร็จ!!";
    echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'สำเร็จ',
            text: 'ส่งเรื่องสำเร็จ!!',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
}
unset($_SESSION['cm_scc']);
?>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</html>