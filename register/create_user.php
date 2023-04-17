<?php
// Get form data
$username = $_POST["username"];
$password = $_POST["password"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$street = $_POST["street"];
$city = $_POST["city"];
$zip = $_POST["zip"];

require_once("connect_db.php");
$conn = connect_mysql();

// Try a transaction, so that we ensure we insert into both tables
try{
    mysqli_begin_transaction($conn);

    // Insert new user into User table
    $sql_user = "INSERT INTO User (username, password, first_name, last_name, email, user_type)
            VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '0')";
    mysqli_query($conn, $sql_user);

    // Insert new customer into Customer table using last inserted id
    $last_id = mysqli_insert_id($conn);
    $sql_customer = "INSERT INTO Customer (customer_id, phone, street, city, zip_code)
        VALUES ('$last_id', '$phone', '$street', '$city', '$zip')";
    mysqli_query($conn, $sql_customer);

    mysqli_commit($conn);

    echo "New account created successfully";

    // Close connection
    mysqli_close($conn);

    header("Location: successful_registration.php");
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
?>