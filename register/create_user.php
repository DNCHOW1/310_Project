<?php

/*
    This file page occurs when customer or employee finishes registering. The information is gathered from their post request and used
    to INSERT the corresponding data in the respective table, using TWO distinct insert commands.

    One insert will be needed to insert part of the information within the User table. This data is similar for customer and employee.

    Another insert will either be done to Customer table or the Employee table. This is because the users are different so they necessitate
    different insertions. 

    BOTH INSERTIONS FOR CUSTOMER USERTYPE AND EMPLOYEE USERTYPE WERE DONE BY DIEN CHAU

    This file was worked on by Dien Chau + Arjun Grover (dropped)
*/

// Get form data (Dien Chau + Arjun Grover)
$username = $_POST["username"];
$password = $_POST["password"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
if(isset($_POST["phone"])){ // If this is set, we are sure that we came from the customer's register page (Dien Chau)
    $phone = $_POST["phone"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $zip = $_POST["zip"];
    $user_type = 0;
} else{ // else we know that we came from employee's register page (Dien Chau)
    $isAdmin = $_POST["employee_type"];
    $user_type = 1;
}

// Connect to the database
require_once("../connect_db.php");
$conn = connect_mysql();

// Try a transaction, so that we ensure we insert into both tables
try{
    mysqli_begin_transaction($conn);

    // Insert new user into User table (Dien Chau)
    $sql_user = "INSERT INTO User (username, password, first_name, last_name, email, user_type)
            VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '$user_type')";
    mysqli_query($conn, $sql_user);

    // Insert the information into either the Customer table or the Employee table (Dien Chau)
    $last_id = mysqli_insert_id($conn);
    if( isset($_POST["phone"]) ){
        // Insert new customer into Customer table using last inserted id
        $sql_user_type = "INSERT INTO Customer (customer_id, phone, street, city, zip_code)
            VALUES ('$last_id', '$phone', '$street', '$city', '$zip')";
    } else{
        $sql_user_type = "INSERT INTO Employee (employee_id, admin)
            VALUES ('$last_id', '$isAdmin')";
    }
    mysqli_query($conn, $sql_user_type);

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