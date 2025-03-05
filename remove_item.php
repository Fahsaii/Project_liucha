<?php
session_start();

if (isset($_GET['key']) && array_key_exists($_GET['key'], $_SESSION['cart'])) {
    unset($_SESSION['cart'][$_GET['key']]);
}

// รีเซ็ต key ให้ต่อเนื่องหลังจากลบสินค้า
$_SESSION['cart'] = array_values($_SESSION['cart']);

header("Location: cart.php");
exit();
?>
