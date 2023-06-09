<!-- 
    This file is the page for the home screen for the employee. This will display a multitude of buttons for the employee to navigate to, including
    editing their account, viewing the admin menu(if admin), viewing reviews... Each of the team members had to contribute slightly to add their respective
    functionality button to this page.

    The main view on this page that displays the ongoing orders for all customers was done by Dien Chau.

    This page was worked on by Dien Chau, Syed Asad, and Ekdev Rajkitkul.
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

    <!-- Button for displaying review page (Ekdev) -->
    <form action="display_review.php" method="get">
        <input type="submit" value="Display Reviews">
    </form>

    <!-- AdminMenu Button (Syed Asad) -->
    <?php 
        if ($_COOKIE["isAdmin"] == 1) {
            echo '<button type="button" onclick="adminMenu()">Admin Menu</button>';
        }
    ?>
    
    <!-- Ongoing orders, all the orders with status 0 for ALL USERS (Dien Chau) -->
    <h2> Ongoing Orders </h2>
    <?php

        // Debugging
        // echo "<p> " . htmlentities(json_encode($_COOKIE)) . "><br>";

        $customerId = json_decode($_COOKIE["currentUser"], true);

        require_once("../connect_db.php");
		$conn = connect_mysql();

        // Query the "order_item_view" table to get the processed view easily, this view will be tailored specifically for employees (Dien Chau)
		$sql = "SELECT * FROM order_item_view oiv WHERE oiv.order_status = 0 ORDER BY oiv.time_ordered ASC";
		$result = mysqli_query($conn, $sql);

        // Check for results
		if (mysqli_num_rows($result) > 0) {
			echo "<ul>";

			$prevId = -1;
			while ($row = mysqli_fetch_assoc($result)) {

				if($row['order_id'] != $prevId){
					if($prevId != -1) {
                        
                        echo "</ul>"; // We must close off the previous item list
                        // Create a button that will run a php function to update order
                        echo
                        '<form method="post" action="update_order.php">
                        <input type="hidden" name="order_id" value="' . $prevId . '">
                        <button type="submit" name="update_order">Serve Order</button>
                        </form>'; 
						echo "</li><br>"; // Closing off the previous order entry and creating break point for new one
					}

					// Not equal to previous so this must mean the order_id is a newly seen order, display the new information
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

             // Create a button that will run a php function to update order, as well as closing off trailing item list and order list
             echo
             '
             </ul>
             <form method="post" action="update_order.php">
             <input type="hidden" name="order_id" value="' . $prevId . '">
             <button type="submit" name="update_order">Serve Order</button>
             </form>
             </ul>
             '; 

			// echo "</ul></ul>"; // Closing off the trailing item list as well as the order list
		} else {
			// Display a message if there are no results
			echo "No orders found.";
		}
		
        mysqli_close($conn);
    ?>
    
    <script>

        // Dien Chau
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
