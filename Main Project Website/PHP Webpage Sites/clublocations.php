<?php 
include('header.php');
include('db_connect.php');

// Fetch locations
$locationQuery = "
    SELECT
        Location.LocationID,
        Location.Type,
        Location.Name,
        Location.Address,
        Location.City,
        Location.Province,
        Location.PostalCode,
        Location.PhoneNumber,
        Location.WebAddress,
        Location.MaxCapacity
    FROM Location
    ORDER BY Location.Province ASC, Location.City ASC;
";
$locationResult = $conn->query($locationQuery);
if (!$locationResult) {
    die("Error executing location query: " . $conn->error);
}

// Fetch family members and associated club members
$familyQuery = "
SELECT 
    fm.FirstName AS FamilyFirstName, 
    fm.LastName AS FamilyLastName, 
    fm.DateOfBirth AS FamilyBirthDate,
    fm.SocialSecurityNumber AS FamilySSN,
    fm.Address AS FamilyAddress,
    cm.MembershipNumber AS ClubMemberID,
    cm.FirstName AS ClubFirstName,
    cm.LastName AS ClubLastName,
    cm.DateOfBirth AS ClubBirthDate,
    cml.LocationID
FROM FamilyMember fm
JOIN FamilyMember_ClubMember fmc ON fm.SocialSecurityNumber = fmc.FamilyMemberSSN
JOIN ClubMember cm ON fmc.ClubMemberID = cm.MembershipNumber  
JOIN ClubMemberLocation cml ON cm.MembershipNumber = cml.ClubMemberMembershipNumber
WHERE cml.LocationID IS NOT NULL
ORDER BY fm.FirstName, fm.LastName;
";
$familyResult = $conn->query($familyQuery);
if (!$familyResult) {
    die("Error executing family query: " . $conn->error);
}

// Organize data by location and family members
$membersByLocation = [];
while ($row = $familyResult->fetch_assoc()) {
    $membersByLocation[$row['LocationID']][$row['FamilySSN']]['FamilyDetails'] = [
        'FirstName' => $row['FamilyFirstName'],
        'LastName' => $row['FamilyLastName'],
        'BirthDate' => $row['FamilyBirthDate'],
        'Address' => $row['FamilyAddress']
    ];
    $membersByLocation[$row['LocationID']][$row['FamilySSN']]['ClubMembers'][] = [
        'MembershipNumber' => $row['ClubMemberID'],
        'FirstName' => $row['ClubFirstName'],
        'LastName' => $row['ClubLastName'],
        'BirthDate' => $row['ClubBirthDate']
    ];
}
?>

<div class="main-container">
    <!-- Locations Section -->
    <div class="gallery-container">
        <h2>Locations</h2>
        <?php if ($locationResult->num_rows > 0): ?>
            <?php while ($row = $locationResult->fetch_assoc()): ?>
                <div class="gallery-item" id="location-<?= $row['LocationID']; ?>" onclick="showMembers(<?= $row['LocationID']; ?>)">
                    <h3><?= $row['Name']; ?></h3>
                    <p><strong>Branch ID:</strong> <?= $row['LocationID']; ?></p>
                    <p><strong>Type:</strong> <?= $row['Type']; ?></p>
                    <p><strong>Address:</strong> <?= $row['Address']; ?>, <?= $row['City']; ?>, <?= $row['Province']; ?> <?= $row['PostalCode']; ?></p>
                    <p><strong>Phone:</strong> <?= $row['PhoneNumber']; ?></p>
                    <p><strong>Web Address:</strong> <a href="<?= $row['WebAddress']; ?>" target="_blank"><?= $row['WebAddress']; ?></a></p>
                    <p><strong>Capacity:</strong> <?= $row['MaxCapacity']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No locations found.</p>
        <?php endif; ?>
    </div>

    <!-- Family Members Section -->
    <div class="gallery-container">
        <h2>Family Members</h2>
        <div id="family-members-container"></div>
    </div>

    <!-- Club Members Section -->
    <div class="gallery-container">
        <h2>Club Members</h2>
        <div id="club-members-container"></div>
    </div>
</div>

<script>
    var membersByLocation = <?= json_encode($membersByLocation); ?>;

    function showMembers(locationID) {
        document.querySelectorAll('.gallery-item').forEach(item => item.style.backgroundColor = '');
        var selectedLocation = document.getElementById('location-' + locationID);
        selectedLocation.style.backgroundColor = '#e0e0e0';

        var familyContainer = document.getElementById('family-members-container');
        var clubContainer = document.getElementById('club-members-container');
        familyContainer.innerHTML = '';
        clubContainer.innerHTML = ''; // Clear the club members container before displaying new data

        if (membersByLocation[locationID]) {
            Object.entries(membersByLocation[locationID]).forEach(([familySSN, familyData]) => {
                // Family Member Information
                var familyDiv = document.createElement('div');
                familyDiv.classList.add('family-item');
                familyDiv.setAttribute('onclick', `showClubMembers('${familySSN}', ${locationID}, this)`); // Attach click handler to the entire item
                familyDiv.innerHTML = `
                    <h3>${familyData.FamilyDetails.FirstName} ${familyData.FamilyDetails.LastName}</h3>
                    <p><strong>Birthday:</strong> ${familyData.FamilyDetails.BirthDate}</p>
                    <p><strong>Address:</strong> ${familyData.FamilyDetails.Address}</p>
                `;
                familyContainer.appendChild(familyDiv);
            });
        } else {
            familyContainer.innerHTML = '<p>No members found for this location.</p>';
        }
    }

    function showClubMembers(familySSN, locationID, familyElement) {
        // Highlight selected family member (whole item)
        document.querySelectorAll('.family-item').forEach(item => item.style.backgroundColor = '');
        familyElement.style.backgroundColor = '#e0e0e0'; // Same color as location selection

        var clubContainer = document.getElementById('club-members-container');
        clubContainer.innerHTML = ''; // Clear the club members container

        var familyData = membersByLocation[locationID][familySSN];
        if (familyData) {
            familyData.ClubMembers.forEach(member => {
                var clubDiv = document.createElement('div');
                clubDiv.classList.add('club-item');
                clubDiv.innerHTML = `
                    <h4>${member.FirstName} ${member.LastName}</h4>
                    <p><strong>Member ID:</strong> ${member.MembershipNumber}</p>
                    <p><strong>Birthday:</strong> ${member.BirthDate}</p>
                `;
                clubContainer.appendChild(clubDiv);
            });
        } else {
            clubContainer.innerHTML = '<p>No club members found for this family.</p>';
        }
    }
</script>

<?php 
$conn->close();
include('footer.php'); 
?>
