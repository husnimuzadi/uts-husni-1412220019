<?php
session_start();
require 'functions.php'; // Mengambil fungsi eksternal
$conn = mysqli_connect("localhost", "root", "", "husni-1412220019");

// Cek apakah user sudah login menggunakan cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
  $row = mysqli_fetch_assoc($result);

  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}

// Redirect jika user sudah login
if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

// Proses data saat login
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;

      // Periksa apakah remember me diaktifkan
      if (isset($_POST['remember'])) {
        // Set cookie
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }

      header("Location: index.php");
      exit;
    }
  }

  $error = true; // Set flag error jika login gagal
}
?>


<!DOCTYPE html>
<html>
<head>

   <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <title>Halaman Login</title>
  <style>
    label {
      display: block;
    }
  body {
    font-family: Arial, sans-serif;
    background-color: #F7F7F7;
  }

  h1 {
    text-align: center;
    color: #3E3E3E;
    margin-top: 50px;
  }

  form {
    max-width: 500px;
    margin: 0 auto;
    background-color: #FFFFFF;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
  }

  ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  li {
    margin-bottom: 10px;
  }

  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #BFBFBF;
    border-radius: 5px;
    font-size: 16px;
    color: #3E3E3E;
  }

  button[type="submit"] {
    background-color: #4285F4;
    color: #FFFFFF;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }

  button[type="submit"]:hover {
    background-color: #357AE8;
  }

  p {
  font-size: 16px;
  color: #333;
  text-align: center;
  display: block;
}

a {
  color: blue;
  text-decoration: underline;
}
</style>

  </style>
</head>
<body>

  <?php if (isset($error))  : ?>

<script>

            alert('Username & Password salah');
            document.location.href = 'login.php';


        </script> 

  <?php endif; ?>

<div class="container">
<h1 class="text-center my-5"><i class="bi bi-box-arrow-in-right"></i> Masuk</h1>





    <form action="" method="post">
        <div class="form-group">
  <label for="username">
    <i class="fas fa-user"></i> Username
  </label>
  <div class="input-group">
    <input type="text" name="username" id="username" class="form-control">
    <div class="input-group-append">
      <span class="input-group-text"><i class="bi bi-keyboard"></i></span>
    </div>
  </div>
</div>
         <div class="form-group">
  <label for="password">
    <i class="fas fa-lock"></i> Password
  </label>
  <div class="input-group">
    <input type="password" name="password" id="password" class="form-control">
    <div class="input-group-append">
      <span class="input-group-text"><i class="bi bi-keyboard"></i></span>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="input-group">
    <label for="remember">Remember Me </label>
    <div class="input-group-append ml-1">
      <div class="input-group-text">
        <input type="checkbox" name="remember" id="remember">
      </div>
    </div>
  </div>
</div>

         
      
        <button type="submit" name="login" id="login" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Login
        </button>
    </form>
</div>
<p>Klik di sini untuk <a href="registrasi.php">Buat Akun</a></p>
<p><a href="forgot.php">Lupa Password?</a></p>

</body>
</html>