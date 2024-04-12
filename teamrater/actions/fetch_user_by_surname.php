<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

$lname = $_GET['lname'] ?? '';

// Prepare SQL query to fetch users based on name parameters
$sql = "SELECT u.*, c.criterianame, c.description, r.rating_value, r.numberofraters
        FROM User u
        LEFT JOIN Ratings r ON u.userid = r.userid
        LEFT JOIN Criteria c ON r.criteriaid = c.criteriaid
        WHERE 1=1";

if (!empty($lname)) {
    $sql .= " AND u.lname = ?";
    // Prepare statement
    $stmt = $conn->prepare($sql);
    if (!empty($lname)) {
        $stmt->bind_param("s", $lname);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize array to store users data
    $users_data = array();

    // Check if there are any users in the database
    if ($result->num_rows > 0) {
        // Fetch users data and add to array
        while ($row = $result->fetch_assoc()) {
            $userid = $row['userid'];

            // Check if the user already exists in the users_data array
            if (!isset($users_data[$userid])) {
                // Add user details to users_data array
                $users_data[$userid] = array(
                    'userid' => $userid,
                    'fname' => $row['fname'],
                    'middle_initial' => $row['middle_initial'],
                    'lname' => $row['lname'],
                    'association' => $row['association'],
                    'ratings' => array()
                );
            }

            // Add rating details to ratings array for the user
            if (!empty($row['criterianame'])) {
                $users_data[$userid]['ratings'][] = array(
                    'criterianame' => $row['criterianame'],
                    'description' => $row['description'],
                    'rating_value' => $row['rating_value'],
                    'numberofraters' => $row['numberofraters']
                );
            }
        }

        // Return users data as JSON response
        echo json_encode(array('success' => true, 'users_data' => array_values($users_data)));
    } else {
        // No users found in the database
        echo json_encode(array('success' => false, 'message' => 'No users found'));
    }
} else {
    // No users found in the database
    echo json_encode(array('success' => false, 'message' => 'No users found'));
}

// Close statement and database connection
$stmt->close();
$conn->close();
