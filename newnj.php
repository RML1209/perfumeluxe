<?php
require 'db_connect.php';
//fetch all products
$result=$conn->query("SELECT  id,name,brand,scent_type,gender,price,year,image,video,audio,description,created_at FROM products ORDER BY created_at DESC");
//searchbar
$search = "";
if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    $stmt = $conn->prepare("
        SELECT id, name, brand, scent_type, gender, price, year, image, video, audio, description, created_at
        FROM products
        WHERE name LIKE ? OR brand LIKE ? OR scent_type LIKE ? OR gender LIKE ?
        ORDER BY created_at DESC
    ");
    $like = "%$search%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT id, name, brand, scent_type, gender, price, year, image, video, audio, description, created_at,created_by,updated_by,deleted_by,is_deleted 
        FROM products WHERE is_deleted = 0 ORDER BY created_at DESC
    ");
}
?>
<?php
//display no products available when no products is added
if($result->num_rows == 0):?>
  <p style="text-align:center;color:#555;">No products available at the moments.</p>
 
  <?php endif;?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfume Luxe Shop</title>
 <!-- Swiper.js CDN for slider -->
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
 <!-- style of profile admin image -->
<style>
/* PROFILE HEADER (Instagram style) */
.header_profile_image {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 8px;
    margin-bottom: 8px;
}

/* PROFILE PICTURE */
.profile-pic {
    width: 32px;             /* Ndogo, classy */
    height: 32px;
    border-radius: 50%;      /* Perfect circle */
    object-fit: cover;       /* Crop vizuri kama Instagram */
    border: 2px solid #e91e63; /* Pink ring style */
}

/* USERNAME */
.profile_username {
    font-size: 13px;
    font-weight: 600;
    color: #444;             /* Soft black */
    font-family: "Poppins", sans-serif;
    letter-spacing: 0.3px;
} 
  }
</style>
  <style>
      * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }
    html,body{
      width: 100%;
      overflow-x:hidden;
    }
 /* Base container styling for the background and layout */
