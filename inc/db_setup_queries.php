<?php

include_once "db_connect.php";

$have_db_query = "CREATE DATABASE IF NOT EXISTS " . $db;
$drop_db_query = "DROP DATABASE " . $db;
$stock_table_query = "CREATE TABLE IF NOT EXISTS stock (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
item_name VARCHAR(100) NOT NULL,
brand VARCHAR(50) NOT NULL,
qty INT(5) UNSIGNED NOT NULL,
price INT(10) UNSIGNED NOT NULL
)";
$sales_table_query = "CREATE TABLE IF NOT EXISTS sales (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
item_name VARCHAR(100) NOT NULL,
brand VARCHAR(50) NOT NULL,
qty INT(5) UNSIGNED NOT NULL,
total INT(10) UNSIGNED NOT NULL,
date_time TIMESTAMP NOT NULL
)";

?>
