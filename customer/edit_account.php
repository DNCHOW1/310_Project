<!DOCTYPE html>
<html>
    <body>
        <?php
            // Get the customer ID from cookie
            $customerId = json_decode($_COOKIE["currentUser"], true);
            
            require_once("../connect_db.php");
            $conn = connect_mysql();

            // Query the user,customer table for the customer's info
            $sql = "SELECT * FROM Customer LEFT JOIN User ON Customer.customer_id = User.user_id WHERE Customer.customer_id = " . $customerId;
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
                    $phone = $row["phone"];
                    $street = $row["street"];
                    $city = $row["city"];
                    $zip_code = $row["zip_code"];
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
                <label for="phone">phone:</label>
                <input type="phone" id="phone" name="phone" value="<?php echo $phone ?>"><br><br>
                <label for="street">street:</label>
                <input type="street" id="street" name="street" value="<?php echo $street ?>"><br><br>
                <label for="city">city:</label>
                <input type="city" id="city" name="city" value="<?php echo $city ?>"><br><br>
                <label for="zip">zip:</label>
                <input type="zip" id="zip" name="zip" value="<?php echo $zip_code ?>"><br><br>
                <input type="submit" value="Save Changes">
            </form
        </div>

        <!-- Button to go back to the home page -->
        <button type="button" onclick="goToHome()">Back to Home</button>
        
        <script>
            function goToHome() {
                // Navigate back to the home page
                window.location.href = "home.php";
            }
        </script>
    </body>
</html>