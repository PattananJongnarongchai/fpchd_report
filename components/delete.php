<?php


include './connection/connection.php'
?>
<!-- Modal ลบข้อมูล -->
<div class="modal fade" id="delModal<?= $k['id_dc']; ?>" tabindex="-1" aria-labelledby="del_data<?= $k['id_dc']; ?>" aria-hidden="true">
    <!-- ส่วนที่เปลี่ยน -->
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLabel">ลบข้อมูลหรือไม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <label for="">คุณแน่ใจที่จะลบข้อมูลใช่หรอไม่</label>
                
                <br class="modal-divider">
                
                <div class="mt-2 modal-footer">
                    <!-- ให้ href ชี้ไปที่ delete.php และส่ง id_dc เป็นพารามิเตอร์ -->
                    <a href="./CRUD/delete.php?id=<?= $k['id_dc']; ?>" type="button" class="btn btn-danger">ยืนยัน</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
</div>