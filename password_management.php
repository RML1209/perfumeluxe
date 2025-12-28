<?php
session_start();
require 'db_connect.php';

if ($_SESSION['role'] != 'super_admin') {
  header("Location: login.php");
  exit();
}

// ✅ Handle search input
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT id, name, email, role FROM users WHERE role='admin'";

if (!empty($search)) {
  $search = $conn->real_escape_string($search);
  $sql .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Registered Admins</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 90%;
      margin: 30px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    .search-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .search-bar input[type="text"] {
      padding: 10px;
      width: 300px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .search-bar button {
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: white;
    }

    .btn-search {
      background: #007BFF;
    }

    .btn-search:hover {
      background: #0056b3;
    }

    .btn-refresh {
      background: #28a745;
    }

    .btn-refresh:hover {
      background: #1e7e34;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #007BFF;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    a.btn-reset {
      background: #dc3545;
      color: white;
      padding: 6px 10px;
      border-radius: 5px;
      text-decoration: none;
    }

    a.btn-reset:hover {
      background: #a71d2a;
    }

    .msg {
      text-align: center;
      color: green;
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Registered Admins</h2>

    <?php if (isset($_GET['msg'])): ?>
      <p class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <!-- 🔍 Search Form -->
    <form class="search-bar" method="GET" action="password_management.php">
      <input type="text" name="search" placeholder="Search admin by name or email" value="<?php echo htmlspecialchars($search); ?>">
      <button type="submit" class="btn-search">Search</button>
      <button type="button" class="btn-refresh" onclick="window.location.href='password_management.php'">Refresh</button>
    </form>

    <table>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
      </tr>

      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['role']); ?></td>
            <td>
              <a class="btn-reset" href="reset_admin_password.php?id=<?php echo $row['id']; ?>">Change Password</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" style="text-align:center;">No admins found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>