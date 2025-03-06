<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีค่าที่ส่งมาหรือไม่
    if (!isset($_POST['menu_id']) || !isset($_POST['topping']) || empty($_POST['topping'])) {
        header("Location: cart.php");
        exit();
    }

    $menu_id = $_POST['menu_id'];
    $topping_name = $_POST['topping'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            // ตรวจสอบว่า Topping ซ้ำหรือไม่
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
                if ($stmt) {
                    $stmt->bind_param("s", $topping_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $topping_price = $row ? $row['Price'] : 0;
                    $stmt->close();
                } else {
                    $topping_price = 0;
                }

                $conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล

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
