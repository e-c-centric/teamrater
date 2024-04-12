<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../settings/connection.php';

    $fname = $_POST['fname'] ?? '';
    $middle_initial = $_POST['middle_initial'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $association = $_POST['association'] ?? '';

    if (empty($fname) || empty($lname)) {
        echo json_encode(array('success' => false, 'message' => 'First name and last name are required'));
        exit;
    }

    $sql_check_user = "SELECT userid FROM User WHERE fname = ? AND middle_initial = ? AND lname = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    $stmt_check_user->bind_param("sss", $fname, $middle_initial, $lname);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();

    if ($result_check_user->num_rows > 0) {
        echo json_encode(array('success' => true, 'message' => 'User already exists'));
    } else {
        $sql_insert_user = "INSERT INTO User (fname, middle_initial, lname, association) VALUES (?, ?, ?, ?)";
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("ssss", $fname, $middle_initial, $lname, $association);

        if ($stmt_insert_user->execute()) {
            echo json_encode(array('success' => true, 'message' => 'User registered successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to register user'));
        }

        $stmt_insert_user->close();
    }

    $stmt_check_user->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
