<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $admin_id = intval($_POST['admin_id']);

  // verify target is admin (not super_admin)
  $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
  $stmt->bind_param("i", $admin_id);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  if (!$res) { header("Location: manage_admins.php?error=notfound"); exit; }
  if ($res['role'] !== 'admin') { header("Location: manage_admins.php?error=forbidden"); exit; }

  // Delete user (or set role to user / deactivate). We'll delete:
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'admin'");
  $stmt->bind_param("i", $admin_id);
  $stmt->execute();

  header("Location: manage_admins.php?msg=deleted");
  exit;
}
?>