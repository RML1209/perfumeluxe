<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'super_admin') {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Super Admin Dashboard - Perfume Luxe</title>
  <style>
    body {font-family: 'Segoe UI'; background: #fafafa;}
    header {background: linear-gradient(to right,#ee9ca7,#ffdde1); color:white; padding:15px; text-align:center;}
    nav {background:white;display:flex; padding:10px;justify-content:center;align-items:center; box-shadow:0 0 5px rgba(0,0,0,0.1);}
    nav a {margin:10px; text-decoration:none; color:#333; font-weight:bold;}
    .container {padding:20px;}
    .logout { color:red;}

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
      box-shadow: 0 2px 20px rgba(189, 12, 12, 0.59);
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
     a{ text-decoration: none;}
    .container h3,p{
       padding: 0px;
      text-align: center;
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
  </style>
</head>
<body>
  <header>
    <h2>Welcome Super Admin, <?php echo $_SESSION['name']; ?> 👑</h2>
  </header>
  <nav>
     <div class="header-nav">
    <div class="nav-item"> <a href="register_admin.php">➕ Register New Admin</a></div>
    <div class="nav-item"><a href="manage_admins.php">⚙️ Manage admins</a></div>
    <div class="nav-item"><a href="super_admin_insights.php">📊 View admins insight</a></div>
    <div class="nav-item"><a href="password_management.php">⚙️ Password magements</a></div>
    <div class="nav-item"><a href="super_admin_orders.php">📦 View Orders</a></div>
    <div class="nav-item"><a href="all_customers.php">👤 Customers</a></div>
    </div>
    <a href="logout.php" class="logout">🚪 Logout</a>
  </nav>

  <div class="container">
    <h3>Control Center</h3>
    <p>As Super Admin, you can register admins, manage products,change admin password and view reports.</p>
  </div>
   <main>
    <div class="dashboard-cards">
      <div class="card">
       <a href="register_admin.php"> <h3>➕ Register admin</h3></a>
        <p>Add new admin</p>
      </div>

      <div class="card">
        <a href="manage_admins.php"><h3>⚙️ Manage admins</h3></a>
        <p>View admin activities and delete admin</p>
      </div>

      <div class="card">
        <a href="super_admin_insights.php"><h3>📊 View admins insight</h3></a>
        <p>View admin insights and see a graph</p>
      </div>

      <div class="card">
        <a href="password_management.php"><h3>⚙️ Password management</h3></a>
        <p>Change admins password</p>
      </div>

       <div class="card">
        <a href="super_admin_orders.php"><h3>📦 Orders</h3></a>
        <p>View and track customer orders.</p>
      </div>

       <div class="card">
        <a href="all_customers.php"><h3>👤 Customers</h3></a>
        <p>About customers</p>
      </div>
    </div>
  </main>
</body>
</html>