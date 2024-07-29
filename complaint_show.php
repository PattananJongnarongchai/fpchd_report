<?php
include './connection/connection.php';
include './components/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* เฉพาะเวอร์ชันของ Bootstrap 4 */
        .container-xl {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* เพิ่ม CSS เพื่อให้ข้อมูลอยู่กลางตัวอักษรในบรรทัดเดียวกัน */
        .form-control p {
            margin-bottom: 0;
            /* ลบระยะห่างด้านล่างของ <p> */
            line-height: inherit;
            /* ให้ line-height เท่ากับของ input */
        }
    </style>
</head>

<body>
    <?php

    // Check if complaint ID is provided in the URL
    if (isset($_GET['id'])) {
        // Fetch complaint details based on the provided ID
        $id = $_GET['id'];
        $query = "SELECT * FROM qd_documents dc LEFT OUTER JOIN doc_types dt ON dt.id_dt = dc.id_type WHERE dc_results = '' AND dc.id_dc = :id";
        $statement = $conn->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        // Check if data is found
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            // Redirect or show error message if no data found
            header("Location: ./error_page.php");
            exit();
        }
    } else {
        // Redirect or show error message if no complaint ID provided
        header("Location: ./error_page.php");
        exit();
    }
    ?>
    <div class="container " style="max-width: 800px; margin-top:20px;">

        <div class="card shadow shadow-intensity-xl">
            <div class="card-header"><b>ข้อมูลข้อร้องเรียนใหม่</b></div>
            <div class="card-body">
                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label mb-1"><b>ชื่อ</b></label>
                        <p class="form-control" type="text"><?= isset($row['name']) ? $row['name'] : 'ไม่พบข้อมูล' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label mb-1"><b>นามสกุล</b></label>
                        <p class="form-control" type="text"><?= isset($row['lname']) ? $row['lname'] : 'ไม่พบข้อมูล' ?></p>
                    </div>
                </div>

                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label mb-1"><b>เบอร์โทรศัพท์</b></label>
                        <p class="form-control" type="text"><?= isset($row['phone']) ? $row['phone'] : 'ไม่พบข้อมูล' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label mb-1"><b>ชื่อเรื่อง</b></label>
                        <p class="form-control" type="text"><?= isset($row['com_title']) ? $row['com_title'] : 'ไม่พบข้อมูล' ?></p>
                    </div>
                </div>

                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label mb-1"><b>ประเภทของข้อร้องเรียน</b></label>
                        <p class="form-control" type="text"><?= isset($row['type_qd']) ? $row['type_qd'] : 'ไม่พบข้อมูล' ?></p>
                    </div>
                </div>

                <div class="row gx-3 mb-3">
                    <div class="col-md-12">
                        <label class="form-label mb-1"><b>รายละเอียด</b></label>
                        <textarea class="form-control" type="textarea"><?= isset($row['dc_discription']) ? $row['dc_discription'] : 'ไม่พบข้อมูล' ?></textarea>
                    </div>
                </div>

                <div class="row gx-3 mb-3">
                    <div class="col-md-12">
                        <label class="form-label mb-1"><b>เอกสารแนบ</b></label>
                        <div class="">
                            <?php
                            if (!empty($row['document_path'])) {
                                $class1 = "btn-success";
                            } else {
                                $class1 = "btn-secondary disabled";
                            }

                            if (!empty($row['document_path1'])) {
                                $class2 = "btn-success";
                            } else {
                                $class2 = "btn-secondary disabled";
                            }
                            ?>
                            <!-- ปุ่มเอกสารการร้องเรียน -->
                            <a class="btn <?php echo $class1; ?>" href='<?php echo "dis_files/" . $row['document_path']; ?>' target="_blank" data-bs-toggle="tooltip" title="เอกสารการร้องเรียน"><i class="bi bi-file-earmark-text-fill"></i> เอกสารการร้องเรียน</a>
                        </div>
                    </div>
                </div>

                <div class="row gx-3 mb-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <form action="./CRUD/update_status.php" method="post">
                                    <input type="hidden" name="id_dc" value="<?= $row['id_dc'] ?>">
                                    <input type="hidden" name="created_by" value="<?= $_SESSION['admin_login_nm'] ?>">
                                    <input type="hidden" name="document_code" value="<?= $document_code ?>">
                                    <button class="btn btn-success" type="submit" name="action" value="accept">รับข้อร้องเรียน</button>
                                </form>

                                <form action="./CRUD/update_status.php" method="post">
                                    <input type="hidden" name="id_dc" value="<?= $row['id_dc'] ?>">
                                    <input type="hidden" name="created_by" value="<?= $_SESSION['admin_login_nm'] ?>">
                                    <input type="hidden" name="document_code" value="<?= $document_code ?>">
                                    <button class="btn btn-danger" type="submit" name="action" value="reject">ไม่รับข้อร้องเรียน</button>
                                </form>
                            </div>
                            <a href="#" class="btn btn-danger" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> กลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './components/footer.php'; ?>
</body>

</html>