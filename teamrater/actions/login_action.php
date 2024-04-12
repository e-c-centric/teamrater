<?php
require_once '../settings/connection.php';
session_start();
$notice = "failure";
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pin = $_POST['pin'];

    $sql = "SELECT * FROM RegistrationTable WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            if ($row['identifier'] == $pin) {
                $notice = "success";
                $_SESSION['email'] = $email;
            } else {
                $notice = "Invalid email or pin";
            }
        }
    }
} else {
    $notice = "Email and pin are required";
}

echo $notice;
