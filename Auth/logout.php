<?php
session_start();

// ล้างค่าตัวแปรใน Session
session_unset();

// เซ็ต Session เพื่อแสดง SweetAlert
$_SESSION["logout_success"] = true;

// Redirect ไปที่หน้า Login
header('Location: ../index');
exit;
