<?php
session_start();

if (isset($_POST['menu_id'], $_POST['topping'])) {
    $menu_id = $_POST['menu_id'];
    $topping_name = $_POST['topping'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $menu_id) {
            // เพิ่ม Topping
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true;
                    break;
                }
            }

            if (!$already_added) {
                // ดึงราคาของ Topping จากฐานข้อมูล
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                $stmt->bind_param("s", $topping_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $topping_price = $row ? $row['Price'] : 0;

                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break;
        }
    }
}

header("Location: cart.php");
exit();

?>
