<?php
session_start();

if (isset($_GET['action']) && isset($_GET['key'])) {
    $action = $_GET['action'];
    $key = $_GET['key'];

    // เช็คว่าเซสชั่นตะกร้าสินค้าอยู่หรือไม่
    if (isset($_SESSION['cart'][$key])) {
        // ถ้าคุณเลือกเพิ่มจำนวนสินค้า
        if ($action === 'increase') {
            $_SESSION['cart'][$key]['quantity'] += 1;
        }
        // ถ้าคุณเลือกลดจำนวนสินค้า
        if ($action === 'decrease' && $_SESSION['cart'][$key]['quantity'] > 1) {
            $_SESSION['cart'][$key]['quantity'] -= 1;
        }
    }
}

// เมื่อเพิ่มสินค้าและเลือก Topping ให้เช็คว่า Topping ยังถูกเก็บในรายการของสินค้านั้นๆ หรือไม่
foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['quantity'] > 1) {
        // ถ้าเพิ่มจำนวนสินค้าก็ต้องให้ Topping ที่เลือกยังคงอยู่
        // ตรวจสอบว่า Topping มีการเลือกอยู่ในสินค้าแต่ละตัวแล้ว
        if (!isset($item['toppings'])) {
            $item['toppings'] = [];
        }
    }
}

header("Location: cart.php");
exit();
?>
