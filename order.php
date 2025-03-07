<?php
session_start();
include 'database/db.php';
echo "<pre>";
print_r($_SESSION['cart']);
echo "</pre>";
exit();



if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}


$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = isset($_POST['email']) ? $_POST['email'] : '';
$payment = $_POST['payment'];

if (empty($name) || empty($address) || empty($phone) || empty($payment)) {
    die("กรุณากรอกข้อมูลให้ครบถ้วน");
}

try {
    $conn->beginTransaction(); 

   
    $sql = "INSERT INTO `order` (CustomerID, Adress, Phone, Payment) VALUES (NULL, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$address, $phone, $payment]);

    $order_id = $conn->lastInsertId(); 

    
    $sql_item = "INSERT INTO order_items (OrderID, MenuID, Quantity, Price) VALUES (?, ?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);

    foreach ($_SESSION['cart'] as $item) {
        $stmt_item->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    $conn->commit(); 
    unset($_SESSION['cart']); 

    echo "สั่งซื้อสำเร็จ! หมายเลขคำสั่งซื้อของคุณคือ: " . $order_id;
} catch (Exception $e) {
    $conn->rollBack();
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}
?>
