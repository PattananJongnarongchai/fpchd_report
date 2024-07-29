 <?php


    include './connection/connection.php';
    date_default_timezone_set('asia/bangkok');

    ?>

 <!-- Modal เพิ่มข้อมูล -->
 <div class="modal fade" id="insert_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <!-- ส่วนที่เปลี่ยน -->
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header ">
                 <b class="modal-title fs-4" id="exampleModalLabel">เรื่องร้องเรียน</b>

                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="CRUD/process_form" method="post" enctype="multipart/form-data">
                 <div class="modal-body">
                     <div class="row g-3">
                         <input type="text" name="created_by" value="<?= $_SESSION['admin_login_nm'] ?>" hidden>
                         <input class="form-control" type="date" name="updated_at" id="updated_at" value="<?= $date ?>" hidden>
                         <div class="col-md-6">
                             <label for="num"><b>รหัสเรื่องร้องเรียน</b></label>
                             <input class="form-control" type="text" name="document_code" id="document_code" placeholder="รหัสเรื่องร้องเรียน" value="<?= $document_code; ?>" readonly>
                         </div>
                         <div class="col-6">
                             <label for="datetime"><b>วันที่รับข้อร้องเรียน</b></label>
                             <input class="form-control" type="date" name="created_at" id="created_at" value="<?= $date; ?>">
                         </div>

                         <div class="col-md-6">
                             <label for=""><b>ชื่อ</b></label>
                             <input type="text" class="form-control" name="name" placeholder="ชื่อ">
                         </div>
                         <div class="col-md-6">
                             <label for=""><b>นามสกุล</b></label>
                             <input type="text" class="form-control" name="lname" placeholder="นามสกุล">
                         </div>
                         <div class="col-md-6">
                             <label for=""><b>เบอร์โทรศัพท์</b></label>
                             <input type="text" class="form-control" name="phone" placeholder="เบอร์โทรศัพท์">
                         </div>
                         <div class="col-md-6">
                             <label for=""><b>ผลพิจารณา</b></label>
                             <div class="form-check">
                                 <input class="form-check-input" type="radio" name="dc_results" id="dc_results" value="รับข้อร้องเรียน" checked>
                                 <label class="form-check-label" for="flexRadioDefault1">
                                     รับข้อร้องเรียน
                                 </label>
                             </div>
                             <div class="form-check">
                                 <input class="form-check-input" type="radio" name="dc_results" id="dc_results" value="ไม่รับข้อร้องเรียน">
                                 <label class="form-check-label" for="flexRadioDefault2">
                                     ไม่รับข้อร้องเรียน
                                 </label>
                             </div>
                         </div>

                         <div class="row g-3">
                             <div class="col-md-6">
                                 <label for=""><b>ร้องเรียนเรื่อง</b></label>
                                 <input type="text" class="form-control" name="com_title" placeholder="ร้องเรียนเรื่อง">
                             </div>
                             <div class=" col-6">
                                 <label for="receiving"><b>ช่องทางการรับเรื่อง</b></label>
                                 <select class="form-select js-example-basic-single" id="exampleFormControlSelect1" aria-label="Default select example" name="id_receiving">
                                     <option value="" disabled selected>กรุณาเลือก</option>
                                     <?php
                                        $stmt_dmall = $conn->query("SELECT * from doc_receiving ");
                                        $stmt_dmall->execute();
                                        $rs_dmall = $stmt_dmall->fetchAll();
                                        foreach ($rs_dmall as $dmselected) {

                                            echo '<option value="' . $dmselected['id_dr']  . '" ' . '>' . $dmselected['receiving_dc'] . '</option>';
                                        } ?>
                                 </select>
                             </div>
                             <div class="col-md-6">
                                 <label for=""><b>ประเภท</b></label>
                                 <select class="form-select js-example-basic-single" id="exampleFormControlSelect1" aria-label="Default select example" name="id_type" onchange="toggleInput()">
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




                         <div class="mb-3">
                             <label for="discription"><b>รายละเอียด</b></label>
                             <textarea class="form-control" name="dc_discription" id="dc_discription" cols="5" rows="5"></textarea>
                         </div>
                         <div class="mb-3">
                             <form class="row" action="process_form.php" method="post" enctype="multipart/form-data">
                                 <label for="formFileMultiple" class="form-label"><b>แนบไฟล์</b></label>
                                 <input class="form-control" type="file" name="document_path">
                         </div>
                         <hr>
                         <div class="col-auto">
                             <label><b>สถานะการร้องเรียน</b></label>
                             <div>
                                 <input type="radio" name="dc_status" id="dc_status" value="รอจัดการ" required>
                                 <label for="dc_status">รอการจัดการ</label>
                             </div>
                             <div>
                                 <input type="radio" name="dc_status" id="dc_status" value="อยู่ระหว่างการจัดการ" required>
                                 <label for="dc_status">อยู่ระหว่างการจัดการ (ภายใน 7 วัน) </label>
                             </div>
                             <div>
                                 <input type="radio" name="dc_status" id="dc_status" value="ยุติเรื่อง" required>
                                 <label for="dc_status">ยุติเรื่อง (ภายใน 30 วัน)</label>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for=""><b>การจัดการ</b></label>
                             <textarea class="form-control" name="dc_manage" id="dc_manage" cols="5" rows="5"></textarea>
                         </div>
                         <div class="mb-3">
                             <form class="row" action="process_form.php" method="post" enctype="multipart/form-data">
                                 <label for="formFileMultiple" class="form-label"><b>แนบไฟล์</b></label>
                                 <input class="form-control" type="file" name="document_path1">
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                             <button type="submit" class="btn btn-primary">ส่งเรื่องร้องเรียน</button>
                         </div>
                     </div>
                 </div>
         </div>
     </div>
     </form>
 </div>