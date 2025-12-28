<?php
require 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'super_admin')) {
    header("Location: login.php");
    exit();
}

// Delete product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: manage_products.php");
    exit();
}

// Fetch products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products - Perfume Luxe</title>
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
a.btn {
  background: #ee9ca7;
  color: white;
  text-decoration: none;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 0.9rem;
  transition: 0.3s;
}
a.btn:hover {
  background: #ffb6c1;
}
.add-btn {
  display: inline-block;
  margin-bottom: 15px;
  background: #333;
  color: white;
  padding: 10px 20px;
  border-radius: 8px;
  text-decoration: none;
}
</style>
</head>
<body>

<header>🧴 Manage Products</header>
<div class="container">
 
  <a href="add_product.php" class="add-btn">➕ Add New Product</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Brand</th>
      <th>Price</th>
      <th>Gender</th>
      <th>Year</th>
      <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['brand']) ?></td>
      <td>$<?= $row['price'] ?></td>
      <td><?= htmlspecialchars($row['gender']) ?></td>
      <td><?= $row['year'] ?></td>
      <td>
        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
        <a href="delete_product.php?delete=<?= $row['id'] ?>" class="btn" style="background:#f44336;">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>