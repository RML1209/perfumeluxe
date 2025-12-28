<?php
require 'db_connect.php'; // Hakikisha connection ipo sahihi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $location = $_POST['location'] ?? '';

    // Hakikisha input zimejazwa
    if (!empty($phone) && !empty($location) && !empty($product_id)) {

        // Pata product_name na admin aliyemiliki product hiyo
        $pstmt = $conn->prepare("SELECT name, created_by FROM products WHERE id = ?");
        $pstmt->bind_param("i", $product_id);
        $pstmt->execute();
        $pstmt->bind_result($product_name, $ordered_by_admin);
        $pstmt->fetch();
        $pstmt->close();

        if (!empty($product_name)) {
            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (product_id, customer_phone, location, product_name, ordered_by_admin)
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $product_id, $phone, $location, $product_name, $ordered_by_admin);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Query failed: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "invalid_product";
        }

    } else {
        echo "missing_fields";
    }
} else {
    echo "invalid_request";
}
?>