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

        //drop database
        if (mysqli_query($db_connect, $drop_db_query)) {
          echo "<p>Database is gone!</p>";
        } else {
          echo "Error - drop database: " .  mysqli_error($db_connect) . "</p>";
        }

      ?>

    </section>

    <?php include "footer.php" ?>

  </body>

</html>
