<?php
require 'db_connect.php';
session_start();

// Hakikisha user ni admin au super_admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'super_admin')) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$search_order = isset($_GET['search_order']) ? trim($_GET['search_order']) : '';

if (!empty($search_order)) {
    $like = "%$search_order%";

    // Kwa admin wa kawaida -> aone orders za products alizoweka mwenyewe
    if ($role == 'admin') {
        $stmt = $conn->prepare("
            SELECT o.id, o.customer_phone, o.location, o.product_name, o.created_at
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE (o.customer_phone LIKE ? OR o.location LIKE ? OR o.product_name LIKE ?)
              AND p.added_by = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->bind_param("sssi", $like, $like, $like, $user_id);
    }
    // Kwa super_admin -> aone orders zote
    else {
        $stmt = $conn->prepare("
            SELECT o.id, o.customer_phone, o.location, o.product_name, o.created_at
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE (o.customer_phone LIKE ? OR o.location LIKE ? OR o.product_name LIKE ?)
            ORDER BY o.created_at DESC
        ");
        $stmt->bind_param("sss", $like, $like, $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // Bila search
    if ($role == 'admin') {
        $stmt = $conn->prepare("
            SELECT o.id, o.customer_phone, o.location, o.product_name, o.created_at
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE p.added_by = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("
            SELECT o.id, o.customer_phone, o.location, o.product_name, o.created_at
            FROM orders o
            JOIN products p ON o.product_id = p.id
            ORDER BY o.created_at DESC
        ");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Orders - Perfume Luxe</title>
<style>
body {
  font-family: 'Segoe UI', sans-serif;
  background: #fafafa;
  color: #333;
  margin: 0;
}
header {
  background: linear-gradient(to right, #ffdde1, #ee9ca7);
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 1.3rem;
}
.container {
  width: 90%;
  margin: 40px auto;
  background: white;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
th {
  background: #ee9ca7;
  color: white;
}
</style>
</head>
<body>

<header>📦 Manage Orders</header>

<div class="container">
  <form method="GET" action="manage_orders.php" style="margin:20px 0; display:flex; gap:10px;">
    <input type="text" name="search_order" value="<?php echo htmlspecialchars($search_order); ?>" 
           placeholder="Search order by phone, location or product..." 
           style="padding:8px; border:1px solid #ccc; border-radius:6px; width:260px;">
    <button type="submit" style="background:#4CAF50; color:#fff; border:none; padding:8px 14px; border-radius:6px; cursor:pointer;">Search</button>
    <a href="manage_orders.php" style="padding:8px 14px; background:#ddd; border-radius:6px; text-decoration:none;">Refresh</a>
  </form>

  <table>
    <tr>
      <th>Order_number</th>
      <th>Customer_phone</th>
      <th>Location</th>
      <th>Order_time</th>
      <th>Product_name</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['customer_phone']) ?></td>
        <td><?= htmlspecialchars($row['location']) ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
        <td><?= htmlspecialchars($row['product_name']) ?></td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center; padding:20px;">No orders found.</td></tr>
    <?php endif; ?>
  </table>
</div>

</body>
</html>