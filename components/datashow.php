<?php include "./connection/connection.php"; ?>

<!-- Modal -->
<div class="modal fade" id="dataModal<?= $k['id_dc'] ?>" tabindex="-1" aria-labelledby="dataModalLabel<?= $k['id_dc'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel<?= $k['id_dc'] ?>">ข้อมูลข้อร้องเรียน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="fullName">ชื่อ-นามสกุล:</label>
                    <input type="text" class="form-control" id="fullName" value="<?= $k['name'] ?> <?= $k['lname'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">เบอร์โทรศัพท์:</label>
                    <input type="text" class="form-control" id="phone" value="<?= $k['phone'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="complaintType">เรื่องร้องเรียน:</label>
                    <textarea class="form-control" id="complaintType"  readonly><?= $k['com_title'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="complaintType">ประเภทของข้อร้องเรียน:</label>
                    <input type="text" class="form-control" id="complaintType" value="<?= $k['type_qd'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="complaintDescription">รายละเอียด:</label>
                    <textarea class="form-control" id="complaintDescription" readonly><?= $k['dc_discription'] ?></textarea>
                </div>

                <?php
                // ตรวจสอบว่ามีข้อมูลใน document_path หรือไม่
                if (!empty($k['document_path'])) {
                    // ถ้ามีข้อมูล กำหนดคลาสเป็น success
                    $class1 = "btn-success";
                } else {
                    // ถ้าไม่มีข้อมูล ให้ใช้คลาสเดิม และเพิ่มคำสั่ง disabled
                    $class1 = "btn-secondary disabled";
                }

                // ตรวจสอบว่ามีข้อมูลใน document_path1 หรือไม่
                if (!empty($k['document_path1'])) {
                    // ถ้ามีข้อมูล กำหนดคลาสเป็น success
                    $class2 = "btn-success";
                } else {
                    // ถ้าไม่มีข้อมูล ให้ใช้คลาสเดิม และเพิ่มคำสั่ง disabled
                    $class2 = "btn-secondary disabled";
                }
                ?>
                <!-- ปุ่มเอกสารการร้องเรียน -->
                <a class="btn <?php echo $class1; ?> mt-2" href='<?php echo "dis_files/" . $k['document_path']; ?>' target="_blank" data-bs-toggle="tooltip" title="เอกสารการร้องเรียน"><i class="bi bi-file-earmark-text-fill"></i> เอกสารการร้องเรียน</a>

                <!-- ปุ่มเอกสารการจัดการ -->
                <a class="btn <?php echo $class2; ?> mt-2" href='<?php echo "manage_files/" . $k['document_path1']; ?>' target="_blank" data-bs-toggle="tooltip" title="เอกสารการจัดการ"><i class="bi bi-file-earmark-text-fill"></i> เอกสารการจัดการ</a>


                <input type="text" name="created_by" value="<?= $_SESSION['admin_login_nm'] ?>" hidden>
            </div>


        </div>
    </div>
</div>
</div>