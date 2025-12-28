$search_order = "";
if (isset($_GET['order_search'])) {
  $search_order = trim($_GET['order_search']);
  $like = "%$search_order%";
  $stmt = $conn->prepare("SELECT * FROM orders 
    WHERE (customer_phone LIKE ? OR location LIKE ? OR product_name LIKE ?)
    ORDER BY created_at DESC");
  $stmt->bind_param("sss", $like, $like, $like);
  $stmt->execute();
  $orders = $stmt->get_result();
} else {
  $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
}





<form method="GET" action="dashboard_admin.php" class="search-form" style="margin:20px 0; display:flex; gap:10px;">
  <input type="text" name="order_search" value="<?php echo htmlspecialchars($search_order); ?>" 
         placeholder="Search order by phone, location or product..." 
         style="padding:8px; border:1px solid #ccc; border-radius:6px; width:260px;">
  <button type="submit" style="background:#4CAF50; color:#fff; border:none; padding:8px 14px; border-radius:6px; cursor:pointer;">Search</button>
  <a href="dashboard_admin.php" style="padding:8px 14px; background:#ddd; border-radius:6px; text-decoration:none;">Reset</a>
</form>


