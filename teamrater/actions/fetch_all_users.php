<?php
// Set headers to return JSON data
header('Content-Type: application/json');

require_once '../settings/connection.php';

$fname = $_GET['fname'] ?? '';
$lname = $_GET['lname'] ?? '';
$middle_initial = $_GET['middle_initial'] ?? '';

$sql = "SELECT u.*, c.criterianame, c.description, r.rating_value, r.numberofraters
        FROM User u
        LEFT JOIN Ratings r ON u.userid = r.userid
        LEFT JOIN Criteria c ON r.criteriaid = c.criteriaid
        WHERE 1=1";

if (!empty($fname) && !empty($lname) && !empty($middle_initial)) {
    $sql .= " AND u.fname = ? AND u.lname = ? AND u.middle_initial = ?";
} elseif (!empty($fname) && !empty($lname)) {
    $sql .= " AND u.fname = ? AND u.lname = ?";
} elseif (!empty($lname)) {
    $sql .= " AND u.lname = ?";
}

$stmt = $conn->prepare($sql);

if (!empty($fname) && !empty($lname) && !empty($middle_initial)) {
    $stmt->bind_param("sss", $fname, $lname, $middle_initial);
} elseif (!empty($fname) && !empty($lname)) {
    $stmt->bind_param("ss", $fname, $lname);
} elseif (!empty($lname)) {
    $stmt->bind_param("s", $lname);
}

$stmt->execute();
$result = $stmt->get_result();

$users_data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['userid'];

        if (!isset($users_data[$userid])) {
            $users_data[$userid] = array(
                'userid' => $userid,
                'fname' => $row['fname'],
                'middle_initial' => $row['middle_initial'],
                'lname' => $row['lname'],
                'association' => $row['association'],
                'ratings' => array()
            );
        }

        if (!empty($row['criterianame'])) {
            $users_data[$userid]['ratings'][] = array(
                'criterianame' => $row['criterianame'],
                'description' => $row['description'],
                'rating_value' => $row['rating_value'],
                'numberofraters' => $row['numberofraters']
            );
        }
    }

    echo json_encode(array('success' => true, 'users_data' => array_values($users_data)));
} else {
    echo json_encode(array('success' => false, 'message' => 'No users found'));
}

$stmt->close();
$conn->close();
