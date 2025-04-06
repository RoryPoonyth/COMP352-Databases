<?php 
include('header.php');
include('db_connect.php');
include('selectall.php');    // Include query logic for fetching Location and Team data
include('delete.php');       // Include delete logic for handling deletions

$ClubMemberResult =getClubMember($conn);
$FamilyMemberResult =getFamilyMember($conn);
$PersonnelResult = getPersonnel($conn);

?>

<link rel="stylesheet" href="../CSS Files/locations.css">
<div class="main-container">
    <!-- Displaying Club Members -->
    <div class="gallery-container">
        <h2>Club Members</h2>
        <button class="create-new-btn" onclick="openModal('modalClubMember')">Create New</button> <!-- Button to create new -->
        <!-- Error Handling Block -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message']) && strpos($_GET['message'], 'ErrorClubMember') !== false): ?>
            <p id="errorMessage" style="color: red;"><strong>Error:</strong> <?= $_GET['message'] ?></p>
            <script>
                // Set a timer to remove the error message after 10 seconds
                setTimeout(function() {
                    document.getElementById("errorMessage").textContent = ''; // Clear the message
                }, 5000); // 10000 milliseconds = 10 seconds
            </script>
        <?php endif; ?>
        <?php if ($ClubMemberResult->num_rows > 0): ?>
            <?php while ($row = $ClubMemberResult->fetch_assoc()): ?>
                <div class="gallery-item" id="ClubMember-<?= $row['club_member_number']; ?>">
                    <h3><?= $row['first_name'] . " " . $row['last_name']; ?></h3>
                    <p><strong>Club Member Number:</strong> <?= $row['club_member_number']; ?></p>
                    <p><strong>Date of Birth:</strong> <?= $row['birth_date']; ?></p>
                    <p><strong>Gender:</strong> <?= $row['gender']; ?></p>
                    <p><strong>Height:</strong> <?= $row['height']; ?> cm</p>
                    <p><strong>Weight:</strong> <?= $row['weight']; ?> kg</p>
                    <p><strong>SIN Number:</strong> <?= $row['sin_number']; ?></p>
                    <p><strong>Medicare Number:</strong> <?= $row['medicare_number']; ?></p>
                    <p><strong>Phone:</strong> <?= $row['telephone_number']; ?></p>
                    <p><strong>Address:</strong> <?= $row['address']; ?>, <?= $row['city']; ?>, <?= $row['province']; ?> <?= $row['postal_code']; ?></p>
                    <p><strong>Status:</strong> <?= $row['active_status'] ? 'Active' : 'Inactive'; ?></p>
                    <p><strong>Email:</strong> <a href="mailto:<?= $row['email_address']; ?>"><?= $row['email_address']; ?></a></p>
                    <a href="delete.php?delete=<?= $row['club_member_number']; ?>&type=club_member" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Club Member?')">Delete</a>
                    <button class="modify-btn" onclick='editClubMember(<?= json_encode($row) ?>)'>Modify</button>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No Club Members found.</p>
        <?php endif; ?>
    </div>

    <!-- Displaying Family Members -->
    <div class="gallery-container">
        <h2>Family Members</h2>
        <button class="create-new-btn" onclick="openModal('modalFamilyMember')">Create New</button> <!-- Button to create new -->
        <!-- Error Handling Block -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message']) && strpos($_GET['message'], 'ErrorFamilyMember') !== false): ?>
            <p id="errorMessage" style="color: red;"><strong>Error:</strong> <?= $_GET['message'] ?></p>
            <script>
                // Set a timer to remove the error message after 10 seconds
                setTimeout(function() {
                    document.getElementById("errorMessage").textContent = ''; // Clear the message
                }, 5000); // 10000 milliseconds = 10 seconds
            </script>
        <?php endif; ?>
        <?php if ($FamilyMemberResult->num_rows > 0): ?>
            <?php while ($row = $FamilyMemberResult->fetch_assoc()): ?>
                <div class="gallery-item" id="FamilyMember-<?= $row['family_member_id']; ?>">
                    <h3><?= $row['first_name'] . " " . $row['last_name']; ?></h3>
                    <p><strong>Family Member ID:</strong> <?= $row['family_member_id']; ?></p>
                    <p><strong>Date of Birth:</strong> <?= $row['birth_date']; ?></p>
                    <p><strong>SIN Number:</strong> <?= $row['sin_number']; ?></p>
                    <p><strong>Medicare Number:</strong> <?= $row['medicare_number']; ?></p>
                    <p><strong>Phone:</strong> <?= $row['telephone_number']; ?></p>
                    <p><strong>Address:</strong> <?= $row['address']; ?>, <?= $row['city']; ?>, <?= $row['province']; ?> <?= $row['postal_code']; ?></p>
                    <p><strong>Email:</strong> <a href="mailto:<?= $row['email_address']; ?>"><?= $row['email_address']; ?></a></p>
                    <a href="delete.php?delete=<?= $row['family_member_id']; ?>&type=family_member" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Family Member?')">Delete</a>
                    <button class="modify-btn" onclick='editFamily(<?= json_encode($row) ?>)'>Modify</button>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No Family Members found.</p>
        <?php endif; ?>
    </div>

    <!-- Displaying Personnel Members -->
    <div class="gallery-container">
        <h2>Personnel</h2>       
        <button class="create-new-btn" onclick="openModal('modalPersonnel')">Create New</button> <!-- Button to create new -->
        <!-- Error Handling Block -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message']) && strpos($_GET['message'], 'ErrorPersonnelCreation') !== false): ?>
            <p id="errorMessage" style="color: red;"><strong>Error:</strong> <?= $_GET['message'] ?></p>
            <script>
                // Set a timer to remove the error message after 10 seconds
                setTimeout(function() {
                    document.getElementById("errorMessage").textContent = ''; // Clear the message
                }, 5000); // 10000 milliseconds = 10 seconds
            </script>
        <?php endif; ?>
        <?php if ($PersonnelResult->num_rows > 0): ?>
            <?php while ($row = $PersonnelResult->fetch_assoc()): ?>
                <div class="gallery-item" id="Personnel-<?= $row['personnel_id']; ?>">
                    <h3><?= $row['first_name'] . " " . $row['last_name']; ?></h3>
                    <p><strong>Personnel ID:</strong> <?= $row['personnel_id']; ?></p>
                    <p><strong>Date of Birth:</strong> <?= $row['birth_date']; ?></p>
                    <p><strong>SIN Number:</strong> <?= $row['sin_number']; ?></p>
                    <p><strong>Medicare Number:</strong> <?= $row['medicare_number']; ?></p>
                    <p><strong>Phone:</strong> <?= $row['telephone_number']; ?></p>
                    <p><strong>Address:</strong> <?= $row['address']; ?>, <?= $row['city']; ?>, <?= $row['province']; ?> <?= $row['postal_code']; ?></p>
                    <p><strong>Email:</strong> <a href="mailto:<?= $row['email_address']; ?>"><?= $row['email_address']; ?></a></p>
                    <p><strong>Mandate:</strong> <?= $row['mandate']; ?></p>
                    <a href="delete.php?delete=<?= $row['personnel_id']; ?>&type=personnel" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Personnel Member?')">Delete</a>
                    <button class="modify-btn" onclick='editPersonnel(<?= json_encode($row) ?>)'>Modify</button>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No Personnel found.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Form (Hidden by default) -->
    <div id="modalClubMember" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalClubMember')">&times;</span>
            <h2 id="modalClubMemberHeader">Create Club Member</h2>
            <form action="add_club_member.php" method="POST">
                <label for="club_member_number">Club Member Number:</label>
                <input type="text" name="club_member_number" id="club_member_number" required><br>

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="club_first_name" required><br>
                
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="club_last_name"  required><br>
                
                <label for="birth_date">Birth Date:</label>
                <input type="date" name="birth_date" id="club_birth_date" required><br>

                <label for="gender">Gender:</label>
                <select name="gender" id="club_gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select><br>

                <label for="height">Height:</label>
                <input type="text" name="height" id="club_height" required><br>

                <label for="weight">Weight:</label>
                <input type="text" name="weight" id="club_weight" required><br>

                <label for="sin_number">SIN Number:</label>
                <input type="text" name="sin_number" id="club_sin" required><br>

                <label for="medicare_number">Medicare Number:</label>
                <input type="text" name="medicare_number" id="club_medicare_number" required><br>

                <label for="telephone_number">Telephone Number:</label>
                <input type="text" name="telephone_number" id="telephone_number"><br>

                <label for="address">Address:</label>
                <input type="text" name="address" id="club_address" required><br>

                <label for="city">City:</label>
                <input type="text" name="city" id="club_city" required><br>

                <label for="province">Province:</label>
                <input type="text" name="province" id="club_province"><br>

                <label for="postal_code">Postal Code:</label>
                <input type="text" name="postal_code" id="club_postal_code" required><br>

                <label for="active_status">Active Status:</label>
                <input type="text" name="active_status" id="club_active_status" required><br>

                <label for="email_address">Email:</label>
                <input type="text" name="email_address" id="club_email" required><br>

                <input type="submit" value="Save User">
            </form>
        </div>
    </div>

    <!-- Modal Form (Hidden by default) -->
    <div id="modalFamilyMember" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalFamilyMember')">&times;</span>
            <h2 id="modalFamilyMemberHeader">Create Family Member</h2>
            <form action="add_family_member.php" method="POST">                
                <label for="family_member_id">Family ID:</label>
                <input type="text" name="family_member_id" id="family_member_id" required><br>

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="family_first_name" required><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="family_last_name" required><br>

                <label for="birth_date">Birth Date:</label>
                <input type="date" name="birth_date" id="family_birth_date" required><br>

                <label for="sin_number">SIN Number:</label>
                <input type="text" name="sin_number" id="family_sin_number" required><br>

                <label for="medicare_number">Medicare Number:</label>
                <input type="text" name="medicare_number" id="family_medicare_number" required><br>

                <label for="telephone_number">Telephone Number:</label>
                <input type="text" name="telephone_number" id="family_telephone_number" ><br>

                <label for="address">Address:</label>
                <input type="text" name="address" id="family_address" required><br>

                <label for="email_address">Email:</label>
                <input type="email" name="email_address" id="family_email"required><br>

                <input type="submit" value="Save Family Member">
            </form>
        </div>
    </div>


    <!-- Modal Form (Hidden by default) -->
    <div id="modalPersonnel" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalPersonnel')">&times;</span>
            <h2 id="modalLocationsHeader">Create Personnel Member</h2>
            <form action="add_personnel.php" method="POST">
            
                <label for="personnel_id">Personnel IDe:</label>
                <input type="text" name="personnel_id" id="personnel_id" required><br>

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="personnel_first_name" required><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="personnel_last_name" required><br>

                <label for="birth_date">Birth Date:</label>
                <input type="date" name="birth_date" id="personnel_birth_date" required><br>

                <label for="sin_number">SIN Number:</label>
                <input type="text" name="sin_number" id="personnel_sin_number" required><br>

                <label for="medicare_number">Medicare Number:</label>
                <input type="text" name="medicare_number" id="personnel_medicare_number" required><br>

                <label for="telephone_number">Telephone Number:</label>
                <input type="text" name="telephone_number" id="personnel_telephone_number"><br>

                <label for="address">Address:</label>
                <input type="text" name="address" required id="personnel_address" ><br>

                <label for="city">City:</label>
                <input type="text" name="city" id="personnel_city" required><br>

                <label for="province">Province:</label>
                <input type="text" name="province" id="personnel_province"><br>

                <label for="postal_code">Postal Code:</label>
                <input type="text" name="postal_code" id="personnel_postal_code" required><br>

                <label for="email_address">Email:</label>
                <input type="email" name="email_address" id="personnel_email" required><br>

                <label for="mandate">Mandate:</label>
                <select name="mandate" id="personnel_mandate" required>
                    <option value="volunteer">Volunteer</option>
                    <option value="salaried">Salaried</option>
                </select><br>

                <input type="submit" value="Save Personnel Member">
            </form>
        </div>
    </div>


