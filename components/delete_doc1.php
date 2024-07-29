<!-- Modal ลบข้อมูล -->
<div class="modal fade" id="deldocModal1<?= $k['id_dt']; ?>" tabindex="-1" aria-labelledby="del_data<?= $k['id_dt']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ลบข้อมูลหรือไม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="https://static-00.iconduck.com/assets.00/danger-icon-512x512-524hjhyw.png" width="50px" height="50px" alt="">

                <br>
                <label for="">คุณต้องการที่จะลบข้อมูลใช่หรือไม่</label>
                <br class="modal-divider">
                <div class="mt-2 modal-footer">
                    <a href="./CRUD/del_doc1.php?id=<?= $k['id_dt']; ?>" type="button" class="btn btn-danger">ยืนยัน</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
</div>