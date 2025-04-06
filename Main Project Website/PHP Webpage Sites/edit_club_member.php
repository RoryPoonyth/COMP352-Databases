<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form values
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];  // Assuming the format 'YYYY-MM-DD
        $gender = $_POST['gender'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $sin_number = $_POST['sin_number'];
        $medicare_number = $_POST['medicare_number'];
        $telephone_number = $_POST['telephone_number'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal_code = $_POST['postal_code'];
        $active_status = $_POST['active_status'];  // 0 or 1 for active/inactive
        $email_address = $_POST['email_address'];
        $club_member_number = $_POST['club_member_number'];

        // Prepare the SQL query to update data in the "club_member" table
        $updateQuery = "UPDATE `ClubMember` SET 
            `first_name` = ?, 
            `last_name` = ?, 
            `birth_date` = ?, 
            `gender` = ?, 
            `height` = ?, 
            `weight` = ?, 
            `sin_number` = ?, 
            `medicare_number` = ?, 
            `telephone_number` = ?, 
            `address` = ?, 
            `city` = ?, 
            `province` = ?, 
            `postal_code` = ?, 
            `email_address` = ?, 
            `active_status` = ? 
        WHERE `club_member_number` = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($updateQuery)) {
            // Bind the parameters
            // Data types for each field:
            // s = string, d = decimal, i = integer, etc.
            $stmt->bind_param(
                "ssssssssssssssii",  // Adjusted data types
                $first_name, $last_name, $birth_date, $gender, $height, 
                $weight, $sin_number, $medicare_number, $telephone_number, 
                $address, $city, $province, $postal_code, $email_address, 
                $active_status, $club_member_number  // Note the correct order of parameters
            );

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to people.php with a success message
                header("Location: people.php?status=success&message=SuccessClubMemberEdit");
            } else {
                // If failed to execute, capture the error
                header("Location: people.php?status=error&message=ErrorCreateClubMember.");
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Capture MySQL errors (like check constraints or other SQL issues)
        header("Location: people.php?status=error&message=ErrorClubMember" . urlencode($e->getMessage()));
    } catch (Exception $e) {
        // Capture general errors
        header("Location: people.php?status=error&message=ErrorClubMember" . urlencode($e->getMessage()));
    }
} else {
    // Redirect or handle non-POST requests here if needed
    header("Location: people.php?status=error&message=" . urlencode($e->getMessage()));
}

// Close the statement and connection
$stmt->close();
?>
