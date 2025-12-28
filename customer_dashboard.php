<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard</title>
    <!-- Font Awesome (CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f1f2f6;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
      padding: 20px;
    }
    
    /* Main Header */
    h1 {
        color: #1a2a44;
        margin-top: 20px;
        font-size: 2em;
        text-align: center;
        opacity: 0;
        animation: fadeIn 0.5s ease-in forwards;
    }
    
    /* Profile Card */
    .user-profile-container {
      max-width: 400px;
      width: 100%;
      background:rgba(242, 234, 236, 0.924);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 6px 10px rgba(201, 32, 32, 0.793);
      text-align: center;
      margin-top: 10px;
      margin-bottom: 20px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      opacity: 0;
      animation: fadeIn 0.4s ease-in forwards;
      animation-delay: 0.1s;
    }

    .user-profile-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 10px rgba(147, 17, 191, 0.724);
    }

    /* User Content - Inherits from parent fade */
    .user-profile-content img,
    .user-profile-content h2,
    .user-profile-content p,
    .user-profile-content button {
        /* Reset opacity so the parent container handles the primary fade-in */
        opacity: 1; 
        animation: none;
        transition: all 0.3s ease-in-out;
    }


    .user-profile-content img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-top: 25px;
      margin-bottom: 15px;
      border: 4px solid #00c4b4;
    }

    .user-profile-content h2 {
      color: #1a2a44;
      font-size: 1.8em;
      margin-bottom: 10px;
     margin-top: 10px; 
    }

    .user-profile-content p {
      color: #4a5568;
      margin-bottom: 10px;
      margin-top: 30px; 
    }

    /* Profile Button Transitions */
    .user-profile-content button {
      background: black;
      color: #fff;
      border: none;
      padding: 14px 6px;
      border-radius: 2px;
      cursor: pointer;
      margin-top: 10px;
      margin-bottom: 20px; 
      font-size: 1em;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(26, 163, 227, 0.716);
    }

    .user-profile-content button:hover {
      background: linear-gradient(45deg, #e55353, #e07b39);
      transform: scale(1.05);
       
    }
    
    .user-profile-content button:active { /* Press state */
      transform: scale(0.95);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      
    }

    /* Animation for fade-in effect */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Action Buttons Container */
    .action-profile-container {
      max-width: 400px;
      width: 100%;
      background:rgba(242, 234, 236, 0.924);
      padding: 20px 10px;
      border-radius: 20px;
       box-shadow: 0 6px 10px rgba(201, 32, 32, 0.793);
      justify-content: center;
      text-align: center;
      margin-bottom: 50px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .action-profile-container:hover{
      transform: translateY(-5px);
      box-shadow: 0 6px 10px rgba(147, 17, 191, 0.724);
    }
    .button-container {
      display: flex;
      flex-wrap: wrap; 
      gap: 10px;
      padding: 10px;
      justify-content: center;
      width: 100%;
      margin: 0;
    }
    

    .button-container button {
      padding: 6px 1px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 10px;
      color: white;
      
      transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
      width: calc(23.33% - 3px);
      min-width: 90px;
      box-shadow: 0 100px 40px rgb(238, 237, 237);
      
      /* --- NEW FADE-IN ANIMATION FOR BUTTONS --- */
      opacity: 0; /* Start invisible */
      animation: fadeIn 0.4s ease-out forwards;
      /* Animation delays are set below using :nth-child */
    }
    
    /* Staggered entry animation for the 6 buttons */
    .button-container button:nth-child(1) { animation-delay: 1.0s; }
    .button-container button:nth-child(2) { animation-delay: 1.1s; }
    .button-container button:nth-child(3) { animation-delay: 1.2s; }
    .button-container button:nth-child(4) { animation-delay: 1.3s; }
    .button-container button:nth-child(5) { animation-delay: 1.4s; }
    .button-container button:nth-child(6) { animation-delay: 1.5s; }
    /* ------------------------------------------- */
    
    .button-container button:hover {
        transform: translateY(-3px); 
      
    }
    
    .button-container button:active {
        transform: translateY(0) scale(0.98); 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); 
    }

    /* Button Colors */
    .add-btn { background: black; }
    .add-btn:hover { background: #075ea6; }

    .view-btn { background: black; }
    .view-btn:hover { background: #008f6b; }

    .logout-btn { background: black; }
    .logout-btn:hover { background: #a71d1d; }

    /* NEW BUTTON STYLES */
    .settings-btn { background:black; }
    .settings-btn:hover { background:violet; }

    .messages-btn { background: black; }
    .messages-btn:hover { background: #e85d8d; }

    .history-btn { background:black; }
    .history-btn:hover { background: #00b4b2; }

    /* Responsive */
    @media (max-width: 500px) {
      .button-container {
        gap: 8px; 
         padding: 6px 2px;
      }
      .button-container button {
        width: calc(16.33% - 3.33px); 
        padding: 6px 2px;
        padding-bottom: 22px;
        font-size: 12px;
        min-width: 80px;
      }
      .user-profile-container {
        padding: 20px;
      }
      h1 {
        font-size: 1.5em;
      }
    }
    
    a{
      text-decoration:none;
      color: inherit;
      display: block;
      width: 100%;
      height: 100%;
    }
    .logo .logo-image {
      display: inline-block;
      font-size: 20px;
      padding: 0px;
      animation: slow-rotate 8s linear infinite;
      
    }
    @keyframes slow-rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
  </style>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
  <p style="text-align: center; margin-bottom: 5px; color: #6e7a90;">You are logged in your account.</p>

  <!-- User Profile -->
  
  <div class="user-profile-container">
    <div class="logo">
      <span class="logo-image">🌸</span>
      <div class="logo-title">
        <span>𝗣</span><span>Ξ</span><span>𝗥</span><span>𝗙</span><span>𝗨</span><span>𝗠</span><span>Ξ</span>
      </div>
      <span class="logo-subtitle">ʟᴜxɛ</span> 
    <div class="user-profile-content">
      
      <img src="1761585419_1760625054_perfume1.jpg" alt="User Profile Picture">
      <h2 id="user-name">John Doe</h2>
    
      <p id="user-stats">MY SOCIAL MEDIA</p>
      <div>
       
<!-- Instagram -->

<button class="user-action-btn"><a href="https://instagram.com/yourprofile" aria-label="Instagram" target="_blank" rel="noopener">
  <i class="fa-brands fa-instagram"></i>
</a> </button>
 
<!-- TikTok -->

<button class="user-action-btn"><a href="https://www.tiktok.com/@yourprofile" aria-label="TikTok" target="_blank" rel="noopener">
  <i class="fa-brands fa-tiktok"></i>
</a>   </button>
      
<!-- Facebook -->
<button class="user-action-btn"><a href="https://facebook.com/yourpage" aria-label="Facebook" target="_blank" rel="noopener">
  <i class="fa-brands fa-facebook"></i>
</a></button>

<!-- WhatsApp -->
<button class="user-action-btn"><a href="https://wa.me/2557XXXXXXXX" aria-label="WhatsApp" target="_blank" rel="noopener">
  <i class="fa-brands fa-whatsapp"></i>
</a></button>

<!-- Snapchat -->
<button class="user-action-btn"><a href="https://www.snapchat.com/add/yourusername" aria-label="Snapchat" target="_blank" rel="noopener">
  <i class="fa-brands fa-snapchat"></i>
</a></button>

      
       
    </div>
    </div>
  </div>

  <!-- Action Buttons (Now 6 buttons with transitions) -->
  <div class="action-profile-container">
    <div class="button-container">
      <button class="add-btn"><a href="load.html">My orders</a></button>
      <button class="view-btn">Offers</button>
      
      <button class="logout-btn"><a href="new_index.php">Products</a></button>
      
      <button class="settings-btn">Favourites</button>
      
      <button class="messages-btn">Payments</button>
      
      <button class="history-btn">My coins</button>
    </div>
  </div>
  
   <!-- Action Buttons (Now 6 buttons with transitions) -->
  <div class="action-profile-container">
    <div class="button-container">
      <button class="add-btn"><a href="load.tml">Others profiles</a></button>
      <button class="view-btn">Update profiles</button>
      
      <button class="logout-btn"><a href="logout.php">Logout</a></button>
    
     
    </div>
  </div>

</body>
</html>

