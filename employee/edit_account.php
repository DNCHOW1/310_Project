<!DOCTYPE html>
<html>
    <body>
        <?php
            // Get the employee ID from cookie
            $employeeId = json_decode($_COOKIE["currentUser"], true);
            
            require_once("../connect_db.php");
            $conn = connect_mysql();

            // Query the user,employee table for the employee's info
            $sql = "SELECT * FROM Employee LEFT JOIN User ON Employee.employee_id = User.user_id WHERE Employee.employee_id = " . $employeeId;
            $result = mysqli_query($conn, $sql);

            // Check for results
            if (mysqli_num_rows($result) > 0) {
                // Display the payment info and autofill the fields
                while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row["username"];
                    $password = $row["password"];
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $email = $row["email"];
                }
            }

            // Close the database connection
            mysqli_close($conn);
        ?>
        <div id="edit-account">
            <h2>User Creation</h2>
            <form method="post" action="update_info.php">
                <label for="username">Username:</label>
                <input disabled type="text" id="username" name="username" value="<?php echo $username ?>"><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password ?>"><br><br>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name ?>"><br><br>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name ?>"><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email ?>"><br><br>
                <input type="submit" value="Save Changes">
            </form
            <br>
            <form method="post" action="delete_acc.php">
                <input type="submit" value="Delete Account">
            </form>
        </div>

        <!-- Button to go back to the home page -->
        <button type="button" onclick="goToHome()">Back to Home</button>
        
        <script>
            function goToHome() {
                // Navigate back to the home page
                window.location.href = "employee_home.php";
            }
        </script>
    </body>
</html>