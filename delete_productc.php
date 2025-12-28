<?php
session_start();
require 'db_connect.php';

// hakikisha admin amelogin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['user_id']; // admin anayefuta product

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product_id = intval($_POST['id']);

    // weka alama ya kufutwa (soft delete)
    $stmt = $conn->prepare("
        UPDATE products 
        SET is_deleted = 1, deleted_by = ?, deleted_at = NOW()
        WHERE id = ?
    ");
    $stmt->bind_param("ii", $id, $product_id);
    $stmt->execute();

    // kurudi kwenye dashboard
    header("Location: admin_products.php?msg=deleted_success");
    exit();
 } else {
      // kama hakuna id iliyopokelewa
  header("Location: admin_products.php?error=no_id");
  exit();
}
?>