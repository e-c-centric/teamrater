<?php
// Set headers to return JSON data
header('Content-Type: application/json');

// Include database connection
require_once '../settings/connection.php';

// Check if the request method is POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve target user ID, criteria IDs, and values from request
    $target_userid = $_REQUEST['target_userid'] ?? '';
    $target_criteriaids = $_REQUEST['target_criteriaids'] ?? '';
    $values = $_REQUEST['values'] ?? '';

    // Validate input data
    if (empty($target_userid) || empty($target_criteriaids) || empty($values)) {
        echo json_encode(array('success' => false, 'message' => 'Target user ID, criteria IDs, and values are required'));
        exit;
    }

    // Convert comma-separated strings of criteria IDs and values to arrays
    $criteria_ids_array = explode(',', $target_criteriaids);
    $values_array = explode(',', $values);

    // Validate input arrays
    if (count($criteria_ids_array) !== count($values_array)) {
        // Return error JSON response if number of criteria IDs does not match number of values
        echo json_encode(array('success' => false, 'message' => 'Number of criteria IDs does not match number of values'));
        exit;
    }

    // Prepare SQL query to update ratings for the target user and criteria
    $sql_select = "SELECT currentsum, numberofraters FROM Ratings WHERE userid = ? AND criteriaid = ?";
    $sql_update = "UPDATE Ratings SET currentsum = ?, numberofraters = ?, rating_value = ROUND(currentsum / numberofraters, 2) WHERE userid = ? AND criteriaid = ?";
    $sql_insert = "INSERT INTO Ratings (userid, criteriaid, currentsum, numberofraters) VALUES (?, ?, ?, 1)";

    // Prepare statements
    $stmt_select = $conn->prepare($sql_select);
    $stmt_update = $conn->prepare($sql_update);
    $stmt_insert = $conn->prepare($sql_insert);

    // Bind parameters
    $stmt_select->bind_param("ii", $target_userid, $criteria_id);
    $stmt_update->bind_param("iiii", $new_sum, $new_raters, $target_userid, $criteria_id);
    $stmt_insert->bind_param("iii", $target_userid, $criteria_id, $value);

    // Execute statements for each criterion
    foreach ($criteria_ids_array as $index => $criteria_id) {
        $value = $values_array[$index];

        // Execute select statement
        $stmt_select->execute();
        $stmt_select->store_result();

        // Bind result variables
        $stmt_select->bind_result($current_sum, $current_raters);

        if ($stmt_select->fetch()) {
            // Update ratings if entry exists
            $new_sum = $current_sum + $value;
            $new_raters = $current_raters + 1;
            $stmt_update->execute();
        } else {
            // Insert new rating if entry does not exist
            $stmt_insert->execute();
        }
    }

    // Close statements
    $stmt_select->close();
    $stmt_update->close();
    $stmt_insert->close();

    // Return success JSON response
    echo json_encode(array('success' => true, 'message' => 'User rated successfully'));
} else {
    // Return error JSON response for invalid request method
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}

// Close database connection
$conn->close();
?>
