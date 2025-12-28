

<?php
session_start();
require 'db_connect.php';

// Hakikisha ni admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Hakikisha ni DELETE request kutoka kwa button
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Product ID
    $admin_id = $_SESSION['user_id']; // Admin aliyefuta

    // Check kama product ipo
    $check = $conn->prepare("SELECT id FROM products WHERE id = ? AND is_deleted = 0");
    $check->bind_param("i", $id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        // Futa product (soft delete)
        $stmt = $conn->prepare("UPDATE products SET is_deleted = 1, deleted_by = ?, deleted_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $id);
        $stmt->execute();

        header("Location: admin_products.php?msg=deleted_success");
        exit();
    } else {
        header("Location: admin_products.php?error=not_found");
        exit();
    }
} else {
    header("Location: admin_products.php?error=invalid_request");
    exit();
}
?>