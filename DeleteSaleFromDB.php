<?php
    $title = "Delete A Sale";
    include "inc/html-head.php";
	include "inc/header.php";

// Grab variables from form post
if (!isset($_POST["saleId"]))
{
	die("Form not properly completed.");
}

$saleId = $_POST["saleId"];

include_once "inc/db_connect.php";

// Connect to the database and grab an array of sales
// Protects against client shenanigans
$sales = array();
$dbconn = mysqli_connect($host, $username, $pwd, $db);
if (!$dbconn)
{
	die("Connection failed: " . mysqli_connect_error());
}
else
{
	$result = mysqli_query($dbconn, "SELECT * FROM sales");
	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			array_push($sales, $row);
		}
	}
}

// Little bit of security to make sure the selected item has a matching record in the database
foreach ($sales as $DBSale)
{
	if ($DBSale['id'] == $saleId)
	{
		$selectedDBSale = $DBSale;
		break;
	}
}

if (!isset($selectedDBSale))
{
	die ("Form data mismatch: Sale not found in database");
}

$sql = "DELETE FROM sales WHERE id='"
	. $selectedDBSale['id'] . "'";

// Landing page
if (mysqli_query($dbconn, $sql))
{
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
