<!DOCTYPE html>
<html>
<head>
	<title>Order History - Pizza Express</title>
</head>
<body>
	<h1>Order History</h1>
	
	<?php
		// test
        $customerId = json_decode($_COOKIE["currentUser"], true);
		
		require_once("../connect_db.php");
		$conn = connect_mysql();

		// Query the "Checkout" and "Customer" tables for orders by the current user
		$sql = "SELECT * FROM Checkout 
					LEFT JOIN Customer 
						ON Checkout.customer_id = Customer.customer_id 
					WHERE 
						Checkout.customer_id = '$customerId'
						AND
						Checkout.order_status = 1
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
					Ordered fufilled " . $row["time_fufilled"] . "<br>
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
				
				echo "</li>";
			}
			echo "</ul>";
		} else {
			// Display a message if there are no results
			echo "No orders found.";
		}

		// Close the database connection
		mysqli_close($conn);
	?>
	
	<!-- Button to go back to the home page -->
	<button type="button" onclick="goToHome()">Back to Home</button>
	
	<script>
		function goToHome() {
			// Navigate back to the home page
			window.location.href = "home.php";
		}
	</script>
	
</body>
</html>
