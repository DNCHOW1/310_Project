<!-- 
This page is just the resulting page that denotes a successful order. When it is successful we want to also clear the cart
so that it is empty and consistent with the completed order. We also want to provide a method for user to go back to the home page.

This page was worked on by Dien Chau and Arjun Grover
 -->

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