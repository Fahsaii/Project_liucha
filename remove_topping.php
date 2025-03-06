<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id']; // รับ menu_id จากฟอร์ม
    $topping_name = $_POST['topping_name']; // รับชื่อ Topping ที่จะลบ

    // เช็คว่า ตะกร้า มีสินค้าอยู่หรือไม่
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['menu_id'] == $menu_id) {
                // ลบ Topping ออกจากสินค้า
                foreach ($_SESSION['cart'][$key]['toppings'] as $index => $topping) {
                    if ($topping['name'] == $topping_name) {
                        unset($_SESSION['cart'][$key]['toppings'][$index]);
                        break;
                    }
                }
            }
        }
    }

    // ส่งข้อมูลกลับไป
    echo json_encode(["status" => "success"]);
}
?>
