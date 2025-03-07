<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "liucha");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีข้อมูลที่ต้องลบ
if (isset($_GET['key']) && isset($_GET['topping_key'])) {
    $key = $_GET['key'];  // หาคีย์ของสินค้าที่ต้องการลบ
    $topping_key = $_GET['topping_key']; // หาคีย์ของ Topping ที่จะลบ

    // ตรวจสอบว่ามีสินค้าตามคีย์หรือไม่
    if (isset($_SESSION['cart'][$key]) && isset($_SESSION['cart'][$key]['toppings'][$topping_key])) {
        // ลบ Topping ที่เลือก
        unset($_SESSION['cart'][$key]['toppings'][$topping_key]);

        // รีเซ็ต array ของ toppings เพื่อให้เป็นอาร์เรย์เรียบร้อย
        $_SESSION['cart'][$key]['toppings'] = array_values($_SESSION['cart'][$key]['toppings']);
    }
}

// รีไดเรกไปยังหน้าตะกร้าสินค้า
header("Location: cart.php");
exit();
?>