</div>

<script>
// Modal functionality
function openModal(type) {
    document.getElementById(type).style.display = "block";
}
function closeModal(type) {
    document.getElementById(type).style.display = "none";
}

// Function to open the modal and prefill the Club Member data
function editClubMember(clubData) {
    openModal('modalClubMember');
    // Set modal title to "Modify Club Member"
    document.getElementById("modalClubMemberHeader").textContent = `Modify Club Member: ${clubData.club_member_number}`;

    // Set form action (can be the same for both create and modify)
    document.querySelector("#modalClubMember form").action = "edit_club_member.php";

    // Fill out form fields with clubData
    document.getElementById("club_member_number").value = clubData.club_member_number;
    document.getElementById("club_first_name").value = clubData.first_name;
    document.getElementById("club_last_name").value = clubData.last_name;
    document.getElementById("club_birth_date").value = clubData.birth_date;
    document.getElementById("club_gender").value = clubData.gender;
    document.getElementById("club_height").value = clubData.height;
    document.getElementById("club_weight").value = clubData.weight;
    document.getElementById("club_sin").value = clubData.sin_number;
    document.getElementById("club_medicare_number").value = clubData.medicare_number;
    document.getElementById("telephone_number").value = clubData.telephone_number;
    document.getElementById("club_address").value = clubData.address;
    document.getElementById("club_city").value = clubData.city;
    document.getElementById("club_province").value = clubData.province;
    document.getElementById("club_postal_code").value = clubData.postal_code;
    document.getElementById("club_active_status").value = clubData.active_status ? 'Active' : 'Inactive';
    document.getElementById("club_email").value = clubData.email_address;
}

