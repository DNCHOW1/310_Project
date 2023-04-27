<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
</head>
<body>
    <h1>Add Review</h1>
    <a href="home.php">Home</a>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="item_id">Item Name:</label>
        <select id="item_id" name="item_id" required>
            <?php
            $customer_id = json_decode($_COOKIE["currentUser"], true);
            require_once("../connect_db.php");
            $conn = connect_mysql();
            $sql = "SELECT item_id, item_name FROM user_item_view uiv WHERE uiv.customer_id = '$customer_id'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>";
            }
            mysqli_close($conn);
            ?>
        </select><br>

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="5" cols="40" required></textarea><br>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>

        <input type="submit" value="Submit">
    </form>
</html>

<?php

require_once("../connect_db.php");
$conn = connect_mysql();

$customer_id = json_decode($_COOKIE["currentUser"], true);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $item_id = $_POST["item_id"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];
    

    if (empty($item_id) || empty($review) || empty($rating)) {
        echo "Please fill out all required fields.";
    } else {
        // Insert review into database
        $upsertSql = "INSERT INTO Review (customer_id, item_id, review, rating)
                        VALUES ('$customer_id', '$item_id', '$review', '$rating')
                      ON DUPLICATE KEY UPDATE
                        review = '$review',
                        rating = '$rating'
                        ";
        mysqli_query($conn, $insertSql);
    }
    mysqli_close($conn);
}
?>
