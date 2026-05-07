<div class="sidebar">
    <div class="logo-area">
        <h2>SmartClinic</h2>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="company.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'company.php' ? 'active' : ''; ?>">
                <i data-lucide="building-2"></i>
                <span>Hospital</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="doctor.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'doctor.php' ? 'active' : ''; ?>">
                <i data-lucide="stethoscope"></i>
                <span>Doctor</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="appointment.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'appointment.php' ? 'active' : ''; ?>">
                <i data-lucide="calendar"></i>
                <span>Appointment</span>
            </a>
        </li>
        <li class="nav-item" style="margin-top: auto; padding-top: 20px;">
            <a href="logout.php" class="nav-link">
                <i data-lucide="log-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
