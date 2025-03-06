<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_id = $_POST['menu_id'];
    $topping_name = $_POST['topping'];

    // Check if the cart session exists, if not, initialize it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Iterate through the cart to find the menu item that matches the menu_id
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['menu_id'] == $menu_id) {

            // Check if the item already has toppings
            if (!isset($_SESSION['cart'][$key]['toppings'])) {
                $_SESSION['cart'][$key]['toppings'] = [];
            }

            // Check if the topping has already been added
            $already_added = false;
            foreach ($_SESSION['cart'][$key]['toppings'] as $topping) {
                if ($topping['name'] == $topping_name) {
                    $already_added = true;
                    break; // Topping is already added, no need to add again
                }
            }

            // If topping hasn't been added, we fetch the price and add it
            if (!$already_added) {
                // Establish a database connection to fetch the topping price
                $conn = new mysqli("localhost", "root", "", "liucha");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch the price of the topping from the database
                $stmt = $conn->prepare("SELECT Price FROM topping WHERE Name = ?");
                if ($stmt) {
                    $stmt->bind_param("s", $topping_name);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $topping_price = $row ? $row['Price'] : 0;
                    $stmt->close();
                } else {
                    // If query fails, set topping price to 0
                    $topping_price = 0;
                }

                // Close the database connection
                $conn->close();

                // Add the topping to the cart
                $_SESSION['cart'][$key]['toppings'][] = [
                    'name' => $topping_name,
                    'price' => $topping_price
                ];
            }

            break; // Exit the loop after finding the menu item
        }
    }

    // Redirect back to the cart page after adding the topping
    header("Location: cart.php");
    exit();
}
?>
