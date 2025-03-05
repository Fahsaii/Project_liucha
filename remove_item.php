<?php
session_start();

if (isset($_GET['name'])) {
    $name = urldecode($_GET['name']);

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($name) {
        return $item['name'] !== $name;
    });
}

header("Location: cart.php");
exit();
?>
