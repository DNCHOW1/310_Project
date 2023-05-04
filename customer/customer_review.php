<!DOCTYPE html>
<html lang="en">
<head>
        <title>Reviews</title>
</head>
<body>
        <h1>Reviews</h1>
        <a href="home.php">Home</a>
        <br><br>
        <!-- Button for Create Review page -->
        <form action="process_review.php" method="get">
                <input type="submit" value="Create/Edit Review">
        </form>
        <form action="delete_review.php" method="get">
                <input type="submit" value="Delete Reviews">
        </form>
        <?php 
            // How to get parameters from the query string
            // https://www.w3docs.com/snippets/php/get-url-query-string-parameters.html#:~:text=To%20get%20the%20query%20string,of%20the%20query%20string%20parameters.&text=Note%20that%20if%20the%20parameter,if%20a%20parameter%20is%20set.
            $customerId = json_decode($_COOKIE["currentUser"], true);

            require_once("../connect_db.php"); // importing function
            $conn = connect_mysql();

            $reviewSql = "SELECT
                                        i.item_name, r.review, r.rating, r.review_date, r.employee_id, r.comment, r.comment_date
                                   FROM `review_and_comment_view` r 
                                   LEFT JOIN Item i 
                                        ON r.item_id = i.item_id 
                                   WHERE customer_id = '$customerId'";
            $reviewResult = mysqli_query($conn, $reviewSql);

            // Display all the review items. 
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
            // Close connection
            mysqli_close($conn);
        ?>
</body>
</html>



