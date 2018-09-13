<!DOCTYPE html>
<html>
  <head>
      <title>Result</title>
  </head>

  <body>
    <?php include "inc/header.php" ?>

    <aside name="server_message" id="server_message">
      <?php
        session_start();
        echo $_SESSION[msg];
        $_SESSION[msg] = "";
       ?>
    </aside>

    <section>

      [HELLO THIS IS THE DISPLAY SECTION HI]

    </section>

    <?php include "inc/footer.php" ?>
  </body>

</html>
