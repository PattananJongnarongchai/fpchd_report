<!DOCTYPE html>
<html lang="en">
<?php include './connection/connection.php';

// ตรวจสอบว่ามีการส่งค่า id_user มาหรือไม่
if (isset($_GET['id'])) {
    // รับค่า id_user จาก URL
    $id_user = $_GET['id'];

    try {
        // เตรียมคำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้จากตาราง users โดยใช้ id_user เป็นเงื่อนไข
        $stmt = $conn->prepare("SELECT * FROM users WHERE id_user = :id_user");
        $stmt->bindParam(":id_user", $id_user);
        $stmt->execute();

        // ดึงข้อมูลผู้ใช้
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลผู้ใช้หรือไม่
        if ($user) {

            // เพิ่มข้อมูลอื่น ๆ ตามต้องการ
        } else {
            echo "ไม่พบข้อมูลผู้ใช้";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ไม่ได้ระบุ ID ของผู้ใช้";
} ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
            background-color: #f2f6fc;
            color: #69707a;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }

        .card-header {
            font-weight: 500;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }

        .form-control {
            border-radius: 0.35rem;
        }
    </style>
</head>
<?php
include './components/navbar.php';
?>

<body>
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- แสดงรูปภาพโปรไฟล์ หรือรูป blank-profile-picture-973460_960_720 หากไม่มี URL หรือ URL ไม่ถูกต้อง -->
                        <img class="img-account-profile rounded-circle mb-2" src="./image/blank-profile-picture-973460_960_720.webp" width="100px" alt="Profile Picture">
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <button class="btn btn-primary" type="button">Upload new image</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form>
                            <div class="row gx-3 mb-3">
                                <div class="col-mb-6">
                                    <label class="small mb-1" for="inputUsername">Username</label>
                                    <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="<?= isset($user['qd_user']) ? $user['qd_user'] : ''; ?>">
                                </div>
                                <div class="col-mb-6">
                                    <label class="small mb-1" for="inputUsername">Password</label>
                                    <input class="form-control" id="inputPassword" type="text" placeholder="Enter your username" value="<?= isset($user['qd_pass']) ? $user['qd_pass'] : ''; ?>">
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="<?= isset($user['name']) ? $user['name'] : ''; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="<?= isset($user['lname']) ? $user['lname'] : ''; ?>">
                                </div>
                            </div>

                            <button class="btn btn-primary" type="button">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './components/footer.php'; ?>
</body>

</html>