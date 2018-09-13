<!DOCTYPE html>
<html>
  <head>
      <title>Add Stock</title>
  </head>

  <body>
    <?php include "inc/header.php" ?>

    <section>
      <h3>Add New Stock Record</h3>

      <aside>
        <p>
          Reminder: this page is for adding completely new stock to the database.
          If you need to add new deliveries to existing stock records, use <a href="edit_stock">edit stock</a>.
        </p>
      </aside>

      <form action="process_form.php" method="post">
        <input type="hidden" name="form_type" id="form_type" value="stock_add" />
        <label for="item_name">Name: </label>
        <input type="text" name="item_name" id="item_name" required="required"/>
        <br />
        <label for="brand">Brand: </label>
        <input type="text" name="brand" id="brand" required="required" />
        <br />
        <label for="qty">Quantity: </label>
        <input type="number" name="qty" id="qty" required="required"/>
        <br />
        <label for="price">Price: </label>
        <input type="number" step="any" name="price" id="price" required="required"/>
        <br />

        <button type="submit">Submit!</button>

      </form>

    </section>

    <?php include "inc/footer.php" ?>
  </body>

</html>
