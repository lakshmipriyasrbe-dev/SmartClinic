<?php
    include_once("common_file.php");

    $response = ['status' => 'error', 'message' => 'Invalid request', 'errors' => []];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action == 'update_status') {
            $id = $_POST['id'] ?? ''; // This is appointment_id
            $status = $_POST['status'] ?? '';
            
            if (!empty($id) && !empty($status)) {
                $data = ['status' => $status, 'updated_date_time' => $GLOBALS['create_date_time_label']];
                $res = $bf->UpdateSQL($GLOBALS['appointment_table'], $data, "appointment_id = ?", [$id]);
                if ($res !== false) {
                    $response = ['status' => 'success', 'message' => 'Status updated successfully'];
                } else {
                    $response['message'] = 'Unable to update status';
                }
            }
            echo json_encode($response);
            exit;
        }

        if ($action == 'cancel') {
            $id = $_POST['id'] ?? '';
            if (!empty($id)) {
                $data = ['deleted' => 1, 'updated_date_time' => $GLOBALS['create_date_time_label']];
                $res = $bf->UpdateSQL($GLOBALS['appointment_table'], $data, "appointment_id = ?", [$id]);
                if ($res !== false) {
                    $response = ['status' => 'success', 'message' => 'Appointment cancelled successfully'];
                } else {
                    $response['message'] = 'Unable to cancel appointment';
                }
            }
            echo json_encode($response);
            exit;
        }

        $doctor_id = $_POST['doctor_id'] ?? '';
        $appointment_date = $_POST['appointment_date'] ?? '';
        $patient_name = $_POST['patient_name'] ?? '';
        $patient_number = $_POST['patient_number'] ?? '';

        // Validation
        $errors = [];
        $res = $valid->common_validation($doctor_id, 'Doctor', 'select');
        if ($res) $errors['doctor_id'] = $res;

        $res = $valid->valid_datetime($appointment_date, 'Appointment Date & Time');
        if ($res) $errors['appointment_date'] = $res;

        $res = $valid->valid_name($patient_name, 'Patient Name');
        if ($res) $errors['patient_name'] = $res;

        if (empty($errors)) {
            // Fetch doctor details
            $stmt = $con->prepare("SELECT id, consultan_name, consultant_fees FROM " . $GLOBALS['consultant_table'] . " WHERE consultant_id = ?");
            $stmt->execute([$doctor_id]);
            $doctor = $stmt->fetch();
            
            if ($doctor) {
                // Check for double booking (comparing up to minutes)
                $stmt = $con->prepare("SELECT id FROM " . $GLOBALS['appointment_table'] . " WHERE consultant_id = ? AND DATE_FORMAT(appointment_date, '%Y-%m-%d %H:%i') = ? AND deleted = 0");
                $stmt->execute([$doctor_id, $appointment_date]);
                if ($stmt->fetch()) {
                    $response['message'] = 'This doctor is already booked for the selected time. Please choose another slot.';
                } else {
                    $data = [
                        'consultant_id' => $doctor_id, 
                        'consultan_name' => $doctor['consultan_name'],
                        'consultant_fees' => $doctor['consultant_fees'],
                        'appointment_date' => $appointment_date,
                        'patient_name' => $patient_name,
                        'patient_number' => $patient_number,
                        'status' => 'Confirmed',
                        'created_date_time' => $GLOBALS['create_date_time_label'],
                        'updated_date_time' => $GLOBALS['create_date_time_label']
                    ];

                    $res = $bf->InsertSQL($GLOBALS['appointment_table'], $data, 'appointment_id');
                    if (is_numeric($res)) {
                        $response = ['status' => 'success', 'message' => 'Appointment booked successfully'];
                    } else {
                        $response['message'] = $res;
                    }
                }
            } else {
                $response['message'] = 'Selected doctor not found';
            }
        } else {
            $response['errors'] = $errors;
            $response['message'] = 'Please fix the errors below';
        }
    }

    echo json_encode($response);
?>
