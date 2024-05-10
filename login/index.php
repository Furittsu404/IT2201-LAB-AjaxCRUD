<?php
session_start();
require 'authentication.php';
require '../db/connection.php';

$conn = new Connection();
$db = new Authentication($conn->connect());

if (isset($_SESSION['user_ID'])) {
  header("Location: ../admin");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['user_Email'];
  $password = $_POST['user_Password'];
  
  if (isset($_POST['login'])) {
    $db->login($email, $password);
  }
  if (isset($_POST['register'])) {
    $verifyEmail = $db->verifyEmail($email);
    if ($verifyEmail) {
      echo "<script>alert('Email already exists!')</script>";
      echo "<script>location.reload();</script>";
      exit();
    }
    $_POST['user_Password'] = password_hash($password, PASSWORD_BCRYPT);
    $form = $_POST;
    $db->register($email, $form);
    $db->login($email, $password);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <title>Log in | Register</title>
</head>

<body>
  <a href="../">
    <svg class="close-button" fill="none" height="40" viewBox="0 0 48 48" width="40" xmlns="http://www.w3.org/2000/svg">
      <path d="m0 0h48v48h-48z" fill="#fff" fill-opacity=".01" />
      <g stroke="rgba(55, 55, 55, 0.9)" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
        <path d="m8 8 32 32" />
        <path d="m8 40 32-32" />
      </g>
    </svg>
  </a>

  <div class="form-container">
    <div class="col col-1">
      <div class="image-layer">
        <img src="../img/natooo.png" class="form-image-main " />
        <img src="../img/cloud.png" class="form-image-1 fi-2" />
        <img src="../img/cloud.png" class="form-image-2 fi-2" />
      </div>
      <p class="featured-words">
        <img src="../img/UTS-Express.png" class="logo"><br />
      </p>
    </div>
    <div class="col col-2">
      <br>
      <div class="btn-box">
        <button class="btn btn-1" id="login">Sign In</button>
        <button class="btn btn-2" id="register">Sign Up</button>
      </div>

      <!-- =================== Login-Form =================== -->
      <br>
      <form method="post" action="">
        <div class="login-form">
          <div class="form-title">
            <span>Sign In</span>
          </div>
          <div class="form-inputs">
            <div class="input-box">
              <input type="text" class="input-field" oninput="letterOnly(this.id);" name="user_Email" id="login_Email" placeholder="Email" />
              <i class="bx bx-user icon"></i>
            </div>
            <div class="input-box">
              <input type="password" class="input-field" oninput="validSymbol(this.id);" name="user_Password" id="login_Password" placeholder="Password" />
              <i class="bx bx-lock-alt icon"></i>
            </div>
            <div class="forget-pass">
              <a id="forgot-password" class="forgot-pass">Forgot Password</a>
            </div>
            <div class="input-box">
              <button name="login" class="input-submit">
                <span>Sign In</span>
                <i class="bx bx-right-arrow-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </form>

      <!-- =================== Register-Form =================== -->

      <form method="post" action="">
        <div class="register-form">
          <div class="form-title">
            <span>Sign Up</span>
          </div>
          <div class="form-inputs">
            <div class="input-box">
              <input type="text" class="input-field" oninput="letterOnly(this.id);" name="user_Name" id="register_Name" placeholder="Name" />
              <i class="bx bx-user icon"></i>
            </div>
            <div class="input-box">
              <input type="text" class="input-field" oninput="validSymbol(this.id);" name="user_Nickname" id="register_Nickname" placeholder="Nickname" />
              <i class="bx bx-user icon"></i>
            </div>
            <div class="input-box">
              <input type="email" class="input-field" oninput="letterOnly(this.id);" name="user_Email" id="register_Email" placeholder="Email" />
              <i class="bx bx-envelope icon"></i>
            </div>
            <div class="input-box">
              <input type="password" class="input-field" oninput="validSymbol(this.id);" name="user_Password" id="register_Password" placeholder="Password" />
              <i class="bx bx-lock-alt icon"></i>
            </div>
            <div class="input-box">
              <button name="register" class="input-submit">
                <span>Sign Up</span>
                <i class="bx bx-right-arrow-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </form>

      <!-- =================== Forgot-Password =================== -->

      <form method="post" action="">
        <div class="forgot-password-form">
          <div class="form-title">
            <span>Forgot Password</span>
          </div>
          <div class="form-inputs">
            <div class="input-box">
              <input type="email" class="input-field" oninput="letterOnly(this.id);" name="user_Email" id="forgotPasswordEmail" placeholder="Email" />
              <i class="bx bx-envelope icon"></i>
            </div>
            <div class="input-box">
              <button name="forgot-password" class="input-submit">
                <span>Send</span>
                <i class="bx bx-right-arrow-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>

  <script src="../js/script.js"></script>
</body>

</html>