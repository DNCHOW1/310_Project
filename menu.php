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
		// Connect to the MySQL database
		$host = "localhost";
		$user = "root";
		$password = "";
		$database = "310_pizza";
		$conn = mysqli_connect($host, $user, $password, $database);
		
		// Check for errors
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		// Query all the items from "Item" table
		$sql = "SELECT * FROM Item";
		$result = mysqli_query($conn, $sql);
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			// Display the results in a list with checkboxes
			echo "<ul>";
			while ($row = mysqli_fetch_assoc($result)) {
				$itemId = $row["item_id"];
				echo "<li><input type=\"checkbox\" name=\"item[]\" value=\"" . $row["item_name"] . "\" id=\"$itemId\"> <strong>" . $row["item_name"] . "</strong><br>" . $row["description"] . "<br>$" . $row["price"] . "</li>";

				// Query the "ItemIngredient" and "Ingredient" table for ingredient_id associated with item_id
				$ingredientSql = "SELECT ing.ingredient_name
											FROM ItemIngredient 
											INNER JOIN Ingredient ing
												ON ItemIngredient.ingredient_id = ing.ingredient_id 
											WHERE ItemIngredient.item_id = '$itemId'";
				$ingredientResult =  mysqli_query($conn, $ingredientSql);

				// Display each ingredient in the item
				if (mysqli_num_rows($ingredientResult) > 0) {
					echo "<ul>";
					while ($ingredientRow = mysqli_fetch_assoc($ingredientResult)) {
						echo "<li>" . $ingredientRow["ingredient_name"] . "</li>";
					}
					echo "</ul>";
				}
			}
			echo "</ul>";
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