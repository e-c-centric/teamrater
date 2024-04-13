<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $target_userid = $_REQUEST['target_userid'] ?? '';
    $target_criteriaids = $_REQUEST['target_criteriaids'] ?? '';
    $values = $_REQUEST['values'] ?? '';

    if (empty($target_userid) || empty($target_criteriaids) || empty($values)) {
        echo json_encode(array('success' => false, 'message' => 'Target user ID, criteria IDs, and values are required'));
        exit;
    }

    $criteria_ids_array = explode(',', $target_criteriaids);
    $values_array = explode(',', $values);

    if (count($criteria_ids_array) !== count($values_array)) {
        echo json_encode(array('success' => false, 'message' => 'Number of criteria IDs does not match number of values'));
        exit;
    }

    $sql_select = "SELECT currentsum, numberofraters FROM Ratings WHERE userid = ? AND criteriaid = ?";
    $sql_update = "UPDATE Ratings SET currentsum = ?, numberofraters = ?, rating_value = ROUND(currentsum / numberofraters, 2) WHERE userid = ? AND criteriaid = ?";
    $sql_insert = "INSERT INTO Ratings (userid, criteriaid, currentsum, numberofraters, rating_value) VALUES (?, ?, ?, 1, ?)";

    $stmt_select = $conn->prepare($sql_select);
    $stmt_update = $conn->prepare($sql_update);
    $stmt_insert = $conn->prepare($sql_insert);

    $stmt_select->bind_param("ii", $target_userid, $criteria_id);
    $stmt_update->bind_param("iiii", $new_sum, $new_raters, $target_userid, $criteria_id);
    $stmt_insert->bind_param("iiid", $target_userid, $criteria_id, $value, $value);

    foreach ($criteria_ids_array as $index => $criteria_id) {
        $value = $values_array[$index];
        $value = floatval($value);

        $stmt_select->execute();
        $stmt_select->store_result();

        $stmt_select->bind_result($current_sum, $current_raters);

        if ($stmt_select->fetch()) {
            $new_sum = $current_sum + $value;
            $new_raters = $current_raters + 1;
            $stmt_update->execute();
        } else {
            $stmt_insert->execute();
        }
    }

    $stmt_select->close();
    $stmt_update->close();
    $stmt_insert->close();

    echo json_encode(array('success' => true, 'message' => 'User rated successfully'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}

$conn->close();
?>
