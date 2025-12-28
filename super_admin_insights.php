<?php
session_start();
require 'db_connect.php'; 

// -------- AUTHENTICATION CHECK ----------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only super_admin allowed
if ($_SESSION['role'] !== 'super_admin') {
    echo "Access Denied! Only Super Admin can view this page.";
    exit();
}

$super_admin_id = $_SESSION['user_id'];

// Fetch all Admins registered by this Super Admin
$admins = $conn->query("
    SELECT id, name, email, created_at
    FROM users
    WHERE role = 'admin' 
    ORDER BY name ASC
");

// Note: If all Super Admins can see all Admins, remove the 'AND registered_by = $super_admin_id'
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Super Admin Dashboard</title>

<style>
/* Reusing some styles from previous files for consistency */
body { font-family: "Poppins", sans-serif; background: #f0f8ff; margin: 0; padding: 0; }
.container { width: 85%; margin: auto; padding: 20px 0; }
h1 { text-align: center; color: #1565c0; margin-bottom: 40px; }
.section { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
table { width: 100%; border-collapse: collapse; }
table th { background: #1565c0; color: white; padding: 12px; text-align: left; }
table td { padding: 12px; border-bottom: 1px solid #eee; }
.btn { 
    padding: 8px 15px; 
    background: #4caf50; 
    color: white; 
    border: none; 
    border-radius: 6px; 
    cursor: pointer; 
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    transition: 0.3s;
}
.btn:hover { background: #388e3c; }
</style>
</head>

<body>
<div class="container">

<h1>Super Admin Panel - Admin List</h1>

<div class="section">
    <h2>Admins Under Management</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Date Joined</th>
            <th>Action</th>
        </tr>
        <?php if ($admins->num_rows > 0): ?>
            <?php while($row = $admins->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="admin_reports.php?admin_id=<?php echo $row['id']; ?>" class="btn">View Reports</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align: center;">No admins registered under your account.</td></tr>
        <?php endif; ?>
    </table>
</div>

</div>
</body>
</html>
