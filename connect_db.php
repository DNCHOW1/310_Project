<?php 
        // Connect to the MySQL database
        function connect_mysql(){
            $host = "localhost";
            $user = "root";
            $password = "";
            $database = "310_pizza";
            $conn = mysqli_connect($host, $user, $password, $database);
            
            // Check for errors
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
                return NULL;
            }
            return $conn;
        }
?>