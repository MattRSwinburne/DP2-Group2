<!DOCTYPE html>
<html>
<head>
	<title>Add Sale Record</title>
</head>
<body>
<!-- Get an array of stock items from the database -->
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
	<h1>New Sales Record</h1>
	<form action="AddSaleToDB.php" method="post">
		<label for="itemIdx">Item:</label>
		<select id="itemIdx" name="itemIdx" onchange="OnItemChange()">
			<option value=""></option>
		</select>
		<br />
		<label for="quantity">Quantity:</label>
		<!--Setting min to 1 and max to 0 makes for a weird out of range error but ensures form can't be submitted-->
		<input type="number" id="quantity" name="quantity" min="1" max="0" onchange="OnQtyChange()" />
		<br />
		<label for="price">Total Price: $</label>
		<label id="price">0</label>
		<p></p>
		<button type="submit">Submit</button>
	</form>
	</section>

    <?php include "inc/footer.php" ?>

	<script>
	var items = <?php echo $itemsJS; ?>;
	var selection = document.getElementById('itemIdx');
	var quantity = document.getElementById('quantity');
	var price = document.getElementById('price');

	{ // fill out the select with the indexes of the array
		let itemIdx;
		for (itemIdx in items)
		{
			let option;
			option = document.createElement('option');
			option.setAttribute('value', itemIdx);
			option.appendChild(document.createTextNode(items[itemIdx].item_name));
			selection.appendChild(option);
		}
	}

	function OnItemChange()
	{
		if (selection.value != "")
		{
			quantity.max = items[selection.value].qty;
		}
		else
		{
			quantity.max = 0;
		}
		quantity.value = 0;
		OnQtyChange();
	}

	function OnQtyChange()
	{
		if (selection.value != "")
		{
			price.innerHTML = items[selection.value].price / 100 * quantity.value;
		}
		else
		{
			price.innerHTML = 0;
		}
	}
	</script>
</body>
</html>
