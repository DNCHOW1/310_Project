<!-- 
This file is just a different login page for the customer. It uses all the attributes for the User table so it looks similar to "employee_register.php",
but it also includes extra fields for attributes in Customer that employee wouldn't have.

This file was done by Dien Chau + Arjun Grover.
 -->

<div id="register">
    <h2>User Creation</h2>
    <form method="post" action="create_user.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name"><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        <label for="phone">phone:</label>
        <input type="phone" id="phone" name="phone"><br><br>
        <label for="street">street:</label>
        <input type="street" id="street" name="street"><br><br>
        <label for="city">city:</label>
        <input type="city" id="city" name="city"><br><br>
        <label for="zip">zip:</label>
        <input type="zip" id="zip" name="zip"><br><br>
        <input type="submit" value="Create User">
    </form>
</div>