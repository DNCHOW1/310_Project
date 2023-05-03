<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the variables from the post request
    $name = $_POST["name"];
    $cc_number = $_POST["cc_number"];
    $cc_exp = date('Y-m-d', strtotime($_POST["cc_expiration"]));
    $cc_sec = $_POST["cc_security_code"];
    $paymentId = $_POST["final_payment_id"];

    require_once("../connect_db.php");
    $conn = connect_mysql();

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    try{
        // If the button that was clicked added/edited a payment option
        if (isset($_POST['add_payment'])) { // we are adding a new payment option for a given user
            if($paymentId == -1){
                $customerId = $_COOKIE["currentUser"];
                $paymentSql = "INSERT INTO Payment (customer_id, name, cc_number, expiration, security_code)
                                VALUES ('$customerId', '$name', '$cc_number', '$cc_exp', '$cc_sec')";
            } else{ // else, we update the payment option within the database,
                $paymentSql = "UPDATE Payment 
                                          SET 
                                            name = '$name',  
                                            cc_number = '$cc_number',
                                            expiration = '$cc_exp', 
                                            security_code = '$cc_sec'
                                          WHERE payment_id = '$paymentId'";
            }
            mysqli_query($conn, $paymentSql);
            echo "add";
    
        // If the button that was clicked deleted a payment option
        } elseif (isset($_POST['del_payment'])) {
            if($paymentId !== -1){ // We cannot delete a paymentId that doesn't exist
                $deleteSql = "DELETE FROM Payment WHERE payment_id = '$paymentId'";
                mysqli_query($conn, $deleteSql);
            }

            echo "delete";
        }
        mysqli_commit($conn);

        header("Location: payment_options.php");

    } catch (\Throwable $e) {
        // An exception thrown, rollback...
        $conn->rollback();
    
        throw $e; // handle exception
    
        // Close connection
        mysqli_close($conn);
    
        echo "An error has occurred...";
        echo "<p><a href=\"./edit_account.php\">Return to Edit Account Page</a></p>";
    }
}
?>