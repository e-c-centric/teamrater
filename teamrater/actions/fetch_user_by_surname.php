<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

$lname = $_GET['lname'] ?? '';

$sql = "SELECT u.*, c.criterianame, c.description, r.rating_value, r.numberofraters
        FROM User u
        LEFT JOIN Ratings r ON u.userid = r.userid
        LEFT JOIN Criteria c ON r.criteriaid = c.criteriaid
        WHERE 1=1";

if (!empty($lname)) {
    $sql .= " AND u.lname = ?";
    $stmt = $conn->prepare($sql);
    if (!empty($lname)) {
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
} else {
    echo json_encode(array('success' => false, 'message' => 'No users found'));
}

$stmt->close();
$conn->close();
