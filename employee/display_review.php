<!DOCTYPE html>
<html>
<head>
    <title>All Reviews</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>All Reviews</h1>
    <a href="employee_home.php">Home</a>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Create Comment</th>
            <th>Delete Review</th>
        </tr>
        <?php
        require_once("../connect_db.php");
        $conn = connect_mysql();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $review_id = $_POST['review_id'];
            $sql = "DELETE FROM Review WHERE Review.item_id= '$review_id'";
            mysqli_query($conn, $sql);
        }
        $sql = "SELECT r.item_id, r.customer_id, r.employee_id, review_date, comment, comment_date, item_name, review, rating FROM `review_and_comment_view` r JOIN Item i ON r.item_id = i.item_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['item_name']."</td>";
            echo "<td>".$row['review']."</td>";
            echo "<td>".$row['rating']."</td>";
            echo "<td>".$row['comment']."</td>";
            echo "<td>
                    <a href='comment_page.php?item_id=".$row['item_id']."&customer_id=".$row['customer_id']."'>Add/Edit Comment</a>
                  </td>";
            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='review_id' value='".$row['item_id']."'>
                        <button type='submit'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
