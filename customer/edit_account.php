<!-- 
    This file displays a page so that the user can edit their account. It utilizes a select statement to autopopulate the fields on the page.
    Whenever the user edits an item on the page and hits "Save Changes", it will call "update_info.php" to update in the database.
    This page also provides buttons to go to the "Payment Options" page where customers can see all their payment options,
    as well as a "Delete Account" button which calls "delete_acc.php" and will remove all of the user related data from the database.

    This file was done by Dien Chau.
 -->

<!DOCTYPE html>
<html>
    <body>
        <?php
            // Get the customer ID from cookie
            $customerId = json_decode($_COOKIE["currentUser"], true);
            
            // connect to the database
            require_once("../connect_db.php");
            $conn = connect_mysql();

            // Query the user,customer table for the customer's info
            $sql = "SELECT * FROM customer_view WHERE customer_id = " . $customerId;
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
            </form>
            <br>

            <!-- Button to go to the payment information for the given user -->
            <form method="post" action="payment_options.php">
                <input type="submit" value="Payment Options">
            </form>
            <br>

            <!-- Button to delete the account -->
            <form method="post" action="delete_acc.php">
                <input type="submit" value="Delete Account">
            </form>
            <br>
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