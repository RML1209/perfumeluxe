<?php
session_start();
require 'db_connect.php';

// only super_admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php"); exit();
}

$search = "";
if (isset($_GET['q'])) {
  $search = trim($_GET['q']);
  $like = "%$search%";
  $stmt = $conn->prepare("
    SELECT u.id, u.name, u.email, u.created_at,
      (SELECT COUNT(*) FROM products p WHERE p.created_by = u.id AND p.is_deleted = 0) AS added_count,
      (SELECT COUNT(*) FROM products p WHERE p.updated_by = u.id AND p.is_deleted = 0) AS edited_count,
      (SELECT COUNT(*) FROM products p WHERE p.deleted_by = u.id) AS deleted_count
    FROM users u
    WHERE u.role = 'admin' AND (u.name LIKE ? OR u.email LIKE ?)
    ORDER BY u.created_at DESC
  ");
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("
    SELECT u.id, u.name, u.email, u.created_at,
      (SELECT COUNT(*) FROM products p WHERE p.created_by = u.id AND p.is_deleted = 0) AS added_count,
      (SELECT COUNT(*) FROM products p WHERE p.updated_by = u.id AND p.is_deleted = 0) AS edited_count,
      (SELECT COUNT(*) FROM products p WHERE p.deleted_by = u.id) AS deleted_count
    FROM users u
    WHERE u.role = 'admin'
    ORDER BY u.created_at DESC
  ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Admins - Perfume Luxe</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body{font-family:Segoe UI,Arial;background:#f7f7f9;color:#222;margin:0;padding:20px;}
  header{background:linear-gradient(90deg,#ffdde1,#ee9ca7);padding:16px;border-radius:8px;color:#111;font-weight:700;margin-bottom:18px;}
  .topbar{display:flex;gap:12px;align-items:center;margin-bottom:14px;}
  .search-form input[type="text"]{padding:8px 12px;border-radius:8px;border:1px solid #ccc;width:260px;}
  .search-form button{padding:8px 12px;border-radius:8px;border:none;background:#ff66b2;color:#fff;cursor:pointer;}
  .card{background:#fff;padding:16px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);}
  table{width:100%;border-collapse:collapse;margin-top:12px;}
  th,td{padding:10px;border-bottom:1px solid #eee;text-align:left;}
  th{background:#ee9ca7;color:#fff;}
  .btn{padding:6px 10px;border-radius:6px;color:#fff;text-decoration:none;font-weight:600;}
  .view{background:#4CAF50;}
  .del{background:#f44336;}
  .activity{background:#6c757d;}
  form.inline{display:inline;}
</style>
</head>
<body>
<header>Manage Admins (Super Admin)</header>

<div class="topbar">
  <form class="search-form" method="GET" action="manage_admins.php">
    <input type="text" name="q" placeholder="Search admin by name or email..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
    <a href="manage_admins.php" style="padding:4px 12px; background:#ddd;font-family:Segoe UI,Arial; border-radius:7px; text-decoration:none;cursor:pointer;">Refresh</a>
  </form>
</div>

<div class="card">
  <table>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Added</th>
      <th>Edited</th>
      <th>Deleted</th>
      <th>Actions</th>
    </tr>

    <?php $i=1; while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo htmlspecialchars($row['email']); ?></td>
      <td><?php echo $row['added_count']; ?></td>
      <td><?php echo $row['edited_count']; ?></td>
      <td><?php echo $row['deleted_count']; ?></td>
      <td>
        <a class="btn view" href="admin_activity.php?admin_id=<?php echo $row['id']; ?>">View Activity</a>

        <!-- delete admin form -->
        <form class="inline" method="POST" action="delete_admin.php" onsubmit="return confirm('Delete this admin? This cannot be undone.');">
          <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
          <button class="btn del" type="submit">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>