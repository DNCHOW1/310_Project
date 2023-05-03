<!-- 
    This is the initial screen whenever someone navigates to the website. The person is greeted by a username and password,
    and should they not have one then they can either register as a customer or as an employee.

    Initial code was written by Dien Chau and Arjun Grover, but when the files were added to seperate folders and user types were
    established the rest was written by Dien Chau.

    This was done by Dien Chau and Arjun Grover.

 -->

<div id="login">
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
        <a href="/register/register.php"><button type="button">Register</button></a>
        <a href="/register/employee_register.php"><button type="button">Employee Register</button></a>
    </form>
</div>
