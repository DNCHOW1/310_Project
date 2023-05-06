<!-- 
    Author: Ekdev Rajkitkul
    Functionality: This file formulated the create/edit review page so that customers can add or update
    a review from the database. It had created a form to allow users to fill out the attributes to their
    review and then utilized the SELECT, INSERT, and UPDATE commands to interact with the database. It
    also utilizes the user item view to populate the current customer's items ordered previously within
    the page's dropdown.
 -->

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
            // access current customer
            $customer_id = json_decode($_COOKIE["currentUser"], true);
            require_once("../connect_db.php");
            $conn = connect_mysql();
            
            // query utilizing view
            $sql = "SELECT item_id, item_name FROM user_item_view uiv WHERE uiv.customer_id = '$customer_id'";
            $result = mysqli_query($conn, $sql);

            // fetch item for dropdown
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

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // post form data
    $item_id = $_POST["item_id"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];

    // error check
    if (empty($item_id) || empty($review) || empty($rating)) {
        echo "Please fill out all required fields.";
    } else {
        // check if review already exists for the given item
        $checkSql = "SELECT COUNT(*) as count FROM Review WHERE customer_id = '$customer_id' AND item_id = '$item_id'";
        $checkResult = mysqli_query($conn, $checkSql);
        $row = mysqli_fetch_assoc($checkResult);
        $count = $row['count'];

        if ($count == 0) {
            // insert new review into database
            $insertSql = "INSERT INTO Review (customer_id, item_id, review, rating)
                              VALUES 
                                ('$customer_id', '$item_id', '$review', '$rating')
                             ";
            mysqli_query($conn, $insertSql);
            echo "Review added successfully.";
        } else {
            // update existing review in database
            $updateSql = "UPDATE Review SET review = '$review', rating = '$rating'
                              WHERE customer_id = '$customer_id' AND item_id = '$item_id'";
            mysqli_query($conn, $updateSql);
            echo "Review updated successfully.";
        }
    }
    mysqli_close($conn);
}

?>
