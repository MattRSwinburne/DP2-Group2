<!DOCTYPE html>
<head>
	<title>Add Sale Record</title>
</head>
<?php include "inc/header.php" ?>
<body>
<?php
// Grab variables from form post
if (isset($_POST["itemIdx"]))
{
	$itemIdx = $_POST["itemIdx"];
}
if (isset($_POST["quantity"]))
{
	$quantity = $_POST["quantity"];
}

if (!isset($itemIdx) or !isset($quantity))
{
	die("Form not properly completed.");
}

include_once "inc/db_connect.php";

// Connect to the database and grab an array of items
// Protects against client shenanigans
$items = array();
$dbconn = mysqli_connect($host, $username, $pwd, $db);
if (!$dbconn)
{
	die("Connection failed: " . mysqli_connect_error());
}
else
{
	$result = mysqli_query($dbconn, "SELECT * FROM stock");
	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			array_push($items, $row);
		}
	}
}

// Little bit of security to make sure the selected item has a matching record in the database
foreach ($items as $DBItem)
{
	if ($items[$itemIdx] == $DBItem)
	{
		if ($quantity > $DBItem['qty']) die("Form data mismatch");

		$selectedDBItem = $DBItem;
		break;
	}
}

if (!isset($selectedDBItem))
{
	die ("Form data mismatch: Item not found in database");
}

$sql = "INSERT INTO sales (id, item_id, qty, total, date_time) VALUES "
. "(NULL, ". "'" . $items[$itemIdx]['id'] . "'"
. ", " . "'" . $quantity . "'"
. ", " . "'" . $items[$itemIdx]['price']*$quantity . "'"
. ", CURRENT_TIMESTAMP)";

// TODO: Have this bit point to the "Display sales record" page.
if (mysqli_query($dbconn, $sql))
{
	echo "Success!";
}
else
{
	echo "Error: " . mysqli_error($dbconn);
}
?>
<?php include "inc/footer.php" ?>
</body>
</html>