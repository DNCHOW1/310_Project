<!--
		Author: Dien Chau, Syed Asad
		Functionality: Displays each menu item after getting them from the database. Then it
		displays the associated ingredients that each menu item has by calling a select from
		The association table. With this, the ingredients will update the bulleted list
		under the menu item so that the user can see what ingredients each menu item has.
-->

<!DOCTYPE html>
<html>
<head>
	<title>Menu - My Online Store</title>
</head>
<body>
	<h1>Menu</h1>
    <a href="home.php">Home</a>
    <a href="cart.php">Cart</a>
	
	<form id="menuForm">
	
	<?php
		
		require_once("../connect_db.php");
		$conn = connect_mysql();

		// Query all the items from "item_ingredient_view" table (Syed Asad)
		$sql = "SELECT * FROM item_ingredient_view";
		$result = mysqli_query($conn, $sql);
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			// Display the results in a list with checkboxes
			echo "<ul>";
			$prevId = -1;
			$prevIngFlag = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$itemId = $row["item_id"];

				if($itemId != $prevId){
					if($prevIngFlag) {
						// We want to close off previous ul list if one was created
						echo "</ul>"; 
						$prevIngFlag = 0;
					}

					// Display a description of the menu item, this is a newly seen menu item (Syed Asad)
					echo 
					"<li>
					<input type=\"checkbox\" name=\"item[]\" value=\"" . $row["item_name"] . "\" id=\"$itemId\"> 
					<strong><a href='review.php?item_id=" . $itemId . "'>" . $row["item_name"] . "</a></strong><br>" . 
					$row["description"] . "<br>$" . 
					$row["price"] .
					"</li>";
					
					// Display a list of all the associated menu ingredients if they exist (Syed Asad)
					if($row["ingredient_id"] != NULL){
						echo "<ul>";
						echo "<li>" . $row["ingredient_name"] . "</li>";
						$prevIngFlag = 1;
					}

					$prevId = $itemId; // Update the prevId of the seen ingredient
				}
				else{
					// Previous menu item has multiple ingredients, add the newly seen ingredient
					echo "<li>" . $row["ingredient_name"] . "</li>";
				}

			}
			if($prevIngFlag) echo "</ul>";  //  close off the last item ingredient list if it exists
			echo "</ul>";							// close off the item list
		} else {
			// Display a message if there are no results
			echo "No items found.";
		}
		
		// Close the database connection
		mysqli_close($conn);
	?>
	
	<!-- Button to add checked items to cart -->
	<button type="button" onclick="addToCart()">Add to Cart</button>
	
	</form>
	
	<script>
		// Helper function for setting cookies, that way we can persist data locally (Dien Chau)
        function setCookie(name,value,exp_days) {
            var d = new Date();
            d.setTime(d.getTime() + (exp_days*24*60*60*1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

		// Helper function to get local data, to be used to make functions easier (Dien Chau)
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

		// Helper function to add to the cart, this local data can be used on other pages (Dien Chau + Syed Asad)
		function addToCart() {
			// Get the checked items from the form
			const form = document.getElementById("menuForm");
			const checkboxes = form.elements["item[]"];
			var checkedItems = [];
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked) {
					checkedItems.push(checkboxes[i].id);
				}
			}
			
			// Get the existing cart items from local storage
			// var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
            var cartItems = getCookie("cartItems");
            if(cartItems) cartItems = JSON.parse(cartItems);
            else cartItems = [];

            const setCartItems = new Set(cartItems); 
			
			// Add the checked items to the cart
			for (var i = 0; i < checkedItems.length; i++) {
				setCartItems.add(checkedItems[i]);
			}
			
			// Save the updated cart items to local storage
			// localStorage.setItem("cartItems", JSON.stringify(cartItems));
			setCookie("cartItems", JSON.stringify(Array.from(setCartItems)), 3);
			
			// Print out to the user that the items have been added to the cart
			if (checkedItems.length > 0) {
				alert(checkedItems.length + " item(s) have been added to your cart.");
			} else {
				alert("Please select at least one item to add to your cart.");
			}
		}
	</script>
	
</body>
</html>