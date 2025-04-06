<?php 
include('header.php');
include('db_connect.php');  // Include the database connection
include('selectall.php');    // Include query logic for fetching Location and Team data
include('delete.php');       // Include delete logic for handling deletions

// Fetch Locations and Teams from the database
$LocationResult = getLocations($conn);  // Pass $conn to getLocations
$TeamResult = getTeams($conn);          // Pass $conn to getTeams

?>

<link rel="stylesheet" href="../CSS Files/locations.css">
<div class="main-container">
    <!-- Displaying Locations -->
    <div class="gallery-container">
        <h2>Locations</h2>
        <button class="create-new-btn" onclick="openModal('modalLocations')">Create New</button> <!-- Button to create new -->
        <!-- Error Handling Block -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message']) && strpos($_GET['message'], 'ErrorLocationCreation') !== false): ?>
            <p id="errorMessage" style="color: red;"><strong>Error:</strong> <?= $_GET['message'] ?></p>
            <script>
                // Set a timer to remove the error message after 10 seconds
                setTimeout(function() {
                    document.getElementById("errorMessage").textContent = ''; // Clear the message
                }, 5000); // 10000 milliseconds = 10 seconds
            </script>
        <?php endif; ?>
        <?php if ($LocationResult->num_rows > 0): ?>
            <?php while ($row = $LocationResult->fetch_assoc()): ?>
                <div class="gallery-item" id="Location-<?= $row['location_id']; ?>">
                    <h3><?= $row['name']; ?></h3>
                    <p><strong>Location ID:</strong> <?= $row['location_id']; ?></p>
                    <p><strong>Location Type:</strong> <?= $row['location_type']; ?></p>
                    <p><strong>Address:</strong> <?= $row['address']; ?>, <?= $row['city']; ?>, <?= $row['province']; ?> <?= $row['postal_code']; ?></p>
                    <p><strong>Phone Number:</strong> <?= $row['phone_number']; ?></p>
                    <p><strong>Web Address:</strong> <a href="<?= $row['web_address']; ?>" target="_blank"><?= $row['web_address']; ?></a></p>
                    <p><strong>Max Capacity:</strong> <?= $row['max_capacity']; ?></p>
                    <!-- Delete button for Location -->
                    <a href="locations.php?delete=<?= $row['location_id']; ?>&type=location" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Location?')">Delete</a>
                    <button class="modify-btn" onclick='editLocation(<?= json_encode($row) ?>)'>Modify</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No Locations found.</p>
        <?php endif; ?>
    </div>

    <!-- Displaying Teams -->
    <div class="gallery-container">
        <h2>Teams</h2>
        <button class="create-new-btn" onclick="openModal('modalTeams')">Create New</button> <!-- Button to create new -->
        <!-- Error Handling Block -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'error' && isset($_GET['message']) && strpos($_GET['message'], 'ErrorTeamCreation') !== false): ?>
            <p id="errorMessage" style="color: red;"><strong>Error:</strong> <?= $_GET['message'] ?></p>
            <script>
                // Set a timer to remove the error message after 10 seconds
                setTimeout(function() {
                    document.getElementById("errorMessage").textContent = ''; // Clear the message
                }, 5000); // 10000 milliseconds = 10 seconds
            </script>
        <?php endif; ?>
        <?php if ($TeamResult->num_rows > 0): ?>
            <?php while ($row = $TeamResult->fetch_assoc()): ?>
                <div class="gallery-item" id="Team-<?= $row['team_id']; ?>)">
                    <h3><?= $row['team_name']; ?></h3>
                    <p><strong>Team ID:</strong> <?= $row['team_id']; ?></p>
                    <p><strong>Location ID:</strong> <?= $row['location_id']; ?></p>
                    <p><strong>Captain PID:</strong> <?= $row['captain_pid']; ?></p>
                    <p><strong>Gender:</strong> <?= $row['gender']; ?></p>
                    <!-- Delete button for Session Team -->
                    <a href="locations.php?delete=<?= $row['team_id']; ?>&type=session_team" class="delete-btn" onclick="return confirm('Are you sure you want to delete this Team?')">Delete</a>
                    <button class="modify-btn" onclick='editTeam(<?= json_encode($row) ?>)'>Modify</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No Teams found.</p>
        <?php endif; ?>
    </div>


        <!-- Modal Form (Hidden by default) -->
        <div id="modalLocations" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalLocations')">&times;</span>
            <h2 id="modalLocationsHeader">Create Location</h2>
            <form id="locationForm" action="add_locations.php" method="POST">
                <label for="location_id">Location ID:</label>
                <input type="text" name="location_id" id="location_id" required><br>
                
                <label for="location_type">Location Type:</label>
                <select name="location_type" id="location_type" required>
                    <option value="Head">Head</option>
                    <option value="Branch">Branch</option>
                </select><br>

                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required><br>

                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required><br>

                <label for="city">City:</label>
                <input type="text" name="city" id="city" required><br>

                <label for="province">Province:</label>
                <input type="text" name="province" id="province"><br>

                <label for="postal_code">Postal Code:</label>
                <input type="text" name="postal_code" id="postal_code" required><br>

                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number"><br>

                <label for="web_address">Web Address:</label>
                <input type="text" name="web_address" id="web_address" required><br>

                <label for="max_capacity">Max Capacity:</label>
                <input type="text" name="max_capacity" id="max_capacity"><br>

                <input type="submit" value="Save Location">
            </form>
        </div>
    </div>

    <!-- Modal Form (Hidden by default) -->
    <div id="modalTeams" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalTeams')">&times;</span>
            <h2 id ="modalTeamsHeader">Create Team</h2>

            <form id="teamForm" action="add_teams.php" method="POST">
                <label for="team_id">Team ID:</label>
                <input type="text" name="team_id" id="team_id" required><br>

                <label for="location_id">Location ID:</label>
                <input type="text" name="location_id" id="team_location_id" required><br>

                <label for="team_name">Team Name:</label>
                <input type="text" name="team_name" id="team_name" required><br>

                <label for="captain_pid">Captain Number:</label>
                <input type="text" name="captain_pid" id="captain_pid" required><br>

                <label for="gender">Team Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Boys">Boys</option>
                    <option value="Girls">Girls</option>
                </select><br>

                <input type="submit" value="Save Team">
            </form>
        </div>
    </div>

