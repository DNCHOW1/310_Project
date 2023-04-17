
<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once("connect_db.php");
    $conn = connect_mysql();

    // Query database to check if username and password match
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
        // Login successful, redirect to homepage or dashboard
        while ($row = mysqli_fetch_assoc($result)) {
            setcookie("currentUser", $row['user_id'], time()+86400*1); // expire in 1 day
            setcookie("userType", $row['user_type'], time()+86400*1); // expire in 1 day
            setcookie("isAdmin", $row['admin'], time()+86400*1); // expire in 1 day
            if($row['user_type'] == 0){ // Regular Customer
                header("Location: customer/home.php");
            } else{ // Employee
                header("Location: employees/employee_home.php");
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