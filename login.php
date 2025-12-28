<?php
session_start();
require 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Tumia prepared statement kwa usalama
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Weka session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect kulingana na role
            if ($row['role'] === 'super_admin') {
                header("Location: dashboard_super_admin.php");
            } elseif ($row['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } elseif ($row['role'] === 'customer') {
                header("Location: customer_dashboard.php");
            } else {
                // Iwapo role haipo sahihi
                $error = "Invalid user role!";
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Perfume Luxe - Login</title>
  <style>
    body {font-family: 'Segoe UI'; background: #f9f9f9; display:flex; justify-content:center; align-items:center; height:100vh;}
    .login-box {background:white;font-size:12px;color:pink; padding:30px; border-radius:10px; box-shadow:0 0 30px rgba(170, 20, 20, 0.81); width:300px;}
    input {width:90%; padding:15px; margin:8px 0; border:1px solid #ccc; border-radius:6px;}
    button {width:80%;color:white;font-size:18px;margin-left:30px;margin-top:20px; padding:12px; background:linear-gradient(to right,#ee9ca7,#ffdde1); border:none; border-radius:6px; font-weight:600; cursor:pointer;}
    button:hover {opacity:0.9;}
    .error {color:red; text-align:center;}
    label{font-size:16px;color:black;font-weight:600;font-family:sans-serif;}
    h2{color:violet;}
    .logo .logo-image {display:inline-block; font-size:20px; padding:0; animation:slow-rotate 8s linear infinite;}
    @keyframes slow-rotate {from {transform: rotate(0deg);} to {transform: rotate(360deg);}}
    a{text-decoration:none;}
  </style>
</head>
<body>
  <div class="login-box">
     <div class="logo">
      <span class="logo-image">🌸</span>
      <div class="logo-title">
        <span>𝗣</span><span>Ξ</span><span>𝗥</span><span>𝗙</span><span>𝗨</span><span>𝗠</span><span>Ξ</span>
      </div>
      <span class="logo-subtitle">ʟᴜxɛ</span>
    </div>

    <h2>Please Login to Continue</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <label for="email">Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <button type="submit">Login</button>
    </form>

    <p style="font-size:19px;">Don't have an account? <a href="user_registration.php" style="color:green;font-weight:600;">Register !.</a></p>
  </div>
</body>
</html>