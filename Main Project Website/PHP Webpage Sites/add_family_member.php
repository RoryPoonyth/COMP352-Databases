<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form values
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];  // Assuming the format 'YYYY-MM-DD'
        $sin_number = $_POST['sin_number'];
        $medicare_number = $_POST['medicare_number'];
        $telephone_number = $_POST['telephone_number'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal_code = $_POST['postal_code'];
        $email_address = $_POST['email_address'];

        // Check if deactivation_date is provided; if not, set it to NULL
        $deactivation_date = isset($_POST['deactivation_date']) && !empty($_POST['deactivation_date']) ? $_POST['deactivation_date'] : NULL;

        // Check if active_status is provided; default to 1 (active)
        $active_status = isset($_POST['active_status']) ? $_POST['active_status'] : 1; // Default to 1 (active)

        // Prepare the SQL query to insert data into the "FamilyMember" table
        $insertQuery = "INSERT INTO `FamilyMember` (
            `first_name`, `last_name`, `birth_date`, `sin_number`, `medicare_number`, 
            `telephone_number`, `address`, `city`, `province`, `postal_code`, 
            `email_address`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($insertQuery)) {
            // Bind the parameters
            // Data types for each field:
            // s = string, d = date (will be passed as string), i = integer, etc.
            $stmt->bind_param("ssssssssiss", $first_name, $last_name, $birth_date, 
                $sin_number, $medicare_number, $telephone_number, $address, $city,
                $province, $postal_code, $email_address);

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to family_members.php with a success message
                header("Location: people.php?status=success&message=SuccessFamilyMemberCreation");
            } else {
                // If failed to execute, capture the error
                header("Location: people.php?status=error&message=ErrorCreateFamilyMember.");
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Capture MySQL errors (like check constraints or other SQL issues)
        header("Location: people.php?status=error&message=ErrorFamilyMember" . urlencode($e->getMessage()));
    } catch (Exception $e) {
        // Capture general errors
        header("Location: people.php?status=error&message=ErrorFamilyMember" . urlencode($e->getMessage()));
    }
} else {
    // Redirect or handle non-POST requests here if needed
    header("Location: people.php?status=error&message=" . urlencode('Invalid request method'));
}

// Close the statement and connection
$stmt->close();
?>
