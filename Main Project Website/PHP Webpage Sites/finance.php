<?php 
include('header.php');
include('db_connect.php');

// Fetch all club members
$clubMembersQuery = "SELECT `club_member_number`, `first_name`, `last_name`, `birth_date`, `gender`, `height`, `weight`, 
                    `sin_number`, `medicare_number`, `telephone_number`, `address`, `city`, `province`, `postal_code`, 
                    `active_status`, `deactivation_date`, `email_address` 
                    FROM `iqc353_4`.`ClubMember`";

$clubMembersResult = $conn->query($clubMembersQuery);
if (!$clubMembersResult) {
    die("Error executing club members query: " . $conn->error);
}

// Fetch payments for a given member
function getPayments($memberID) {
    global $conn;
    $paymentQuery = "
        SELECT 
            payment_date, 
            payment_amount, 
            membership_year 
        FROM Payment
        WHERE club_member_number = $memberID
        ORDER BY payment_date ASC
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
            club_member_number, 
            first_name, 
            last_name
        FROM ClubMember
        WHERE club_member_number = $memberID
    ";
    $memberResult = $conn->query($memberQuery);
    if (!$memberResult) {
        die("Error executing member query: " . $conn->error);
    }
    return $memberResult->fetch_assoc();
}

// Get the year from the input
$year = isset($_GET['year']) ? $_GET['year'] : null;

// Fetch payment summary for the given year
function getPaymentSummary($year) {
    global $conn;
    $summaryQuery = "
        SELECT
          SUM(CASE
             WHEN payment_amount <= 100 THEN payment_amount
             ELSE 100
          END) AS TotalMembershipFees, 
          SUM(CASE
             WHEN payment_amount > 100 THEN payment_amount - 100
             ELSE 0
          END) AS TotalDonations
        FROM
          Payment
        WHERE membership_year = $year;
    ";
    $summaryResult = $conn->query($summaryQuery);
    if (!$summaryResult) {
        die("Error executing summary query: " . $conn->error);
    }
    return $summaryResult->fetch_assoc();
}

// Get the member ID from URL and fetch relevant data
$memberID = isset($_GET['memberID']) ? $_GET['memberID'] : null;
$memberDetails = $memberID ? getMemberDetails($memberID) : null;
$payments = $memberID ? getPayments($memberID) : [];
$paymentSummary = $year ? getPaymentSummary($year) : null;

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../CSS Files/fiannce.css">
    <script type="text/javascript">
        // JavaScript function to handle member selection
        function handleMemberClick(memberID, birthDate) {
            // Format the year from the member's birthdate
            var memberYear = new Date(birthDate).getFullYear();
            
            // Update the location (URL) without affecting the Year input box
            var currentUrl = window.location.href.split('?')[0];
            window.location.href = currentUrl + '?memberID=' + memberID + '&year=' + memberYear;
        }
    </script>
</head>
<body>

<div class="main-container">

    <!-- Year Input Form -->
    <div class="center-div">
        <div>
            <h2 class="center-text">Yearly Earnings</h2>
            <form method="GET" action="">
                <label for="year">Enter Year:</label>
                <input type="number" id="year" name="year" value="<?= $year ?>" required>
                <button type="submit">Show Payments</button>
            </form>
            <?php if ($paymentSummary && ($paymentSummary['TotalMembershipFees'] > 0 || $paymentSummary['TotalDonations'] > 0)): ?>
                <div>
                    <p><strong>Total Membership Fees:</strong> $<?= $paymentSummary['TotalMembershipFees']; ?></p>
                    <p><strong>Total Donations:</strong> $<?= $paymentSummary['TotalDonations']; ?></p>
                </div>
            <?php elseif ($year): ?>
                <div>
                    <p>No Payments for Given Year</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Club Members and Payments Section -->
    <div style="display: flex; width: 100%;">    

        <!-- Club Members Section -->
        <div class="gallery-container" style="flex: 1;">
            <h2>Club Members</h2>
            <?php if ($clubMembersResult->num_rows > 0): ?>
                <?php while ($row = $clubMembersResult->fetch_assoc()): ?>
                    <div class="gallery-item" id="member-<?= $row['club_member_number']; ?>" 
                    onclick="handleMemberClick(<?= $row['club_member_number']; ?>, '<?= $row['birth_date']; ?>')">
                        <h3><?= $row['first_name'] . ' ' . $row['last_name']; ?></h3>
                        <p><strong>Member ID:</strong> <?= $row['club_member_number']; ?></p>
                        <p><strong>Birthday:</strong> <?= $row['birth_date']; ?></p>
                        <p><strong>Address:</strong> <?= $row['address']; ?>, <?= $row['city']; ?>, <?= $row['province']; ?> <?= $row['postal_code']; ?></p>
                        <p><strong>Telephone:</strong> <?= $row['telephone_number']; ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No club members found.</p>
            <?php endif; ?>
        </div>

        <!-- Payments Section -->
        <div class="gallery-container" id="payments-container" style="flex: 1; display:flex;">
            <h2>Payments for Member: <span id="payments-name"><?= $memberDetails ? $memberDetails['first_name'] . ' ' . $memberDetails['last_name'] : 'Select a Member'; ?></span></h2>
            <div id="payments-gallery">
                <?php if ($memberID && $payments && count($payments) > 0): ?>
                    <!-- If a member is selected and there are payments -->
                    <?php foreach ($payments as $payment): ?>
                        <div class="gallery-item">
                            <p><strong>Payment Date:</strong> <?= $payment['payment_date']; ?></p>
                            <p><strong>Payment Amount:</strong> <?= $payment['payment_amount']; ?></p>
                            <p><strong>Membership Year:</strong> <?= $payment['membership_year']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($memberID): ?>
                    <!-- If a member is selected but there are no payments -->
                    <div class="gallery-item">No Payments Related to This Member</div>
                <?php else: ?>
                    <!-- If no member is selected -->
                    <div class="gallery-item">Select a member to view payments</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php 
include('footer.php'); 
?>

</body>
</html>
