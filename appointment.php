<?php
    include_once("common_file.php");

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }

    $current_date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking | SmartClinic</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        /* Custom styling to match user's screenshot */
        .flatpickr-calendar {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            width: auto !important;
            display: flex !important;
            flex-direction: row !important;
            border-radius: 12px !important;
            overflow: hidden !important;
        }
        .flatpickr-innerContainer {
            border-right: 1px solid #f1f5f9;
            padding: 10px;
        }
        .flatpickr-time {
            height: auto !important;
            max-height: 320px !important;
            border-top: none !important;
            padding: 10px 0 !important;
            display: flex !important;
            flex-direction: column !important;
            width: 130px !important;
            background: #f8fafc !important;
        }
        .flatpickr-calendar.hasTime .flatpickr-time {
            height: 320px !important;
        }
        .flatpickr-time .flatpickr-am-pm, .flatpickr-time input {
            color: #1e293b !important;
        }
        .flatpickr-day {
            color: #475569 !important;
            border-radius: 8px !important;
        }
        .flatpickr-day.selected {
            background: #000000 !important;
            border-color: #000000 !important;
            color: #ffffff !important;
        }
        .flatpickr-day:hover {
            background: #f1f5f9 !important;
        }
        .flatpickr-months .flatpickr-month {
            color: #1e293b !important;
            fill: #1e293b !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-weight: 600 !important;
        }
        .flatpickr-weekday {
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <header class="top-header">
                <div class="page-title">
                    <h1>Appointments</h1>
                </div>
            </header>

            <div class="grid-container" style="grid-template-columns: 1fr 2fr;">
                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Book Appointment</h2>
                    </div>
                    <form name="appt_form" id="appt_form" onsubmit="event.preventDefault(); formSubmit('appt_form', 'appointment_action.php', 'appointment.php', 'appointment');">
                        <div class="form-group">
                            <label for="appt-doctor">Select Doctor</label>
                            <select id="appt-doctor" name="doctor_id" class="form-input" required>
                                <option value="">Choose a doctor...</option>
                                <?php
                                    $stmt = $con->prepare("SELECT id, consultant_id, consultan_name, consultant_specification FROM " . $GLOBALS['consultant_table'] . " WHERE deleted = 0 ORDER BY consultan_name ASC");
                                    $stmt->execute();
                                    $doctors = $stmt->fetchAll();
                                    foreach ($doctors as $doc) {
                                        echo "<option value='" . $doc['consultant_id'] . "'>" . $doc['consultan_name'] . " (" . $doc['consultant_specification'] . ")</option>";
                                    }
                                ?>
                            </select>
                            <span id="error-doctor_id" class="error-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="appt-datetime">Appointment Date & Time</label>
                            <input type="text" id="appt-datetime" name="appointment_date" class="form-input" placeholder="Select date and time..." required readonly>
                            <span id="error-appointment_date" class="error-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="appt-patient">Patient Name</label>
                            <input type="text" id="appt-patient" name="patient_name" class="form-input" placeholder="Full Name" onkeypress="return allowLettersOnly(event)" required>
                            <span id="error-patient_name" class="error-msg"></span>
                        </div>
                        
                        <div id="success-msg" class="success-msg hidden"></div>
                        
                        <button type="submit" class="btn-primary">Confirm Booking</button>
                    </form>
                </div>

                <div class="content-card">
                    <div class="content-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h2>Appointment Schedule</h2>
                        <a href="reports/appointment_report.php" target="_blank" class="status-badge status-attended" style="text-decoration: none; padding: 8px 16px;">Print Full Report</a>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 ORDER BY appointment_date DESC");
                                    $stmt->execute();
                                    $appointments = $stmt->fetchAll();
                                    $now = date('Y-m-d H:i:s');

                                    if ($appointments) {
                                        foreach ($appointments as $appt) {
                                            $status_class = "status-confirmed";
                                            $status_text = "Confirmed";
                                            
                                            // Status Logic
                                            if (isset($appt['status']) && $appt['status'] == 'Attended') {
                                                $status_class = "status-attended";
                                                $status_text = "Attended";
                                            } else if ($appt['appointment_date'] < $now) {
                                                $status_class = "status-expired";
                                                $status_text = "Expired";
                                            }

                                            echo "<tr>";
                                            echo "<td>" . $appt['patient_name'] . "</td>";
                                            echo "<td>" . $appt['consultan_name'] . "</td>";
                                            echo "<td>" . date('d-m-Y h:i A', strtotime($appt['appointment_date'])) . "</td>";
                                            echo "<td><span class='status-badge $status_class'>$status_text</span></td>";
                                            echo "<td>";
                                            if ($status_text == "Confirmed") {
                                                echo "<button class='status-badge status-attended' style='border:none; cursor:pointer; margin-right:5px;' onclick='updateStatus(\"" . $appt['appointment_id'] . "\", \"Attended\")'>Mark Attended</button>";
                                                echo "<button class='status-badge status-expired' style='border:none; cursor:pointer;' onclick='cancelAppointment(\"" . $appt['appointment_id'] . "\")'>Cancel</button>";
                                            } else if ($status_text == "Attended") {
                                                echo "<a href='reports/receipt.php?id=" . $appt['appointment_id'] . "' target='_blank' class='status-badge status-confirmed' style='text-decoration: none;'>Download Receipt</a>";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='text-align:center;'>No appointments scheduled</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="main/js/script.js"></script>
    <script src="main/js/keyboard_control.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#appt-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "F j, Y - h:i K",
            minDate: "today",
            time_24hr: false,
            inline: false, // Set to true if you want it always visible
            minuteIncrement: 30,
            onReady: function(selectedDates, dateStr, instance) {
                // You can add more custom behavior here to match the screenshot exactly
            }
        });

        function updateStatus(id, status) {
            if (confirm('Are you sure you want to mark this as ' + status + '?')) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);
                formData.append('action', 'update_status');

                fetch('appointment_action.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }

        function cancelAppointment(id) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('action', 'cancel');

                fetch('appointment_action.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
