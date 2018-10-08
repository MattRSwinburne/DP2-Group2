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

if(!isset($_GET["total"])) {
  $_GET["total_range_symbol"] = "";
  $_GET["total"] = "";
}

if(!isset($_GET["date"])) {
  $_GET["date"] = "";
}
?>
