<?php
$PASS = $_POST["password"];
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];

// Get the employee ID from a session variable or form data
$employeeId = json_decode($_COOKIE["currentUser"], true);
        
require_once("../connect_db.php");
$conn = connect_mysql();

$updateUserSql = "UPDATE User
                    SET 
                    password = '$PASS',
                    first_name = '$firstName',
                    last_name = '$lastName',
                    email = '$email'
                    WHERE user_id = '$employeeId'";

try{
    mysqli_begin_transaction($conn);

    mysqli_query($conn, $updateUserSql);

    mysqli_commit($conn);
} catch (\Throwable $e) {
    // An exception thrown, rollback...
    $conn->rollback();

    throw $e; // handle exception

    // Close connection
    mysqli_close($conn);

}
header("Location: edit_account.php");
?>