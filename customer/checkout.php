<!-- 
This code is the checkout screen after a user has continued on from finalizing their cart. On this screen, a user will
be able to select a pre-existing payment option or create a new one. Additionally, they'll be able to choose the type of order they want, 
a delivery or takeout, as well as fill in the related attributes to that type. The results of this page will be forwarded to "process_order.php"

This code was done by Dien Chau, Syed Asad, and Arjun Grover (dropped).
 -->

<!DOCTYPE html>
<html>
<head>
	<title>Checkout - Pizza Express</title>
</head>
<body>
	<h1>Checkout</h1>
	
	<?php
		$finalPaymentId = -1;

		// Add radio button for each payment (Dien Chau + Syed Asad)
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
		
		// Query the "payment" table for the customer's payment info (Syed Asad + Dien Chau)
		$sql = "SELECT * FROM payment WHERE customer_id = $customerId";
		$result = mysqli_query($conn, $sql);
		
		createRadioButton(-1, "", "", "", "", "New Payment", TRUE); // create a "empty" payment_id option, should they choose to make new
		
		// Check for results
		if (mysqli_num_rows($result) > 0) {
			$index = 0;

			// Display the payment info and autofill the fields (Syed Asad + Dien Chau)
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
		
		// Query the "Customer" table for the customer's address info (Arjun)
		$sql_address = "SELECT * FROM Customer WHERE customer_id = " . $customerId;
		$result_address = mysqli_query($conn, $sql_address);
		
		// Check for results (Arjun)
		if (mysqli_num_rows($result_address) > 0) {
			// Fetch the address info and store it in variables
			while ($row_address = mysqli_fetch_assoc($result_address)) {
				$address = $row_address["street"];
				$city = $row_address["city"];
				// $state = $row_address["state"];
				$zip = $row_address["zip_code"];
			}
		} else {
			// Leave the fields blank
			$address = "";
			$city = "";
			$zip = "";
		}
		
		// Close the database connection
		mysqli_close($conn);
	?>
	
	<!-- Html below was joint effort by Dien and Arjun using code from Syed's payment_options page -->
	<form method="post" action="process_order.php">
	
		<label for="name">Name:</label>
		<input type="text" name="name" required><br>

		<label for="cc_number">Credit Card Number:</label>
		<input type="text" name="cc_number" required><br>

		<label for="cc_expiration">Expiration:</label>
		<input type="month" name="cc_expiration" required><br>

		<label for="cc_security_code">Security Code:</label>
		<input type="text" name="cc_security_code" required><br>


		<?php
			// forward the post request from cart->checkout so that cart->process_order is possible
			echo '<input type="hidden" name="cartItems" value="' . htmlentities(json_encode($_POST)) . '">';
			echo '<input type="hidden" name="final_payment_id" value="' . $finalPaymentId . '">';
		?>

		<label for="orderType">Order Type:</label>
		<select name="orderType" id="orderType" onchange="showFields()">
			<option value="pickup">Pickup</option>
			<option value="delivery">Delivery</option>
		</select><br>

		<div id="pickupFields" style="display: block;">
			<label for="pickupTime">Pickup Time:</label>
			<input type="time" name="pickupTime" required><br>
		</div>

		<div id="deliveryFields" style="display: none;">
			<label for="address">Address:</label>
			<input type="text" name="address" value="<?php echo $address; ?>" required><br>
			<label for="city">City:</label>
			<input type="text" name="city" value="<?php echo $city; ?>" required><br>
			<!-- <label for="state">State:</label>
			<input type="text" name="state" value="<?php echo $state; ?>" required><br> -->
			<label for="zip">ZIP Code:</label>
			<input type="text" name="zip" value="<?php echo $zip; ?>" required><br>
		</div>
		
		<input type="submit" value="Place Order"><br>

		<!-- Button to go back to the menu -->
		<button type="button" onclick="goToCart()">Back to Cart</button>
	
	</form>
	
	<script>
		function goToCart() {
			// Navigate back to the menu page
			window.location.href = "cart.php";
		}
		
		// Upon selecting a dropdown, will show either pickup options or takeout options (Dien + Arjun)
		function showFields() {
			let orderType = document.getElementById("orderType").value;
			let pickupFields = document.getElementById("pickupFields");
			let deliveryFields = document.getElementById("deliveryFields");
			const pickupTimeInput = document.getElementsByName('pickupTime')[0];
			const pickupTime = pickupTimeInput.value;

			if (orderType === "pickup") {
				pickupTimeInput.setAttribute("required", "");
				pickupFields.style.display = "block";
				deliveryFields.style.display = "none";
			} else if (orderType === "delivery") {
				pickupTimeInput.removeAttribute("required");
				pickupFields.style.display = "none";
				deliveryFields.style.display = "block";
			}
		}

		// Radio buttons for the payment options. If a new radio button is clicked it will update the values to forward to next page (Dien + Syed)
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