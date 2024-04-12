<?php
// Set headers to return JSON data
header('Content-Type: application/json');

// Include database connection
require_once '../settings/connection.php';

// Retrieve criteria ID from GET request
$criteriaid = $_GET['criteriaid'] ?? '';
$order = $_GET['order'] ?? '';

// Validate criteria ID
if (empty($criteriaid)) {
    echo json_encode(array('success' => false, 'message' => 'Criteria ID is required'));
    exit;
}

if ($order == 0) {
    $sql = "SELECT u.*, r.rating_value, r.numberofraters
            FROM User u
            LEFT JOIN Ratings r ON u.userid = r.userid AND r.criteriaid = ?
            ORDER BY r.rating_value DESC";
} else {
    $sql = "SELECT u.*, r.rating_value, r.numberofraters, c.criterianame
            FROM User u
            LEFT JOIN Ratings r ON u.userid = r.userid AND r.criteriaid = ?
            LEFT JOIN Criteria c ON r.criteriaid = c.criteriaid
            ORDER BY r.numberofraters DESC";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $criteriaid);
$stmt->execute();
$result = $stmt->get_result();

// Initialize array to store users data
$users_data = array();

// Fetch users data and add to array
while ($row = $result->fetch_assoc()) {
    $users_data[] = array(
        'userid' => $row['userid'],
        'fname' => $row['fname'],
        'middle_initial' => $row['middle_initial'] ?? "",
        'lname' => $row['lname'],
        'association' => $row['association'] ?? "",
        'rating_value' => $row['rating_value'] ?? "N/A",
        'numberofraters' => $row['numberofraters'] ?? 0
    );
}

// Return users data as JSON response
echo json_encode(array('success' => true, 'users_data' => $users_data));

// Close statement and database connection
$stmt->close();
$conn->close();
