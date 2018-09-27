<!DOCTYPE html>
<html>
  <head>
      <title>Edit Stock</title>
  </head>

  <body>
    <?php include "inc/header.php" ?>

    <section>
      <?php
        include_once "inc/db_connect.php";
        //connect to db
        $db_connect = mysqli_connect($host, $username, $pwd, $db);

        //make sure it actually connects
        if (mysqli_connect_errno())
        {
          echo "<p>DB Connection Error: " . mysqli_connect_error() . "</p>";
        }
        //Testing: if you're having trouble with the connection, uncomment for stats
        // echo "Connection status: " . mysqli_stat($db_connect);

        //if you don't have a thing you're editing yet, search for a thing!
        if (!isset($_GET['stockid'])) {
          ?>
          <form action="process_form.php" method="post">
            <input type="hidden" name="form_type" id="form_type" value="stock_edit_search" />
          <?php

            include "inc/stock_search.php";
            echo "</form>";
        }
        else {
          $editing_query = "SELECT * FROM stock WHERE id = " . $_GET['stockid'];
          $editing = mysqli_query($db_connect, $editing_query);
          if (mysqli_num_rows($editing) > 1) {
            echo "ERROR: can only edit one item at a time.";
          }
          elseif (mysqli_num_rows($editing) == 0) {
            echo "ERROR: Can't find item in stock";
          }
          else {
            $editing = mysqli_fetch_assoc($editing);
            echo "<p>You are editing " . $editing['item_name'] . " (" . $editing['brand'] . ").</p>";
            ?>
            <form action="process_form.php" method="post">
              <input type="hidden" name="form_type" id="form_type" value="stock_edit" />
              <input type="hidden" name="stockid" id="stockid" value="<?php echo $_GET['stockid'] ?>" />
              <label for="item_name">Name: </label>
              <input type="text" name="item_name" id="item_name" value="<?php echo $editing['item_name'] ?>" />
              <br />
              <label for="brand">Brand: </label>
              <input type="text" name="brand" id="brand" value="<?php echo $editing['brand'] ?>"/>
              <br />
              <label for="qty">Quantity: </label>
              <input type="number" name="qty" id="qty" value="<?php echo $editing['qty'] ?>"/>
              <br />
              <label for="price">Price: </label>
              <!-- The below ALLOWS two decimal places, but trailing 0s will be cut off :(-->
              <!-- Cannot be fixed without javascript, so am leaving it at the moment.-->
              <input type="number" step="any" name="price" id="price" value="<?php echo number_format($editing['price']/100, 2) ?>"/>
              <br />
              <button type="submit">Submit</button> <button type="reset">Reset</button>
            </form>
            <?php
          }
        }
      ?>
    </section>

    <?php include "inc/footer.php" ?>
  </body>

</html>
