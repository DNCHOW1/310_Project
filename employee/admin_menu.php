<!DOCTYPE html>
<html>
<head>
	<title>Menu - My Online Store</title>
</head>
<body>
	<h1>Menu</h1>
	<a href="employee_home.php">Home</a>
	
	<form id="menuForm">
	
		<?php
			// Import and use function
			require_once("../connect_db.php");
			$conn = connect_mysql();
			
			// Query all the items from "Item" table
			$sql = "SELECT * FROM Item";
			$result = mysqli_query($conn, $sql);

			// TODO:
			// Functionality to add new menu item
			// Functionality to delete some menu item
			//	 Remember to delete the menu item from the linking table "ItemIngredient" as well
			// Functionality to edit a menu item
			//	 This'll be somewhat tricky, because there's ingredients associated to each menu item
			
			// Check for results
			if (mysqli_num_rows($result) > 0) {
				// Display the results in a list with checkboxes
				echo "<ul>";
				while ($row = mysqli_fetch_assoc($result)) {
					$itemId = $row["item_id"];

					// Display an item's attributes
					echo 
					"<li name=\"item[]\" value=\"" . $row["item_name"] . "\" id=\"$itemId\">
					<strong>" . $row["item_name"] . "</strong><br>" . 
					$row["description"] . "<br>$" . 
					$row["price"] . 
					"</li>";

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
	
	</form>
</body>
</html>