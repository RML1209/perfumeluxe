<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php");
  exit();
}


$id = intval($_GET['id']); // ID ya admin anayebadilishiwa password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
  $conn->query("UPDATE users SET password='$new_password' WHERE id=$id");

  header("Location: manage_admins.php?msg=Password Changed Successfully");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Admin Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      color:pink;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(156, 26, 26, 0.72);
    }
    input[type="password"], button {
      display: block;
      width: 90%;
      margin: 10px 0;
      padding: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
      
    }
    button {
      background: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      width: 80%;
      margin-left:30px;
      margin-top:25px; 
      padding:12px;
      font-size:18px;
    }
    button:hover {
      background: #0056b3;
    }
    h2{
      color:violet;
      font-size:18px;
    }
    label{
    font-size:14px;
    color:black;
    font-weight:600;
    font-family:sans-serif;  
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
    <h2>Fill the form below to change admin password.</h2>
    <label for="new_password">New password</label>
    <input type="password" name="new_password" placeholder="Enter new password" required>
    <button type="submit">Update Password</button>
  </form>
</body>
</html>