<?php
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'lab5_data');
}

$db_connected = false;
$db_error = '';

mysqli_report(MYSQLI_REPORT_OFF);
$mysql = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

if ($mysql->connect_errno && DB_PASSWORD === '') {
    $mysql = @new mysqli(DB_HOST, DB_USER, 'root');
    if ($mysql->connect_errno) {
        $mysql = @new mysqli(DB_HOST, DB_USER, 'QweRtY');
    }
}

if ($mysql->connect_errno) {
    $db_error = "Не удалось подключиться к серверу MySQL (" . $mysql->connect_errno . "): " . $mysql->connect_error;
} else {
    $mysql->set_charset("utf8mb4");
    $mysql->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    if ($mysql->select_db(DB_NAME)) {
        $db_connected = true;

        $table_check = $mysql->query("SHOW TABLES LIKE 'terms'");
        if ($table_check && $table_check->num_rows == 0) {
            $create_table_sql = "CREATE TABLE IF NOT EXISTS `terms` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `term` VARCHAR(255) NOT NULL,
                `definition` TEXT NOT NULL,
                `image` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $mysql->query($create_table_sql);
        }
    } else {
        $db_error = "Не удалось выбрать базу данных " . DB_NAME . ": " . $mysql->error;
    }
}
?>