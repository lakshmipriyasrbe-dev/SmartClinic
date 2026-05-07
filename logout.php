<?php
    include_once("common_file.php");

    // 1. Perform Database Backup
    $dbConfig = $bf->getDbConfig();
    $host = $dbConfig['host'];
    $dbname = $dbConfig['dbname'];
    $user = $dbConfig['user'];
    $pass = $dbConfig['pass'];

    $backup_dir = __DIR__ . '/main/backup';
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0777, true);
    }

    $backup_file = $backup_dir . '/backup_' . date('Ymd_His') . '.sql';
    
    // Command for mysqldump
    // On Windows, if there's no password, we skip the -p part or use -p""
    $command = "mysqldump --host=$host --user=$user " . ($pass ? "--password=$pass" : "") . " $dbname > \"$backup_file\"";
    
    // Execute the command
    exec($command, $output, $return_var);

    // 2. Unset Session
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    // 3. Redirect to index.php
    header("Location: index.php");
    exit;
?>
