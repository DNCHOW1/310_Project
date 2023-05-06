<!-- 
        Author: Ekdev Rajkitkul
        Functionality: This page holds buttons to both the create and delete review page, and displays
        all the reviews and associated attributes. Utilized SELECT command to access the customers
        own reviews. Additionally, it can can display the employee comments associated with the review
        underneath each review item
 -->

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Reviews</title>
</head>
<body>
        <h1>Reviews</h1>
        <a href="home.php">Home</a>
        <br><br>
        <!-- button for Create Review page -->
        <form action="process_review.php" method="get">
                <input type="submit" value="Create/Edit Review">
        </form>
        <!-- button for Delete Review page -->
        <form action="delete_review.php" method="get">
                <input type="submit" value="Delete Reviews">
        </form>
        <?php 
            $customerId = json_decode($_COOKIE["currentUser"], true);
            require_once("../connect_db.php"); // connect
            $conn = connect_mysql();
            // access customers own review
            $reviewSql = "SELECT
                                        i.item_name, r.review, r.rating, r.review_date, r.employee_id, r.comment, r.comment_date
                                   FROM `review_and_comment_view` r 
                                   LEFT JOIN Item i 
                                        ON r.item_id = i.item_id 
                                   WHERE customer_id = '$customerId'";
            $reviewResult = mysqli_query($conn, $reviewSql);

            // display all the reviews and attributes
            while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                    echo "<p>Review Item: " . $reviewRow['item_name'] . "</p>";
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
</body>
</html>



