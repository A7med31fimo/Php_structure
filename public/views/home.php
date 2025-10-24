<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Home | CV-Creator</title>
  <script>
    // Check token before showing page
    // localStorage.clear()

    const token = localStorage.getItem("auth_token");

    // console.log(token)
    if (!token) {
      window.location.href = "http://localhost/Php_structure/public/views/auth/login.php";
    }
    // Prevent going back to login after login
    // window.history.pushState(null, "", window.location.href);
    // window.onpopstate = function() {
    // window.history.pushState(null, "", window.location.href);
    // };
  </script>
</head>

<body>
  <?php
  session_start();
  require "./navbar.php";
  require "./header.php";
  require "./body.php";
  require "./footer.php";
  ?>
</body>

</html>