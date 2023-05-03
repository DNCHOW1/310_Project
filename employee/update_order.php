<?php

        /*
                This code handles the logic for updating an order for an employee. This functionality makes it so that an employee can "serve"
                an order, which will update the status of an order as well as update the time_fufilled column in the database.

                This code was written by Dien Chau.
        */
        
        // Read in form data
        $orderId = $_POST['order_id'];
        $employeeId = json_decode($_COOKIE["currentUser"], true);

        // connect to database
        require_once("../connect_db.php");
        $conn = connect_mysql();


        try{
                // Update a given order_id so now it's "served"
                $updateSql = "UPDATE Checkout 
                                        SET 
                                                order_status = 1 ,
                                                employee_id = $employeeId
                                        WHERE order_id = $orderId";
                mysqli_query($conn, $updateSql);
            } catch (\Throwable $e) {
                // An exception thrown, rollback...
                $conn->rollback();
            
                throw $e; // handle exception
        }

        // Close connection
         mysqli_close($conn);

         header("Location: employee_home.php");
?>