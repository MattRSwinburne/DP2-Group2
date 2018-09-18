<!DOCTYPE html>
<html>
<head>
	<title>Delete Sale Record</title>
</head>
<body>
<!-- Get an array of sales from the database -->
<?php
$sales = array();
$salesJS = array();
$items = array();
$itemsJS = array();

include "inc/db_connect.php";
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
		// Convert to json so it can be passed to javascript
		$salesJS = json_encode($sales);
	}
	$result = mysqli_query($dbconn, "SELECT * FROM stock");
	if (mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result))
		{
			array_push($items, $row);
		}
		// Convert to json so it can be passed to javascript
		$itemsJS = json_encode($items);
	}
}
?>

<?php include "inc/header.php" ?>

<section>
	<h1>Delete Sales Record</h1>
	<form action="DeleteSaleFromDB.php" method="post">
	<label for="saleId">Sale Record:</label>
		<select id="saleId" name="saleId" onchange="OnSaleChange()">
			<option value=""></option>
		</select>
		<br />
		<label>Item: </label>
		<label id="itemName"></label>
		<br />
		<label>Quantity: </label>
		<label id="quantity"></label>
		<br />
		<label>Total Price: $</label>
		<label id="price">0</label>
		<br />
		<label>Date: </label>
		<label id="dateTime"></label>
		<p></p>
		<button type="submit" onclick="return confirm('Are you sure you want to delete this record?')">Delete Record</button>
	</form>
	</section>

    <?php include "inc/footer.php" ?>

	<script>
	var sales = <?php echo $salesJS; ?>;
	var items = <?php echo $itemsJS; ?>;
	var selection = document.getElementById('saleId');
	var itemName = document.getElementById('itemName');
	var quantity = document.getElementById('quantity');
	var price = document.getElementById('price');
	var dateTime = document.getElementById('dateTime');

	{ // fill out the select with the indexes of the array
		let saleIdx;
		for (saleIdx in sales)
		{
			let option;
			option = document.createElement('option');
			option.setAttribute('value', sales[saleIdx].id);
			option.appendChild(document.createTextNode(sales[saleIdx].date_time));
			selection.appendChild(option);
		}
	}

	function OnSaleChange()
	{
		if (selection.value != "")
		{
			let saleIdx;
			for (saleIdx in sales)
			{
				if (sales[saleIdx].id == selection.value)
				{
					itemName.innerHTML = FindItemNameById(sales[saleIdx].item_id);
					quantity.innerHTML = sales[saleIdx].qty;
					price.innerHTML = sales[saleIdx].total;
					dateTime.innerHTML = sales[saleIdx].date_time;
					break;
				}
			}
		}
		else
		{
			itemName.innerHTML = "";
			quantity.innerHTML = "";
			price.innerHTML = "";
			dateTime.innerHTML = "";
		}
	}

	function FindItemNameById(itemId)
	{
		let itemIdx;
		for (itemIdx in items)
		{
			if (items[itemIdx].id == itemId)
			{
				return items[itemIdx].item_name;
			}
		}
		return "";
	}
	</script>
</body>
</html>
