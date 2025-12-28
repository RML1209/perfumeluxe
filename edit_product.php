<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}



$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $scent_type = $_POST['scent_type'];
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    $image = $product['image'];
    $video = $product['video'];
    $audio = $product['audio'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image = 'uploads/'.time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    if(isset($_FILES['video']) && $_FILES['video']['error'] == 0){
        $video = 'uploads/'.time().'_'.$_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], $video);
    }
    if(isset($_FILES['audio']) && $_FILES['audio']['error'] == 0){
        $audio = 'uploads/'.time().'_'.$_FILES['audio']['name'];
        move_uploaded_file($_FILES['audio']['tmp_name'], $audio);
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE products SET name=?, brand=?, scent_type=?, gender=?, price=?, year=?, description=?, image=?, video=?, audio=? ,updated_by=? WHERE id=?");
    $stmt->bind_param("ssssddssssii", $name, $brand, $scent_type, $gender, $price, $year, $description, $image, $video, $audio,$user_id, $id);
    if($stmt->execute()){
        header("Location: admin_dashboard.php?msg=Product updated successfully");
    } else {
        echo "Error: ".$stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - Perfume Luxe</title>
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #ffdde1, #ee9ca7);
    margin: 0;
    padding: 0;
  }

  header {
    background: rgba(255,255,255,0.2);
    text-align: center;
    padding: 20px;
    color: white;
    font-size: 1.8rem;
    font-weight: bold;
    backdrop-filter: blur(8px);
  }

  .container {
    max-width: 600px;
    margin: 50px auto;
    background: white;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  }

  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #444;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  label {
    font-weight: 600;
    margin-bottom: 0px;
    color: #333;
  }

  input[type="text"],
  input[type="number"],
  textarea,
  input[type="file"] {
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    width: 90%;
  }

  textarea {
    resize: vertical;
    min-height: 80px;
  }

  button {
    background: linear-gradient(90deg, #ee9ca7, #ffdde1);
    border: none;
    padding: 12px;
    border-radius: 30px;
    color: #333;
    /* font-size: 1.1rem; */
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease;
    width:80%;
    margin-left:30px;
    
  }

  button:hover {
    transform: scale(1.05);
    background: linear-gradient(90deg, #ffdde1, #ee9ca7);
  }

  .current {
    font-size: 0.9rem;
    color: #666;
  }

  .back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
  }

  .back-link a {
    color: black;
    text-decoration: none;
    font-weight: bold;
  }

  .back-link a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<header>📝 Edit Product</header>

<div class="container">
  <h2>Update Product Details</h2>

  <form method="POST" enctype="multipart/form-data">
    <label>Product Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Brand</label>
    <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>">

    <label>Scent Type</label>
    <input type="text" name="scent_type" value="<?= htmlspecialchars($product['scent_type']) ?>">

    <label>Gender</label>
    <input type="text" name="gender" value="<?= htmlspecialchars($product['gender']) ?>">

    <label>Price (Tsh)</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>">

    <label>Year</label>
    <input type="number" name="year" value="<?= $product['year'] ?>">

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

    <label>Product Image</label>
    <input type="file" name="image">
    <p class="current">(current: <?= htmlspecialchars($product['image']) ?>)</p>

    <label>Product Video</label>
    <input type="file" name="video">
    <p class="current">(current: <?= htmlspecialchars($product['video']) ?>)</p>

    <label>Product Audio</label>
    <input type="file" name="audio">
    <p class="current">(current: <?= htmlspecialchars($product['audio']) ?>)</p>

    <button type="submit">💾 Update Product</button>
  </form>

  <div class="back-link">
  <a href="admin_products.php" style="padding:8px 14px; background:#ddd; border-radius:6px; text-decoration:none;">← Back </a>
  </div>
</div>

</body>
</html>