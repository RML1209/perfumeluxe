<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php");
  exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'admin')";

  if ($conn->query($sql)) {
    $message = "Admin registered successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register Admin - Perfume Luxe</title>
  <style>
    body {font-family: 'Segoe UI'; background:#f2f2f2; display:flex; justify-content:center; align-items:center; height:100vh;}
    form {background:white; padding:20px;color:pink; border-radius:10px; width:300px; box-shadow:0 0 20px rgba(137, 12, 12, 0.71);}
    input {width:90%; padding:15px; margin:8px 0; border:1px solid #ccc; border-radius:6px;}
    button {background:linear-gradient(to right,#ee9ca7,#ffdde1); border:none; padding:12px; width:80%; border-radius:6px;color:white;font-size:18px;margin-left:30px;margin-top:20px; cursor:pointer;}
    button:hover {opacity:0.9;}
     label{font-size:14px;color:black;font-weight:600;font-family:sans-serif;}
    .message {text-align:center; color:green;}

      h3{
      color:violet;
      font-size:16px;
    }
     .logo .logo-image {
      display: inline-block;
      font-size: 20px;
      padding: 0px;
      animation: slow-rotate 8s linear infinite;
    }
    @keyframes slow-rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
  </style>
</head>
<body>
  <form method="POST">
     <div class="login-box">
     <div class="logo">
      <span class="logo-image">🌸</span>
      <div class="logo-title">
        <span>𝗣</span><span>Ξ</span><span>𝗥</span><span>𝗙</span><span>𝗨</span><span>𝗠</span><span>Ξ</span>
      </div>
      <span class="logo-subtitle">ʟᴜxɛ</span>
    </div>
    <h3>Fill the form to register new admin.</h3>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
    <label for="name">Full name</label>
    <input type="text" name="name" placeholder="Enter full name" required>
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Enter email" required>
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Enter password" required>
    <button type="submit">Register Admin</button>
  </form>
</body>
</html>