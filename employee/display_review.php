<!DOCTYPE html>
<html>
<head>
    <title>All Reviews</title>
</head>
<body>
    <h1>All Reviews</h1>
    <a href="employee_home.php">Home</a>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        <?php
        require_once("../connect_db.php");
        $conn = connect_mysql();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $review_id = $_POST['review_id'];
            $sql = "DELETE FROM Review WHERE Review.item_id= '$review_id'";
            mysqli_query($conn, $sql);
        }
        $sql = "SELECT r.item_id, item_name, review, rating FROM Review r JOIN Item i ON r.item_id = i.item_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['item_name']."</td>";
            echo "<td>".$row['review']."</td>";
            echo "<td>".$row['rating']."</td>";
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
