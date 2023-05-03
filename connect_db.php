<?php 
        /*
            Seperating connecting to the database into another file and making it a function to reduce code. Initial connection code was
            written by Arjun Grover but the code was extracted and all files refactored by Dien Chau.

            This file was worked on by Dien Chau & Arjun Grover.
        */

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