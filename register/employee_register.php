<!-- 
This file is just a different login page for the employee. It uses all the attributes for the User table so it looks similar to "register.php",
but it also included a dropdown for whether the employee should be an admin or not.

This file was done by Dien Chau
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
        <select id="employee_admin_type" name="employee_type" required>
            <option value="0">Employee</option>
            <option value="1">Admin</option>
        </select><br><br>
        <input type="submit" value="Create User">
    </form>
</div>