<?php
require 'db_connect.php'; // hakikisha connection ipo sahihi

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO suggestions (email, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $message);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Thank you for your suggestion!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Something went wrong. Please try again.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Please fill all fields.');
                window.history.back();
              </script>";
    }
}
?>