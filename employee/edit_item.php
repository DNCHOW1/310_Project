<?php

/*   
    Author: Syed Asad
    Functionality: This file is the script to edit a menu item
    to the backend of the database using a post request. The
    php code puts an sql query to find the name of the menu item
    to be changed and uses the fields in the text boxes to change
    values such as the name, price, and description.
*/

// Get form data
$oldname = $_POST["oldname"];
$newname = $_POST["newname"];
$newprice = $_POST["newprice"];
$newdesc = $_POST["newdesc"];

require_once("../connect_db.php");
$conn = connect_mysql();

try{
	// Add item into table
	$sql_add_item = "UPDATE Item 
		SET item_name = '$newname', price = '$newprice',
			description = '$newdesc'
		WHERE item_name = '$oldname'";
	mysqli_query($conn, $sql_add_item);

    mysqli_commit($conn);

    echo "Item edited successfully";
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