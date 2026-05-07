<?php
header('Content-Type: application/json');
require_once 'main/basic_functions.php';

$bf = new Basic_Functions();
$con = $bf->con;

$response = ['status' => 'error', 'message' => '', 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $response['errors']['login-username'] = "Enter the Username";
    }
    if (empty($password)) {
        $response['errors']['login-password'] = "Enter the Password";
    }

    if (empty($response['errors'])) {
        // Fetch user
        $stmt = $con->prepare("SELECT * FROM sc_user WHERE username = ? AND deleted = 0");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $response['errors']['login-username'] = "Incorrect username";
        } else {
            // Check password
            // Note: We use the same encode_decode to match what was stored during registration
            $encrypted_input = $bf->encode_decode('encrypt', $password);
            
            if ($user['password'] != $encrypted_input) {
                $response['errors']['login-password'] = "Password mismatch";
            } else {
                // Success
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['loginer_name'];
                $_SESSION['admin'] = $user['admin'];

                // Insert into login table
                $login_data = [
                    'login_date_time' => date('Y-m-d H:i:s'),
                    'user_id' => $user['id']
                ];
                $bf->InsertSQL('sc_login', $login_data, '', '', 'LOGIN');

                $response['status'] = 'success';
                $response['message'] = 'Login successful! Redirecting...';
            }
        }
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
