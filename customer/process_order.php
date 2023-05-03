<?php

/*

*/

$name = $_POST["name"];
$cc_number = $_POST["cc_number"];
$cc_exp = date('Y-m-d', strtotime($_POST["cc_expiration"]));
$cc_sec = $_POST["cc_security_code"];
$orderType = $_POST["orderType"];
$pickupTime = $_POST["pickupTime"];
$pickupTimeFormatted = date('Y-m-d H:i:s', strtotime($pickupTime));
$address = $_POST["address"];
$city = $_POST["city"];
$zip = $_POST["zip"];
$cartItems = json_decode($_POST["cartItems"]);
$paymentId = $_POST["final_payment_id"];

require_once("../connect_db.php");
$conn = connect_mysql();

// Try a transaction, so that we ensure we insert into OrderItem, Checkout
try{
    $customerId = $_COOKIE["currentUser"];
    $totalPrice = 0.0;

    mysqli_begin_transaction($conn);

    // If $paymentId == -1, user wants to create a new payment option
    // We want to insert into payment and get the id
    if($paymentId == -1){
        $paymentSql = "INSERT INTO Payment (customer_id, name, cc_number, expiration, security_code)
                        VALUES ('$customerId', '$name', '$cc_number', '$cc_exp', '$cc_sec')";
        mysqli_query($conn, $paymentSql);
        $paymentId = mysqli_insert_id($conn);
    }

    // Insert new order into checkout table
    $new_order = "INSERT INTO Checkout (customer_id, payment_id, order_type, total_price)
            VALUES ('$customerId', '$paymentId', '$orderType', '0')";
    mysqli_query($conn, $new_order);

    $orderId = mysqli_insert_id($conn); // retrieve the last orderId

    // Insert into one of the subtype-entities
    if($orderType == "delivery"){
        $deliverySql = "INSERT INTO Delivery (order_id, address, city, zip_code)
            VALUES ('$orderId', '$address', '$city', '$zip')";
        mysqli_query($conn, $deliverySql);
    } else{
        $takeoutSql = "INSERT INTO Takeout (order_id, pickupTime)
            VALUES ('$orderId', '$pickupTimeFormatted')";
        mysqli_query($conn, $takeoutSql);
    }

    // Loop through the cart items and query
    foreach ($cartItems as $itemId => $quantity) {
        
        // Query the "item" table for the current item
        $sql = "SELECT * FROM item WHERE item_id = " . $itemId;
        $result = mysqli_query($conn, $sql);
        
        // Check for results
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row["price"]; // fetch price
                
                // Insert into OrderItem(bridge entity)
                $orderItemSql = "INSERT INTO OrderItem (order_id, item_id, amount)
                    VALUES ('$orderId', '$itemId', '$quantity')";
                mysqli_query($conn, $orderItemSql);

                // Add to total_price to update the new_order later
                $totalPrice += ((int)$quantity) * $price;
            }
        }
    }

    // Update the orderId with the acquired totalPrice
    $updateSql = "UPDATE Checkout
                  SET total_price = '$totalPrice'
                  WHERE order_id = '$orderId'";
    
    mysqli_query($conn, $updateSql);

    mysqli_commit($conn);

    echo "New order created successfully";

    // Close connection
    mysqli_close($conn);

    header("Location: successful_order.php");
} catch (\Throwable $e) {
    // An exception thrown, rollback...
    $conn->rollback();

    throw $e; // handle exception

    // Close connection
    mysqli_close($conn);
}

?>