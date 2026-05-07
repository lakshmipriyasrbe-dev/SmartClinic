<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking | SmartClinic</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <form action="appointment.php" method="POST">
                        <div class="form-group">
                            <label for="appt-doctor">Select Doctor</label>
                            <select id="appt-doctor" name="doctor_id" class="form-input" required>
                                <option value="">Choose a doctor...</option>
                                <option value="1">Dr. Sarah Johnson (Pediatrics)</option>
                                <option value="2">Dr. Mark Williams (Dermatology)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appt-date">Date</label>
                            <input type="date" id="appt-date" name="date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="appt-time">Time Slot</label>
                            <select id="appt-time" name="time_slot" class="form-input" required>
                                <option value="">Select slot...</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appt-patient">Patient Name</label>
                            <input type="text" id="appt-patient" name="patient_name" class="form-input" placeholder="Full Name" required>
                        </div>
                        <button type="submit" class="btn-primary">Confirm Booking</button>
                    </form>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Appointment Schedule</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Slot</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alice Cooper</td>
                                    <td>Dr. Sarah Johnson</td>
                                    <td>2026-05-08</td>
                                    <td>10:00 AM</td>
                                    <td><span class="status-badge status-confirmed">Confirmed</span></td>
                                    <td>
                                        <button class="status-badge status-expired" style="border:none; cursor:pointer;">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
