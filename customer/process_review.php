<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
</head>
<body>
    <h1>Add Review</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="item_id">Item ID:</label>
        <input type="text" id="item_id" name="item_id" required><br>

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="5" cols="40" required></textarea><br>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>

        <input type="submit" value="Submit">
    </form>
</html>

<?php

require_once("../connect_db.php");
$conn = mysqli_connect();

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
        $insertSql = "INSERT INTO Review (customer_id, item_id, review, rating)
                      VALUES ('$customer_id', '$item_id', '$review', '$rating')";
        // $stmt = mysqli_prepare($conn, "INSERT INTO Review (`customer_id`, `item_id`, `review`, `rating`) VALUES (?, ?, ?, ?)");
        // mysqli_stmt_bind_param($stmt, "iisi", $customer_id, $item_id, $review, $rating);
        // if (mysqli_stmt_execute($stmt)) {
        //     echo "Review added successfully.";
        // } else {
        //     echo "Error adding review: " . mysqli_stmt_error($stmt);
        // }
        // mysqli_stmt_close($stmt);
        mysqli_query($conn, $insertSql);
    }
    mysqli_close($conn);
}
?>