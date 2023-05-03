<!DOCTYPE html>
<html>
<head>
    <title>Write Comment</title>
</head>
<body>
    <h1>Write Comment</h1>
    <a href="employee_home.php">Home</a>
    <?php
    require_once("../connect_db.php");
    $conn = connect_mysql();
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $item_id = $_GET['item_id'];
    //     $customer_id = $_GET['customer_id'];
    //     $comment = $_POST['comment'];
    //     $employee_id = json_decode($_COOKIE["currentUser"], true);
    //     $sql = "INSERT INTO EmployeeComment (item_id, customer_id, employee_id, comment) VALUES ('$item_id', '$customer_id', '$employee_id', '$comment')";
    //     mysqli_query($conn, $sql);
    //     echo "<p>Comment added successfully!</p>";
    // }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $item_id = $_GET['item_id'];
        $customer_id = $_GET['customer_id'];
        $comment = $_POST['comment'];
        $employee_id = json_decode($_COOKIE["currentUser"], true);
        // Check if review already exists for the given item
        $checkSql = "SELECT COUNT(*) as count FROM EmployeeComment WHERE customer_id = '$customer_id' AND item_id = '$item_id'";
        $checkResult = mysqli_query($conn, $checkSql);
        $row = mysqli_fetch_assoc($checkResult);
        $count = $row['count'];

        if ($count == 0) {
            // Insert new review into database
            $insertSql = "INSERT INTO EmployeeComment (item_id, customer_id, employee_id, comment) VALUES ('$item_id', '$customer_id', '$employee_id', '$comment')";
            mysqli_query($conn, $insertSql);
            echo "Comment added successfully.";
        } else {
            // Update existing review in database
            $updateSql = "UPDATE EmployeeComment SET comment='$comment', employee_id='$employee_id' WHERE item_id='$item_id' AND customer_id='$customer_id'";
            mysqli_query($conn, $updateSql);
            echo "Comment updated successfully.";
        }
        mysqli_close($conn);
    }

    ?>
    <form method="post">
        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment"></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
