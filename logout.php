<?php
session_start();
session_unset();
session_destroy(); // เคลียร์ session ทั้งหมด
header("Location: index.php"); // กลับไปหน้าแรก
exit();
?>