// Function to open the modal and prefill the Family Member data
function editFamily(familyData) {
    openModal('modalFamilyMember');
    // Set modal title to "Modify Family Member"
    document.getElementById("modalFamilyMemberHeader").textContent = `Modify Family Member: ${familyData.family_member_id}`;

    // Set form action (can be the same for both create and modify)
    document.querySelector("#modalFamilyMember form").action = "edit_family_member.php";

    // Fill out form fields with familyData
    document.getElementById("family_member_id").value = familyData.family_member_id;
    document.getElementById("family_first_name").value = familyData.first_name;
    document.getElementById("family_last_name").value = familyData.last_name;
    document.getElementById("family_birth_date").value = familyData.birth_date;
    document.getElementById("family_sin_number").value = familyData.sin_number;
    document.getElementById("family_medicare_number").value = familyData.medicare_number;
    document.getElementById("family_telephone_number").value = familyData.telephone_number;
    document.getElementById("family_address").value = familyData.address;
    document.getElementById("family_email").value = familyData.email_address;
}

// Function to open the modal and prefill the Personnel data
function editPersonnel(personnelData) {
    openModal('modalPersonnel');
    // Set modal title to "Modify Personnel"
    document.getElementById("modalLocationsHeader").textContent = `Modify Personnel: ${personnelData.personnel_id}`;

    // Set form action (can be the same for both create and modify)
    document.querySelector("#modalPersonnel form").action = "edit_personnel.php";

    // Fill out form fields with personnelData
    document.getElementById("personnel_id").value = personnelData.personnel_id;
    document.getElementById("personnel_first_name").value = personnelData.first_name;
    document.getElementById("personnel_last_name").value = personnelData.last_name;
    document.getElementById("personnel_birth_date").value = personnelData.birth_date;
    document.getElementById("personnel_sin_number").value = personnelData.sin_number;
    document.getElementById("personnel_medicare_number").value = personnelData.medicare_number;
    document.getElementById("personnel_telephone_number").value = personnelData.telephone_number;
    document.getElementById("personnel_address").value = personnelData.address;
    document.getElementById("personnel_city").value = personnelData.city;
    document.getElementById("personnel_province").value = personnelData.province;
    document.getElementById("personnel_postal_code").value = personnelData.postal_code;
    document.getElementById("personnel_email").value = personnelData.email_address;
    document.getElementById("personnel_mandate").value = personnelData.mandate;
}



</script>

<?php 
$conn->close();
include('footer.php'); 
?>
