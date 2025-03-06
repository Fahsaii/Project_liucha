<?php
session_start();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id']; 
    $topping_name = $_POST['topping']; 

    // ตรวจสอบการส่งข้อมูล
    if (empty($menu_id) || empty($topping_name)) {
        $_SESSION['error'] = "กรุณาเลือก Topping หรือเมนู";
        header("Location: cart.php");
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ค้นหาเมนูในตะกร้า
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) { 

            // ตรวจสอบว่ามีการเพิ่ม Topping หรือไม่
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            // ตรวจสอบว่า Topping นี้ถูกเพิ่มไปแล้วหรือยัง
            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true;
                    break; 
                }
            }

            if (!$already_added) {
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // ดึงราคาของ Topping จากฐานข้อมูล
                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                $stmt->bind_param("s", $topping_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if (!$row) {
                    $_SESSION['error'] = "ไม่พบ Topping นี้ในฐานข้อมูล";
                    header("Location: cart.php");
                    exit();
                }

                $topping_price = $row['Price'];

                // เพิ่ม Topping ในตะกร้า
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break;
        }
    }

    // รีไดเรกต์ไปหน้าตะกร้า
    $_SESSION['success'] = "Topping added successfully!";
    header("Location: cart.php");
    exit();
}
?>
