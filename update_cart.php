<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id'];
    $topping_name = $_POST['topping'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {
            // ตรวจสอบว่ามีการเลือก Topping ไว้แล้วหรือไม่
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            // ตรวจสอบว่า Topping ที่จะเพิ่มซ้ำกันหรือไม่
            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true; // ถ้าซ้ำให้ไม่เพิ่ม
                    break;
                }
            }

            // ถ้ายังไม่ซ้ำก็ให้เพิ่ม Topping ลงไปในสินค้านั้นๆ
            if (!$already_added) {
                // เชื่อมต่อฐานข้อมูลเพื่อดึงราคาของ Topping
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

                // เพิ่ม Topping ลงในรายการ
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break;
        }
    }


// เมื่อเสร็จสิ้นแล้วให้ redirect กลับไปยังหน้า cart.php
header("Location: cart.php");
exit();
?>