</div>

<script>
// Modal functionality
function openModal(type) {
    document.getElementById(type).style.display = "block";
    if (type === 'modalLocations') {
        document.getElementById("modalLocationsHeader").innerText = "Create Location";
        document.getElementById("locationForm").action = "add_locations.php";
        document.getElementById("location_id").value = "";
        document.getElementById("name").value = "";
        document.getElementById("address").value ="";
        document.getElementById("city").value = "";
        document.getElementById("province").value = "";
        document.getElementById("postal_code").value = "";
        document.getElementById("phone_number").value = "";
        document.getElementById("web_address").value = "";
        document.getElementById("max_capacity").value = "";
    } else {
        document.getElementById("modalTeamsHeader").innerText = "Create Team";
        document.getElementById("teamForm").action = "add_teams.php";
        document.getElementById("team_id").value = "";
        document.getElementById("team_location_id").value = "";
        document.getElementById("team_name").value = "";
        document.getElementById("captain_pid").value = "";
        document.getElementById("gender").value ="";
    }
}
function closeModal(type) {
    document.getElementById(type).style.display = "none";
}

function editTeam(teamData) {
    openModal('modalTeams');
    // Set modal title to "Modify Location"
    document.getElementById("modalTeamsHeader").textContent = `Modify Team: ${teamData.team_id}`;

    // Set form action (you can have one endpoint for both create/modify logic)
    document.getElementById("teamForm").action = "edit_teams.php";

    // Fill out form fields with locationData
    document.getElementById("team_id").value = teamData.team_id;
    document.getElementById("team_location_id").value = teamData.location_id;
    document.getElementById("team_name").value = teamData.team_name;
    document.getElementById("captain_pid").value = teamData.captain_pid;
    document.getElementById("gender").value = teamData.gender;
}


function editLocation(locationData) {
    openModal('modalLocations');
    // Set modal title to "Modify Location"
    document.getElementById("modalLocationsHeader").textContent = `Modify Location: ${locationData.location_id}`;

    // Set form action (you can have one endpoint for both create/modify logic)
    document.getElementById("locationForm").action = "edit_locations.php";

    // Fill out form fields with locationData
    document.getElementById("location_id").value = locationData.location_id;
    document.getElementById("name").value = locationData.name;
    document.getElementById("address").value = locationData.address;
    document.getElementById("city").value = locationData.city;
    document.getElementById("province").value = locationData.province;
    document.getElementById("postal_code").value = locationData.postal_code;
    document.getElementById("phone_number").value = locationData.phone_number;
    document.getElementById("web_address").value = locationData.web_address;
    document.getElementById("max_capacity").value = locationData.max_capacity;

    // Set the dropdown value
    document.getElementById("location_type").value = locationData.location_type;

    // Open the modal
}



</script>


<?php 
// Now call the function to close the connection at the end of the script
$conn->close();
include('footer.php'); 
?>
