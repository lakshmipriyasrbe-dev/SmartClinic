<?php
    include_once("common_file.php");

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }

    $edit_id = $_GET['company_id'] ?? '';
    $company_name = "";
    $company_email = "";
    $company_address = "";

    if (!empty($edit_id)) {
        $rows = $bf->getTableRecords($GLOBALS['company_table'], 'company_id', $edit_id);
        $row = $rows[0] ?? null;
        if ($row) {
            $company_name = $row['company_name'];
            $company_email = $row['company_email'];
            $company_address = $row['company_address'];
        }
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
                    <?php
                        $max_company = 1;
                        $companies_all = $bf->getTableRecords($GLOBALS['company_table']);
                        $company_count = count($companies_all);
                        
                        $can_show_form = (empty($edit_id) && $company_count < $max_company) || !empty($edit_id);
                    ?>
                    
                    <div class="content-card-header">
                        <h2><?php echo empty($edit_id) ? "Register Hospital" : "Update Hospital"; ?></h2>
                    </div>

                    <?php if ($can_show_form): ?>
                        <form name="company_form" id="company_form" onsubmit="event.preventDefault(); formSubmit('company_form', 'company_action.php', 'company.php', 'company');">
                            <input type="hidden" name="view_company_id" value="<?php echo $edit_id; ?>">
                            
                            <div class="form-group">
                                <label for="comp-name">Hospital Name</label>
                                <input type="text" id="comp-name" name="company_name" class="form-input" placeholder="Main Clinic Branch" value="<?php echo $company_name; ?>" onkeypress="return allowLettersOnly(event)" required>
                                <span id="error-company_name" class="error-msg"></span>
                            </div>
                            <div class="form-group">
                                <label for="comp-address">Address</label>
                                <textarea id="comp-address" name="address" class="form-input" style="height: 100px; resize: none;" placeholder="123 Medical Plaza, New York, NY" required><?php echo $company_address; ?></textarea>
                                <span id="error-address" class="error-msg"></span>
                            </div>
                            <div class="form-group">
                                <label for="comp-email">Email Address</label>
                                <input type="email" id="comp-email" name="email" class="form-input" placeholder="contact@smartclinic.com" value="<?php echo $company_email; ?>" required>
                                <span id="error-email" class="error-msg"></span>
                            </div>
                            
                            <div id="success-msg" class="success-msg hidden"></div>
                            
                            <button type="submit" class="btn-primary"><?php echo empty($edit_id) ? "Save Details" : "Update Details"; ?></button>
                            <?php if (!empty($edit_id)): ?>
                                <a href="company.php" class="btn-secondary" style="text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 6px; background: #e2e8f0; color: #475569; margin-top: 10px; width: 100%; text-align: center;">Cancel</a>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <div style="padding: 20px; text-align: center; background: #f8fafc; border-radius: 12px; border: 1px dashed var(--border-color);">
                            <p style="color: var(--text-muted); font-size: 0.9rem;">You have reached the maximum limit of **<?php echo $max_company; ?>** hospital registration.</p>
                            <p style="margin-top: 10px; font-size: 0.85rem;">To change details, please use the **Edit** option in the listing.</p>
                        </div>
                    <?php endif; ?>
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
                                <?php
                                    $companies = $bf->getTableRecords($GLOBALS['company_table']);
                                    if ($companies) {
                                        foreach ($companies as $comp) {
                                            echo "<tr>";
                                            echo "<td>" . $comp['id'] . "</td>";
                                            echo "<td>" . $comp['company_name'] . "</td>";
                                            echo "<td>" . $comp['company_email'] . "</td>";
                                            echo "<td>" . $comp['company_address'] . "</td>";
                                            echo "<td>
                                                    <a href='company.php?company_id=" . $comp['company_id'] . "' class='status-badge status-attended' style='border:none; cursor:pointer; text-decoration:none;'>Edit</a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='text-align:center;'>No records found</td></tr>";
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
</body>
</html>
