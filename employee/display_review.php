<!-- 
    Author: Ekdev Rajkitkul
    Functionality: The following file creates a master page for the admin/employee to view all customers reviews,
    with each review yielding an action to delete their review (in case customer posts something inappropriate) or 
    attach an employee comment to their review. The write_comment page is attached within the websites page to click on
    to redirect admin/employees to write or update their comment. Utilized SELECT, DELETE, and review_and_comment views
    to execute the functionality, interact with the db, and display as shown. Can also filter based on rating (index)
 -->

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
    <form method="post">
        <label for="rating_filter">Filter by Rating:</label>
        <select id="rating_filter" name="rating_filter">
            <option value="all" selected>All Ratings</option>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
        <button type="submit">Apply Filter</button>
    </form>
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
        // delete functionality
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer_id']) ) {
            $customer_id = $_POST['customer_id'];
            $review_id = $_POST['review_id'];
            $sql = "DELETE FROM Review WHERE Review.item_id= '$review_id' AND Review.customer_id = '$customer_id'";
            mysqli_query($conn, $sql);
        }
        // rating filter via indices
        $rating_filter = isset($_POST['rating_filter']) ? $_POST['rating_filter'] : 'all';
        if ($rating_filter == 'all') {
            $sql = "SELECT r.item_id, r.customer_id, r.employee_id, review_date, comment, comment_date, item_name, review, rating FROM `review_and_comment_view` r JOIN Item i ON r.item_id = i.item_id";
        } else {
            $sql = "SELECT r.item_id, r.customer_id, r.employee_id, review_date, comment, comment_date, item_name, review, rating FROM `review_and_comment_view` r JOIN Item i ON r.item_id = i.item_id WHERE r.rating = $rating_filter";
        }

        // display master table
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
                        <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
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