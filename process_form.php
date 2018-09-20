<?php

  //DEFINE DATA-PROCESSING FUNCTIONS

  function get_db_connect(){
    include_once 'inc/db_connect.php';
    //connect to db
    $db_connect = mysqli_connect($host, $username, $pwd, $db);

    //make sure it actually connects
    if (mysqli_connect_errno())
    {
      echo "<p>DB Connection Error: " . mysqli_connect_error() . "</p>";
    }
    //Testing: if you're having trouble with the connection, uncomment for stats
    // echo "Connection status: " . mysqli_stat($db_connect);
    return $db_connect;
  }

  function add_stock() {

    $db_connect = get_db_connect();

    //set up variables
    $item_name = $_POST[item_name];
    $brand = $_POST[brand];
    $qty = $_POST[qty];
    //for accuracy, we want to store prices as integers, not decimals
    //so *100 to store it as cents rather than dollars
    //REMEMBER TO RECONVERT IT ON THE OTHER SIDE!
    $price = $_POST[price] * 100;
    $msg = "";

    // echo $item_name, $brand, $qty, $price;

    //set up queries
    $check = "SELECT * FROM stock WHERE item_name='$item_name' AND brand='$brand';";
    $insert = "INSERT INTO stock (item_name, brand, qty, price)
    VALUES ('$item_name', '$brand', '$qty', '$price');";

    //Testing: uncomment to see what your queries are actually coming out as
    // echo $check . "<br />\r\n" . $insert;

    //check then insert
    $result = mysqli_query($db_connect, $check);
    if (mysqli_num_rows($result) > 0) {
      // if there's already something in the database, throw an error
        $msg = "ERROR: Item already exists!";
      }
    else {
    //but if there isn't, add the item
      if (mysqli_query($db_connect, $insert)) {
        $msg = "Success!\r\n";
      }
      else {
        $msg = "ERROR: can't add item to database?\r\n" . mysqli_error($db_connect);
      }
    }

    return $msg;
  }

  function edit_stock() {
    $msg = "";
    $db_connect = get_db_connect();

    //set up variables
    $id = $_POST[stockid];
    $item_name = $_POST[item_name];
    $brand = $_POST[brand];
    $qty = $_POST[qty];
    //for accuracy, we want to store prices as integers, not decimals
    //so *100 to store it as cents rather than dollars
    //REMEMBER TO RECONVERT IT ON THE OTHER SIDE!
    $price = $_POST[price] * 100;

    //set up $query
    $edit_query = "UPDATE stock
    SET item_name='$item_name',
    brand='$brand',
    qty='$qty',
    price='$price'
    WHERE id='$id';";

    //do the edit!
    if (mysqli_query($db_connect, $edit_query)) {
      $msg = "Success!\r\n";
    }
    else {
      $msg = "ERROR: can't add item to database?\r\n" . mysqli_error($db_connect);
    }
    return $msg;
  }

  //start the session, so you can pass data back
  session_start();

  // GET THE DATA, CALL THE FUNCTION
  $form_type = $_POST[form_type];

  //make sure your data is valid
  foreach($_POST as $value) {
    $value = filter_var($value, FILTER_SANITIZE_STRING);
  }

  //there should be no reason that $msg will end up undefined
  //but just in case initialise it anyway.
  $msg = "";

  // go through and figure out what you need to do with the data
  // TODO: Make this not a giant if statement omfg but shhh works for now

  if ($form_type == "stock_add") {
    $msg = add_stock();
  }
  elseif ($form_type == "stock_edit") {
    $msg = edit_stock();
  }

  // If you can't figure out what to do with it, throw up an error message
  else {
    $msg .= "<p>Hello, this is process_form, something went wrong.
    I can't figure out what you want me to do with this data!
    Here's what you sent in...</p> \r\n";
    $msg .= "<p>";
    foreach ($_POST as $key => $var) {
      $msg .= $key . ": " . $var . "<br /> \r\n";
    }
    $msg .= "</p>";
  }

  // after data is processed, put the message string in session storage,
  // and redirect to the result page!
  //Debugging: comment out this bit, so you can see debug echos from above
  $_SESSION[msg] = $msg;
  //redirect stock-related things to the stock display page
  if (strstr($form_type, "stock")) {
    header("Location: /DP2-Group2/show_stock.php");
  }
?>
