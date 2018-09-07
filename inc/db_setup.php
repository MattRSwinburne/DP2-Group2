<!DOCTYPE html>
<html>
  <head>
      <title>Drop Database</title>
  </head>

  <body>

    <?php include "header.php" ?>

    <section>

      <?php

        include_once "db_setup_queries.php";

        //connect to database platform
        $db_connect = mysqli_connect($host, $username, $pwd);

        //make sure it actually connects
        if (mysqli_connect_errno())
          {
            echo "<p>DB Connection Error: " . mysqli_connect_error() . "</p>";
          }
        //check if the database we want exists
        if (mysqli_query($db_connect, $have_db_query)) {
          echo "<p>We have the database!</p>";
        } else {
          echo "<p>Error - database creation: " . mysqli_error($db_connect) . "</p>";
        };

        //use the database
        //using $db instead of hard-coding values
        //means that we don't have to have the same db name
        mysqli_query($db_connect, "USE " . $db);

        //check if the tables exist
        //these we DO have to have named identically
        if (mysqli_query($db_connect, $stock_table_query)) {
          echo "<p>We have stock!</p>";
        } else {
          echo "Error - stock database: " .  mysqli_error($db_connect) . "</p>";
        }
        if (mysqli_query($db_connect, $sales_table_query)) {
          echo "<p>We have sales!</p>";
        } else {
          echo "Error - sales database: " .  mysqli_error($db_connect) . "</p>";
        }

      ?>

    </section>

    <?php include "footer.php" ?>

  </body>

</html>
