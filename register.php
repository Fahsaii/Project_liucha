<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "liucha";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เช็คว่ามีสินค้าในตะกร้าหรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("❌ ไม่มีสินค้าในตะกร้า");
}

// รับค่าจากฟอร์ม
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = isset($_POST['email']) ? $_POST['email'] : '';
$payment = $_POST['payment'];

// เช็คว่ากรอกข้อมูลครบหรือไม่
if (empty($name) || empty($address) || empty($phone) || empty($payment)) {
    die("❌ กรุณากรอกข้อมูลให้ครบถ้วน");
}

// เริ่ม Transaction
$conn->begin_transaction();
try {
    // ✅ บันทึกคำสั่งซื้อ (ตาราง `orders`)
    $stmt = $conn->prepare("INSERT INTO orders (CustomerID, Adress, Phone, Payment) VALUES (NULL, ?, ?, ?)");
    $stmt->bind_param("sss", $address, $phone, $payment);
    $stmt->execute();

    // ✅ รับ `OrderID` ล่าสุด
    $order_id = $conn->insert_id;
    if (!$order_id) {
        throw new Exception("❌ ไม่สามารถสร้างคำสั่งซื้อได้");
    }

    // ✅ บันทึกสินค้าลง `order_items`
    $stmt_item = $conn->prepare("INSERT INTO order_items (OrderID, MenuID, Quantity, Price) VALUES (?, ?, ?, ?)");

    foreach ($_SESSION['cart'] as $item) {
        $stmt_item->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt_item->execute();
    }

    // ✅ ยืนยันการบันทึก
    $conn->commit();
    unset($_SESSION['cart']); // ล้างตะกร้าหลังจากสั่งซื้อสำเร็จ

    echo "✅ สั่งซื้อสำเร็จ! หมายเลขคำสั่งซื้อของคุณคือ: " . $order_id;
} catch (Exception $e) {
    $conn->rollback();
    die("❌ เกิดข้อผิดพลาด: " . $e->getMessage());
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
