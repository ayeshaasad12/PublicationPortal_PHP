<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex align-items-center justify-content-center flex-column">
  <section class="mx-2 shadow rounded">
    <div class="container p-5">
      <div class="row">
        <div class="col-lg-8">
          <h1 class="text-center">Login</h1>
          <h2 class="text-center">Please fill the form below to login</h2>

          <?php
          session_start();
          if (isset($_SESSION['error'])) {
              echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
              unset($_SESSION['error']);
          }
          ?>
          <form class="needs-validation" action="login_process.php" method="POST" novalidate>
            <div class="form-group my-2">
              <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
              <div class="invalid-feedback">Enter your correct email.</div>
            </div>
            <div class="form-group my-2">
              <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password" required>
              <div class="invalid-feedback">Enter your password (min 6 characters).</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4">
                <button type="submit" class="btn btn-primary">Sign in</button>
              </div>
              <div class="col-lg-8 text-end">
                <p>Not a Member? <a href="register.php">Register</a></p>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 text-center d-none d-lg-block">
          <img src="Capture.JPG" alt="sometext" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <script>
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>
</html>
