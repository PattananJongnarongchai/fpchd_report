<?php


include './connection/connection.php'
?>
<!-- Modal เพิ่ม -->


    <div class="modal fade" id="insert_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- ส่วนที่เปลี่ยน -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลหรือไม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <label for="">คุณต้องการเพิ่มใช่หรอไม่</label>
                    <br class="modal-divider">

                    <div class="mt-2 modal-footer">
                        <!-- ให้ href ชี้ไปที่ delete.php และส่ง id_dc เป็นพารามิเตอร์ -->
                        <a href="../CRUD/add_doc.php" type="button" class="btn btn-danger">ยืนยัน</a>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>