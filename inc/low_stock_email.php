<?php
function CheckLowStock()
{
	require "db_connect.php";
	$dbconn = mysqli_connect($host, $username, $pwd, $db);
	if (!$dbconn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	$query = "SELECT item_name, brand, `time`
	FROM email_stock
	JOIN stock ON email_stock.stock_id = stock.id
	WHERE `sent` = '0'";
	$result = mysqli_query($dbconn, $query);

	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			mail($alert_email, "Low Stock Warning", "Item: " . $row['item_name'] . " (" . $row['brand'] . ") " . $row['time']);
			echo "Sent an email";
		}

		// after sending all the unsent emails, update the database
		$query = "UPDATE email_stock SET `sent`='1' WHERE `sent` = '0'";
		mysqli_query($dbconn, $query);
	}
	return;
}
?>

<?php CheckLowStock(); ?>