<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toppings'])) {
 
    $conn = new mysqli("localhost", "root", "", "liucha");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($_POST['toppings'] as $toppingID) {
   
        $sql = "SELECT * FROM topping WHERE ToppingID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $toppingID);
        $stmt->execute();
        $result = $stmt->get_result();
        $topping = $result->fetch_assoc();

        if ($topping) {
       
            $_SESSION['cart'][] = [
                'name' => $topping['Name'],
                'price' => $topping['Price'],
                'quantity' => 1
            ];
        }
    }

    $conn->close();
}

header("Location: cart.php");
exit();
