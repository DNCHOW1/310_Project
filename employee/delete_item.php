<?php
// Author: Syed Asad
// Functionality: This file is the script to delete a menu item
// to the backend of the database using a post request. The
// php code puts an sql query to delete the desired item with the name.
// Get form data
$itemname = $_POST["itemname"];

require_once("../connect_db.php");
$conn = connect_mysql();

try{
    $sql_getid = "SELECT * FROM Item WHERE item_name = '$itemname'";
    $result = mysqli_query($conn, $sql_getid);

    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $del_id = $row["item_id"];

            // Delete all associations
            $sql_remove_items = "DELETE FROM ItemIngredient WHERE item_id = '$del_id'";
            mysqli_query($conn, $sql_remove_items);

            // Delete item from menu list
            $sql_remove_item = "DELETE FROM Item WHERE item_name = '$itemname'";
            mysqli_query($conn, $sql_remove_item);
        }

        // Delete item from menu list
        $sql_remove_item = "DELETE FROM Item WHERE item_name = '$itemname'";
        mysqli_query($conn, $sql_remove_item);
    }

    mysqli_commit($conn);

    echo "Item deleted successfully";
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