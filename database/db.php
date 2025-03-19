<?php
// กำหนดข้อมูลสำหรับเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";  // ชื่อเซิร์ฟเวอร์ MySQL (ที่ตั้งอยู่บนเครื่องเดียวกัน)
$username = "root";         // ชื่อผู้ใช้ในการเชื่อมต่อฐานข้อมูล
$password = "";             // รหัสผ่านสำหรับผู้ใช้ (ว่างในกรณีนี้)
$database = "liucha";       // ชื่อฐานข้อมูลที่ต้องการเชื่อมต่อ

try {
    // สร้างการเชื่อมต่อกับฐานข้อมูลโดยใช้ PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    
    // กำหนดให้ PDO จัดการข้อผิดพลาดโดยแสดงข้อผิดพลาดเป็นข้อยกเว้น
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ถ้าเชื่อมต่อสำเร็จ จะไม่แสดงอะไร (การเชื่อมต่อสำเร็จ)
} catch (PDOException $e) {
    // ถ้าเกิดข้อผิดพลาดในการเชื่อมต่อ (เช่น ข้อมูลไม่ถูกต้อง) จะแสดงข้อความข้อผิดพลาด
    die("Connection failed: " . $e->getMessage());
}
?>
