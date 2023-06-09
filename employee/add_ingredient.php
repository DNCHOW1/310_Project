<?php

/*
Author: Syed Asad
Functionality: This file is the script to add an ingredient to a menu item
to the backend of the database using a post request. The
php code puts an sql query to push values into the database. If the ingredient name 
does not exist, then a new ingredient will be made and added into the 
association table in the database.
*/

// Get form data

$itemname = $_POST["itemname"];
$ingredientname = $_POST["ingredientname"];

require_once("../connect_db.php");
$conn = connect_mysql();

try{
	// Add ingredient into table if it doesn't exist
	$sql_add_ingredient =  "INSERT INTO Ingredient (ingredient_name) 
                            SELECT '$ingredientname'
                            WHERE NOT EXISTS 
                                (SELECT ingredient_name
                                 FROM Ingredient 
                                 WHERE ingredient_name = '$ingredientname')";
	mysqli_query($conn, $sql_add_ingredient);

    // Associate item to menu item
    $associate =    "INSERT INTO ItemIngredient (item_id, ingredient_id, amount)
                    SELECT Item.item_id, Ingredient.ingredient_id, 1
                    FROM Item
                    JOIN Ingredient ON Item.item_name = '$itemname' AND Ingredient.ingredient_name = '$ingredientname'
                    WHERE Item.item_name = Ingredient.ingredient_name = '$ingredientname'";
    mysqli_query($conn, $associate);

    mysqli_commit($conn);

    echo "Ingredient added successfully";
}
catch (\Throwable $e) {
    // An exception thrown, rollback...
    $conn->rollback();

    echo $e->getCode();
    if (mysqli_errno($e) == 1062) {
        print 'no way!';
    } else{
        throw $e; // handle exception
    }

}

// Close connection
mysqli_close($conn);

header("Location: admin_menu.php");

?>