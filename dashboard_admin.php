<?php
session_start();
require 'db_connect.php';

// Only allow admins (not super_admins)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit();
}

// // Hakikisha ni admin pekee anaingia
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//   header("Location: login.php");
//   exit();
// }

// Search variables (ili kuepuka undefined errors)
// $search = isset($_GET['search']) ? trim($_GET['search']) : '';
// $search_order = isset($_GET['search_order']) ? trim($_GET['search_order']) : '';

// // ====== SEARCH PRODUCTS ======
// $sql_products = "SELECT * FROM products WHERE is_deleted = 0";
// if (!empty($search)) {
//   $sql_products .= " AND (name LIKE '%$search%' OR scent_type LIKE '%$search%' OR price LIKE '%$search%')";
// }
// $sql_products .= " ORDER BY created_at DESC";
// $products = $conn->query($sql_products);

// // ====== SEARCH ORDERS ======
// $sql_orders = "SELECT * FROM orders";
// if (!empty($search_order)) {
//   $sql_orders .= " WHERE (customer_phone LIKE '%$search_order%' OR product_name LIKE '%$search_order%' OR location LIKE '%$search_order%')";
// }
// $sql_orders .= " ORDER BY created_at DESC";
// $orders = $conn->query($sql_orders);

// $search_order = '';
// if (isset($_GET['order_search'])) {
//   $search_order = trim($_GET['order_search']);
//   $like = "%$search_order%";
  
//   $stmt = $conn->prepare("SELECT customer_phone,product_name,location,created_at FROM orders 
//     WHERE (customer_phone LIKE ? OR location LIKE ? OR product_name LIKE ?)
//     ORDER BY created_at DESC");
//   $stmt->bind_param("sss", $like, $like, $like);
//   $stmt->execute();
//   $orders = $stmt->get_result();
// } else {
//   $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
// }





// // hakikisha admin yupo
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//   header("Location: login.php");
//   exit;
// }

// $search = "";
// if (isset($_GET['search'])) {
//   $search = trim($_GET['search']);
//   $like = "%$search%";
//   $stmt = $conn->prepare("SELECT * FROM products 
//     WHERE (name LIKE ? OR brand LIKE ? OR scent_type LIKE ? OR gender LIKE ?) 
//       AND is_deleted = 0
//     ORDER BY created_at DESC");
//   $stmt->bind_param("ssss", $like, $like, $like, $like);
//   $stmt->execute();
//   $result = $stmt->get_result();
// } else {
//   $result = $conn->query("SELECT * FROM products WHERE is_deleted = 0 ORDER BY created_at DESC");
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Perfume Luxe</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fafafa;
      color: #333;
      margin: 0;
    }
    a{ text-decoration: none;

    }

    header {
      background: linear-gradient(to right, #ffdde1, #ee9ca7);
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 1.5rem;
      font-weight: bold;
      letter-spacing: 1px;
    }

    nav {
      background: white;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 25px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    nav a {
      text-decoration: none;
      color: #333;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #ee9ca7;
    }

    .logout {
      color: red;
    }

    main {
      padding: 40px;
      text-align: center;
    }

    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 20px rgba(161, 19, 19, 0.59);
      transition: transform 0.3s;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      color: #ee9ca7;
      margin-bottom: 10px;
    }

    .card p {
      color: #666;
      font-size: 0.95rem;
    }

    /* navigation item */
  .header-nav{
    display:flex;
    overflow-x:auto;
    white-space:nowrap;
    background-color:white; 
    padding:10px 0;
  }
  .header-nav::webkit-srcollbar{
    display:none;/*ficha scrollbar kwenye chrome /safari*/
  }
  .nav-item{
    display:inline-block;
    background-color:violet;
    padding:8px 10px;
    margin:0 8px;
    border-radius:20px;
    font-size:14px;
    cursor:pointer;
    transition:background-color 0.3s;
    flex-shrink:0;
  }
  .nav-item:hover{
    background-color:pink;
  }

  <a href="register_admin.php">➕ Register New Admin</a>
    <a href="manage_admins.php">⚙️ Manage admins</a>
    <a href="password_management.php">⚙️ Password magements</a>
    <a href="super_admin_orders.php">📦 View Orders</a>

  </style>
</head>
<body>

  <header>
    Welcome Admin, <?php echo $_SESSION['name']; ?> 👋
  </header>

  <nav>
    <div class="header-nav">
    <div class="nav-item"><a href="admin_products.php">🧴 Manage Products</a></div>
    <div class="nav-item"><a href="admin_orders.php">📦 View Orders</a></div>
    <div class="nav-item"><a href="admin_view_feedback.php">💬 Customer Messages</a></div>
    <div class="nav-item"><a href="products_insights.php">🧴My insights</a></div>
    <div class="nav-item"><a href="edit_admin_profile.php"> ⚙️ Edit profile</a></div>
    </div>
    <a href="logout.php" class="logout">🚪 Logout</a>
  </nav>

  <main>
    <h2>Admin Control Panel</h2>
    <p>You can manage perfumes, orders, and customer messages.</p>

    <div class="dashboard-cards">
      <div class="card">
       <a href="admin_products.php"> <h3>🧴 Manage Products</h3></a>
        <p>Add, edit, or delete perfume products.</p>
      </div>

      <div class="card">
        <a href="admin_orders.php"><h3>📦 Orders</h3></a>
        <p>View and track customer orders.</p>
      </div>

      <div class="card">
        <a href="admin_view_feedback.php"><h3>💬 Messages</h3></a>
        <p>Check customer inquiries and feedback.</p>
      </div>

      <div class="card">
        <a href="products_insights.php"><h3>🧴My insights</h3></a>
        <p>View and track your added products.</p>
      </div>

     <div class="card">
        <a href="edit_admin_profile.php"><h3>⚙️ Edit profile</h3></a>
        <p>Change your profile. </p>
      </div>

    </div>
  </main>

</body>
</html>