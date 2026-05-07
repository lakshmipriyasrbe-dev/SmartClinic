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
    <title>Doctor Management | SmartClinic</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <header class="top-header">
                <div class="page-title">
                    <h1>Doctor Management</h1>
                </div>
            </header>

            <div class="grid-container" style="grid-template-columns: 1fr 2fr;">
                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Add New Doctor</h2>
                    </div>
                    <form action="doctor.php" method="POST">
                        <div class="form-group">
                            <label for="doc-name">Doctor Name</label>
                            <input type="text" id="doc-name" name="name" class="form-input" placeholder="Dr. John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="doc-spec">Specialization</label>
                            <input type="text" id="doc-spec" name="specialization" class="form-input" placeholder="Cardiology" required>
                        </div>
                        <div class="form-group">
                            <label for="doc-fees">Consultation Fees ($)</label>
                            <input type="number" id="doc-fees" name="fees" class="form-input" placeholder="100" required>
                        </div>
                        <div class="form-group">
                            <label for="doc-contact">Contact Number</label>
                            <input type="tel" id="doc-contact" name="contact" class="form-input" placeholder="+1 (555) 000-0000" required>
                        </div>
                        <button type="submit" class="btn-primary">Add Doctor</button>
                    </form>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Doctor Directory</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Fees</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dr. Sarah Johnson</td>
                                    <td>Pediatrics</td>
                                    <td>$85.00</td>
                                    <td>+1 555-0123</td>
                                    <td>
                                        <button class="status-badge status-attended" style="border:none; cursor:pointer;">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dr. Mark Williams</td>
                                    <td>Dermatology</td>
                                    <td>$120.00</td>
                                    <td>+1 555-0456</td>
                                    <td>
                                        <button class="status-badge status-attended" style="border:none; cursor:pointer;">Edit</button>
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
