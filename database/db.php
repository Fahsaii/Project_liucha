<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "liucha"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "เชื่อมต่อสำเร็จ!"; // เพิ่มข้อความนี้เพื่อตรวจสอบ
} catch (PDOException $e) {
    die("เชื่อมต่อไม่สำเร็จ: " . $e->getMessage());
}?>
