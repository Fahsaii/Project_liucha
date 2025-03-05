<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    if (!empty($name) && $price > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $name) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $name,
                'price' => $price,
                'quantity' => 1
            ];
        }
    }
}

header("Location: cart.php");
exit();
?>
