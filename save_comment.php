<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$comment = mysqli_real_escape_string($conn, $_POST['comment']);

$sql = "INSERT INTO comments (user_id, comment) VALUES ('$user_id', '$comment')";

if (mysqli_query($conn, $sql)) {
    header("Location: about_perfume.php?success=1");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>