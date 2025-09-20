<?php require_once 'classloader.php'; ?>

<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-image: url("https://img.freepik.com/free-vector/winter-blue-pink-gradient-background-vector_53876-117275.jpg?t=st=1746104039~exp=1746107639~hmac=2f238261c795cf2f54851b4f9f1b1bda806f8a408384522f6de69dcd5115750f&w=1380");
      }
      * {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif !important;
      }
  </style>
  <title>Writer Registration</title>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 p-5">
        <div class="card shadow">
          <div class="card-header">
            <h2>Welcome to the writer side, Register Now as writer!</h2>
          </div>
          <form action="core/handleForms.php" method="POST">
            <div class="card-body">
              <?php  
              if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                if ($_SESSION['status'] == "200") {
                  echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
                } else {
                  echo "<div class='alert alert-danger'>{$_SESSION['message']}</div>"; 
                }
              }
              unset($_SESSION['message']);
              unset($_SESSION['status']);
              ?>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
              </div>
              <button type="submit" class="btn btn-primary float-right mt-4" name="insertNewUserBtn">Register as Writer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>