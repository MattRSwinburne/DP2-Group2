<?php
//if you have GET values (mainly for show_stock searches), put'm in some variables
// otherwise blank variables are fine too.
if (!isset($_GET["item_name"])){
  $_GET["item_name"] = "";
};

if (!isset($_GET["brand"])) {
  $_GET["brand"] = "";
};

if (!isset($_GET["qty"])) {
  $_GET["qty_range_symbol"] = "";
  $_GET["qty"] = "";
};

if(!isset($_GET["price"])) {
  $_GET["price_range_symbol"] = "";
  $_GET["price"] = "";
}
?>


<!-- // nb: add <form> & </form> on either side of this include!
// Depending on where you want your form to redirect to you'll want
// to change your form action, but the inner bits of the form don't
// need to change.
// also your form_type hidden input needs to be outside! -->


    <label for="item_name">Name: </label>
    <input type="text" name="item_name" id="item_name" value="<?php echo $_GET["item_name"] ?>"/>
    <br />
    <label for="brand">Brand: </label>
    <input type="text" name="brand" id="brand" value="<?php echo $_GET["brand"] ?>"/>
    <br />
    <label for="qty">Quantity: </label>
    <select name="qty_range_symbol">
      <option value=">" <?php if($_GET["qty_range_symbol"] == ">") {echo 'selected="selected"';}?>>&gt;</option>
      <option value="<" <?php if($_GET["qty_range_symbol"] == "<") {echo 'selected="selected"';}?>>&lt;</option>
      <option value="=" <?php if($_GET["qty_range_symbol"] == "=") {echo 'selected="selected"';}?>>=</option>
    </select>
    <input type="number" name="qty" id="qty" value="<?php echo $_GET["qty"] ?>"/>
    <br />
    <label for="price">Price: </label>
    <select name="price_range_symbol">
      <option value=">" <?php if($_GET["price_range_symbol"] == ">") {echo 'selected="selected"';}?>>&gt;</option>
      <option value="<" <?php if($_GET["price_range_symbol"] == "<") {echo 'selected="selected"';}?>>&lt;</option>
      <option value="=" <?php if($_GET["price_range_symbol"] == "=") {echo 'selected="selected"';}?>>=</option>
    </select>
    <input type="number" step="any" name="price" id="price" value="<?php echo $_GET["price"] ?>"/>
    <br />
