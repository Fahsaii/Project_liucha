<?php
session_start();
include 'database/db.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้รับข้อมูลจากฟอร์มแล้ว
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $ordersname = $_POST['name'];
    $tel = $_POST['tel'];
    $address = $_POST['address1'] . ' ' . $_POST['address3']; // รวมที่อยู่
    $payment_method = $_POST['payment_method'] ?? 'ไม่ระบุ'; // ช่องทางการชำระเงิน
    $total_price = $_POST['total_price'] ?? 0; // ราคา

    // ดึงค่าของ ordersID ล่าสุดจากฐานข้อมูล
    $sql = "SELECT MAX(ordersID) AS max_order_id FROM orders";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่า ordersID ล่าสุดเป็น NULL หรือไม่ ถ้าเป็น NULL ให้เริ่มต้นที่ 1
    $new_order_id = $row['max_order_id'] ? $row['max_order_id'] + 1 : 1;

    // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูล
    $sql = "INSERT INTO orders (ordersID, ordersname, tel, address, payment_method, total_price) 
            VALUES (:ordersID, :ordersname, :tel, :address, :payment_method, :total_price)";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);

    // ผูกค่าพารามิเตอร์กับคำสั่ง SQL
    $stmt->bindValue(':ordersID', $new_order_id);
    $stmt->bindValue(':ordersname', $ordersname);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':payment_method', $payment_method);
    $stmt->bindValue(':total_price', $total_price);

    // ตรวจสอบการทำงานของคำสั่ง SQL
    if ($stmt->execute()) {
        // การบันทึกข้อมูลสำเร็จ
        // ใช้ header() เพื่อทำการ redirect ไปยังหน้าที่ต้องการ (success.php หรือหน้าที่คุณต้องการ)
        header("Location: index.php"); 
        exit; // สิ้นสุดสคริปต์หลังจาก redirect
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $stmt->closeCursor();
    $conn = null; // ปิดการเชื่อมต่อ
}
?>
