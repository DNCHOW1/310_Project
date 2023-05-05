<?php

/*
This file is responsible for deleting a employee account. This is rather simple as we just need to delete from the User table, and then
the change will cascade down to all the other tables that use this as a foreign key. Thus, it would delete all the employee comments related
to this account.

This file was done by Dien Chau.
*/

require_once("../connect_db.php");
$conn = connect_mysql();

$employee_id = json_decode($_COOKIE["currentUser"], true);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

try{
    mysqli_begin_transaction($conn);
    
    // Delete user from database
    $deleteSql = "DELETE FROM User WHERE User.user_id = '$employee_id'";
    mysqli_query($conn, $deleteSql);

    mysqli_commit($conn);

    echo "Successfully deleted account...";
    echo "<p><a href=\"../index.php\">Return to Login Page</a></p>";

} catch (\Throwable $e) {
    // An exception thrown, rollback...
    $conn->rollback();

    throw $e; // handle exception

    // Close connection
    mysqli_close($conn);

    echo "An error has occurred...";
    echo "<p><a href=\"./employee_home.php\">Return to Home Page</a></p>";

}
?>