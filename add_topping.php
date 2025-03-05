<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['menu_id']) && isset($_POST['topping']) && is_array($_POST['topping'])) {

    $conn = new mysqli("localhost", "root", "", "liucha");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $menu_id = $_POST['menu_id'];

    foreach ($_POST['topping'] as $toppingID) {
        $sql = "SELECT Name, Price FROM topping WHERE ToppingID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $toppingID);
        $stmt->execute();
        $result = $stmt->get_result();
        $topping = $result->fetch_assoc();

        if ($topping) {
      
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['menu_id'] == $menu_id) {
                
                    $item['toppings'][] = [
                        'name' => $topping['Name'],
                        'price' => $topping['Price']
                    ];
                    break;
                }
            }
        }
    }

    $conn->close();
}

header("Location: cart.php");
exit();
