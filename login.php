
<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connect to MySQL database
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "310_pizza";
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query database to check if username and password match
    $sql = "SELECT * FROM User WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Login successful, redirect to homepage or dashboard
        while ($row = mysqli_fetch_assoc($result)) {
            setcookie("currentUser", $row['user_id'], time()+86400*1); // expire in 1 day
        }
        header("Location: home.php");
        exit();
    } else {
        // Login failed, display error message
        echo "Invalid username or password";
    }

    // Close connection
    mysqli_close($conn);
}
?>