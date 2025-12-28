<?php
session_start();
require 'db_connect.php';

// Hakikisha admin amelogin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product_id = intval($_POST['id']);

    // Pata product ili kupata jina kabla ya kuifuta
    $get_product = $conn->prepare("SELECT product_name FROM products WHERE id = ?");
    $get_product->bind_param("i", $product_id);
    $get_product->execute();
    $result = $get_product->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_name = $product['product_name'];

        // ======= 1️⃣ Delete (Soft delete ikiwa una column is_deleted) =======
        $delete_query = $conn->prepare("UPDATE products SET is_deleted = 1, deleted_by = ?, deleted_at = NOW() WHERE id = ?");
        $delete_query->bind_param("ii", $admin_id, $product_id);
        $delete_query->execute();

        // ======= 2️⃣ Save Activity kwa super_admin =======
        $details = "Admin ID $admin_id deleted product '$product_name' (ID: $product_id)";
        $log_activity = $conn->prepare("INSERT INTO admin_activity (admin_id, action_type, details) VALUES (?, 'delete_product', ?)");
        $log_activity->bind_param("is", $admin_id, $details);
        $log_activity->execute();

        // ======= 3️⃣ Redirect baada ya kufuta =======
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