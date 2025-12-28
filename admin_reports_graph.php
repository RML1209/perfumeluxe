<?php
session_start();
require 'db_connect.php'; 

// -------- AUTHENTICATION CHECK ----------
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'super_admin') {
  
    exit();
}

// 1. Pata ID ya Admin anayeangaliwa
if (!isset($_GET['admin_id']) || !is_numeric($_GET['admin_id'])) {
    echo "Error: Admin ID not specified.";
    exit();
}

$admin_to_view_id = $_GET['admin_id'];

// Pata jina la admin kwa ajili ya kichwa cha habari
$target_admin_info = $conn->query("SELECT name FROM users WHERE id = '$admin_to_view_id' AND role = 'admin'")->fetch_assoc();
$target_admin_name = $target_admin_info ? htmlspecialchars($target_admin_info['name']) : "Unknown Admin";

// ================= FETCHING REAL DATA FOR CHART =================
// Mfano: Kuhesabu bidhaa zilizoongezwa na admin huyu kwa siku 7 zilizopita
$dailyProducts = $conn->query("
    SELECT DATE(created_at) as product_date, COUNT(*) as daily_count
    FROM products
    WHERE created_by = '$admin_to_view_id' AND created_at >= DATE(NOW() - INTERVAL 7 DAY)
    GROUP BY product_date
    ORDER BY product_date ASC
");

$chart_labels = [];
$chart_data = [];

while ($row = $dailyProducts->fetch_assoc()) {
    $chart_labels[] = date('D, M j', strtotime($row['product_date'])); 
    $chart_data[] = $row['daily_count'];
}

$js_labels = json_encode($chart_labels);
$js_data = json_encode($chart_data);

// ... HTML na CSS za Grafu zinafuata hapa, zikitumia $js_labels na $js_data ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Graphs for <?php echo $target_admin_name; ?></title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* Weka CSS zote za insights_graph.php hapa */
</style>

</head>
<body>

<div class="top-buttons">
    <button class="btn" onclick="window.location.href = 'admin_reports.php?admin_id=<?php echo $admin_to_view_id; ?>'">⬅ Back to Reports</button>
    <button class="btn" onclick="refreshPage()">🔄 Refresh Data</button>
</div>

<div class="graph-card">
    <canvas id="barChart"></canvas>
</div>

<script>
function refreshPage(){ location.reload(); }

const ctx = document.getElementById('barChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        // Data ya PHP inatumika hapa
        labels: <?php echo $js_labels; ?>, 
        datasets: [{
            label: 'Products Added (<?php echo $target_admin_name; ?>)',
            data: <?php echo $js_data; ?>,
            backgroundColor: 'rgba(255,255,255,0.7)',
            borderRadius: 8,
        }]
    },
    // ... (options za chart) ...
});
</script>

</body>
</html>




