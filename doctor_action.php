<?php
    include_once("common_file.php");

    $response = ['status' => 'error', 'message' => 'Invalid request', 'errors' => []];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action == 'delete') {
            $id = $_POST['doctor_id'] ?? '';
            if (!empty($id)) {
                $data = ['deleted' => 1, 'updated_date_time' => $GLOBALS['create_date_time_label']];
                $res = $bf->UpdateSQL($GLOBALS['consultant_table'], $data, "consultant_id = ?", [$id]);
                if ($res !== false) {
                    echo json_encode(['status' => 'success', 'message' => 'Doctor deleted successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Unable to delete doctor']);
                }
            }
            exit;
        }

        $view_doctor_id = $_POST['view_doctor_id'] ?? '';
        $name = $_POST['name'] ?? '';
        $specialization = $_POST['specialization'] ?? '';
        $fees = $_POST['fees'] ?? '';
        $contact = $_POST['contact'] ?? '';

        // Validation
        $errors = [];
        $res = $valid->valid_name($name, 'Doctor Name');
        if ($res) $errors['name'] = $res;

        $res = $valid->common_validation($specialization, 'Specialization', 'text');
        if ($res) $errors['specialization'] = $res;

        $res = $valid->common_validation($fees, 'Consultation Fees', 'text');
        if ($res) $errors['fees'] = $res;

        $res = $valid->valid_mobile($contact, 'Contact Number');
        if ($res) $errors['contact'] = $res;

        if (empty($errors)) {
            $data = [
                'consultan_name' => $name,
                'consultant_specification' => $specialization,
                'consultant_fees' => $fees,
                'consultant_number' => $contact,
                'updated_date_time' => $GLOBALS['create_date_time_label']
            ];

            if (empty($view_doctor_id)) {
                // Insert
                $data['created_date_time'] = $GLOBALS['create_date_time_label'];
                $res = $bf->InsertSQL($GLOBALS['consultant_table'], $data, 'consultant_id');
                if (is_numeric($res)) {
                    $response = ['status' => 'success', 'message' => 'Doctor added successfully'];
                } else {
                    $response['message'] = $res;
                }
            } else {
                // Update
                $where = "consultant_id = ?";
                $res = $bf->UpdateSQL($GLOBALS['consultant_table'], $data, $where, [$view_doctor_id]);
                if ($res !== false) {
                    $response = ['status' => 'success', 'message' => 'Doctor details updated successfully'];
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
