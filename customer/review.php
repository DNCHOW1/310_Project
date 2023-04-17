<?php 
        // How to get parameters from the query string
        // https://www.w3docs.com/snippets/php/get-url-query-string-parameters.html#:~:text=To%20get%20the%20query%20string,of%20the%20query%20string%20parameters.&text=Note%20that%20if%20the%20parameter,if%20a%20parameter%20is%20set.
        $itemId = //TODO;

        require_once("../connect_db.php"); // importing function
        $conn = connect_mysql();

        $reviewSql = "SELECT * FROM Review WHERE item_id = '$itemId'";
        mysqli_query($conn, $reviewSql);

        // TODO: Display all the review items. 
        // Customer can add, edit, and delete only their own review
        // A customer can see all reviews for given item

        // Close connection
        mysqli_close($conn);
?>