<!DOCTYPE html>
<html>
<head>
	<title>Payment Options - Pizza Express</title>
</head>
<body>
	<h1>Payment Options</h1>
	
	<?php
		$finalPaymentId = -1;

		// Add radio button for each payment
		function createRadioButton($paymentId, $name, $cc_number, $cc_expiration, $cc_security_code, $label, $checked=FALSE){ 
			$paymentInfo = array(
				"payment_id" => $paymentId,
				"name" => $name,
				"cc_number" => $cc_number,
				"cc_expiration" => $cc_expiration,
				"cc_security_code" => $cc_security_code
			);
			$paymentInfoEncoded = htmlspecialchars(json_encode($paymentInfo), ENT_QUOTES, 'UTF-8');
			$id = $paymentId;
			$finalPaymentId = $paymentId;
			echo '<label for="' . $id . '">' . $label . '</label>';
			echo '<input type="radio" name="payment_id" id="' . $id . '"';
			if($checked) echo 'checked';
			echo ' data-payment-info="' . $paymentInfoEncoded . '"><br>';
		}		

		// Get the customer ID from a session variable or form data
        $customerId = json_decode($_COOKIE["currentUser"], true);
		
		require_once("../connect_db.php");
		$conn = connect_mysql();
		
		// Query the "payment" table for the customer's payment info
		$sql = "SELECT * FROM payment WHERE customer_id = $customerId";
		$result = mysqli_query($conn, $sql);
		
		createRadioButton(-1, "", "", "", "", "New Payment", TRUE); // create a "empty" payment_id option, should they choose to make new
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			$index = 0;

			// Display the payment info and autofill the fields
			while ($row = mysqli_fetch_assoc($result)) {
				$name = $row["name"];
				$cc_number = $row["cc_number"];
				$cc_expiration = date('Y-m', strtotime($row["expiration"]));
				$cc_security_code = $row["security_code"];
				$paymentId = $row["payment_id"];
				$label = "Payment Option " . ($index + 1);
				createRadioButton($paymentId, $name, $cc_number, $cc_expiration, $cc_security_code, $label, false);
				$index++;
			}
		} else {
			// Leave the fields blank
			$name = "";
			$cc_number = "";
			$cc_expiration = "";
			$cc_security_code = "";
			$paymentId = "";
		}
		
		// Close the database connection
		mysqli_close($conn);
	?>
	
	<form method="post" action="handle_payment_edit.php">
	
		<label for="name">Name:</label>
		<input type="text" name="name" required><br>

		<label for="cc_number">Credit Card Number:</label>
		<input type="text" name="cc_number" required><br>

		<label for="cc_expiration">Expiration:</label>
		<input type="month" name="cc_expiration" required><br>

		<label for="cc_security_code">Security Code:</label>
		<input type="text" name="cc_security_code" required><br>

        <?php echo '<input type="hidden" name="final_payment_id" value="' . $finalPaymentId . '">'; ?>

        <input type="submit" name="add_payment" value="Add/Update Payment">
        <input type="submit" name="del_payment" value="Delete Payment">
        <br>
		
        
	</form>

    <!-- Button to go back to edit-account -->
    <button type="button" onclick="goToAccount()">Back to Edit Account</button>
	
	<script>
		function goToAccount() {
			// Navigate back to the menu page
			window.location.href = "edit_account.php";
		}
		
		var paymentRadioButtons = document.getElementsByName("payment_id");
		for (var i = 0; i < paymentRadioButtons.length; i++) {
			paymentRadioButtons[i].addEventListener("change", function() {
				var paymentInfo = JSON.parse(this.getAttribute('data-payment-info'));
				document.getElementsByName("name")[0].value = paymentInfo.name;
				document.getElementsByName("cc_number")[0].value = paymentInfo.cc_number;
				document.getElementsByName("cc_expiration")[0].value = paymentInfo.cc_expiration;
				document.getElementsByName("cc_security_code")[0].value = paymentInfo.cc_security_code;
				document.getElementsByName('final_payment_id')[0].value = paymentInfo.payment_id;
			});
		}
	</script>
</body>
</html>