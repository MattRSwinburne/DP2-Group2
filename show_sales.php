<!DOCTYPE html>
<html>
  <head>
      <title>Current Sales</title>
  </head>

  <body>
    <?php include "inc/header.php" ?>

    <aside name="server_message" id="server_message">
      <?php
        session_start();
        if (isset($_SESSION['msg'])) {
          echo $_SESSION['msg'];
        }
        $_SESSION['msg'] = "";
       ?>
    </aside>

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

        $query = "SELECT * FROM sales";
        $result = mysqli_query($db_connect, $query);
        if (mysqli_num_rows($result) > 0) {
          ?>
          <table>
            <tr>
              <th>Item</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Date</th>
              <th></th>
            </tr>
            <?php
            foreach ($result as $row) {
              echo "<tr>\n";
              echo "<td>" . $row['item_id'] . "</td>\n";
              echo "<td>" . $row['qty'] . "</td>\n";
              echo "<td>" . $row['total'] . "</td>\n";
              echo "<td>" . $row['date_time'] . "</td>\n";
              echo "<td><a href='edit_sales.php?saleid=". $row['id']."'>edit</a>";
              echo "</tr>\n";
            }?>
          </table>
          <?php
        }
        else {
          echo "ERROR:Sale table is empty.";
        }

      ?>

    </section>

    <?php include "inc/footer.php" ?>
  </body>

</html>
