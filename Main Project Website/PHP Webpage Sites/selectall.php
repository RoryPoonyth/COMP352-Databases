<?php
include('db_connect.php');
// Function to get locations
function getLocations($conn) {
    $LocationQuery = "SELECT `Location`.`location_id`,
                             `Location`.`location_type`,
                             `Location`.`name`,
                             `Location`.`address`,
                             `Location`.`city`,
                             `Location`.`province`,
                             `Location`.`postal_code`,
                             `Location`.`phone_number`,
                             `Location`.`web_address`,
                             `Location`.`max_capacity`
                      FROM `iqc353_4`.`Location`";
    $result = $conn->query($LocationQuery);  // Execute query
    return $result;  // Return the result to be used in the calling file
}

// Function to get teams
function getTeams($conn) {
    $TeamQuery = "SELECT `Team`.`team_id`,
                          `Team`.`team_name`,
                          `Team`.`location_id`,
                          `Team`.`gender`,
                          `Team`.`captain_pid`
                   FROM `iqc353_4`.`Team`";
    $result = $conn->query($TeamQuery);  // Execute query
    return $result;  // Return the result to be used in the calling file
}


// Query to fetch club member information
function getClubMember($conn) {
    $ClubMemberQuery = "SELECT `club_member_number`, `first_name`, `last_name`, `birth_date`, `gender`, `height`, `weight`, 
                    `sin_number`, `medicare_number`, `telephone_number`, `address`, `city`, `province`, `postal_code`, 
                    `active_status`, `deactivation_date`, `email_address` 
                    FROM `iqc353_4`.`ClubMember`";
    $result = $conn->query($ClubMemberQuery);  // Execute query
    return $result;  // Return the result to be used in the calling file
}

function getFamilyMember($conn) {

    // Query to fetch family member information
    $FamilyMemberQuery = "SELECT `family_member_id`, `first_name`, `last_name`, `birth_date`, `sin_number`, `medicare_number`, 
                        `telephone_number`, `address`, `city`, `province`, `postal_code`, `email_address`
                        FROM `iqc353_4`.`FamilyMember`";
    $result = $conn->query($FamilyMemberQuery);  // Execute query
    return $result;  // Return the result to be used in the calling fil
}
function getPersonnel($conn) {
    // Query to fetch personnel member information
    $PersonnelQuery = "SELECT `personnel_id`, `first_name`, `last_name`, `birth_date`, `sin_number`,  `medicare_number`, 
                        `telephone_number`, `address`, `city`, `province`, `postal_code`, `email_address`, 
                        `mandate`
                        FROM `iqc353_4`.`Personnel`;";
    $result = $conn->query($PersonnelQuery);  // Execute query
    return $result;  // Return the result to be used in the calling fil
}

// Fetch payments for a given member
function getPayments($memberID) {
    global $conn;
    $paymentQuery = "
        SELECT 
            PaymentDate, 
            Amount, 
            MembershipYear 
        FROM Payment
        WHERE ClubMemberID = $memberID
        ORDER BY PaymentDate ASC
    ";
    $paymentResult = $conn->query($paymentQuery);
    if (!$paymentResult) {
        die("Error executing payment query: " . $conn->error);
    }
    $payments = [];
    while ($payment = $paymentResult->fetch_assoc()) {
        $payments[] = $payment;
    }
    return $payments;
}

// Fetch member details for the given member ID
function getMemberDetails($memberID) {
    global $conn;
    $memberQuery = "
        SELECT 
            MembershipNumber, 
            FirstName, 
            LastName 
        FROM ClubMember
        WHERE MembershipNumber = $memberID
    ";
    $memberResult = $conn->query($memberQuery);
    if (!$memberResult) {
        die("Error executing member query: " . $conn->error);
    }
    return $memberResult->fetch_assoc();
}