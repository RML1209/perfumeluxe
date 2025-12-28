<?php
session_start();
require 'db_connect.php';

// Check admin session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();


}
//admin_id session
$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $scent_type = $_POST['scent_type'];
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    

    // Upload files if exist
    $image = $video = $audio = NULL;
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image = ''.time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    if(isset($_FILES['video']) && $_FILES['video']['error'] == 0){
        $video = ''.time().'_'.$_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], $video);
    }
    if(isset($_FILES['audio']) && $_FILES['audio']['error'] == 0){
        $audio = ''.time().'_'.$_FILES['audio']['name'];
        move_uploaded_file($_FILES['audio']['tmp_name'], $audio);
    }

    $stmt = $conn->prepare("INSERT INTO products 
        (id,name, brand, scent_type, gender, price, year, description, image, video, audio,created_by)
        VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssddssssi",$id, $name, $brand, $scent_type, $gender, $price, $year, $description, $image, $video, $audio,$user_id);
    if($stmt->execute()){
        header("Location: admin_dashboard.php?msg=Product added successfully");
    } else {
        echo "Error: ".$stmt->error;
    }
}
?>
<style>
    /* ===== General Styles ===== */
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f9f9f9;
    margin: 0;
    padding: 0;
}

form {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
}

/* ===== Form Headings ===== */
form h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-size: 1.8rem;
}

/* ===== Input & Textarea Styling ===== */
form input[type="text"],
form input[type="number"],
form textarea,
form input[type="file"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s ease;
}

form input[type="text"]:focus,
form input[type="number"]:focus,
form textarea:focus {
    border-color: #ff66b2;
    box-shadow: 0 0 8px rgba(255, 102, 178, 0.3);
}

/* ===== Textarea Specific ===== */
form textarea {
    resize: vertical;
    min-height: 100px;
}

/* ===== File Input Styling ===== */
form input[type="file"] {
    padding: 6px 10px;
    border-radius: 8px;
    cursor: pointer;
    background: #f5f5f5;
}

/* ===== Button Styling ===== */
form button {
    width: 100%;
    padding: 14px;
    background: linear-gradient(to right, #ff99cc, #ff66b2);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

form button:hover {
    background: linear-gradient(to right, #ffb3d9, #ff70bb);
    transform: scale(1.02);
}

/* ===== Responsive ===== */
@media (max-width: 650px) {
    form {
        padding: 20px 25px;
        margin: 20px;
    }
}
</style>

<!-- HTML Form -->
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="12">
    <input type="text" style="color:red;" name="name" placeholder="Product Name" required>
    <input type="text" name="brand" placeholder="Brand">
    <input type="text" name="scent_type" placeholder="Scent Type">
    <input type="text" name="gender" placeholder="Gender">
    <input type="number" step="0" name="price" placeholder="Price">
    <input type="number" name="year" placeholder="Year">
    <textarea name="description" placeholder="Description"></textarea>
    <p>Choose image</p>
    <input type="file" name="image">
    <p>Choose video</p>
    <input type="file" name="video">
    <p>Choose audio</p>
    <input type="file" name="audio" >
    <button type="submit">Add Product</button>
</form>