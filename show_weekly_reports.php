<!DOCTYPE html>
<html>
  <head>
      <title>Current Stock</title>
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

    <aside name="search_report_all" id="search_report_all">
      <form action="show_all_reports.php">
        <input type="hidden" name="search" id="search" value="reports" />
        <?php include "inc/report_sales_search.php" ?>
        <input type="hidden" name="search2" id="search2" value="reports2" />
        <?php include "inc/report_stock_search.php" ?>
      </form>
    </aside>

    <aside name="export_report_all" id="export_report_all">
      <form method="post" action="process_form.php">
        <input type="submit" name="form_type" id="form_type" value="ExportWeek"/>
      </form>
    </aside>

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


        $query = "SELECT * FROM stock WHERE active!='0'";

        $query2 = "SELECT sales.id, stock.item_name, stock.brand, sales.qty, sales.total, sales.date_time
                  FROM sales
                  INNER JOIN stock ON stock.id=sales.item_id
                  WHERE sales.id != '0'
                  GROUP BY WEEK(sales.date_time)
                  ORDER BY WEEK(sales.date_time)";


        $result = mysqli_query($db_connect, $query);
        $result2 = mysqli_query($db_connect, $query2);
        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result2) > 0) {
          ?>
          <h2> Stock </h2>
          <table>
            <tr>
              <th>Item</th>
              <th>Brand</th>
              <th>Quantity</th>
              <th>Price</th>
              <th></th>
            </tr>
            <?php
            foreach ($result as $row) {
              echo "<tr>\n";
              echo "<td>" . $row['item_name'] . "</td>\n";
              echo "<td>" . $row['brand'] . "</td>\n";
              echo "<td>" . $row['qty'] . "</td>\n";
              echo "<td>$" . number_format($row['price']/100, 2) . "</td>\n";
              echo "</tr>\n";
            }?>
          </table>
          <h2> Sales ordered and grouped by week </h2>
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
            foreach ($result2 as $row) {
              echo "<tr>\n";
              echo "<td>" . $row['item_name'] . "</td>\n";
              echo "<td>" . $row['brand'] . "</td>\n";
              echo "<td>" . $row['qty'] . "</td>\n";
              echo "<td>" . "$" . number_format($row['total']/100, 2) . "</td>\n";
              echo "<td>" . $row['date_time'] . "</td>\n";
              echo "</tr>\n";
            }?>
          </table>
          <?php
        }
        else {
          echo "No results.";
        }
      ?>
    <p><b>For the export to CSV to work you need to create a folder in C: drive called "files"</b></p>

    </section>
  </body>

</html>
