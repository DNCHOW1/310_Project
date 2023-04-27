<!DOCTYPE html>
<html>
<head>
	<title>Menu - My Online Store</title>
</head>
<body>
	<h1>Menu</h1>
	<a href="employee_home.php">Home</a>
	
	
	<?php
		// Import and use function
		require_once("../connect_db.php");
		$conn = connect_mysql();
		
		// TODO:
		// Functionality to delete some menu item
		//	 Remember to delete the menu item from the linking table "ItemIngredient" as well
		// Functionality to edit a menu item
		//	 This'll be somewhat tricky, because there's ingredients associated to each menu item

		echo
		"<form method=\"post\" action=\"delete_item.php\">
			<label for=\"itemname\">Item Name To Delete:</label>
			<input type=\"text\" id=\"itemname\" name=\"itemname\"><br><br>
			<input type=\"submit\" value=\"Delete Item\">
		</form><br><br>";

		echo
		"<form method=\"post\" action=\"add_item.php\">
			<label for=\"newname\">Item Name To Add:</label>
			<input type=\"text\" id=\"newname\" name=\"newname\"><br><br>
			<label for=\"newprice\">Item Price:</label>
			<input type=\"text\" id=\"newprice\" name=\"newprice\"><br><br>
			<label for=\"newdesc\">Item Description:</label>
			<input type=\"text\" id=\"newdesc\" name=\"newdesc\"><br><br>
			<input type=\"submit\" value=\"Add Item\">
		</form><br><br>";

		echo
			"<form method=\"post\" action=\"add_ingredient.php\">
				<label for=\"itemname\">Menu Item Name:</label>
				<input type=\"text\" id=\"itemname\" name=\"itemname\"><br><br>
				<label for=\"ingredientname\">Ingredient Name:</label>
				<input type=\"text\" id=\"ingredientname\" name=\"ingredientname\"><br><br>
				<input type=\"submit\" value=\"Add Ingredient to Item\">
			</form><br><br>";

		echo
		"<form method=\"post\" action=\"remove_ingredient.php\">
			<label for=\"itemname\">Menu Item Name:</label>
			<input type=\"text\" id=\"itemname\" name=\"itemname\"><br><br>
			<label for=\"ingredientname\">Ingredient Name:</label>
			<input type=\"text\" id=\"ingredientname\" name=\"ingredientname\"><br><br>
			<input type=\"submit\" value=\"Remove Ingredient from Item\">
		</form><br><br>";

		echo
		"<form method=\"post\" action=\"edit_item.php\">
			<label for=\"oldname\">Old Item Name:</label>
			<input type=\"text\" id=\"oldname\" name=\"oldname\"><br><br>
			<label for=\"newname\">New Item Name:</label>
			<input type=\"text\" id=\"newname\" name=\"newname\"><br><br>
			<label for=\"newprice\">New Price:</label>
			<input type=\"text\" id=\"newprice\" name=\"newprice\"><br><br>
			<label for=\"newdesc\">New Description:</label>
			<input type=\"text\" id=\"newdesc\" name=\"newdesc\"><br><br>
			<input type=\"submit\" value=\"Edit Item\">
		</form>";
		
		// Query all the items from "item_ingredient_view" table
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

					// Display a description of the menu item, this is a newly seen menu item
					echo 
					"<li name=\"item[]\" value=\"" . $row["item_name"] . "\" id=\"$itemId\">
					<strong>" . $row["item_name"] . "</strong><br>" . 
					$row["description"] . "<br>$" . 
					$row["price"] . 
					"</li>";
					
					// Display a list of all the associated menu ingredients if they exist
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

</body>
</html>