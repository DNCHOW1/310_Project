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
        <?php 
            // How to get parameters from the query string
            // https://www.w3docs.com/snippets/php/get-url-query-string-parameters.html#:~:text=To%20get%20the%20query%20string,of%20the%20query%20string%20parameters.&text=Note%20that%20if%20the%20parameter,if%20a%20parameter%20is%20set.
            $customerId = json_decode($_COOKIE["currentUser"], true);

            require_once("../connect_db.php"); // importing function
            $conn = connect_mysql();

            $reviewSql = "SELECT * FROM `review` WHERE customer_id = '$customerId'";
            $reviewResult = mysqli_query($conn, $reviewSql);

            // Display all the review items. 
            while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                    echo "<p>Review Content: " . $reviewRow['review'] . "</p>";
                    echo "<p>Review Rating: " . $reviewRow['rating'] . "</p>";
                    echo "<p>Time Reviewed: " . $reviewRow['datetime'] . "</p>";
            }
            // Close connection
            mysqli_close($conn);
        ?>
</body>
</html>



