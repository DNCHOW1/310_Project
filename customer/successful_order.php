<!DOCTYPE html>
<html>
<head>
    <title>New Order Created</title>
</head>
<body>
    <?php
        // Delete the cart cookie, as we've used it already
        setcookie("cartItems", NULL, time() - 180000000000, "/");

    ?>
    <h2>New Order Successfully Created</h2>
    <p>Yummy!</p>
    <p><a href="home.php">Return to Home Page</a></p>
</body>
</html>