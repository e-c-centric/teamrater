<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../settings/connection.php';

    $full_name = $_POST['full_name'] ?? '';

    if (empty($full_name)) {
        echo json_encode(array('success' => false, 'message' => 'Full name is required'));
        exit;
    }

    $email = 'dummy@example.com';
    $password = 'dummy_password';

    $sql = "INSERT INTO User (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    if ($stmt->execute()) {
        $new_user_id = $stmt->insert_id;

        $sql_update_name = "UPDATE User SET full_name = ? WHERE userid = ?";
        $stmt_update_name = $conn->prepare($sql_update_name);
        $stmt_update_name->bind_param("si", $full_name, $new_user_id);
        $stmt_update_name->execute();

        $stmt_update_name->close();

        echo json_encode(array('success' => true, 'message' => 'New user added successfully'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to add new user'));
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
