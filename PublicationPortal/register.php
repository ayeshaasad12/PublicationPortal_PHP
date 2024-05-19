

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Signup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
</head>
<style>
body{
    background-color: #d5f6ff!important;
    background-image: url(assets/register.webp);
    background-position: bottom;
    background-repeat: no-repeat;
    background-size: contain;
    height: 100vh;
    font-family: 'Poppins'!important;
}

section{
    background-image: url(/assets/bg.webp);
    background-position: center center;
    background-repeat: no-repeat;
    background-color: white;
}

h1{
    font-size: 24px;
    color: rgb(69, 126, 212);
}

h2{
    font-size: 16px;
}

button{
    background-color: rgb(69, 126, 212)!important;
    border: none!important;
    border-radius: 4px!important;
    font-size: 14px!important;
}

a,p{
    font-size: 14px;
}

img{
    height: 80%;
}

.container{
    min-width: 750px;
}

@media only screen and (max-width: 1024px) {
    .container {
    min-width: auto!important;
    }
}
</style>

<body class="d-flex align-items-center justify-content-center flex-column">
  <section class="mx-2 shadow rounded">
    <div class="container p-5">
      <div class="row">
        <div class="col-lg-8">
          <h1 class="text-center">Signup</h1>
          <h2 class="text-center">Please fill the form below to signup</h2>
          <form class="needs-validation" action="register_process.php" method="POST" novalidate>
            <div class="form-group my-2">
              <input type="text" class="form-control" id="inputUserName" name="username" placeholder="Username" required>
              <div class="invalid-feedback">Enter your correct username</div>
            </div>
            <div class="form-group my-2">
              <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
              <div class="invalid-feedback">Enter your correct email</div>
            </div>
            <div class="form-group my-2">
              <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password" required minlength="6">
              <div class="invalid-feedback">Enter your password (min 6 characters)</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4">
                <button type="submit" class="btn btn-primary">Sign up</button>
              </div>
              <div class="col-lg-8 text-end">
                <p>Already have an account? <a href="login.php">Login</a></p>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 text-center d-none d-lg-block">
          <img src="assets/image-1.webp" alt="sometext" class="img-fluid">
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
