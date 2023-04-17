<!DOCTYPE html>
<html>
<head>
    <title>Pizza Express</title>
</head>
<body>
    <h1>Welcome to Pizza Express!</h1>
    
    <!-- Logout button -->
    <button style="position: absolute; top: 10px; right: 10px;" onclick="logout()">Logout</button>

	<!-- Button for edit account info page -->
    <form action="edit_account.php" method="get">
        <input type="submit" value="Edit Account Info">
    </form>
    
    <!-- Button for menu page -->
    <form action="menu.php" method="get">
        <input type="submit" value="Menu">
    </form>
    
    <!-- Button for cart page -->
    <form action="cart.php" method="get">
        <input type="submit" value="Cart">
    </form>

    <!-- Button for History page -->
    <form action="history.php" method="get">
        <input type="submit" value="History">
    </form>
    
    <script>
        function logout() {
            // Invalidate cookies
            document.cookie = 'currentUser=; Max-Age=-99999999;'; 
            document.cookie = 'cartItems=; Max-Age=-99999999';
            document.cookie = 'userType=; Max-Age=-99999999';

            // Navigate back to login page
			window.location.href = "../index.php";
        }
    </script>
    
    <h2> Ongoing Orders </h2>
    <?php
        require_once('../connect_db.php');

        // Debugging
        echo "<p> " . htmlentities(json_encode($_COOKIE)) . "><br>";

        $customerId = json_decode($_COOKIE["currentUser"], true);
		
		$conn = connect_mysql();

		// Query the "Checkout" and "Customer" tables for orders by the current user
		$sql = "SELECT * FROM Checkout 
					LEFT JOIN Customer 
						ON Checkout.customer_id = Customer.customer_id 
					WHERE 
						Checkout.customer_id = '$customerId'
						AND
						Checkout.order_status = 0
					ORDER BY Checkout.time_ordered DESC";
		$result = mysqli_query($conn, $sql);
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			echo "<ul>";

			// Display each order
			while ($row = mysqli_fetch_assoc($result)) {
				echo 
				"<li>
					<strong>Order #" . $row["order_id"] . "</strong><br>
					Ordered on " . $row["time_ordered"] . "<br>
					Total price: $" . $row["total_price"] . "<br>";
				
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
				
				echo "</li><br>";
			}
			echo "</ul>";
		} else {
			// Display a message if there are no results
			echo "No orders found.";
		}

		// Close the connection
        mysqli_close($conn);
    ?>
</body>
</html>
