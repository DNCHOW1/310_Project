<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
</head>
<body>
    <h1>Add Review</h1>
    <form method="post" action="process_review.php"
        <label for="item_id">Item ID:</label>
        <input type="text" id="item_id" name="item_id" required><br>

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="5" cols="40" required></textarea><br>

        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>

        <input type="submit" value="Submit">
    </form>
</html>