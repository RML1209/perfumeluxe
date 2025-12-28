

<?php
session_start();
require 'db_connect.php'; 

// -------- AUTHENTICATION CHECK (Only admin allowed) ----------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Access Denied! Only Admin can view his/her insights.";
    exit();
}

$admin_id = $_SESSION['user_id']; // ID ya admin aliyeingia

// ================= INSIGHTS =================

// 1. Total Products (Admin Activity - created_by)
$result = $conn->query("SELECT COUNT(*) AS total_products FROM products WHERE is_deleted = 0 AND created_by = '$admin_id'");
$total_products = $result->fetch_assoc()['total_products'];

// 2. Total Orders (IMEREKEBISHWA - Inatumia ordered_by_admin)
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders WHERE ordered_by_admin = '$admin_id'");
$total_orders = $result->fetch_assoc()['total_orders'];

// 3. Total Customers (HAZIBADILISHWI - Global Insights)
$result = $conn->query("SELECT COUNT(*) AS total_customers FROM users WHERE role='customer'");
$total_customers = $result->fetch_assoc()['total_customers'];

// 4. Best Selling Products (IMEREKEBISHWA - Inatumia ordered_by_admin)
$bestSelling = $conn->query("
    SELECT products.name, COUNT(orders.id) AS total_sold
    FROM orders
    JOIN products ON orders.product_id = products.id
    WHERE orders.ordered_by_admin = '$admin_id'
    GROUP BY products.id
    ORDER BY total_sold DESC
    LIMIT 5
");

// 5. Latest Orders (IMEREKEBISHWA - Inatumia ordered_by_admin)
$latestOrders = $conn->query("
    SELECT * FROM orders 
    WHERE ordered_by_admin = '$admin_id' 
    ORDER BY id DESC 
    LIMIT 5
");

// 6. New Customers (HAZIBADILISHWI - Global Insights)
$newCustomers = $conn->query("
    SELECT id, name, email, created_at
    FROM users
    WHERE role='customer'
    ORDER BY id DESC
");

// 7. Recently Added Products (Admin Activity - created_by)
$newProducts = $conn->query("
    SELECT id, name, brand, created_at
    FROM products
    WHERE is_deleted = 0 AND created_by = '$admin_id'
    ORDER BY id DESC
    LIMIT 5
");
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard Insights</title>

<style>
body {
    font-family: "Poppins", sans-serif;
    background: #f5f6fa;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
    padding: 20px 0;
}

/* NEW: Kitufe cha Grafu Kwenye Juu Kulia */
.top-bar-buttons {
    display: flex;
    justify-content: flex-end; 
    margin-bottom: 20px;
}

.btn-graph {
    padding: 10px 20px;
    background: #42a5f5; /* Rangi ya Bluu */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-graph:hover {
    background: #1e88e5;
    transform: translateY(-2px);
}
/* END NEW CSS */


h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #d81b60;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* TOP CARDS */
.insights-container {
    display: flex;
    gap: 20px;
    margin: 20px 0;
}

.card {
    flex: 1;
    background: white;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    margin-bottom: 10px;
    font-size: 20px;
    color: #e91e63;
}

.card p {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    color: #222;
}

/* SECTIONS */
.section {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    margin-top: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.section h2 {
    margin-bottom: 15px;
    color: #d81b60;
}

/* TABLES */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
}

table th {
    background: #d81b60;
    color: white;
    padding: 12px;
    text-align: left;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

table tr:hover {
    background: #f3e5f5;
}

</style>
</head>

<body>
<div class="container">

    <div class="top-bar-buttons">
        <button class="btn-graph" onclick="window.location.href = 'insights_graph.php'">📊 View Insight Graph</button>
    </div>

    <h1>Perfume Insights</h1>

    <div class="insights-container">

        <div class="card">
            <h3>Total Products</h3>
            <p><?php echo $total_products; ?></p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>

        <div class="card">
            <h3>Total Customers</h3>
            <p><?php echo $total_customers; ?></p>
        </div>

    </div>

    <div class="section">
        <h2>Best Selling Products</h2>
        <table>
            <tr><th>Product</th><th>Total Sold</th></tr>
            <?php while($row = $bestSelling->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['total_sold']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>Latest Orders</h2>
        <table>
            <tr><th>Phone</th><th>Location</th><th>Product</th><th>Date</th></tr>
            <?php while($row = $latestOrders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customer_phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>New Customers</h2>
        <table>
            <tr><th>Name</th><th>Email</th><th>Date Joined</th></tr>
            <?php while($row = $newCustomers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="section">
        <h2>Recently Added Products</h2>
        <table>
            <tr><th>Name</th><th>Brand</th><th>Date</th></tr>
            <?php while($row = $newProducts->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['brand']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>
