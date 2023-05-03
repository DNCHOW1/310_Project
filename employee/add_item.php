<?php
 /*   
    Author: Syed Asad
    Functionality: This file is the script to add a menu item
    to the backend of the database using a post request. The
    php code puts an sql query to push values into the database.
*/


// Get form data
$newname = $_POST["newname"];
$newprice = $_POST["newprice"];
$newdesc = $_POST["newdesc"];

require_once("../connect_db.php");
$conn = connect_mysql();

try{
	// Add item into table
	$sql_add_item = "INSERT INTO Item (item_name, price, description)
		VALUES ('$newname', '$newprice', '$newdesc')";
	mysqli_query($conn, $sql_add_item);

    mysqli_commit($conn);

    echo "Item added successfully";
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