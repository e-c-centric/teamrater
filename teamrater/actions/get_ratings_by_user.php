<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../settings/connection.php';

    $userid = $_GET['userid'] ?? '';

    if (empty($userid)) {
        echo json_encode(array('success' => false, 'message' => 'User ID is required'));
        exit;
    }

    $sql = "SELECT r.rating_value, c.criterianame, r.numberofraters
            FROM Ratings r
            INNER JOIN Criteria c ON r.criteriaid = c.criteriaid
            WHERE r.userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    $ratings_data = array();

    while ($row = $result->fetch_assoc()) {
        $ratings_data[] = array(
            'criterianame' => $row['criterianame'],
            'rating_value' => $row['rating_value'],
            'numberofraters' => $row['numberofraters']
        );
    }

    $stmt->close();

    echo json_encode(array('success' => true, 'ratings_data' => $ratings_data));

    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
