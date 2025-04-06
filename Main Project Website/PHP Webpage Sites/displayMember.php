<?php
// Include the database connection file
include('db_connect.php');

// Fetch the latest member (assuming MembershipNumber is auto-incremented)
$query = "SELECT * FROM ClubMember ORDER BY MembershipNumber DESC LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if a member exists
$member = mysqli_fetch_assoc($result);

// Include the header
include('header.php');
?>

<div class="content">
    <h2>Member Details</h2>
    <?php if ($member): ?>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($member['FirstName']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($member['LastName']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($member['DateOfBirth']); ?></p>
        <p><strong>Height:</strong> <?php echo htmlspecialchars($member['Height']); ?> ft</p>
        <p><strong>Weight:</strong> <?php echo htmlspecialchars($member['Weight']); ?> lbs</p>
        <p><strong>Social Security Number:</strong> <?php echo htmlspecialchars($member['SocialSecurityNumber']); ?></p>
        <p><strong>Medicare Card Number:</strong> <?php echo htmlspecialchars($member['MedicareCardNumber']); ?></p>
        <p><strong>Telephone Number:</strong> <?php echo htmlspecialchars($member['TelephoneNumber']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($member['Address']); ?></p>
        <p><strong>City:</strong> <?php echo htmlspecialchars($member['City']); ?></p>
        <p><strong>Province:</strong> <?php echo htmlspecialchars($member['Province']); ?></p>
        <p><strong>Postal Code:</strong> <?php echo htmlspecialchars($member['PostalCode']); ?></p>
        <p><strong>Active Status:</strong> <?php echo $member['ActiveStatus'] ? 'Active' : 'Inactive'; ?></p>
    <?php else: ?>
        <p>No member found.</p>
    <?php endif; ?>
</div>

<?php
// Include the footer
include('footer.php');
?>