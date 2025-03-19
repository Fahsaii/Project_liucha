<?php
session_start();  // เริ่มต้น session เพื่อจัดการข้อมูลระหว่างการเยี่ยมชมเว็บไซต์

// ตรวจสอบว่าเป็นการร้องขอแบบ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $name = $_POST['product_name'] ?? "";  // ชื่อสินค้า
    $price = $_POST['price'] ?? 0;  // ราคาสินค้า
    $image = $_POST['image'] ?? "";  // รูปภาพของสินค้า
    $menu_id = $_POST['menu_id'] ?? "";  // รหัสเมนู
    $toppings = isset($_POST['topping']) ? $_POST['topping'] : [];  // ท็อปปิ้งที่เลือก

    // ตรวจสอบให้แน่ใจว่ามีชื่อสินค้าและราคาที่ถูกต้อง (ราคาต้องมากกว่า 0)
    if (!empty($name) && $price > 0) {
        // ตรวจสอบว่าใน session ยังไม่มีตะกร้า หรือไม่ ถ้าไม่มีจะสร้างตะกร้าขึ้นมา
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // ตรวจสอบว่ามีสินค้านี้ในตะกร้าแล้วหรือยัง
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            // หากมีสินค้าในตะกร้าตรงกับที่เลือก ให้เพิ่มจำนวนสินค้าและท็อปปิ้ง
            if ($item['name'] === $name && $item['menu_id'] === $menu_id) {
                $item['quantity'] += 1;  // เพิ่มจำนวนสินค้าในตะกร้า
                $item['toppings'] = array_merge($item['toppings'], $toppings);  // เพิ่มท็อปปิ้ง
                $item['toppings'] = array_unique($item['toppings']);  // ลบท็อปปิ้งซ้ำ
                $found = true;  // ตั้งค่าให้พบสินค้าแล้ว
                break;
            }
        }

        // ถ้ายังไม่พบสินค้าในตะกร้า จะเพิ่มสินค้าลงไปใหม่
        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'menu_id' => $menu_id,
                'quantity' => 1,  // กำหนดจำนวนสินค้าเริ่มต้นเป็น 1
                'toppings' => $toppings  // ท็อปปิ้งที่เลือก
            ];
        }
    }
}

// เปลี่ยนเส้นทางไปยังหน้าตะกร้าสินค้า (cart.php)
header("Location: cart.php");
exit();  // หยุดการทำงานของสคริปต์
?>
