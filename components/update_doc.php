<!-- Modal แก้ไขข้อมูล -->
<div class="modal fade" id="editModal<?= $k['id_dr']; ?>" tabindex="-1" aria-labelledby="edit_data<?= $k['id_dr']; ?>" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</b>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- ใส่ฟอร์มสำหรับแก้ไขข้อมูลที่นี่ -->
                <form action="./CRUD/edit_doc.php" method="post">
                    <input type="hidden" name="id_dr" value="<?= $k['id_dr']; ?>">
                    <label for="edited_data"><b>แก้ไขข้อมูล</b></label>
                    <input type="text" name="receiving_dc" class="form-control" value="<?= $k['receiving_dc']; ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">บันทึก</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            </div>
            </form>
        </div>
    </div>
</div>