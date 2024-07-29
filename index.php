<?php
include './connection/connection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPCDH E-complaint</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/index.css?v=9">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <!-- Font -->
    <script src="https://kit.fontawesome.com/c3bc32620a.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

</head>

<body class="body">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div style="width: 500px;">
                <div class="card shadow-lg p-3 mb-5  ">
                    <div class="card-header ">
                        <img class="img-fluid" src="./image/title_logo.png">
                        <b>
                            <h4 class="mt-3">เข้าสู่ระบบเพื่อใช้งานเว็บไซต์</h4>
                        </b>
                        <b>
                            <h5>โรงพยาบาลพิชัยดาบหัก</h5>
                        </b>
                    </div>
                    <div class="card-body">
                        <form action="./Auth/login_process" method="post">
                            <?php if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_SESSION['error'];
                                    unset($_SESSION['error']); ?>
                                </div>
                            <?php } ?>
                            <label for="username" class="form-label"><b>Username</b></label>
                            <div class="mb-3 input-group flex-nowrap ">
                                <span class="form-group input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control bold" id="qd_user" name="qd_user" placeholder="username" required autocomplete="off">
                            </div>
                            <label for="password"><b>Password</b></label>
                            <div class="input-group mb-3 flex-nowarp">
                                <span class="form-group input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                <input name="qd_pass" type="password" class="form-control bold" id="password" placeholder="password" />
                                <span class="form-group input-group-text" onclick="password_show_hide();">
                                    <i class="fas fa-eye" id="show_eye"></i>
                                    <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                </span>

                            </div>
                    </div>


                    <input type="submit" name="login" class="btn btn-primary" value="Login">

                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include './components/footer.php' ?>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        //       document.addEventListener("DOMContentLoaded", function () {
        //     const togglePassword = document.querySelector("#togglePassword");
        //     const password = document.querySelector("#qd_pass");

        //     togglePassword.addEventListener("click", function () {
        //         // toggle the type attribute
        //         const type = password.getAttribute("type") === "password" ? "text" : "password";
        //         password.setAttribute("type", type);

        //         // toggle the icon
        //         this.classList.toggle("bi-eye");
        //     });

        //     // prevent form submit
        //     const form = document.querySelector("form");
        //     form.addEventListener('submit', function (e) {
        //         e.preventDefault();
        //     });
        // });
        function password_show_hide() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
        // ตรวจสอบว่ามีการออกจากระบบสำเร็จหรือไม่
        <?php
        if (isset($_SESSION["logout_success"]) && $_SESSION["logout_success"] === true) {
            echo 'Swal.fire({
            title: "ออกจากระบบสำเร็จ",
            text: "คุณได้ออกจากระบบเรียบร้อยแล้ว",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });';
            // หลังจากแสดง SweetAlert ให้ทำการลบ Session logout_success เพื่อไม่ให้แสดงซ้ำ
            unset($_SESSION["logout_success"]);
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
    </script>
    <?php
    $ar_lg = isset($_SESSION['ar_lg']) ? $_SESSION['ar_lg'] : '';
    if ($ar_lg === "01") {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Logout สำเร็จ',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        </script>";
        unset($_SESSION['ar_lg']);
    }
    ?>
    <!-- <script>
        const togglePassword = document
            .querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script> -->
    <?php
    if (isset($_SESSION['ar_wr']) && $_SESSION['ar_wr'] == 01) {
        $_SESSION['success'] = "ท่านไม่สามารถเข้าใช้หน้านี้ได้!!";
        echo "<script>
    $(document).ready(function() {
        Swal.fire({
            title: 'ระวัง',
            text: 'ท่านไม่สามารถเข้าใช้หน้านี้ได้!!',
            icon: 'warning',
            timer: 1500,
            showConfirmButton: false
        });
    })
    </script>";
    }
    unset($_SESSION['ar_wr']);
    ?>
</body>

</html>