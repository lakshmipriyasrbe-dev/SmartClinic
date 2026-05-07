<?php
    include_once("common_file.php");

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }

    $edit_id = $_GET['doctor_id'] ?? '';
    $name = "";
    $specialization = "";
    $fees = "";
    $contact = "";

    if (!empty($edit_id)) {
        $stmt = $con->prepare("SELECT * FROM " . $GLOBALS['consultant_table'] . " WHERE consultant_id = ? AND deleted = 0");
        $stmt->execute([$edit_id]);
        $row = $stmt->fetch();
        if ($row) {
            $name = $row['consultan_name'];
            $specialization = $row['consultant_specification'];
            $fees = $row['consultant_fees'];
            $contact = $row['consultant_number'];
        }
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
                        <h2><?php echo empty($edit_id) ? "Add New Doctor" : "Update Doctor"; ?></h2>
                    </div>
                    <form name="doctor_form" id="doctor_form" onsubmit="event.preventDefault(); formSubmit('doctor_form', 'doctor_action.php', 'doctor.php', 'doctor');">
                        <input type="hidden" name="view_doctor_id" value="<?php echo $edit_id; ?>">
                        
                        <div class="form-group">
                            <label for="doc-name">Doctor Name</label>
                            <input type="text" id="doc-name" name="name" class="form-input" placeholder="Dr. John Doe" value="<?php echo $name; ?>" onkeypress="return allowLettersOnly(event)" required>
                            <span id="error-name" class="error-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="doc-spec">Specialization</label>
                            <input type="text" id="doc-spec" name="specialization" class="form-input" placeholder="Cardiology" value="<?php echo $specialization; ?>" required>
                            <span id="error-specialization" class="error-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="doc-fees">Consultation Fees ($)</label>
                            <input type="number" id="doc-fees" name="fees" class="form-input" placeholder="100" value="<?php echo $fees; ?>" onkeypress="return allowNumbersOnly(event)" required>
                            <span id="error-fees" class="error-msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="doc-contact">Contact Number</label>
                            <input type="tel" id="doc-contact" name="contact" class="form-input" placeholder="1234567890" value="<?php echo $contact; ?>" onkeypress="return allowNumbersOnly(event)" required>
                            <span id="error-contact" class="error-msg"></span>
                        </div>
                        
                        <div id="success-msg" class="success-msg hidden"></div>
                        
                        <button type="submit" class="btn-primary"><?php echo empty($edit_id) ? "Add Doctor" : "Update Doctor"; ?></button>
                        <?php if (!empty($edit_id)): ?>
                            <a href="doctor.php" class="btn-secondary" style="text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 6px; background: #e2e8f0; color: #475569; margin-left: 10px;">Cancel</a>
                        <?php endif; ?>
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Fees</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM " . $GLOBALS['consultant_table'] . " WHERE deleted = 0 ORDER BY id DESC");
                                    $stmt->execute();
                                    $doctors = $stmt->fetchAll();
                                    if ($doctors) {
                                        foreach ($doctors as $doc) {
                                            echo "<tr>";
                                            echo "<td>" . $doc['id'] . "</td>";
                                            echo "<td>" . $doc['consultan_name'] . "</td>";
                                            echo "<td>" . $doc['consultant_specification'] . "</td>";
                                            echo "<td>$" . $doc['consultant_fees'] . "</td>";
                                            echo "<td>" . $doc['consultant_number'] . "</td>";
                                             echo "<td>
                                                    <a href='doctor.php?doctor_id=" . $doc['consultant_id'] . "' class='status-badge status-attended' style='border:none; cursor:pointer; text-decoration:none; margin-right:5px;'>Edit</a>
                                                    <button onclick='deleteDoctor(\"" . $doc['consultant_id'] . "\")' class='status-badge status-expired' style='border:none; cursor:pointer;'>Delete</button>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' style='text-align:center;'>No records found</td></tr>";
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
    <script>
        function deleteDoctor(id) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                const formData = new FormData();
                formData.append('doctor_id', id);
                formData.append('action', 'delete');

                fetch('doctor_action.php', {
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
