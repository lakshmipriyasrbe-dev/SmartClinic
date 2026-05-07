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
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 600;">
                        JD
                    </div>
                </div>
            </header>

            <div class="grid-container">
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <div class="value">$12,450.00</div>
                    <div style="margin-top: 10px; color: var(--accent-color); font-size: 0.8rem;">+12.5% from last month</div>
                </div>
                <div class="stat-card">
                    <h3>Confirmed Appointments</h3>
                    <div class="value">48</div>
                    <div style="margin-top: 10px; color: var(--text-muted); font-size: 0.8rem;">12 pending approval</div>
                </div>
                <div class="stat-card">
                    <h3>Active Doctors</h3>
                    <div class="value">14</div>
                    <div style="margin-top: 10px; color: var(--text-muted); font-size: 0.8rem;">Across 6 specializations</div>
                </div>
            </div>

            <div class="content-card">
                <div class="content-card-header">
                    <h2>Upcoming Appointments</h2>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Alice Cooper</td>
                                <td>Dr. Sarah Johnson</td>
                                <td>2026-05-08</td>
                                <td>10:00 AM</td>
                                <td><span class="status-badge status-confirmed">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>Bob Miller</td>
                                <td>Dr. Mark Williams</td>
                                <td>2026-05-08</td>
                                <td>11:30 AM</td>
                                <td><span class="status-badge status-attended">Attended</span></td>
                            </tr>
                            <tr>
                                <td>Charlie Brown</td>
                                <td>Dr. Sarah Johnson</td>
                                <td>2026-05-07</td>
                                <td>02:00 PM</td>
                                <td><span class="status-badge status-expired">Expired</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
