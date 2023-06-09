<!-- 
    This file is the page for the home screen for the customer. This will display a multitude of buttons for the customer to navigate to, including
    editing their account, viewing the menu, viewing their cart, etc. Each of the team members had to contribute slightly to add their respective
    functionality button to this page.

    The main view on this page that displays the ongoing orders for a user was done by Dien Chau.

    This page was worked on by Dien Chau, Arjun Grover, Syed Asad, and Ekdev Rajkitkul.
 -->

<!DOCTYPE html>
<html>
<head>
    <title>Pizza Express</title>
</head>
<body>
    <h1>Welcome to Pizza Express!</h1>
    
    <!-- Logout button -->
    <button style="position: absolute; top: 10px; right: 10px;" onclick="logout()">Logout</button>

	<!-- Button for edit account info page (Dien Chau) -->
    <form action="edit_account.php" method="get">
        <input type="submit" value="Edit Account Info">
    </form>
    
    <!-- Button for menu page (Syed Asad) -->
    <form action="menu.php" method="get">
        <input type="submit" value="Menu">
    </form>
    
    <!-- Button for cart page (Syed Asad) -->
    <form action="cart.php" method="get">
        <input type="submit" value="Cart">
    </form>

    <!-- Button for History page (Dien Chau) -->
    <form action="history.php" method="get">
        <input type="submit" value="History">
    </form>

	<!-- Button for Review page (Ekdev) -->
    <form action="customer_review.php" method="get">
        <input type="submit" value="View Reviews">
    </form>
    <script>

        // Whenever a user logs out, we want to invalidate this information so that another user loggin in won't use it. (Dien Chau)
        function logout() {
            // Invalidate cookies
            document.cookie = 'currentUser=; Max-Age=-99999999;path=/'; 
            document.cookie = 'cartItems=; Max-Age=-99999999;path=/';
            document.cookie = 'userType=; Max-Age=-99999999;path=/';

            // Navigate back to login page
			window.location.href = "../index.php";
        }
    </script>
    
    <!-- This html code was worked on by Dien Chau and Arjun Grover -->
    <h2> Ongoing Orders </h2>
    <?php

        // Connect to the database
        require_once('../connect_db.php');

        // Debugging
        // echo "<p> " . htmlentities(json_encode($_COOKIE)) . "><br>";

        $customerId = json_decode($_COOKIE["currentUser"], true);
		
		$conn = connect_mysql();

		// Query the "order_item_view" table to get the processed view easily, this view will be tailored specifically for customer (Dien Chau)
		$sql = "SELECT * FROM order_item_view oiv WHERE oiv.customer_id = '$customerId' AND oiv.order_status = 0 ORDER BY oiv.time_ordered DESC";
		$result = mysqli_query($conn, $sql);
		
		// Check for results and display them if they exist (Dien Chau)
		if (mysqli_num_rows($result) > 0) {
			echo "<ul>";

			$prevId = -1;
			while ($row = mysqli_fetch_assoc($result)) {

				if($row['order_id'] != $prevId){
					if($prevId != -1) {
						echo "</ul>"; // We must close off the previous item list
						echo "</li><br>"; // Closing off the previous order entry and creating break point for new one
					}

					// Not equal to previous so this must mean the order_id is a newly seen order, display the new information (Dien Chau + Arjun Grover)
					echo 
					"<li>
						<strong>Order #" . $row["order_id"] . "</strong><br>
						Ordered on " . $row["time_ordered"] . "<br>
						Total price: $" . $row["total_price"] . "<br>";
					
						echo "<ul>";
						echo "<li>" . $row["amount"] . " x " . $row["item_name"] . " - $" . $row["order_item_price"] . "</li>";
					
					
					$prevId = $row['order_id'];
				} else{
					echo "<li>" . $row["amount"] . " x " . $row["item_name"] . " - $" . $row["order_item_price"] . "</li>";
				}
			}
			echo "</ul></ul>"; // Closing off the trailing item list as well as the order list
		} else {
			// Display a message if there are no results
			echo "No orders found.";
		}

		// Close the connection
        mysqli_close($conn);
    ?>
</body>
</html>
