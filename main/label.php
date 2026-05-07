<?php
    date_default_timezone_set('Asia/Calcutta');
	$GLOBALS['create_date_time_label'] = date('Y-m-d H:i:s');

    // Tables
	$table_prefix = "sc_";
	$GLOBALS['user_table'] = $table_prefix.'user'; $GLOBALS['login_table'] = $table_prefix.'login'; $GLOBALS['company_table'] = $table_prefix.'company'; $GLOBALS['consultant_table'] = $table_prefix.'consultant';
    $GLOBALS['appointment_table'] = $table_prefix.'appointment';

    // Security
    $GLOBALS['salt'] = "SmartClinic_2026_Secure_Salt_!@#";
?>