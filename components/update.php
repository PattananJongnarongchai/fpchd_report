<?php


include './connection/connection.php'
?>
<!-- Modal แก้ไขข้อมูล -->
<div class='modal fade' id="editModal<?= $k['id_dc'] ?>" tabindex='-1' aria-labelledby="editModalLabel<?= $k['id_dc'] ?>" aria-hidden='true'>
    <form class="row g-3" action="CRUD/edit" method="post" enctype="multipart/form-data"> <!-- เปลี่ยน method เป็น post -->
        <input type="hidden" name="_method" value="put"> <!-- เพิ่ม hidden input field สำหรับ method -->

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="modal-title fs-4" id="exampleModalLabel">แก้ไขเรื่องร้องเรียน
                        <input class="form-control" type="hidden" name="updated_at" id="updated_at" value="<?= $k['updated_at'] ?>">
                        <input type="text" name="created_by" value="<?= $_SESSION['admin_login_nm'] ?>" hidden>
                        <input type="text" name="id_dc" value="<?= $k['id_dc'] ?>" hidden> <!-- เพิ่ม hidden input field สำหรับ ID ของข้อมูลที่จะแก้ไข -->
                    </b>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="num"><b>รหัสเรื่องร้องเรียน</b></label>
                            <input class="form-control" type="text" name="document_code" id="document_code" value="<?= $k['document_code'] ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label for=""><b>วันที่รับเรื่อง</b></label>
                            <input class="form-control" type="date" name="created_at" id="created_at" value="<?= $k['created_at'] ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for=""><b>ชื่อ</b></label>
                            <input type="text" class="form-control" name="name" value="<?= $k['name'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label for=""><b>นามสกุล</b></label>
                            <input type="text" class="form-control" name="lname" value="<?= $k['lname'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label for=""><b>เบอร์โทรศัพท์</b></label>
                            <input type="text" class="form-control" name="phone" value="<?= $k['phone'] ?>">
                        </div>
                        <div class="col-6">
                            <label for=""><b>ผลพิจารณา</b></label>
                            <div class="form-check">
                                <input class="form-check-input1" type="radio" name="dc_results" id="dc_results" value="รับข้อร้องเรียน" <?= ($k['dc_results'] == 'รับข้อร้องเรียน') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    รับข้อร้องเรียน
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input2" type="radio" name="dc_results" id="dc_results" value="ไม่รับข้อร้องเรียน" <?= ($k['dc_results'] == 'ไม่รับข้อร้องเรียน') ? 'checked' : ''; ?> ?>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    ไม่รับข้อร้องเรียน
                                </label>
                            </div>

                        </div>
                        <div class="col-6">
                            <label for="com_title"><b>เรื่องร้องเรียน</b></label>
                            <input type="text" class="form-control" name="com_title" value="<?= $k['com_title'] ?>">

                        </div>
                        <div class="col-6">
                            <label for=""><b>ช่องทางการรับเรื่อง</b></label>
                            <select class="form-select js-example-basic-single" id="exampleFormControlSelect1" aria-label="Default select example" name="id_receiving">
                                <option value disabled selected>กรุณาเลือก</option>
                                <?php
                                $stmt_dmall = $conn->query("SELECT * from doc_receiving ");
                                $stmt_dmall->execute();
                                $rs_dmall = $stmt_dmall->fetchAll();
                                foreach ($rs_dmall as $dmselected) {
                                    $select1 = ($dmselected['id_dr'] == $k['id_receiving']) ? " selected " : "";
                                    echo '<option value="' . $dmselected['id_dr'] . '" ' . $select1 . '>' . $dmselected['receiving_dc'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="types"><b>ประเภท</b></label>
                            <select class="form-select js-example-basic-single" id="exampleFormControlSelect1" aria-label="Default select example" name="id_type">
                                <option value disabled selected>กรุณาเลือก</option>
                                <?php
                                $stmt_dmall = $conn->query("SELECT * from doc_types ");
                                $stmt_dmall->execute();
                                $rs_dmall = $stmt_dmall->fetchAll();
                                foreach ($rs_dmall as $dmselected) {
                                    $select1 = ($dmselected['id_dt'] == $k['id_type']) ? " selected " : "";
                                    echo '<option value="' . $dmselected['id_dt'] . '" ' . $select1 . '>' . $dmselected['type_qd'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="discription"><b>รายละเอียด</b></label>
                            <textarea class="form-control" name="dc_discription" id="dc_discription" cols="5" rows="5"><?= $k['dc_discription'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>แนบไฟล์</b></label>
                            <input class="form-control" type="file" name="document_path" ">
                            </div>
                            <hr>
                            <div class=" col-auto">
                            <label><b>สถานะการร้องเรียน</b></label>
                            <div>
                                <input type="radio" name="dc_status" id="dc_status" value="รอจัดการ" <?= ($k['dc_status'] == 'รอจัดการ') ? 'checked' : ''; ?>>
                                <label for="status">รอการจัดการ</label>
                            </div>
                            <div>
                                <input type="radio" name="dc_status" id="dc_status" value="อยู่ระหว่างการจัดการ" <?= ($k['dc_status'] == 'อยู่ระหว่างการจัดการ') ? 'checked' : ''; ?>>
                                <label for="status">อยู่ระหว่างการจัดการ (ภายใน 7 วัน) </label>
                            </div>
                            <div>
                                <input type="radio" name="dc_status" id="dc_status" value="ยุติเรื่อง" <?= ($k['dc_status'] == 'ยุติเรื่อง') ? 'checked' : ''; ?>>
                                <label for="status">ยุติเรื่อง (ภายใน 30 วัน)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for=""><b>การจัดการ</b></label>
                            <textarea class="form-control" name="dc_manage" id="dc_manage" cols="5" rows="5"><?= $k['dc_manage'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label"><b>แนบไฟล์</b></label>
                            <input class="form-control" type="file" name="document_path1">
                        </div>
                        <div class=" modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary" name="edit">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>