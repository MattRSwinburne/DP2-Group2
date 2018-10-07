<?php
    $title = "Show Sales";
    include "inc/html-head.php";
    include "inc/header.php" ?>

    <aside name="server_message" id="server_message">
      <?php
        session_start();
        if (isset($_SESSION['msg'])) {
          echo $_SESSION['msg'];
        }
        $_SESSION['msg'] = "";
       ?>
    </aside>

    <aside name="sales_search" id="sales_search">
      <form action="show_sales.php">
        <input type="hidden" name="search" id="search" value="sales" />
        <?php include "inc/sales_search.php" ?>
        <button type="submit">Submit!</button>
        <a href="show_sales.php"><button type="button">Reset</button></a>
      </form>
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

        $query = "SELECT sales.id, stock.item_name, stock.brand, sales.qty, sales.total, sales.date_time
                  FROM sales
                  INNER JOIN stock ON stock.id=sales.item_id
                  WHERE sales.id != '0'";


        if (isset($_GET["search"])) {
          if ($_GET["item_name"] != "") {
            $query .= "AND stock.item_name LIKE '%" . $_GET["item_name"] . "%'";
          }
          if ($_GET["brand"] != "") {
            $query .= "AND stock.brand LIKE '%" . $_GET["brand"] . "%'";
          }
          if ($_GET["qty"] != "") {
            $query .= "AND sales.qty" . $_GET["qty_range_symbol"] . "'" . $_GET["qty"] . "'";
          }
          if ($_GET["total"] != "") {
            $query .= "AND sales.total" . $_GET["total_range_symbol"]  . "'" . $_GET["total"]*100 . "'";
          }
          if ($_GET["date"] != "") {
            $query .= "AND DATE(sales.date_time)='" . $_GET["date"] . "'";
          }
        }
        //if your query is buggy  (check you're putting your data in the right box before anything, SELF :/)
        // echo $query;
        $result = mysqli_query($db_connect, $query);
        if (mysqli_num_rows($result) > 0) {
          ?>
          <table>
            <tr>
              <th>Item</th>
              <th>Brand</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Date</th>
              <th></th>
            </tr>
            <?php
            foreach ($result as $row) {
              echo "<tr>\n";
              echo "<td>" . $row['item_name'] . "</td>\n";
              echo "<td>" . $row['brand'] . "</td>\n";
              echo "<td>" . $row['qty'] . "</td>\n";
              echo "<td>" . "$" . number_format($row['total']/100, 2) . "</td>\n";
              echo "<td>" . $row['date_time'] . "</td>\n";
              echo "<td><a href='edit_sales.php?saleid=". $row['id']."'>edit</a>";
              echo "</tr>\n";
            }?>
          </table>
          <?php
        }
        else {
          echo "No results.";
        }

      ?>

    </section>

    <?php include "inc/footer.php" ?>
  </body>

</html>