body {
    background: linear-gradient(to bottom right, #ffe6f0, #ffcce6); /* Background gradient from your image */
    min-height: 100vh; /* Ensure the background fills the viewport */
    margin: 0;
    padding: 0;
    font-family: sans-serif; /* Example font */
    width: 100%;
}

/* Flexbox to align header content (logo, searchbar, nav) */
header {
    display: flex;
    justify-content: space-between; /* Spreads out the main elements */
    align-items: center; /* Vertically centers elements */
    padding: 10px 20px;
}


/* Base container styling for the background and layout */
body {
    background: linear-gradient(to bottom right, #ffe6f0, #ffcce6); /* Background gradient from your image */
    min-height: 100vh; /* Ensure the background fills the viewport */
    margin: 0;
    padding: 0;
    font-family: sans-serif; /* Example font */
}

/* Flexbox to align header content (logo, searchbar, nav) */
header {
    display: flex;
    justify-content: space-between; /* Spreads out the main elements */
    align-items: center; /* Vertically centers elements */
    padding: 10px 20px;
}

/* --- Search Bar Styling --- */

.search-container {
    margin-left:0px;
    margin-bottom: 50px;
    margin-top:30px;
    margin-right: 70px;
    display: flex;
    align-items: center;
    
    border: none;
    border-radius:20px;  
    /* Sets the overall width and keeps it rounded */
    background-color: white; /* The main white container */
    padding: 0px; /* Creates internal space */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    width: 40px; /* Adjust width as needed for your design */
    max-width: 90%;
}

.search-input {
    flex-grow: 1; /* Allows the input to take up most of the space */
    border: none;
    border-radius:20px;
    padding: 12px;
    
    font-size: 12px;
    color: #555;
    background: white; /* Makes the input area transparent inside the white container */
    /* Remove default focus outline */
    outline: none; 
}

.search-input::placeholder {
  
    /* To match the font style of the placeholder in the image */
    font-weight: 500; 
     color:black;
     font-size:14px;
    margin-right:40px; 
}

.search-button {
    /* Main button styling to create the rounded pink look */
    border: none;
    border-radius: 20px; /* Fully rounded button */
    padding: 10px;
    font-size: 12px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    /* Gradient for the pink look */
    background: linear-gradient(to right, #ff99cc, #ff66b2); 
    box-shadow: 0 2px 4px rgba(255, 102, 178, 0.5); /* Matching shadow */
    transition: background 0.3s ease;
    
   
}

.search-button:hover {
    /* Slightly darker gradient on hover */
    background: linear-gradient(to right, #ffb3d9, #ff70bb);
}






    body {
      background: #fdfdfd;
      color: #333;
    }
    /*icon color */
    .fab fa-facebook{ color:#1877f2}
     .fab fa-instagram{color:#e4405f;}
     .fab fa-facebook{color:#25D366;}
    /* HEADER */
    header {
      width: 100%;
      background: linear-gradient(90deg, #ffdde1, #ee9ca7);  
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 20px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-bottom-right-radius: 60px;
      border-top-left-radius: 20px;
    }

    .logo {
      font-size: 1.1rem;
      font-weight: 700;
      color: indigo;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.3s ease-in-out;
    }
    .logo:hover { transform: scale(1.1); }

    .logo .logo-image {
      display: inline-block;
      font-size: 20px;
      padding: 10px;
      animation: slow-rotate 8s linear infinite;
    }
    @keyframes slow-rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .logo .logo-title { display: flex; gap: 2px; }
    .logo .logo-title span {
      display: inline-block;
      opacity: 0;
      transform: translateY(20px);
      animation: fade-in-bounce 1.5s ease-in-out forwards;
    }
    /* Staggered animation for logo letters */
    .logo .logo-title span:nth-child(1) { animation-delay: 0.1s; }
    .logo .logo-title span:nth-child(2) { animation-delay: 0.2s; }
    .logo .logo-title span:nth-child(3) { animation-delay: 0.3s; }
    .logo .logo-title span:nth-child(4) { animation-delay: 0.4s; }
    .logo .logo-title span:nth-child(5) { animation-delay: 0.5s; }
    .logo .logo-title span:nth-child(6) { animation-delay: 0.6s; }
    .logo .logo-title span:nth-child(7) { animation-delay: 0.7s; }

    @keyframes fade-in-bounce {
      0% { opacity: 0; transform: translateY(20px); }
      60% { opacity: 1; transform: translateY(-5px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .logo .logo-subtitle {
      opacity: 0;
      animation: fade-in 1s ease-in-out 1.5s forwards;
    }
    @keyframes fade-in { from {opacity: 0;} to {opacity: 1;} }

    nav ul { list-style: none; display: flex; gap: 20px; }
    nav ul li { display: inline; }
    nav ul li a {
      text-decoration: none;
      font-weight: 500;
      color: pink;
      font-size: 15px;
      transition: color 0.3s, transform 0.3s ease-in-out;
    }
    nav ul li a:hover { color: #222; transform: translateY(-3px); }

    .navigation {
      background: white;
      border-radius: 10px;
      padding: 6px;
      
      
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      margin-top:60px;
    }
    .navigation:hover {
      background-color: indigo;
      color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* SHOP CONTENT */
    main {
      padding: 50px 20px;
      max-width: 1200px;
      margin: auto;
      text-align: center;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 30px;
      animation: fadeInDown 1.5s ease;
    }
    @keyframes fadeInDown {
      from {opacity: 0; transform: translateY(-30px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .shop {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .product-card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
      text-align: center;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      animation: fadeIn 1.5s ease;
      
    }
    .product-card img{
      width: 100%;
      height:auto;
       /* max-height:300px;  */
      object-fit:contain;
      margin:0 auto;
    }
    .product-card:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .product-image {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 12px;
    }
    .media { margin: 12px 0; }
    .product-description {
      margin: 15px 0;
      font-size: 1rem;
      color: #555;
      line-height: 1.5;
      text-align: left;
    }

    /* about product */
   .about_product {
      display: inline-block;
      margin: 8px;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      transition: all 0.3s ease;
      background:gold; color: #fff; 
    }
    .about_product:hover{
      background:yellow;
    } 

    .btn {
      display: inline-block;
      margin: 8px;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      transition: all 0.3s ease;
    }
    .order-btn { background: #ff6f61; color: #fff; }
    .order-btn:hover { background: #e55d50; }
    .whatsapp-btn { background: #25d366; color: #fff; }
    .whatsapp-btn:hover { background: #1da851; }
    
    /* ===== HOME OVERLAY STYLE ===== */
.home-overlay {
  left: -100%;
  bottom: 0;
  height: 100%;
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(8px);
  transition: left 0.6s ease-in-out;
  border-top-right-radius: 45px;
  justify-content: center;
  align-items: center;
}
.home-overlay.active {
  left: 0;
}

/* ===== ABOUT OVERLAY STYLE ===== */
.about-overlay {
  opacity: 0;
  visibility: hidden;
  background: rgba(0, 0, 0, 0.75);
  backdrop-filter: blur(12px);
  transition: opacity 0.6s ease-in-out, visibility 0.6s;
  justify-content: center;
  align-items: center;
  text-align: center;
  border-radius: 25px;
}

.about-overlay.active {
  opacity: 1;
  visibility: visible;
}

.about-content {
  background: rgba(255, 255, 255, 0.08);
  padding: 40px;
  border-radius: 20px;
  animation: fadeSlideUp 0.8s ease-in-out;
  max-width: 500px;
  color: white;
}

.about-title {
  font-size: 2rem;
  margin-bottom: 15px;
  color: #fff;
  letter-spacing: 1px;
  animation: fadeSlideUp 1.2s ease forwards;
}

.about-text {
  font-size: 1.1rem;
  line-height: 1.7;
  color: #f1f1f1;
  min-height: 100px;
  text-align: center;
  margin-bottom: 25px;
  white-space: pre-line; /* allows new lines in typewriter text */
}

/* Fade + slide animation */
@keyframes fadeSlideUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}
    /* FOOTER */
    footer {
      background: #333;
      color: white;
      text-align: center;
      padding: 30px 15px;
      margin-top: 50px;
      opacity: 0;
      animation: fade-in 0.7s ease-in-out 0.9s forwards;
    }
    footer .socials { margin: 15px 0; }
    footer .socials a {
      margin: 0 10px;
      font-size:20px;
      text-decoration: none;
      color: #ffdde1;
      font-weight: bold;
      transition: color 0.3s, transform 0.3s ease-in-out;
    }
    /*icon size*/
    .socials i{
      font-size:35px;
    }
    footer .socials a:hover { color: #fff; transform: rotate(360deg); }
    footer p { margin-top: 10px; font-size: 0.9rem; color: #ccc; }
    
    
    /* ========== OVERLAY ========== */
    .overlay {
      position: fixed;
      bottom: -100%;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: white;
      text-align: center;
      transition: bottom 0.6s ease-in-out;
      z-index: 2000;
      padding: 20px;
      border-top-left-radius:45px;
    
    }

    .overlay.active {
      bottom: 0;
    }

    .overlay p {
      font-size: 1.3rem;
      margin-bottom: 20px;
    }

    .back-btn {
      background: crimson;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background: darkred;
    }
    
    
    /* Video styling */
.product-video {
  width: 100%;
  height: 220px;
  border-radius: 12px;
  object-fit: cover;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  background-color: #f7f7f7;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-video:hover {
  transform: scale(1.02);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* ===== CUSTOM AUDIO PLAYER STYLE ===== */
audio {
  width: 100%;
  height: 40px;
  border-radius: 30px;
  outline: none;
  background: linear-gradient(90deg, #ee9ca7, #ffdde1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  margin-top: 8px;
}

audio:hover {
  transform: scale(1.02);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
}

/* Safari/Chrome custom controls */
audio::-webkit-media-controls-panel {
  background: linear-gradient(90deg, #ffdde1, #ee9ca7);
  border-radius: 30px;
}

audio::-webkit-media-controls-play-button,
audio::-webkit-media-controls-mute-button {
  border-radius: 50%;
  background-color: white;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

audio::-webkit-media-controls-current-time-display,
audio::-webkit-media-controls-time-remaining-display {
  color: #333;
  font-weight: bold;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.7);
}

audio::-webkit-media-controls-timeline {
  border-radius: 50px;
  background-color: rgba(255, 255, 255, 0.3);
}

/* ===== CREATE ORDER OVERLAY (with blur effect) ===== */
.order-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(255,255,255,0.95);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 3000;
}

.order-box {
  background: white;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  width: 90%;
  max-width: 400px;
  text-align: center;
}

.order-box h2 {
  color: indigo;
  margin-bottom: 15px;
}

.order-box input {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.order-box button {
  width: 48%;
  padding: 10px;
  border: none;
  border-radius: 8px;
  margin-top: 10px;
  cursor: pointer;
}

#addOrderBtn {
  background: #b9d325ff;
  color: white;
}

#closeOrderBtn {
  background: crimson;
  color: white;
}

    .dashboard-cards {
      display: flex;
      justify-content:space-between;
      gap: 20px;
      margin-top: 30px;
    }

    .card {
      background:white;
      
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 20px rgba(240, 98, 98, 0.92);
      transition: transform 0.3s;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-5px);
    }

  

    .card p {
      color:black;
      font-size: 22px;
    }
    a{text-decoration:none;}

    
    .user-icon{
    margin-right:40px;
     margin-top: 40px;

      
    }
   
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <span class="logo-image">🌸</span>
      <div class="logo-title">
        <span>𝗣</span><span>Ξ</span><span>𝗥</span><span>𝗙</span><span>𝗨</span><span>𝗠</span><span>Ξ</span>
      </div>
      <span class="logo-subtitle">ʟᴜxɛ</span>
    </div>
   <!-- <div class="search-container">
        <input type="text" class="search-input" placeholder="Search perfume...">
        <button type="submit" class="search-button"><i class="fa-solid fa-search"></i></button>
    </div>   -->
    <form class="search-container" method="GET" action="">
  <input 
    type="text" 
    class="search-input" 
    name="query" 
    placeholder="Search perfume..." 
    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>"
  >
  <button type="submit" class="search-button">
    <i class="fa-solid fa-search"></i>
  </button>
</form>
    
  <nav>
  <ul>
     <div class="navigation"><li><a href="#" id="homeBtn"><i class="fas fa-home"></i></a></li></div>
    <div class="navigation"><li><a href="#" id="shopBtn"><i class="fas fa-store"></i></a></li></div> 
   <div class="navigation"><li><a href="#" id="aboutBtn"><i class="fas fa-shield-halved"></i></a></li></div>  
   
    <!-- <div class="navigation"><li><a href="#" id="homeBtn">Home</a></li></div>
    <div class="navigation"><li><a href="#" id="shopBtn">Shop</a></li></div>
    <div class="navigation"><li><a href="#" id="aboutBtn">About</a></li></div> -->
  </ul>
</nav>
  </header>

  <!-- SHOP CONTENT -->
  <main>
    <h1>Perfume Collection</h1>
  <div class="shop">
   
  <?php while($row = $result->fetch_assoc()): ?>
    
    <div class="product-card">
      
     <div class="header_profile_image">
      <img src="1762076647_1760640890_1760625282_perfume3.jpg" alt="profile picture" class="profile-pic">
      <span class="profile_username">caston</span>
    </div>  

      <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
      
      <?php if (!empty($row['video'])): ?>
      <div class="media">
        <video class="product-video" controls>
          <source src="<?php echo $row['video']; ?>" type="video/mp4">
        </video>
      </div>
      <?php elseif (!empty($row['audio'])): ?>
      <div class="media">
        <audio controls>
          <source src="<?php echo $row['audio']; ?>" type="audio/mpeg">
        </audio>
      </div>
      <?php endif; ?>

      <p class="product-description">
        <strong style="color:darkgreen;"><?php echo $row['name']; ?></strong><br>
        <?php echo htmlspecialchars($row['description']); ?><br>
        <b  style="color:#e91e63;">Brand:</b> <?php echo $row['brand']; ?><br>
        <b style="color:#e91e63;">Type:</b> <?php echo $row['scent_type']; ?><br>
        <b style="color:#e91e63;">Gender:</b> <?php echo $row['gender']; ?><br>
        <b style="color:#e91e63;">Price:</b> Tsh <?php echo $row['price']; ?>/=<br>
      </p>

       <button class="btn order-btn" style="font-size:12px;"  onclick="createOrder('<?php echo $row['id']; ?>','<?php echo $row['name']; ?>')"><i class="fas fa-cart-shopping" style="font-size:16px;"></i> Order</button>
      <button class="btn whatsapp-btn"  style="font-size:12px;" onclick="chatWhatsApp('<?php echo $row['name']; ?>')"><i class="fab fa-whatsapp" style="font-size:16px;"></i>  Chat</button>
     <!-- <button class="about_product" onclick="openModel()" style="font-size:12px;"><i class="fas fa-circle-info" style="font-size:16px;"></i> About</button> -->

<button class="about_product"  onclick="window.open('about_perfume.php', '_blank')" style="font-size:12px;"><i class="fas fa-circle-info" style="font-size:16px;"></i> About
  
</button>
      <!-- <button class="btn order-btn" onclick="createOrder('<?php echo $row['id']; ?>','<?php echo $row['name']; ?>')">Create Order</button>
      <button class="btn whatsapp-btn" onclick="chatWhatsApp('<?php echo $row['name']; ?>')">Chat on WhatsApp</button>
      <button class="about_product" >About product</button> -->

    </div>
  <?php endwhile; ?>
</div>  
  </main>
    <!-- SHOP OVERLAY -->
  <div class="overlay" id="overlay">
    <p>Welcome to shopping with Perfume Luxe</p>

    
    <button class="back-btn" id="closeOverlay">Back</button>
  </div>
  
 <!-- ===== HOME OVERLAY ===== -->
<div class="overlay home-overlay" id="homeOverlay">
  <p>Welcome to <strong>Perfume Luxe</strong> — Discover luxury fragrances crafted with passion and elegance.</p>
<div class="dashboard-cards">
 <div class="card">
       <a href="login.php"><i class="fa-solid fa-right-to-bracket" style="font-size:40px;color:pink;padding:10px;background:indigo;border-radius:100px;"></i></a>
        <p>Login now in your account to get our products.</p>
      </div>

 <div class="card">
       <a href="users_registration.php"><i class="fa-solid fa-user-plus" style="font-size:40px;color:pink;padding:10px;background:indigo;border-radius:100px;"></i></a>
        <p>Register now in perfumeluxe to get your account.</p>
      </div> 
   </div>      
      <br>
      <br>
      <br>
  <button class="back-btn" id="closeHomeOverlay">Back</button>
</div>

<!-- ===== ABOUT OVERLAY ===== -->
<!-- ===== ABOUT OVERLAY ===== -->
<div class="overlay about-overlay" id="aboutOverlay">
  <div class="about-content">
    <h2 class="about-title">About Perfume Luxe</h2>
    <p class="about-text" id="typeText"></p>
    <button class="back-btn" id="closeAboutOverlay">Close</button>
  </div>
</div>
<!-- CREATE ORDER OVERLAY -->
<div id="orderOverlay" class="order-overlay">
  <div class="order-box">
    <h2>Create Your Order</h2>
    <form id="orderForm">
      <input type="hidden" name="product_id" value="12">
      <input type="text" id="orderPhone" placeholder="WhatsApp Number" required>
      <input type="text" id="orderLocation" placeholder="Your Location" required>
      <input type="text" id="orderProduct" readonly>
      <button type="submit" id="addOrderBtn">Add Order</button>
      <button type="button" id="closeOrderBtn">Cancel</button>
      
    </form>
  </div>
</div>

  <!-- FOOTER -->
  <footer>
    <h3>Perfume Luxe</h3>
    <div class="socials">

  <a href="https://www.fb.com/l/6lp1kJRRR"><i class="fab fa-facebook" style="font-size:26px;"></i></a>
      <a href="https://www.instagram.com/official_perfumeluxe/?utm_source=qr&r=nametag"><i class="fab fa-instagram" style="font-size:26px;"></i></a>
      <a href="https://chat.whatsapp.com/JXTyGTU3Xol4vuTjLtJvnZ?mode=ems_share_t"><i class="fab fa-whatsapp" style="font-size:26px;"></i></a>
    

      <!-- <a href="https://www.fb.com/l/6lp1kJRRR"><i class="fab fa-facebook"></i>Facebook</a>
      <a href="https://www.instagram.com/official_perfumeluxe/?utm_source=qr&r=nametag"><i class="fab fa-instagram"></i>Instagram</a>
      <a href="https://chat.whatsapp.com/JXTyGTU3Xol4vuTjLtJvnZ?mode=ems_share_t"><i class="fab fa-whatsapp"></i>WhatsApp</a>
     -->
    </div>
     <p>Share your suggestions with us 💬</p>

  <form action="submit_feedback.php" method="POST" 
        style="max-width:400px; margin:20px auto; text-align:left; background:#333; padding:20px; border-radius:10px;">
    
    <label for="email" style="display:block; margin-bottom:5px;">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required
           style="width:100%; padding:10px; border:none; border-radius:6px; margin-bottom:15px;">

    <label for="message" style="display:block; margin-bottom:5px;">Your Suggestion:</label>
    <textarea id="message" name="message" rows="4" placeholder="Write what you seggest in perfumeluxe...." required
              style="width:100%; padding:10px; border:none; border-radius:6px; margin-bottom:15px;"></textarea>

    <button type="submit" 
            style="background:#ff66b2; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; width:100%;">
      Send Suggestion
    </button>
  </form>

    <p>&copy; 2025 Perfume Luxe. All Rights Reserved.</p>
  </footer>

  

  <!-- JS -->
  <script>
        // SHOP overlay open
    document.getElementById("shopBtn").addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("overlay").classList.add("active");
    });

    // Close overlay
    document.getElementById("closeOverlay").addEventListener("click", function() {
      document.getElementById("overlay").classList.remove("active");
    });
    
    // ===== HOME OVERLAY =====
document.getElementById("homeBtn").addEventListener("click", function(e) {
  e.preventDefault();
  document.getElementById("homeOverlay").classList.add("active");
});

document.getElementById("closeHomeOverlay").addEventListener("click", function() {
  document.getElementById("homeOverlay").classList.remove("active");
});
// ===== ABOUT OVERLAY =====
const aboutBtn = document.getElementById("aboutBtn");
const aboutOverlay = document.getElementById("aboutOverlay");
const closeAboutOverlay = document.getElementById("closeAboutOverlay");
const typeText = document.getElementById("typeText");

// Typewriter text message
const aboutMessage = 
  "Perfume Luxe is your destination for premium, long-lasting fragrances.\n\nEach scent tells a story — of elegance, charm, and unforgettable luxury.";

// Function for typewriter effect
function typeWriter(text, element, speed = 45) {
  element.textContent = ""; // clear previous text
  let i = 0;
  const timer = setInterval(() => {
    if (i < text.length) {
      element.textContent += text.charAt(i);
      i++;
    } else {
      clearInterval(timer);
    }
  }, speed);
}

aboutBtn.addEventListener("click", function(e) {
  e.preventDefault();
  aboutOverlay.classList.add("active");
  typeWriter(aboutMessage, typeText); // start typing animation
});

closeAboutOverlay.addEventListener("click", function() {
  aboutOverlay.classList.remove("active");
  typeText.textContent = ""; // reset text when closing
});

    
    function createOrder(product) {
      alert("Order created for: " + product);
      // later: connect to database
    }

    function chatWhatsApp(product) {
      let phone = "255768174044"; // your WhatsApp number
      let message = encodeURIComponent("Hello! I'm interested in buying: " + product);
      window.open(`https://wa.me/${phone}?text=${message}`, "_blank");
    }
  </script>
<script>
  // ====== SMART MEDIA CONTROL ======
  const audios = document.querySelectorAll("audio");
  const videos = document.querySelectorAll("video");
  let currentAudio = null;

  // 🎵 AUDIO: itaplay tu ikiwa iko 50% kwenye screen
  const audioObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const audio = entry.target;

      if (entry.isIntersecting) {
        // pause zingine zote kwanza
        audios.forEach(a => {
          if (a !== audio) a.pause();
        });
        // play hii moja
        audio.play().catch(() => {});
        currentAudio = audio;
      } else {
        // ikiwa imetoka kwenye view
        if (currentAudio === audio) {
          audio.pause();
          currentAudio = null;
        }
      }
    });
  }, { threshold: 0.5 });

  audios.forEach(audio => {
    audio.pause();
    audioObserver.observe(audio);
  });

  // 🎥 VIDEO CONTROL
  videos.forEach(video => {
    video.muted = true; // default ni kimya
    video.controls = true; // user aweze kudhibiti

    // ikichezwa, zima muziki mwingine
    video.addEventListener("play", () => {
      audios.forEach(a => a.pause());
      if (currentAudio) {
        currentAudio.pause();
        currentAudio = null;
      }

      // video nyingine zisimame
      videos.forEach(v => {
        if (v !== video) v.pause();
      });

      // toa mute kwenye video iliyobofiwa
      video.muted = false;
    });
  });

  // 🔇 Ikiwa video imetoka kwenye screen, imute
  const videoObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const video = entry.target;
      if (!entry.isIntersecting) {
        video.muted = true; // ikitoka kwenye view
      }
    });
  }, { threshold: 0.5 });

  videos.forEach(video => videoObserver.observe(video));
  
  // ===== CREATE ORDER OVERLAY =====
let currentProduct = "";
let currentProductId = "";

// When user clicks "Create Order"
function createOrder(productId ,product) {
  currentProductId =productId ;
  currentProduct = product;
  document.getElementById("orderOverlay").style.display = "flex";
  document.getElementById("orderProduct").value = product;
}

// Close overlay
document.getElementById("closeOrderBtn").addEventListener("click", function() {
  document.getElementById("orderOverlay").style.display = "none";
});

// Handle form submit
document.getElementById("orderForm").addEventListener("submit", async function(e) {
  e.preventDefault();

  const phone = document.getElementById("orderPhone").value;
  const location = document.getElementById("orderLocation").value;
  const product = currentProduct;

  const formData = new FormData();
  formData.append("product_id",currentProductId );
  formData.append("phone", phone);
  formData.append("location", location);
  formData.append("product", product);

  const res = await fetch("order_process.php", {
    method: "POST",
    body: formData
  });

  const result = await res.text();
  if (result.trim() === "success") {
    alert("✅ Order sent successfully!");
    document.getElementById("orderOverlay").style.display = "none";
  } else {
    alert("❌ Failed to send order. Try again.");
  }
});

</script>


</body>
</html>
