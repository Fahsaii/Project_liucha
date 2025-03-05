<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = &$_SESSION['cart']; 

if (isset($_GET['action']) && isset($_GET['name'])) {
    $action = $_GET['action'];
    $name = urldecode($_GET['name']); 

    foreach ($cart as $key => $item) {
        if ($item['name'] === $name) {
            if ($action === 'increase') {
                $_SESSION['cart'][$key]['quantity'] += 1;
            } elseif ($action === 'decrease' && $_SESSION['cart'][$key]['quantity'] > 1) {
                $_SESSION['cart'][$key]['quantity'] -= 1;
            }
            break;
        }
    }
}


header("Location: cart.php");
exit();
