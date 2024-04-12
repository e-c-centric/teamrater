<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');


include '../settings/connection.php';

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

$node_id = $data['node_id'] ?? '';
$sensors = $data['sensors'] ?? [];

registerNode($node_id, $conn);

$sensorIds = [];
foreach ($sensors as $sensor => $measurements) {
    foreach ($measurements as $measurement) {
        $sensorIds[$sensor][] = getReadingTypeId($measurement, $conn);
    }
}

header('Content-Type: application/json');
echo json_encode(['node_id' => $node_id, 'sensor_ids' => $sensorIds]);

function registerNode($node_id, $conn)
{
    $stmt = $conn->prepare("SELECT node_id FROM SensorNodes WHERE extra_details = ?");
    $stmt->bind_param("s", $node_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO SensorNodes (extra_details) VALUES (?)");
        $stmt->bind_param("s", $node_id);
        $stmt->execute();
    }
}

function getReadingTypeId($measurement, $conn)
{
    $stmt = $conn->prepare("SELECT reading_type_id FROM ReadingTypes WHERE reading_type = ?");
    $stmt->bind_param("s", $measurement);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['reading_type_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO ReadingTypes (reading_type) VALUES (?)");
        $stmt->bind_param("s", $measurement);
        $stmt->execute();
        $reading_type_id = $stmt->insert_id;

        return $reading_type_id;
    }
}
