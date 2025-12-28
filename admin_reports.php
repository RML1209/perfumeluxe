<?php
session_start();
require 'db_connect.php'; 

// -------- AUTHENTICATION CHECK ----------
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'super_admin') {
    echo "Access Denied!";
    exit();
}

// 1. Pata ID ya Admin anayeangaliwa kutoka kwenye URL
if (!isset($_GET['admin_id']) || !is_numeric($_GET['admin_id'])) {
    echo "Error: Admin ID not specified.";
    exit();
}

$admin_to_view_id = $_GET['admin_id'];

// Tutaendelea kutumia $admin_to_view_id badala ya $admin_id kwenye Queries
$target_admin_info = $conn->query("SELECT name FROM users WHERE id = '$admin_to_view_id' AND role = 'admin'")->fetch_assoc();
$target_admin_name = $target_admin_info ? htmlspecialchars($target_admin_info['name']) : "Unknown Admin";

// ================= INSIGHTS =================

// 1. Total Products (Sasa inatumia created_by na ID ya Admin anayeangaliwa)
$result = $conn->query("SELECT COUNT(*) AS total_products FROM products WHERE is_deleted = 0 AND created_by = '$admin_to_view_id'");
$total_products = $result->fetch_assoc()['total_products'];

// 2. Total Orders (Global Insights - Bado Global)
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = $result->fetch_assoc()['total_orders'];

// ... (Queries zingine za Global - Total Customers, Best Selling, Latest Orders, New Customers - zitaendelea kuwa Global)

// 7. Recently Added Products (Sasa inatumia created_by na ID ya Admin anayeangaliwa)
$newProducts = $conn->query("
    SELECT id, name, brand, created_at
    FROM products
    WHERE is_deleted = 0 AND created_by = '$admin_to_view_id'
    ORDER BY id DESC
    LIMIT 5
");
// ... End of PHP logic ...

// Kisha kwenye HTML, tutabadilisha vichwa vya habari na kuweka link ya Grafu

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reports for <?php echo $target_admin_name; ?></title>

<style> 
/* Weka CSS zote za dashboard_insights.php hapa */
body { font-family: "Poppins", sans-serif; background: #f5f6fa; margin: 0; padding: 0; }
.container { width: 90%; max-width: 1200px; margin: auto; padding: 20px 0; }
.top-bar-buttons { display: flex; justify-content: space-between; margin-bottom: 20px; }
.btn-graph, .btn-back { padding: 10px 20px; background: #42a5f5; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; transition: 0.3s; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
.btn-back { background: #d81b60; }
h1 { text-align: center; margin-bottom: 30px; font-size: 32px; color: #d81b60; text-transform: uppercase; letter-spacing: 1px; }
/* ... (Weka CSS zote za cards, sections, na tables kutoka dashboard_insights.php hapa) ... */
</style>
</head>

<body>
<div class="container">

    <div class="top-bar-buttons">
        <button class="btn-back" onclick="window.location.href = 'super_admin_insights.php'">⬅ Back to Admin List</button>
        <a href="admin_reports_graph.php?admin_id=<?php echo $admin_to_view_id; ?>" class="btn-graph">📊 View Graphs for <?php echo $target_admin_name; ?></a>
    </div>

    <h1>Insights for: <?php echo $target_admin_name; ?></h1>

    <div class="insights-container">

        <div class="card">
            <h3>Products Created (<?php echo $target_admin_name; ?>)</h3>
            <p><?php echo $total_products; ?></p>
        </div>

        </div>
    
    </div>
</body>
</html>
