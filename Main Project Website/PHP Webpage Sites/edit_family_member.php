<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form values
        $family_member_id = $_POST['family_member_id'];
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

        // Prepare the SQL query to insert data into the "FamilyMember" table
        $updateQuery = "UPDATE `FamilyMember` SET
        `first_name` = ?, `last_name` = ?, `birth_date` = ?, `sin_number` = ?, `medicare_number` = ?, 
        `telephone_number` = ?, `address` = ?, `city` = ?, `province` = ?, `postal_code` = ?, 
        `email_address` = ? WHERE `family_member_id` = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($updateQuery)) {
            // Bind the parameters
            // Data types for each field:
            // s = string, d = date (will be passed as string), i = integer, etc.
            $stmt->bind_param("ssssssssissi", $first_name, $last_name, $birth_date, 
                $sin_number, $medicare_number, $telephone_number, $address, $city,
                $province, $postal_code, $email_address, $family_member_id);

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to family_members.php with a success message
                header("Location: people.php?status=success&message=SuccessFamilyMemberEdit");
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
