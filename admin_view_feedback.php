<?php
session_start();
require 'db_connect.php';

// Hakikisha ni admin pekee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Search handling
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("
        SELECT * FROM suggestions 
        WHERE email LIKE ? OR message LIKE ?
        ORDER BY created_at DESC
    ");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT email,message,created_at FROM suggestions ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Suggestions</title>
<style>
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f9f9f9;
    padding: 20px;
  }

  h2 {
    color: #333;
    margin-bottom: 20px;
  }

  .search-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    gap: 10px;
  }

  .search-container input[type="text"] {
    width: 300px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
  }

  .search-container button {
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
  }

  .btn-search {
    background: #ff66b2;
    color: #fff;
  }

  .btn-reset {
    background: #ccc;
    color: #000;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
  }

  th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
  }

  th {
    background: #ff66b2;
    color: white;
  }

  tr:hover {
    background: #f2f2f2;
  }
</style>
</head>
<body>

<h2>User Suggestions 💬</h2>

<!-- 🔍 Search Form -->
<form class="search-container" method="GET" action="admin_view_feedback.php">
  <input type="text" name="search" placeholder="Search by email or message..." 
         value="<?php echo htmlspecialchars($search); ?>">
  <button type="submit" class="btn-search">Search</button>
  <a href="admin_view_feedback.php" class="btn-reset" 
     style="text-decoration:none; display:inline-block; line-height:40px;border-radius:8px;padding:4px 10px;">Refresh</a>
</form>

<!-- 🧾 Suggestions Table -->
<table>
  <tr>
    <th>#</th>
    <th>Email</th>
    <th>Message</th>
    <th>Date</th>
  </tr>

  <?php
  $i = 1;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$i}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['message']}</td>
                  <td>{$row['created_at']}</td>
                </tr>";
          $i++;
      }
  } else {
      echo "<tr><td colspan='4' style='text-align:center; color:#888;'>No suggestions found</td></tr>";
  }
  ?>
</table>

</body>
</html>