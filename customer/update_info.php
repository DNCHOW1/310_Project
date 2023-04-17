<?php
$PASS = $_POST["password"];
$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$street = $_POST["street"];
$city = $_POST["city"];
$zip = $_POST["zip"];

// Get the customer ID from a session variable or form data
$customerId = json_decode($_COOKIE["currentUser"], true);
        
require_once("../connect_db.php");
$conn = connect_mysql();

$updateUserSql = "UPDATE User
                    SET 
                    password = '$PASS',
                    first_name = '$firstName',
                    last_name = '$lastName',
                    email = '$email'
                    WHERE user_id = '$customerId'";
$updateCustomerSql = "UPDATE Customer
                        SET 
                        phone = '$phone',
                        street = '$street',
                        city = '$city',
                        zip_code = '$zip'
                        WHERE customer_id = '$customerId'";

try{
    mysqli_begin_transaction($conn);

    mysqli_query($conn, $updateUserSql);
    mysqli_query($conn, $updateCustomerSql);

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