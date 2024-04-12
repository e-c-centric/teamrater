<?php
header('Content-Type: application/json');


require_once '../settings/connection.php';
$notice = ['success' => false, 'message' => ''];
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pin = rand(1000, 9999);
    $message = "Your pin is: " . $pin;

    $sql = "INSERT INTO RegistrationTable (email, identifier) VALUES ('$email', '$pin')";
    $result = $conn->query($sql);

    if ($result) {
        $notice['success'] = true;
        $notice['message'] = $message;
    } else {
        $notice['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $notice['message'] = "Email is required";
}


echo json_encode($notice);
