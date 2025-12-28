

<?php
session_start();
require 'db_connect.php';

// Hakikisha admin yupo
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

//overlay message after delete,not found and invalid request for product
$message = "";
$type = "";

if (isset($_GET['msg']) && $_GET['msg'] === "deleted_success") {
    $message = "Product deleted successfully!";
    $type = "success";
} elseif (isset($_GET['error']) && $_GET['error'] === "not_found") {
    $message = "Product not found!";
    $type = "error";
} elseif (isset($_GET['error']) && $_GET['error'] === "invalid_request") {
    $message = "Invalid request!";
    $type = "warning";
}

$admin_id = $_SESSION['user_id']; // Admin aliye login
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// ===== Search & Filter kwa admin aliyelogin =====
if (!empty($search)) {
    $like = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM products 
        WHERE (name LIKE ? OR brand LIKE ? OR scent_type LIKE ? OR gender LIKE ?)
        AND is_deleted = 0 
        AND created_by = ?
        ORDER BY created_at DESC");
    $stmt->bind_param("ssssi", $like, $like, $like, $like, $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE is_deleted = 0 AND created_by = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - My Products</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f4f7fa;
    margin: 0;
    padding: 20px;
    color: #333;
}
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #222;
}
.add {
    background: #3126c6f1;
    color: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    display: inline-block;
    margin-bottom: 20px;
    font-weight: bold;
    transition: 0.3s;
}
.add:hover { background: #3f51b5; }
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-radius: 10px;
    overflow: hidden;
}
th, td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}
th {
    background: #3949ab;
    color: #fff;
    font-weight: 600;
}
tr:nth-child(even) { background: #f9f9f9; }
tr:hover { background: #e3e8ff; }
a.edit, a.delete {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #fff;
    transition: 0.3s;
    text-decoration: none;
    margin: 2px 0;
    display: inline-block;
}
a.edit { background: #43a047; }
a.edit:hover { background: #388e3c; }
a.delete { background: #e53935; }
a.delete:hover { background: #c62828; }
img, video, audio {
    max-width: 100px;
    max-height: 80px;
    border-radius: 8px;
}
@media(max-width: 1200px){
    th, td { font-size: 0.9rem; padding: 10px; }
    img, video, audio { max-width: 80px; max-height: 60px; }
}
@media(max-width: 768px){
    table, thead, tbody, th, td, tr { display: block; }
    tr { margin-bottom: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 10px; }
    th { display: none; }
    td { text-align: right; padding-left: 50%; position: relative; }
    td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: calc(50% - 30px);
        text-align: left;
        font-weight: bold;
    }
    img, video, audio { max-width: 70px; max-height: 50px; }
}
 /* delete product overlay */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(253, 253, 253, 0.88);
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease;
  z-index: 9999;
}

.overlay-content {
  background: white;
  color: #44df44e9;
  padding: 20px 40px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(226, 19, 19, 0.75);
  font-size: 20px;
  text-align: center;
  animation: popIn 0.3s ease;
}

.overlay.success .overlay-content {
  border-left: 2px solid #4CAF50;
}

.overlay.error .overlay-content {
  border-left: 2px solid #f44336;
}

.overlay.warning .overlay-content {
  border-left: 2px solid #ff9800;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes popIn {
  from { transform: scale(0.8); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
</style>
</head>
<body>


<h2>My Products</h2>

<form method="GET" action="admin_products.php" class="search-form" style="margin-bottom:20px; display:flex; gap:10px;">
  <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
         placeholder="Search product by name, brand, type or gender..." 
         style="padding:8px; border:1px solid #ccc; border-radius:6px; width:260px;">
  <button type="submit" style="background:#ff66b2; color:#fff; border:none; padding:8px 14px; border-radius:6px; cursor:pointer;">Search</button>
  <a href="admin_products.php" style="padding:8px 14px; background:#ddd; border-radius:6px; text-decoration:none;">Refresh</a>
</form>

<a class="add" href="add_product.php" style="text-decoration:none;">➕ Add Product</a>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Brand</th>
        <th>Scent Type</th>
        <th>Gender</th>
        <th>Price</th>
        <th>Year</th>
        <th>Description</th>
        <th>Image</th>
        <th>Video</th>
        <th>Audio</th>
        <th>Actions</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td><?= htmlspecialchars($row['brand']); ?></td>
        <td><?= htmlspecialchars($row['scent_type']); ?></td>
        <td><?= htmlspecialchars($row['gender']); ?></td>
        <td>$<?= number_format($row['price'], 2); ?></td>
        <td><?= htmlspecialchars($row['year']); ?></td>
        <td><?= htmlspecialchars($row['description']); ?></td>
        <td><?php if($row['image']): ?><img src="<?= $row['image']; ?>" alt="Image"><?php endif; ?></td>
        <td><?php if($row['video']): ?><video src="<?= $row['video']; ?>" controls></video><?php endif; ?></td>
        <td><?php if($row['audio']): ?><audio src="<?= $row['audio']; ?>" controls></audio><?php endif; ?></td>
        <td>
            <a class="edit" href="edit_product.php?id=<?= $row['id']; ?>">Edit</a>
            <a class="delete" href="delete_product.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure to delete this product?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- for overlay display when product deleted ,not found -->
 <?php if (!empty($message)): ?>
<div class="overlay <?php echo $type; ?>">
  <div class="overlay-content">
    <p><?php echo $message; ?></p>
  </div>
</div>
<?php endif; ?>

<script>
  const overlay = document.querySelector('.overlay');
  if (overlay) {
    setTimeout(() => {
      overlay.style.opacity = '0';
      setTimeout(() => overlay.remove(), 300);
    }, 2500); // inaondoka baada ya sekunde 2.5
  }
</script>
</body>
</html>