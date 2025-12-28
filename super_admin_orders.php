<?php
require 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: login.php");
    exit();
}

$search = $_GET['search'] ?? '';

$query = "
    SELECT o.id, o.customer_phone, o.location, o.product_name, o.created_at,
           a.name AS admin_name
    FROM orders o
    JOIN users a ON o.ordered_by_admin = a.id
";

if (!empty($search)) {
    $query .= " WHERE (o.product_name LIKE ? OR o.customer_phone LIKE ? OR a.name LIKE ?)";
}

$query .= " ORDER BY o.created_at DESC";

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Orders (Super Admin)</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    input[type="text"] {
      padding: 8px;
      width: 250px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: pink;
    }
  </style>
</head>
<body>
  <h2>All Orders (Super Admin)</h2>

  <form method="GET" action="">
    <input type="text" name="search" placeholder="Search orders..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" style="background:#ff66b2; color:#fff; border:none; padding:8px 14px; border-radius:6px; cursor:pointer;">Search</button>
    <a href="super_admin_orders.php" style="padding:8px 14px; background:#ddd; border-radius:6px; text-decoration:none;">Refresh</a>
  </form>

  <table>
    <tr>
      <th>#</th>
      <th>Product</th>
      <th>Customer Phone</th>
      <th>Location</th>
      <th>Order Time</th>
      <th>Admin Name</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['product_name']) ?></td>
      <td><?= htmlspecialchars($row['customer_phone']) ?></td>
      <td><?= htmlspecialchars($row['location']) ?></td>
      <td><?= htmlspecialchars($row['created_at']) ?></td>
      <td><?= htmlspecialchars($row['admin_name']) ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>