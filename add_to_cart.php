<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['product_name'] ?? "";
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? "";  // <-- ดึงรูปภาพจากฟอร์ม

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
                'image' => $image,  // <-- เพิ่ม image เข้าไป
                'quantity' => 1
            ];
        }
    }
}

header("Location: cart.php");
exit();
?>
