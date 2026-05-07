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
    <title>Company Management | SmartClinic</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <header class="top-header">
                <div class="page-title">
                    <h1>Hospital Details</h1>
                </div>
            </header>

            <div class="grid-container" style="grid-template-columns: 1fr 2fr;">
                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Register Hospital</h2>
                    </div>
                    <form action="company.php" method="POST">
                        <div class="form-group">
                            <label for="comp-name">Hospital Name</label>
                            <input type="text" id="comp-name" name="company_name" class="form-input" placeholder="Main Clinic Branch" required>
                        </div>
                        <div class="form-group">
                            <label for="comp-address">Address</label>
                            <textarea id="comp-address" name="address" class="form-input" style="height: 100px; resize: none;" placeholder="123 Medical Plaza, New York, NY" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="comp-email">Email Address</label>
                            <input type="email" id="comp-email" name="email" class="form-input" placeholder="contact@smartclinic.com" required>
                        </div>
                        <button type="submit" class="btn-primary">Save Details</button>
                    </form>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h2>Company Listings</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>SmartClinic Main</td>
                                    <td>info@smartclinic.com</td>
                                    <td>Downtown Medical Center</td>
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
