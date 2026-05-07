<?php
    require_once 'main/basic_functions.php';
    $bf = new Basic_Functions();
    $con = $bf->con;

    // Check if any users exist
    $stmt = $con->prepare("SELECT COUNT(*) FROM sc_user WHERE deleted = 0");
    $stmt->execute();
    $userCount = $stmt->fetchColumn();

    $showLogin = ($userCount > 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartClinic | <?php echo $showLogin ? 'Login' : 'Registration'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .hidden { display: none !important; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-hero">
            <h1>SmartClinic</h1>
            <p>Streamline your clinic operations with our advanced appointment scheduler. Experience seamless healthcare management.</p>
        </div>
        <div class="auth-form-side">
            <div class="auth-card">
                <div class="auth-tabs <?php echo ($userCount == 0 || $userCount > 0) ? 'hidden' : ''; // Always hidden now as per request to show only one ?>">
                    <div id="login-tab" class="auth-tab <?php echo $showLogin ? 'active' : ''; ?>" onclick="toggleAuth('login')">Login</div>
                    <div id="register-tab" class="auth-tab <?php echo !$showLogin ? 'active' : ''; ?>" onclick="toggleAuth('register')">Register</div>
                </div>

                <div class="form-header" style="margin-bottom: 25px;">
                    <h2 style="font-size: 1.5rem; color: var(--text-main);">
                        <?php echo $showLogin ? 'Login' : 'Create Account'; ?>
                    </h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        <?php echo $showLogin ? 'Please enter your credentials to continue.' : 'Register your clinic to get started.'; ?>
                    </p>
                </div>

                <!-- Login Form -->
                <form id="login-form" name="login_form" action="dashboard.php" method="POST" class="<?php echo !$showLogin ? 'hidden' : ''; ?>">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" id="login-username" name="username" class="form-input" placeholder="Enter your username" required>
                        <span class="error-msg" id="error-login-username"></span>
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label for="login-password">Password</label>
                        <div style="position: relative;">
                            <input type="password" id="login-password" name="password" class="form-input" placeholder="••••••••" required>
                            <i data-lucide="eye" class="toggle-password" data-target="login-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                        </div>
                        <span class="error-msg" id="error-login-password"></span>
                    </div>
                    <button type="submit" class="btn-primary">Sign In</button>
                </form>

                <!-- Registration Form -->
                <form id="register-form" name="register_form" action="index.php" method="POST" class="<?php echo $showLogin ? 'hidden' : ''; ?>">
                    <div class="form-group">
                        <label for="reg-name">Full Name</label>
                        <input type="text" id="reg-name" name="name" class="form-input" placeholder="John Doe" required>
                        <span class="error-msg" id="error-name"></span>
                    </div>
                    <div class="form-group">
                        <label for="reg-mobile">Mobile Number</label>
                        <input type="tel" id="reg-mobile" name="mobile" class="form-input" placeholder="10-digit number" required>
                        <span class="error-msg" id="error-mobile"></span>
                    </div>
                    <div class="form-group">
                        <label for="reg-username">Username</label>
                        <input type="text" id="reg-username" name="username" class="form-input" placeholder="Choose a username" required>
                        <span class="error-msg" id="error-username"></span>
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label for="reg-password">Password</label>
                        <div style="position: relative;">
                            <input type="password" id="reg-password" name="password" class="form-input" placeholder="••••••••" required oninput="checkPasswordRequirements(this.value)">
                            <i data-lucide="eye" id="toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);"></i>
                        </div>
                        <span class="error-msg" id="error-password"></span>
                        
                        <div id="password-hints" class="password-hints-container">
                            <p>Password must contain:</p>
                            <ul class="hints-list">
                                <li id="hint-lower" class="invalid"><i data-lucide="circle"></i> A lowercase letter</li>
                                <li id="hint-upper" class="invalid"><i data-lucide="circle"></i> A capital (uppercase) letter</li>
                                <li id="hint-number" class="invalid"><i data-lucide="circle"></i> A number</li>
                                <li id="hint-special" class="invalid"><i data-lucide="circle"></i> A special character</li>
                                <li id="hint-length" class="invalid"><i data-lucide="circle"></i> Minimum 8 characters</li>
                            </ul>
                        </div>
                    </div>
                    <div id="form-success" class="success-msg hidden"></div>
                    <button type="submit" class="btn-primary">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="main/js/keyboard_control.js"></script>
    <script src="main/js/script.js"></script>
    <script>
        // Initialize Lucide
        lucide.createIcons();

        // Apply keyboard controls
        const regName = document.getElementById('reg-name');
        if (regName) {
            regName.addEventListener('keypress', allowLettersOnly);
            regName.addEventListener('input', restrictPasteLetters);
        }
        
        const regMobile = document.getElementById('reg-mobile');
        if (regMobile) {
            regMobile.addEventListener('keypress', allowNumbersOnly);
            regMobile.addEventListener('input', restrictPasteNumbers);
        }

        function toggleAuth(type) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');

            if (type === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginTab.classList.remove('active');
                registerTab.classList.add('active');
            }
            lucide.createIcons(); // Refresh icons for visible form
        }

        // Handle registration form submit
        const regForm = document.getElementById('register-form');
        if (regForm) {
            regForm.addEventListener('submit', function(e) {
                e.preventDefault();
                formSubmit('register_form', 'process_registration.php', 'index.php');
            });
        }

        // Handle login form submit
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                formSubmit('login_form', 'process_login.php', 'dashboard.php');
            });
        }
    </script>
</body>
</html>