<!DOCTYPE html>
<html>
<head>
	<title>Cart - Pizza Express</title>
</head>
<body>
	<h1>Cart</h1>
	
	<?php
	
		// Get the cart items from local storage
		if(isset($_COOKIE["cartItems"])){
			$cartItems = json_decode($_COOKIE["cartItems"], true);
		} else{
			$cartItems = [];
		}
	
		require_once("../connect_db.php");
		$conn = connect_mysql();

		if (!empty($cartItems)) {
			echo "<form method=\"post\" action=\"checkout.php\">";
			echo "<ul>";
			// Loop through the cart items and display them
			foreach ($cartItems as $itemId) {
				
				// Query the "item" table for the current item
				$sql = "SELECT * FROM item WHERE item_id = " . $itemId;
				$result = mysqli_query($conn, $sql);
				
				// Check for results
				if (mysqli_num_rows($result) > 0) {
					// Display the item
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<li><strong>" . $row["item_name"] . "</strong><br>" . $row["description"] . "<br>$" . $row["price"] . "<br>";
						echo "<select name=\"" . $row["item_id"] . "\">";
						for ($i = 1; $i <= 10; $i++) {
							echo "<option value=\"" . $i . "\">" . $i . "</option>";
						}
						echo "</select><br>";
						echo "<button type=\"button\" onclick=\"removeItem(" . $row["item_id"] . ")\">Remove Item</button></li>";
					}
				} else {
					// Display a message if there are no results
					echo "No items found.";
				}
				
			}
			
			echo "</ul>";
			echo "<input type=\"submit\" value=\"Continue To Checkout\">";
			echo "</form>";
		} else {
			// Display a message if the cart is empty
			echo "Your cart is empty.";
		}

		// Close the database connection
		mysqli_close($conn);
	?>
	
	<!-- Button to go back to the menu -->
	<button type="button" onclick="goToMenu()">Back to Menu</button>
	
	<script>
		function goToMenu() {
			// Navigate back to the menu page
			window.location.href = "menu.php";
		}

		function setCookie(name,value,exp_days) {
            var d = new Date();
            d.setTime(d.getTime() + (exp_days*24*60*60*1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

		function getCookie(name) {
            var cname = name + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++){
                var c = ca[i];
                while(c.charAt(0) == ' '){
                    c = c.substring(1);
                }
                if(c.indexOf(cname) == 0){
                    return c.substring(cname.length, c.length);
                }
            }
            return "";
        }
		
		function removeItem(itemId) {
			// Remove the item from the cart
			var cartItems = JSON.parse(getCookie("cartItems"));
			var index = cartItems.indexOf(itemId.toString());
			if (index > -1) {
				cartItems.splice(index, 1);
			}

			setCookie("cartItems", JSON.stringify(cartItems), 3);
			
			// Reload the page to update the cart display
			location.reload();
		}
	</script>
	
</body>
</html>
