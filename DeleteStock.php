<!DOCTYPE html>
<html>
<head>
	<title>Delete Stock</title>
</head>
<body>
<!-- Get an array of items from the database -->
<?php
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
	$result = mysqli_query($dbconn, "SELECT * FROM `stock` WHERE `active`!='0'");
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
	<h1>Delete Stock</h1>
	<form action="DeleteStockFromDB.php" method="post">
	<label for="stockId">Stock Item: </label>
		<select id="stockId" name="stockId" onchange="OnStockChange()">
			<option value=""></option>
		</select>
		<br />
		<label>Item: </label>
		<label id="itemName"></label>
		<br />
		<label for="brand">Brand: </label>
		<label id="brand"></label>
		<br />
		<label>Quantity: </label>
		<label id="quantity"></label>
		<br />
		<label>Price: $</label>
		<label id="price"></label>
		<p></p>
		<button type="submit" onclick="return OnSubmit()">Delete Stock Record</button>
	</form>
	</section>

    <?php include "inc/footer.php" ?>

	<script>
	var items = <?php echo $itemsJS; ?>;
	var selection = document.getElementById('stockId');
	var itemName = document.getElementById('itemName');
	var brand = document.getElementById('brand');
	var quantity = document.getElementById('quantity');
	var price = document.getElementById('price');

	{ // fill out the select with the indexes of the array
		let stockIdx;
		for (stockIdx in items)
		{
			let option;
			option = document.createElement('option');
			option.setAttribute('value', items[stockIdx].id);
			option.appendChild(document.createTextNode(items[stockIdx].item_name));
			selection.appendChild(option);
		}
	}

	function OnStockChange()
	{
		if (selection.value != "")
		{
			let stockIdx;
			for (stockIdx in items)
			{
				if (items[stockIdx].id == selection.value)
				{
					itemName.innerHTML = items[stockIdx].item_name;
					brand.innerHTML = items[stockIdx].brand;
					quantity.innerHTML = items[stockIdx].qty;
					price.innerHTML = items[stockIdx].price / 100;
					break;
				}
			}
		}
		else
		{
			itemName.innerHTML = "";
			brand.innerHTML = "";
			quantity.innerHTML = "";
			price.innerHTML = "";
			dateTime.innerHTML = "";
		}
	}

	function OnSubmit()
	{
		if (selection.value == "")
		{
			return false;
		}
		return confirm('Are you sure you want to delete this record?');
	}
	</script>
</body>
</html>
