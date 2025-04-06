<?php
include('db_connect.php');

// Handle Delete Action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Determine which table to delete from
    if (isset($_GET['type']) && $_GET['type'] == 'club_member') {
        $deleteQuery = "DELETE FROM `iqc353_4`.`ClubMember` WHERE `club_member_number` = ?";
        $returnSite = "People: people.php";
    } elseif (isset($_GET['type']) && $_GET['type'] == 'family_member') {
        $deleteQuery = "DELETE FROM `iqc353_4`.`FamilyMember` WHERE `family_member_id` = ?";
        $returnSite = "People: people.php";
    } elseif (isset($_GET['type']) && $_GET['type'] == 'personnel') {
        $deleteQuery = "DELETE FROM `iqc353_4`.`Personnel` WHERE `personnel_id` = ?";
        $returnSite = "People: people.php";
    } elseif (isset($_GET['type']) && $_GET['type'] == 'location') {
        $deleteQuery = "DELETE FROM `iqc353_4`.`Location` WHERE `location_id` = ?";
        $returnSite = "Location: locations.php";
    } elseif (isset($_GET['type']) && $_GET['type'] == 'session_team') {
        $deleteQuery = "DELETE FROM `iqc353_4`.`Team` WHERE `team_id` = ?";
        $returnSite = "Location: locations.php";
    }


    if (isset($deleteQuery)) {
        // Prepare and execute the delete query
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: people.php?status=success&message=DeletionSucceded");
        } else {
            header("Location: people.php?status=error&message=DeletionFailed");
        }

        // Redirect back to avoid resubmitting the form on refresh
        header($returnSite);
        exit;
    }
}
?>
