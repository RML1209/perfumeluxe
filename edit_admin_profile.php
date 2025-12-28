<?php
session_start();
require 'db_connect.php';

// Hakikisha admin yupo logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
$message = "";

// ============================
//  FETCH CURRENT PROFILE DATA
// ============================
$sql = "SELECT username, profile_picture FROM admin_profile WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($db_username, $db_profile_picture);
$stmt->fetch();
$stmt->close();

// Defaults
if (!$db_username) { $db_username = ""; }
if (!$db_profile_picture) { $db_profile_picture = "default_profile.png"; }

$profile = [
    "username" => $db_username,
    "profile_picture" => $db_profile_picture
];

// ============================
//   HANDLE FORM SUBMISSION
// ============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];

    // Handle image upload
    if (!empty($_FILES["profile_picture"]["name"])) {

        // Create uploads folder if not exists
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        $image = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target = "uploads/" . $image;
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target);

    } else {
        $image = $profile['profile_picture']; 
    }

    // Check if profile exists
    $check = $conn->prepare("SELECT id FROM admin_profile WHERE admin_id = ?");
    $check->bind_param("i", $admin_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        // UPDATE PROFILE
        $sql = "UPDATE admin_profile 
                   SET username=?, profile_picture=?, updated_at=NOW() 
                 WHERE admin_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $image, $admin_id);
        $stmt->execute();

        $message = "Profile updated successfully!";

    } else {

        // INSERT NEW PROFILE (UNIQUE)
        $sql = "INSERT INTO admin_profile 
                (admin_id, username, profile_picture, profile_created_by)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $admin_id, $username, $image, $admin_id);
        $stmt->execute();

        $message = "Profile created successfully!";
    }

    header("Location: edit_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Admin Profile</title>
<style>
body { 
    font-family: Arial; 
    background:#f7f7f7; 
    padding:20px;
}
.container { 
    width:350px; 
    margin:auto; 
    background:white; 
    padding:20px; 
    border-radius:10px; 
    box-shadow:0 0 10px rgba(0,0,0,0.1); 
}
input, button { 
    width:100%; 
    padding:10px; 
    margin-top:10px; 
    border-radius:5px; 
    border:1px solid #ccc; 
}
button {
    background:#e91e63;
    color:white;
    border:none;
    cursor:pointer;
}
button:hover {
    background:#c2185b;
}
.profile-preview img {
    width:120px; 
    height:120px; 
    border-radius:50%; 
    object-fit:cover; 
    border:3px solid #e91e63;
    display:block;
    margin:auto;
}
h3 { 
    text-align:center; 
    color:#e91e63; 
}
</style>
</head>
<body>

<div class="container">
    <h3>Edit Profile</h3>

    <?php if(!empty($message)) echo "<p style='color:green; text-align:center;'>$message</p>"; ?>

    <div class="profile-preview">
        <img src="uploads/<?php echo $profile['profile_picture']; ?>" id="previewImage">
    </div>

    <form method="POST" enctype="multipart/form-data">

        <label>Username</label>
        <input type="text" name="username" 
               value="<?php echo htmlspecialchars($profile['username']); ?>" 
               required>

        <label>Profile Picture</label>
        <input type="file" name="profile_picture" id="fileInput">

        <button type="submit">Save Changes</button>

    </form>
</div>

<script>
// LIVE IMAGE PREVIEW (optional)
document.getElementById("fileInput").addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
        document.getElementById("previewImage").src = URL.createObjectURL(file);
    }
});
</script>

</body>
</html>