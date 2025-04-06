<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form values
        $location_type = $_POST['location_type'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal_code = $_POST['postal_code'];
        $phone_number = $_POST['phone_number'];
        $web_address = $_POST['web_address'];
        $max_capacity = $_POST['max_capacity'];

        // Prepare the SQL query to insert data into the "Location" table
        $insertQuery = "INSERT INTO `Location` (
            `location_type`, `name`, `address`, `city`, `province`, `postal_code`, 
            `phone_number`,`web_address`,`max_capacity`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($insertQuery)) {
            // Bind the parameters
            // Data types for each field:
            // s = string, d = date (will be passed as string), i = integer, etc.
            $stmt->bind_param("ssssssssi", $location_type, $name, $address, $city,
                $province, $postal_code, $phone_number, $web_address, $max_capacity);

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to family_members.php with a success message
                header("Location: locations.php?status=success&message=SuccessLocationCreation");
            } else {
                // If failed to execute, capture the error
                header("Location: locations.php?status=error&message=ErrorLocationCreation");
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Capture MySQL errors (like check constraints or other SQL issues)
        header("Location: locations.php?status=error&message=ErrorLocation" . urlencode($e->getMessage()));
    } catch (Exception $e) {
        // Capture general errors
        header("Location: locations.php?status=error&message=ErrorLocation" . urlencode($e->getMessage()));
    }
} else {
    // Redirect or handle non-POST requests here if needed
    header("Location: locations.php?status=error&message=" . urlencode('Invalid request method'));
}

// Close the statement and connection
$stmt->close();
?>
