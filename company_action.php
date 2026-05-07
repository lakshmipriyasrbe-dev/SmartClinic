<?php
    include_once("common_file.php");

    $response = ['status' => 'error', 'message' => 'Invalid request', 'errors' => []];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $view_company_id = $_POST['view_company_id'] ?? '';
        $company_name = $_POST['company_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        // Validation
        $errors = [];
        $res = $valid->common_validation($company_name, 'Company Name', 'text');
        if ($res) $errors['company_name'] = $res;

        $res = $valid->common_validation($email, 'Email Address', 'text');
        if ($res) $errors['email'] = $res;

        $res = $valid->common_validation($address, 'Address', 'text');
        if ($res) $errors['address'] = $res;

        if (empty($errors)) {
            $data = [
                'company_name' => $company_name,
                'company_email' => $email,
                'company_address' => $address,
                'updated_date_time' => $GLOBALS['create_date_time_label']
            ];

            if (empty($view_company_id)) {
                // Insert
                $data['created_date_time'] = $GLOBALS['create_date_time_label'];
                $res = $bf->InsertSQL($GLOBALS['company_table'], $data, 'company_id');
                if (is_numeric($res)) {
                    $response = ['status' => 'success', 'message' => 'Company registered successfully'];
                } else {
                    $response['message'] = $res;
                }
            } else {
                // Update
                $where = "company_id = ?";
                $res = $bf->UpdateSQL($GLOBALS['company_table'], $data, $where, [$view_company_id]);
                if ($res !== false) {
                    $response = ['status' => 'success', 'message' => 'Company details updated successfully'];
                } else {
                    $response['message'] = 'Unable to update details';
                }
            }
        } else {
            $response['errors'] = $errors;
            $response['message'] = 'Please fix the errors below';
        }
    }

    echo json_encode($response);
?>
