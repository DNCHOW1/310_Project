
<?php

/*
    This file handles the backend logic for checking for successful login. If the login is successful then cookies should be set to persist some
    of the user's data and make later logic in other pages easier to do.

    The view for the User was done by Dien Chau.

    This file was done by Dien Chau & Arjun Grover.
*/

// Check if form was submitted (Arjun Grover)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data (Arjun Grover)
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once("connect_db.php");
    $conn = connect_mysql();

    // Query database to check if username and password match (Dien Chau)
    $sql = "SELECT * FROM User 
                LEFT JOIN Employee
                    ON User.user_id = Employee.employee_id
                WHERE 
                    username='$username' 
                    AND 
                    password='$password'
                ";
                
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        // Login successful, redirect to homepage or dashboard (Dien Chau)
        while ($row = mysqli_fetch_assoc($result)) {

            // Setting cookies to make later computations easier (Dien chau)
            // If the user is a customer, userType will be 0 and isAdmin will just be NULL and won't be set
            // Otherwise userType will be 1 and isAdmin WILL have to be either 0 or 1
            setcookie("currentUser", $row['user_id'], time()+86400*1, "/"); // expire in 1 day
            setcookie("userType", $row['user_type'], time()+86400*1, "/"); // expire in 1 day
            setcookie("isAdmin", $row['admin'], time()+86400*1, "/"); // expire in 1 day
            if($row['user_type'] == 0){ // Regular Customer
                header("Location: customer/home.php");
            } else{ // Employee or Admin
                header("Location: employee/employee_home.php");
            }
        }
        exit();
    } else {
        // Login failed, display error message
        echo "Invalid username or password";
    }

    // Close connection
    mysqli_close($conn);
}
?>