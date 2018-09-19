<!DOCTYPE html>
<head>
	<title>Delete Stock Record</title>
</head>
<?php include "inc/header.php" ?>
<body>
<?php
// Grab variables from form post
if (!isset($_POST["stockId"]))
{
	die("Form not properly completed.");
}

$stockId = $_POST["stockId"];

include_once "inc/db_connect.php";

// Connect to the database and grab an array of stock
// Protects against client shenanigans
$stock = array();
$dbconn = mysqli_connect($host, $username, $pwd, $db);
if (!$dbconn)
{
	die("Connection failed: " . mysqli_connect_error());
}
else
{
	$result = mysqli_query($dbconn, "SELECT * FROM `stock` WHERE `active`!='0'");
	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			array_push($stock, $row);
		}
	}
}

// Little bit of security to make sure the selected item has a matching record in the database
foreach ($stock as $DBStock)
{
	if ($DBStock['id'] == $stockId)
	{
		$selectedDBStock = $DBStock;
		break;
	}
}

if (!isset($selectedDBStock))
{
	die ("Form data mismatch: Stock not found in database");
}

$sql = "UPDATE `stock` SET `active` = '0', `qty` = '0' WHERE `stock`.`id` = " . $selectedDBStock['id']; 

// Landing page
if (mysqli_query($dbconn, $sql))
{
	echo "Record successfully deleted!";
}
else
{
	echo "Error: " . mysqli_error($dbconn);
}
?>
<?php include "inc/footer.php" ?>
</body>
</html>
