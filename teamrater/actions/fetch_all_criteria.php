<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

$sql = "SELECT * FROM Criteria";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $criteria_data = array();

    while ($row = $result->fetch_assoc()) {
        $criteria_data[] = $row;
    }

    echo json_encode(array('success' => true, 'criteria' => $criteria_data));
} else {
    echo json_encode(array('success' => false, 'message' => 'No criteria found'));
}

$conn->close();
?>
