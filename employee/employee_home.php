<!DOCTYPE html>
<html>
<head>
    <title>Pizza Express</title>
</head>
<body>
    <h1>Welcome to Pizza Express!</h1>
    
    <!-- Logout button -->
    <button style="position: absolute; top: 10px; right: 10px;" onclick="logout()">Logout</button>

    <!-- AdminMenu Button -->
    <?php 
        if ($_COOKIE["userType"] == 1) {
            echo '<button type="button" onclick="adminMenu()">Admin Menu</button>';
        }
    ?>
    
    <h2> Ongoing Orders </h2>
    <?php

        // Debugging
        echo "<p> " . htmlentities(json_encode($_COOKIE)) . "><br>";

        $customerId = json_decode($_COOKIE["currentUser"], true);

        require_once("../connect_db.php");
		$conn = connect_mysql();

		// Query the "Checkout" for ALL unserved orders
		$sql = "SELECT * FROM Checkout 
					WHERE 
						Checkout.order_status = 0
					ORDER BY Checkout.time_ordered ASC";
		$result = mysqli_query($conn, $sql);
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			echo "<ul>";
			// Display each order
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<li><strong>Order #" . $row["order_id"] . "</strong><br>Ordered on " . $row["time_ordered"] . "<br>Total price: $" . $row["total_price"] . "<br>";
				
				// Query the "OrderItem" and "Item" tables for items in the current order
				$itemSql = "SELECT * FROM OrderItem INNER JOIN Item ON OrderItem.item_id = Item.item_id WHERE OrderItem.order_id = " . $row["order_id"];
				$itemResult = mysqli_query($conn, $itemSql);
				
				// Display each item in the order
				if (mysqli_num_rows($itemResult) > 0) {
					echo "<ul>";
					while ($itemRow = mysqli_fetch_assoc($itemResult)) {
						echo "<li>" . $itemRow["amount"] . " x " . $itemRow["item_name"] . " - $" . $itemRow["price"] . "</li>";
					}
					echo "</ul>";
				} else {
					echo "No items found for this order.";
				}

                // Create a button that will run a php function to update order
                echo
                 '<form method="post" action="update_order.php">
                <input type="hidden" name="order_id" value="' . $row['order_id'] . '">
                <button type="submit" name="update_order">Serve Order</button>
                </form>'; 
				
				echo "</li><br>";
			}
			echo "</ul>";
		} else {
			// Display a message if there are no results
			echo "No orders found.";
		}
        mysqli_close($conn);
    ?>
    
    <script>
        function logout() {
            // Invalidate cookies
            document.cookie = 'currentUser=; Max-Age=-99999999;'; 
            document.cookie = 'cartItems=; Max-Age=-99999999';
            document.cookie = 'userType=; Max-Age=-99999999';

            // Navigate back to login page
			window.location.href = "../index.php";
        }

        function adminMenu() {
            // Navigate to admin menu page
            window.location.href = "admin_menu.php";
        }
    </script>
</body>
</html>
