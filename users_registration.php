<?php
require 'db_connect.php'; // hakikisha connection ipo sahihi
$error = "";
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // hakikisha kila kitu kimejazwa
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // angalia kama email tayari ipo
        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // encrypt password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            

            // insert data mpya
            $role = 'customer';
            $stmt = $conn->prepare("INSERT INTO users (name, email, role, password, created_at) VALUES (? , ?, ?, ? ,NOW())");
            $stmt->bind_param("ssss", $name, $email, $role, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Failed to register. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Perfume Luxe - Customer Registration</title>
  <style>
    body {font-family: 'Segoe UI'; background: #f9f9f9; display:flex; justify-content:center; align-items:center; height:100vh;}
    .login-box {background:white;font-size:12px;color:pink; padding:30px; border-radius:10px; box-shadow:0 0 30px rgba(170, 20, 20, 0.81); width:300px;}
    input {width:90%; padding:15px; margin:8px 0; border:1px solid #ccc; border-radius:6px;}
    button {width:80%;color:white;font-size:18px;margin-left:30px;margin-top:20px; padding:12px; background:linear-gradient(to right,#ee9ca7,#ffdde1); border:none; border-radius:6px; font-weight:600; cursor:pointer;}
    button:hover {opacity:0.9;}
    .error {color:red; text-align:center; font-weight:600;}
    .success {color:green; text-align:center; font-weight:600;}
    label{font-size:16px;color:black;font-weight:600;font-family:sans-serif;}
    h2{color:violet;}
    .logo .logo-image {display:inline-block; font-size:20px; animation:slow-rotate 8s linear infinite;}
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

    <h2>Please fill the form to register.</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
      <label>Username</label>
      <input type="text" name="name" placeholder="Enter your username" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <label>Confirm Password</label>
      <input type="password" name="confirm_password" placeholder="Re-enter your password" required>

      <button type="submit">Register</button>
    </form>

    <p style="font-size:19px;">Have an account? <a href="login.php" style="color:green;font-weight:600;">Login now!</a></p>
  </div>
</body>
</html>