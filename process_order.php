<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    
    $orderDetails = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'items' => $_SESSION['cart']
    ];

   

    
    unset($_SESSION['cart']);

   
    echo "ขอบคุณสำหรับการสั่งซื้อ! เราจะติดต่อคุณเร็ว ๆ นี้.";
} else {
    echo "ไม่พบข้อมูลการสั่งซื้อ.";
}
?>
