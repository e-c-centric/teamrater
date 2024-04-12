<?php
// Set headers to return JSON data
header('Content-Type: application/json');

// Include database connection
require_once '../settings/connection.php';

// Initialize variables to store name parameters
$fname = $_GET['fname'] ?? '';
$lname = $_GET['lname'] ?? '';
$middle_initial = $_GET['middle_initial'] ?? '';

// Prepare SQL query to fetch users based on name parameters
$sql = "SELECT u.*, c.criterianame, c.description, r.rating_value, r.numberofraters
        FROM User u
        LEFT JOIN Ratings r ON u.userid = r.userid
        LEFT JOIN Criteria c ON r.criteriaid = c.criteriaid
        WHERE 1=1";

// Add conditions based on name parameters
if (!empty($fname) && !empty($lname) && !empty($middle_initial)) {
    // Search by first name, last name, and middle initial
    $sql .= " AND u.fname = ? AND u.lname = ? AND u.middle_initial = ?";
} elseif (!empty($fname) && !empty($lname)) {
    // Search by first name and last name
    $sql .= " AND u.fname = ? AND u.lname = ?";
} elseif (!empty($lname)) {
    // Search by last name only
    $sql .= " AND u.lname = ?";
}

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute query
if (!empty($fname) && !empty($lname) && !empty($middle_initial)) {
    $stmt->bind_param("sss", $fname, $lname, $middle_initial);
} elseif (!empty($fname) && !empty($lname)) {
    $stmt->bind_param("ss", $fname, $lname);
} elseif (!empty($lname)) {
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

// Close statement and database connection
$stmt->close();
$conn->close();
