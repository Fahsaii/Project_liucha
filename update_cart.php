<?php
session_start();

if (isset($_GET['action']) && isset($_GET['key'])) {
    $action = $_GET['action'];
    $key = $_GET['key'];

    if (isset($_SESSION['cart'][$key])) {
        if ($action === "increase") {
            $_SESSION['cart'][$key]['quantity'] += 1; // เพิ่มจำนวนสินค้า
        } elseif ($action === "decrease") {
            $_SESSION['cart'][$key]['quantity'] -= 1; // ลดจำนวนสินค้า
            if ($_SESSION['cart'][$key]['quantity'] <= 0) {
                unset($_SESSION['cart'][$key]); // ลบสินค้าออกถ้าจำนวนน้อยกว่า 1
            }
        }
    }
}

header("Location: cart.php");
exit();
?>
