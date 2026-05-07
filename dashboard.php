<?php
    include_once("common_file.php");

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }

    // Calculations
    // 1. Expected Revenue (Sum of fees for confirmed appointments)
    $stmt = $con->prepare("SELECT SUM(consultant_fees) as total FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 AND (status = 'Confirmed' OR status IS NULL)");
    $stmt->execute();
    $expected_revenue = $stmt->fetch()['total'] ?? 0;

    // 2. Confirmed Appointments Count
    $stmt = $con->prepare("SELECT COUNT(*) as count FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 AND (status = 'Confirmed' OR status IS NULL)");
    $stmt->execute();
    $confirmed_count = $stmt->fetch()['count'] ?? 0;

    // 3. Active Doctors Count
    $stmt = $con->prepare("SELECT COUNT(*) as count FROM " . $GLOBALS['consultant_table'] . " WHERE deleted = 0");
    $stmt->execute();
    $doctors_count = $stmt->fetch()['count'] ?? 0;

    // Fetch user info for initials
    $user_name = $_SESSION['user_name'] ?? 'Admin';
    $initials = strtoupper(substr($user_name, 0, 1) . substr(strrchr($user_name, " "), 1, 1));
    if (strlen($initials) < 2) $initials = strtoupper(substr($user_name, 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SmartClinic</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <header class="top-header">
                <div class="page-title">
                    <h1>Dashboard</h1>
                    <p style="color: var(--text-muted);">Welcome back! Here's what's happening today.</p>
                </div>
                <div class="user-profile">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 600; color: white;">
                        <?php echo $initials; ?>
                    </div>
                </div>
            </header>

            <div class="grid-container">
                <div class="stat-card">
                    <h3>Expected Revenue</h3>
                    <div class="value">₹<?php echo number_format($expected_revenue, 2); ?></div>
                    <div style="margin-top: 10px; color: var(--accent-color); font-size: 0.8rem;">Based on confirmed bookings</div>
                </div>
                <div class="stat-card">
                    <h3>Confirmed Appointments</h3>
                    <div class="value"><?php echo $confirmed_count; ?></div>
                    <div style="margin-top: 10px; color: var(--text-muted); font-size: 0.8rem;">Awaiting patient arrival</div>
                </div>
                <div class="stat-card">
                    <h3>Active Doctors</h3>
                    <div class="value"><?php echo $doctors_count; ?></div>
                    <div style="margin-top: 10px; color: var(--text-muted); font-size: 0.8rem;">Available for consultation</div>
                </div>
            </div>

            <div class="content-card">
                <div class="content-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2>Upcoming Appointments</h2>
                    <a href="reports/dashboard_report.php" target="_blank" class="status-badge status-attended" style="text-decoration: none; padding: 6px 12px; font-size: 0.8rem;">Print List</a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Doctor</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $now = date('Y-m-d H:i:s');
                                $stmt = $con->prepare("SELECT * FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 AND appointment_date >= ? ORDER BY appointment_date ASC LIMIT 5");
                                $stmt->execute([$now]);
                                $upcoming = $stmt->fetchAll();

                                if ($upcoming) {
                                    foreach ($upcoming as $appt) {
                                        $status_class = "status-confirmed";
                                        $status_text = "Confirmed";
                                        if (isset($appt['status']) && $appt['status'] == 'Attended') {
                                            $status_class = "status-attended";
                                            $status_text = "Attended";
                                        }

                                        echo "<tr>";
                                        echo "<td>" . $appt['patient_name'] . "</td>";
                                        echo "<td>" . $appt['consultan_name'] . "</td>";
                                        echo "<td>" . date('d-m-Y h:i A', strtotime($appt['appointment_date'])) . "</td>";
                                        echo "<td><span class='status-badge $status_class'>$status_text</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align:center;'>No upcoming appointments</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
