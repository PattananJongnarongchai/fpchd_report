$(document).ready(function () {
  // Initialize tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Filter buttons event listener
  $(".filter-button").click(function () {
    var status = $(this).data("status");
    if (status === "all") {
      $("#myTable").DataTable().search("").draw();
    } else {
      $("#myTable").DataTable().column(7).search(status).draw();
    }
  });

  // Load all data button event listener
  $("#allButton").click(function () {
    var table = $("#myTable").DataTable();
    table.search("").columns().search("").draw();
  });

  // Initialize DataTable
  var table = $("#myTable").DataTable({
    dom: "Qlfrtip",
    searchBuilder: {
      depthLimit: 2,
    },
    buttons: [
      {
        extend: "csv",
        split: ["pdf", "excel"],
      },
    ],
    pagingType: "full_numbers",
    lengthMenu: [
      [10, -1],
      [10, "All"],
    ],
    language: {
      lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
      zeroRecords: "ไม่พบรายการคำร้องเรียน",
      info: "แสดงหน้า _PAGE_ จาก _PAGES_",
      infoEmpty: "ไม่มีรายการที่แสดง",
      infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
      paginate: {
        first: "<i class='bi bi-skip-backward-fill'></i>",
        last: "<i class='bi bi-skip-forward-fill'></i>",
        next: "<i class='bi bi-caret-right-fill'></i>",
        previous: "<i class='bi bi-caret-left-fill'></i>",
      },
      search: "คำค้นหา:",
    },
  });

  // Move buttons container
  table.buttons().container().appendTo("#myTable_wrapper .col-md-6:eq(0)");
});

function confirmDelete() {
  Swal.fire({
    title: "คำเตือน",
    text: "คุณแน่ใจที่จะลบข้อมูลหรือไม่? ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // ถ้าผู้ใช้คลิก 'ยืนยัน' ให้ทำการลบข้อมูล
      const documentId = document
        .querySelector(".deleteBtn")
        .getAttribute("data-id");
      window.location.href = "./CRUD/delete.php?id=" + documentId;
    }
  });
}

function logoutWithAlert() {
  Swal.fire({
    title: "คุณต้องการออกจากระบบหรือไม่?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "ออกจากระบบ",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // ถ้าผู้ใช้คลิก 'ออกจากระบบ' ให้ทำการ Logout
      // $_SESSION["ar_lg"] = "01";
      // header("location:./Auth/logout.php ");
      window.location.href = "./Auth/logout.php";
    }
  });
}
function sidebaropen() {
  document.getElementById("myside-bar").style.display = "block";
}
function sidebarclose() {
  document.getElementById("myside-bar").style.display = "none";
}

// index.js
