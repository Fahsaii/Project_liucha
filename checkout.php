<?php 
session_start();
include 'database/db.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $ordersname = $_POST['name'];
    $tel = $_POST['tel'];
    $address = $_POST['address1'] . ' ' . $_POST['address3'];
    $payment_method = $_POST['payment_method'] ?? 'ไม่ระบุ';
    $total_price = floatval($_POST['total_price'] ?? 0); // ใช้ค่าจากฟอร์ม

    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
    $slip_image = NULL;
    if ($payment_method == "QR Promptpay" && isset($_FILES['slip']) && $_FILES['slip']['error'] == 0) {
        $target_dir = "uploads/";

        // ตรวจสอบว่ามีโฟลเดอร์ uploads หรือไม่ ถ้าไม่มีให้สร้าง
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // ตั้งชื่อไฟล์โดยใช้ timestamp + ชื่อไฟล์เดิม
        $slip_image = $target_dir . time() . "_" . basename($_FILES["slip"]["name"]);
        
        // ย้ายไฟล์ไปที่โฟลเดอร์ uploads
        if (!move_uploaded_file($_FILES["slip"]["tmp_name"], $slip_image)) {
            die("เกิดข้อผิดพลาดในการอัปโหลดไฟล์");
        }
    }

    // ดึง ordersID ล่าสุดจากฐานข้อมูล
    $sql = "SELECT MAX(ordersID) AS max_order_id FROM orders";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $new_order_id = $row['max_order_id'] ? $row['max_order_id'] + 1 : 1;

    // บันทึกข้อมูลลงฐานข้อมูล
    $sql = "INSERT INTO orders (ordersID, ordersname, tel, address, payment_method, total_price, slip_image) 
            VALUES (:ordersID, :ordersname, :tel, :address, :payment_method, :total_price, :slip_image)";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':ordersID', $new_order_id);
    $stmt->bindValue(':ordersname', $ordersname);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':payment_method', $payment_method);
    $stmt->bindValue(':total_price', $total_price); // ใช้ค่า total_price ที่ถูกต้อง
    $stmt->bindValue(':slip_image', $slip_image);

    if ($stmt->execute()) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    $stmt->closeCursor();
    $conn = null;
}
?>