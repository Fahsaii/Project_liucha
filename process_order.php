<?php
session_start();

// ตรวจสอบว่ามีข้อมูลการสั่งซื้อหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // รับข้อมูลจากฟอร์ม
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // ประมวลผลคำสั่งซื้อ (เช่น การบันทึกลงฐานข้อมูล หรือส่งอีเมล)
    // ตัวอย่างการบันทึกคำสั่งซื้อลงในไฟล์ (หรือสามารถบันทึกลงฐานข้อมูลได้)
    $orderDetails = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'items' => $_SESSION['cart']
    ];

    // ส่งข้อมูลไปยังฐานข้อมูลหรืออีเมล

    // เคลียร์ตะกร้า
    unset($_SESSION['cart']);

    // แสดงข้อความขอบคุณ
    echo "ขอบคุณสำหรับการสั่งซื้อ! เราจะติดต่อคุณเร็ว ๆ นี้.";
} else {
    echo "ไม่พบข้อมูลการสั่งซื้อ.";
}
?>
