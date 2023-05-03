<?php

/*
Author: Syed Asad
Functionality: This file is the script to remove an ingredient from an item
to the backend of the database using a post request. The
php code puts an sql query to remove all rows in the association table with
matching ids from each of the ingredient and menu item tables.
Get form data
*/

$itemname = $_POST["itemname"];
$ingredientname = $_POST["ingredientname"];

require_once("../connect_db.php");
$conn = connect_mysql();

try{
    // Remove from association
    $associate =    "DELETE FROM ItemIngredient
                    WHERE item_id = (SELECT item_id FROM Item WHERE item_name = '$itemname')
                        AND ingredient_id = (SELECT ingredient_id FROM Ingredient WHERE ingredient_name = '$ingredientname')";
    mysqli_query($conn, $associate);

    mysqli_commit($conn);

    echo "Ingredient removed successfully";
}
catch (\Throwable $e) {
    // An exception thrown, rollback...
    $conn->rollback();

    // catch error on distinct username/email: TODO
    echo $e->getCode();
    if (mysqli_errno($e) == 1062) {
        print 'no way!';
    }

    throw $e; // handle exception
}

// Close connection
mysqli_close($conn);

header("Location: admin_menu.php");

?>