<?php
require("header.php"); // Include the header file

session_start(); // Start the session

$user_id = $_SESSION['user_id']; // Get the ID of the logged-in user from the session

$mysqli = new mysqli("localhost", "root", "", "adb_login"); // Connect to the database

if ($mysqli->connect_error) {
    die("Connection lost: " . $mysqli->connect_error); // Display an error message in case of connection failure
}

$query = "SELECT * FROM adds WHERE id_users = ?"; // SQL query to retrieve data of the logged-in user
$stmt = $mysqli->prepare($query); // Prepare the SQL query

if ($stmt) {
    $stmt->bind_param("i", $user_id); // Bind values and execute the prepared query
    $stmt->execute();

    $result = $stmt->get_result(); // Get the query results

    if ($result->num_rows > 0) { // Check if there are any result rows
        // Display data in an HTML table if there are results
        echo '<div class="lC_tList">
                <table>
                <thead>
                    <tr>
                        <th>LastName</th>
                        <th>Firstname</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Address</th>
                        <th>Notes</th>
                        <th>Modify</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="colorInt">';

        while ($row = $result->fetch_assoc()) { // Loop through each result row
            echo '<tr>';
            echo '<td>' . $row["lastname"] . '</td>'; // Display data in each table column
            echo '<td>' . $row["firstname"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["phone"] . '</td>';
            echo '<td>' . $row["address"] . '</td>';
            echo '<td>' . $row["notes"] . '</td>'; // Display the notes field
            echo '<td><a href="editContact.php?id=' . $row["id"] . '" class="lC_bModify">Modify</a></td>';

            echo '<td>
                <form action="delContact.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this contact?\')">
                    <input type="hidden" name="delete_user" value="' . $row["id"] . '">
                    <button type="submit" name="Contact" class="lC_bDel">Delete</button>
                </form>
            </td>';
            echo '</tr>';
        }

        echo '</tbody></table></div>'; // Close the table
    } else {
        echo '<div class="table-style lC_tEmp">
        <h2 class="lC_hEmp">Table empty</h2>
        </div>'; // Display a message if the table is empty
    }

    $stmt->close(); // Close the prepared statement
} else {
    echo "Error in preparing the query."; // Display a message in case of query preparation error
}

// Display buttons to create a contact, import CSV, and disconnect
echo '<div class="button-container">';
echo '<form action="adds.php" method="GET">';
echo '<button type="submit" name="viewAdds" value="viewAdds" class="lC_bCreate">Create Contact</button>';
echo '</form>';
echo '<form action="impCsv.php" method="GET">';
echo '<button type="submit" name="impCsv" value="impCsv" class="lC_bImp">Import Csv</button>';
echo '</form>';
echo '<form action="logout_user.php" method="POST">';
echo '<button type="submit" name="bDisconnect" value="bDisconnect" class="lC_bDisc">Disconnect</button>';
echo '</form>';
echo '</div>';

// Handle user logout if the session indicates a logout request
if (isset($_SESSION['bDisconnect'])) {
    session_unset(); // Unset session data
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the home page
    exit();
}

$mysqli->close(); // Close the database connection
require_once("footer.php"); // Include the footer file
?>