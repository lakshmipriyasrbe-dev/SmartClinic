<?php
header('Content-Type: application/json');
require_once 'main/basic_functions.php';
require_once 'main/validation.php';

$bf = new Basic_Functions();
$con = $bf->con;
$val = new validation();

$response = ['status' => 'error', 'message' => '', 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    $errors = [];
    
    $err = $val->valid_name($name, "Full Name");
    if ($err) $errors['name'] = $err;

    $err = $val->valid_mobile($mobile, "Mobile Number");
    if ($err) $errors['mobile'] = $err;

    if (empty($username)) {
        $errors['username'] = "Enter the Username";
    } else {
        // Check if username exists
        $stmt = $con->prepare("SELECT id FROM sc_user WHERE username = ? AND deleted = 0");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors['username'] = "Username already exists";
        }
    }

    $err = $val->valid_password($password, "Password");
    if ($err) $errors['password'] = $err;

    if (empty($errors)) {
        $data = [
            'loginer_name' => $name,
            'user_mobile' => $mobile,
            'username' => $username,
            'password' => $bf->encode_decode('encrypt', $password),
            'created_date_time' => $GLOBALS['create_date_time_label'],
            'updated_date_time' => $GLOBALS['create_date_time_label'],
            'admin' => 1
        ];

        $insert_id = $bf->InsertSQL('sc_user', $data, 'user_id', '', 'REGISTER');

        if (is_numeric($insert_id)) {
            $response['status'] = 'success';
            $response['message'] = 'Registration successful! You are successfully registered.';
        } else {
            $response['message'] = $insert_id;
        }
    } else {
        $response['errors'] = $errors;
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
