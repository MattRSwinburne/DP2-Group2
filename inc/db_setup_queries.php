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
$sales_table_query = "CREATE TABLE IF NOT EXISTS `sales` (
	`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
	`item_id` int(6) unsigned NOT NULL,
	`qty` int(5) unsigned NOT NULL,
	`total` int(10) unsigned NOT NULL,
	`date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `itemFK` (`item_id`),
	CONSTRAINT `itemFK` FOREIGN KEY (`item_id`) REFERENCES `stock` (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
?>
