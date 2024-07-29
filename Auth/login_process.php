<?php
session_start();

include "../connection/connection.php";
if (isset($_POST['login'])) {
    date_default_timezone_set('Asia/Bangkok');
    $log_u = date('d-m-Y H:i:s');
    // รับค้า user & pass
    $qd_user = $_POST["qd_user"];
    $qd_pass = $_POST["qd_pass"];
    // echo "$qd_user" . "<br>";
    // echo "$qd_pass" . "<br>";
    // exit();
    
    if (empty($qd_user)) {
        $_SESSION["error"] = "กรุณากรอก username!";
        header("location: ../index");
    } else if (empty($qd_pass)) {
        $_SESSION["error"] = "กรุณากรอก password!";
        header("location: ../index");

    } else {
        try {
            $check_data = $conn->prepare("SELECT * FROM users WHERE qd_user = :qd_user");
            $check_data->bindParam(":qd_user", $qd_user);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($qd_user == $row["qd_user"]) {
                    if ($qd_pass == $row["qd_pass"]) {
                        $sql_log = $conn->prepare("UPDATE users set log_u = :log_u WHERE qd_user = :qd_user");
                        $sql_log->bindParam(":log_u", $log_u);
                        $sql_log->bindParam("qd_user", $qd_user);
                        $sql_log->execute();
                        $_SESSION['admin_login_rp'] = $row['qd_user'];
                        $_SESSION['admin_login_nm'] = $row['name'];
                        $_SESSION['admin_login_lnm'] = $row['lname'];
                        // ในส่วนที่เข้าสู่ระบบสำเร็จ
                        $_SESSION['user_id'] = $row['id_user']; // สมมติว่าไอดีผู้ใช้ถูกเก็บไว้ใน $row['id_user']

                        $_SESSION['admin_role'] = $row['role'];
                        $_SESSION['log_u'] = $row['log_u'];
                        $_SESSION["ar_lo"] = "01";
                        $_SESSION['user_status'] = $row['us_status'];
                        header("location: ../home");

                    } else {
                        $_SESSION["error"] = "username หรือ password ผิด!";
                        header("location: ../index");
                    }

                } else {
                    $_SESSION['error'] = "username หรือ password ผิด!";
                    header("location: ../index");
                }
            } else {
                $_SESSION['error'] = "ไม่มีข้อมูลในระบบ โปรดติดต่อเจ้าหน้าที่!!!";
                header("location: ../index");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
