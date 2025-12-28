<?php
session_start();
require 'db_connect.php';

// Only allow admins (not super_admins)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit();
}

// // Hakikisha ni admin pekee anaingia
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//   header("Location: login.php");
//   exit();
// }

// Search variables (ili kuepuka undefined errors)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_order = isset($_GET['search_order']) ? trim($_GET['search_order']) : '';

// ====== SEARCH PRODUCTS ======
$sql_products = "SELECT * FROM products WHERE is_deleted = 0";
if (!empty($search)) {
  $sql_products .= " AND (name LIKE '%$search%' OR scent_type LIKE '%$search%' OR price LIKE '%$search%')";
}
$sql_products .= " ORDER BY created_at DESC";
$products = $conn->query($sql_products);

// ====== SEARCH ORDERS ======
$sql_orders = "SELECT * FROM orders";
if (!empty($search_order)) {
  $sql_orders .= " WHERE (customer_phone LIKE '%$search_order%' OR product_name LIKE '%$search_order%' OR location LIKE '%$search_order%')";
}
$sql_orders .= " ORDER BY created_at DESC";
$orders = $conn->query($sql_orders);

// $search_order = '';
// if (isset($_GET['order_search'])) {
//   $search_order = trim($_GET['order_search']);
//   $like = "%$search_order%";
  
//   $stmt = $conn->prepare("SELECT customer_phone,product_name,location,created_at FROM orders 
//     WHERE (customer_phone LIKE ? OR location LIKE ? OR product_name LIKE ?)
//     ORDER BY created_at DESC");
//   $stmt->bind_param("sss", $like, $like, $like);
//   $stmt->execute();
//   $orders = $stmt->get_result();
// } else {
//   $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
// }





// // hakikisha admin yupo
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//   header("Location: login.php");
//   exit;
// }

// $search = "";
// if (isset($_GET['search'])) {
//   $search = trim($_GET['search']);
//   $like = "%$search%";
//   $stmt = $conn->prepare("SELECT * FROM products 
//     WHERE (name LIKE ? OR brand LIKE ? OR scent_type LIKE ? OR gender LIKE ?) 
//       AND is_deleted = 0
//     ORDER BY created_at DESC");
//   $stmt->bind_param("ssss", $like, $like, $like, $like);
//   $stmt->execute();
//   $result = $stmt->get_result();
// } else {
//   $result = $conn->query("SELECT * FROM products WHERE is_deleted = 0 ORDER BY created_at DESC");
// }
?>
