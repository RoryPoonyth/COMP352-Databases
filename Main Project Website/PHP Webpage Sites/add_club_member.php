<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
        // Get the form values
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birth_date = $_POST['birth_date'];  // Assuming the format 'YYYY-MM-DD'
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
        $deactivation_date = $_POST['deactivation_date'];  // Assuming the format 'YYYY-MM-DD' or NULL
        $email_address = $_POST['email_address'];

        // Prepare the SQL query to insert data into the "club_member" table
        $insertQuery = "INSERT INTO `ClubMember` (
            `first_name`, `last_name`, `birth_date`, `gender`, `height`, 
            `weight`, `sin_number`, `medicare_number`, `telephone_number`, 
            `address`, `city`, `province`, `postal_code`, `active_status`, 
            `deactivation_date`, `email_address`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
        if ($stmt = $conn->prepare($insertQuery)) {
        // Bind the parameters
        // Data types for each field:
        // s = string, d = decimal, i = integer, b = blob, etc.
        $stmt->bind_param("ssssddssssssssss", $first_name, $last_name, $birth_date, $gender, $height, 
                $weight, $sin_number, $medicare_number, $telephone_number, $address, $city, 
                $province, $postal_code, $active_status, $deactivation_date, $email_address);

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to people.php with a success message
                header("Location: people.php?status=success&message=SuccessClubMemberCreation");
            } else {
                // If failed to execute, capture the error
                header("Location: people.php?status=error&message=ErrorCreateClubMember". urlencode($e->getMessage()));
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
