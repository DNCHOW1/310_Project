<!DOCTYPE html>
<html>
<head>
    <title>Employee Comment</title>
</head>
<body>
    <h1>Employee Comment</h1>
    <form method="post" action="submit_employee_comment.php">
        <label for="review_id">Review ID:</label>
        <input type="text" name="review_id" id="review_id"><br><br>
        <label for="comment">Comment:</label><br>
        <textarea name="comment" id="comment" rows="4" cols="50"></textarea><br><br>
        <button type="submit">Submit Comment</button>
    </form>
</body>
</html>

<?php
require_once("../connect_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = $_POST['review_id'];
    $comment = $_POST['comment'];
    $employee_id = 1; // replace with actual employee ID
    
    $conn = connect_mysql();
    $sql = "INSERT INTO employeecomment (customer_id, item_id, employee_id, comment) 
            SELECT customer_id, item_id, $employee_id, '$comment' 
            FROM Review WHERE Review.item_id = $review_id";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

header("Location: employee_home.php");
exit;
?>
