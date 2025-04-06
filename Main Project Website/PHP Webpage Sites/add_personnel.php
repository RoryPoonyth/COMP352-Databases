<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
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
        $mandate = $_POST['mandate'];

        // Prepare the SQL query to insert data into the "club_member" table
        $insertQuery = "INSERT INTO `Personnel` (
            `first_name`, `last_name`, `birth_date`,`sin_number`, `medicare_number`, 
            `telephone_number`, `address`, `city`, `province`, `postal_code`, 
            `email_address`, `mandate`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
        if ($stmt = $conn->prepare($insertQuery)) {
        // Bind the parameters
        // Data types for each field:
        // s = string, d = decimal, i = integer, b = blob, etc.
        $stmt->bind_param("ssssssssssss", $first_name, $last_name, $birth_date, $sin_number,
                $medicare_number, $telephone_number, $address, $city, $province, $postal_code, 
                $email_address, $mandate);

            // Execute the query

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to family_members.php with a success message
                header("Location: people.php?status=success&message=PersonnelCreation");
            } else {
                // If failed to execute, capture the error
                header("Location: people.php?status=error&message=ErrorPersonnelCreation.");
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Capture MySQL errors (like check constraints or other SQL issues)
        header("Location: people.php?status=error&message=ErrorPersonnelCreation" . urlencode($e->getMessage()));
    } catch (Exception $e) {
        // Capture general errors
        header("Location: people.php?status=error&message=ErrorPersonnelCreation" . urlencode($e->getMessage()));
    }
} else {
    // Redirect or handle non-POST requests here if needed
    header("Location: people.php?status=error&message=" . urlencode('Invalid request method'));
}

// Close the statement and connection
$stmt->close();
?>
