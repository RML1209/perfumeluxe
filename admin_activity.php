<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php"); exit;
}

$admin_id = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;
if (!$admin_id) { header("Location: manage_admins.php"); exit; }

// admin info
$stmt = $conn->prepare("SELECT id,name,email FROM users WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
if (!$admin) { header("Location: manage_admins.php"); exit; }

// products added
$stmt = $conn->prepare("SELECT id,name,brand,price,year,created_at FROM products WHERE created_by = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$added = $stmt->get_result();

// products edited
$stmt2 = $conn->prepare("SELECT id,name,brand,price,year,created_at,updated_by FROM products WHERE updated_by = ? AND is_deleted = 0 ORDER BY created_at DESC");
$stmt2->bind_param("i", $admin_id);
$stmt2->execute();
$edited = $stmt2->get_result();

// products deleted (soft-deleted)
$stmt3 = $conn->prepare("SELECT id,name,brand,price,year,deleted_at FROM products WHERE deleted_by = ? AND is_deleted = 1 ORDER BY deleted_at DESC");
$stmt3->bind_param("i", $admin_id);
$stmt3->execute();
$deleted = $stmt3->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo htmlspecialchars($admin['name']); ?> - Activity</title>
<style>
  body{font-family:Segoe UI;background:#f5f5f7;padding:18px}
  h1{color:#333}
  .section{background:#fff;padding:14px;border-radius:8px;margin-bottom:12px;box-shadow:0 2px 6px rgba(0,0,0,0.04)}
  table{width:100%;border-collapse:collapse}
  th,td{padding:8px;border-bottom:1px solid #eee;text-align:left}
  th{background:#ee9ca7;color:white}
</style>
</head>
<body>
  <h1>Activity for <?php echo htmlspecialchars($admin['name']); ?></h1>

  <div class="section">
    <h3>Products Added (<?php echo $added->num_rows; ?>)</h3>
    <?php if ($added->num_rows): ?>
      <table><tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Year</th><th>Created</th></tr>
      <?php while($r = $added->fetch_assoc()): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['name']); ?></td>
          <td><?php echo htmlspecialchars($r['brand']); ?></td>
          <td><?php echo $r['price']; ?></td>
          <td><?php echo $r['year']; ?></td>
          <td><?php echo $r['created_at']; ?></td>
        </tr>
      <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No products added by this admin.</p>
    <?php endif; ?>
  </div>

  <div class="section">
    <h3>Products Edited (<?php echo $edited->num_rows; ?>)</h3>
    <?php if ($edited->num_rows): ?>
      <table><tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Year</th><th>Last Updated</th></tr>
      <?php while($r = $edited->fetch_assoc()): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['name']); ?></td>
          <td><?php echo htmlspecialchars($r['brand']); ?></td>
          <td><?php echo $r['price']; ?></td>
          <td><?php echo $r['year']; ?></td>
          <td><?php echo $r['created_at']; // or show updated_at if you created it ?></td>
        </tr>
      <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No products edited by this admin.</p>
    <?php endif; ?>
  </div>

  <div class="section">
    <h3>Products Deleted (<?php echo $deleted->num_rows; ?>)</h3>
    <?php if ($deleted->num_rows): ?>
      <table><tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Year</th><th>Deleted At</th></tr>
      <?php while($r = $deleted->fetch_assoc()): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['name']); ?></td>
          <td><?php echo htmlspecialchars($r['brand']); ?></td>
          <td><?php echo $r['price']; ?></td>
          <td><?php echo $r['year']; ?></td>
          <td><?php echo $r['deleted_at']; ?></td>
        </tr>
      <?php endwhile; ?></table>
    <?php else: ?>
      <p>No products deleted by this admin.</p>
    <?php endif; ?>
  </div>

  <p><a href="manage_admins.php" style="padding:4px 12px; background:#ddd;font-family:Segoe UI,Arial; border-radius:7px; text-decoration:none;cursor:pointer;">Back to Admins</a></p>
</body>
</html>