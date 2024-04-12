<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include '../settings/connection.php';

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$node_id = $data['node_id'] ?? '';
$sensor_id = $data['sensor_id'] ?? '';
$reading_type_id = $data['reading_type_id'] ?? '';
$value = $data['value'] ?? '';

if (!empty($node_id) && !empty($sensor_id) && !empty($reading_type_id) && is_numeric($value)) {
    insertReading($node_id, $sensor_id, $reading_type_id, $value, $conn);
    echo json_encode(['success' => true, 'message' => 'Reading inserted successfully.']);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input. Please ensure all fields are correctly formatted.']);
}

function insertReading($node_id, $sensor_id, $reading_type_id, $value, $conn) {
    $stmt = $conn->prepare("INSERT INTO Readings (node_id, sensor_id, reading_type_id, value) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $node_id, $sensor_id, $reading_type_id, $value);
    $stmt->execute();
}
?>
