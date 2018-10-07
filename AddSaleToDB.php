<?php
    $title = "Add Sales";
    include "inc/html-head.php";
		include "inc/header.php"
		
// Grab variables from form post
if (isset($_POST["itemId"]))
{
	$itemId = $_POST["itemId"];
}
if (isset($_POST["quantity"]))
{
	$quantity = $_POST["quantity"];
}

if (!isset($itemId) or !isset($quantity))
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
	$result = mysqli_query($dbconn, "SELECT * FROM stock WHERE active!=0");
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
	if ($DBItem['id'] == $itemId)
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
. "(NULL, ". "'" . $selectedDBItem['id'] . "'"
. ", " . "'" . $quantity . "'"
. ", " . "'" . $selectedDBItem['price']*$quantity . "'"
. ", CURRENT_TIMESTAMP);"
. "UPDATE stock SET qty = qty-$quantity WHERE id = " . $selectedDBItem['id'];

// Redirect to the show sales page if successful
if (mysqli_multi_query($dbconn, $sql))
{
	include_once 'inc/low_stock_email.php';
	CheckLowStock();
	header("Location: /DP2-Group2/show_sales.php");
}
else
{
	echo "Error: " . mysqli_error($dbconn);
}
?>
<?php include "inc/footer.php" ?>
</body>
</html>
