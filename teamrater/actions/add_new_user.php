<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $fname = $_REQUEST['fname'] ?? '';
    $lname = $_REQUEST['lname'] ?? '';
    $association = $_REQUEST['association'] ?? '';
    $middle_initial = $_REQUEST['middle_initial'] ?? '';
    $target_criteriaids = $_REQUEST['target_criteriaids'] ?? '';
    $values = $_REQUEST['values'] ?? '';

    if (empty($target_criteriaids) || empty($values)) {
        echo json_encode(array('success' => false, 'message' => 'Target user ID, criteria IDs, and values are required'));
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO User (fname, lname, middle_initial, association) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $lname, $middle_initial, $association);

    if ($stmt->execute()) {
        echo json_encode(array('success' => true, 'userid' => $conn->insert_id));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to create user'));
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
