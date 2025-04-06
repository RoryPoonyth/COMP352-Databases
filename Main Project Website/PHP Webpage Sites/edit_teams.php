<?php
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get the form values
        $team_id = $_POST['team_id'];
        $location_id = $_POST['location_id'];
        $team_name = $_POST['team_name'];
        $captain_pid = $_POST['captain_pid'];
        $gender = $_POST['gender'];


        // Prepare the SQL query to insert data into the "Session_Team" table
        $updateQuery = "UPDATE `Team` SET `location_id` = ?, `team_name` = ?,
            `captain_pid` = ?, `gender` = ? WHERE team_id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($updateQuery)) {
            // Bind the parameters
            // Data types for each field:
            // s = string, d = date (will be passed as string), i = integer, etc.
            $stmt->bind_param("isssi", $location_id, $team_name, $captain_pid, $gender, $team_id);

            // Execute the query
            if ($stmt->execute()) {
                // If successful, redirect back to family_members.php with a success message
                header("Location: locations.php?status=success&message=SuccessLocationCreation");
            } else {
                // If failed to execute, capture the error
                header("Location: locations.php?status=error&message=ErrorTeamCreation");
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Capture MySQL errors (like check constraints or other SQL issues)
        header("Location: locations.php?status=error&message=ErrorTeamCreation" . urlencode($e->getMessage()));
    } catch (Exception $e) {
        // Capture general errors
        header("Location: locations.php?status=error&message=ErrorTeamCreation" . urlencode($e->getMessage()));
    }
} else {
    // Redirect or handle non-POST requests here if needed
    header("Location: locations.php?status=error&message=" . urlencode('Invalid request method'));
}

// Close the statement and connection
$stmt->close();
?>
