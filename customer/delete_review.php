<!-- 
    Author: Ekdev Rajkitkul
    Functionality: This file allows customers to delete their review from the database 
    and website. It uses the SELECT and DELETE queries to display the items in which 
    the user has already reviewed and allow the user to delete it from the database.
 -->

<!DOCTYPE html>
<html>
<head>
    <title>Delete Review</title>
</head>
<body>
    <h1>Delete Review</h1>
    <a href="home.php">Home</a>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="item_id">Select item to delete:</label>
        <select id="item_id" name="item_id" required>
            <?php
            // get curr customer info
            $customer_id = json_decode($_COOKIE["currentUser"], true);
            // establish connection
            require_once("../connect_db.php");
            $conn = connect_mysql();
            // form query
            $sql = "SELECT r.item_id, item_name FROM Review r JOIN Item i ON r.item_id = i.item_id WHERE r.customer_id = '$customer_id'";
            $result = mysqli_query($conn, $sql);
            // populate
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>";
            }
            mysqli_close($conn);
            ?>
        </select><br>

        <input type="submit" value="Delete">
    </form>
</body>
</html>

<?php

require_once("../connect_db.php");
$conn = connect_mysql();

$customer_id = json_decode($_COOKIE["currentUser"], true);

// connection check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // item post
    $item_id = $_POST["item_id"];
    // delete review from database w/ query
    $deleteSql = "DELETE FROM Review WHERE customer_id = '$customer_id' AND item_id = '$item_id'";
    mysqli_query($conn, $deleteSql);
    mysqli_close($conn);
    header("Location: home.php");
    exit();
}
?>
