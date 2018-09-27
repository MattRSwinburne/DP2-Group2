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
        if (!isset($_GET['saleid'])) {
          ?>
          <form action="process_form.php" method="post">
            <input type="hidden" name="form_type" id="form_type" value="sale_edit_search" />
          <?php

            include "inc/sale_search.php";
            echo "</form>";
        }
        else {
          $editing_query = "SELECT * FROM sales WHERE id = " . $_GET['saleid'];
          $editing = mysqli_query($db_connect, $editing_query);
          if (mysqli_num_rows($editing) == 0) {
            echo "ERROR: Can't find item in sales";
          }
          else {
            $editing = mysqli_fetch_assoc($editing);
            echo "<p>You are editing " . $editing['item_id'] . ".</p>";
            ?>
            <form action="process_form.php" method="post">
              <input type="hidden" name="form_type" id="form_type" value="sales_edit" />
              <input type="hidden" name="saleid" id="saleid" value="<?php echo $_GET['saleid'] ?>" />
              <label for="item_id">Item id: </label>
              <input type="number" name="item_id" id="item_id" value="<?php echo $editing['item_id'] ?>" />
              <br />
              <label for="brand">Quantity </label>
              <input type="number" name="qty" id="qty" value="<?php echo $editing['qty'] ?>"/>
              <br />
              <label for="qty">Date:</label>
              <input type="date" name="date_time" id="date_time" value="<?php echo $editing['date_time'] ?>"/>
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
