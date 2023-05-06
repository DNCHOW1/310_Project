<!-- 
        Author: Ekdev Rajkitkul
        Functionality: The following file displays all the reviews for a given item by all customers,
        creates a page where every menu item is linked to.
 -->

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Reviews</title>
</head>
<body>
        <h1>Reviews</h1>
</body>
</html>

<?php 
        $itemId = $_GET['item_id']; // get the itemId parameter from the query string

        require_once("../connect_db.php");
        $conn = connect_mysql();

        // view all reviews within databbase using query
        $reviewSql = "SELECT * FROM `review_and_comment_view` WHERE item_id = '$itemId'";
        $reviewResult = mysqli_query($conn, $reviewSql);

        // display all the reviews and their attributes 
        while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                echo "<p>Review Content: " . $reviewRow['review'] . "</p>";
                echo "<p>Review Rating: " . $reviewRow['rating'] . "</p>";
                echo "<p>Time Reviewed: " . $reviewRow['review_date'] . "</p>";
                if ($reviewRow['employee_id'] != NULL){
                        echo "<p>Employee ID: " . $reviewRow['employee_id'] . "</p>";
                        echo "<p>Comment: " . $reviewRow['comment'] . "</p>";
                        echo "<p>Comment Date " . $reviewRow['comment_date'] . "</p>";
                }
                echo "<br>";
        }
        mysqli_close($conn);
?>
