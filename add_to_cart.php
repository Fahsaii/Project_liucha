<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['product_name'] ?? "";
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? "";
    $menu_id = $_POST['menu_id'] ?? "";
    $toppings = isset($_POST['topping']) ? $_POST['topping'] : [];

    if (!empty($name) && $price > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $name && $item['menu_id'] === $menu_id) {
                $item['quantity'] += 1;
               
                $item['toppings'] = array_merge($item['toppings'], $toppings);
               
                $item['toppings'] = array_unique($item['toppings']);
                $found = true;
                break;
            }
        }

       
        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'menu_id' => $menu_id,
                'quantity' => 1,
                'toppings' => $toppings
            ];
        }
    }
}
header("Location: cart.php");
exit();
?>
