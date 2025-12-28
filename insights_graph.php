<?php
session_start();
// Hakikisha faili hili lipo na linaunganisha na database
require 'db_connect.php'; 

// -------- AUTHENTICATION CHECK ----------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only admin allowed to view this
if ($_SESSION['role'] !== 'admin') {
    echo "Access Denied! Only Admin can view his/her graphs.";
    exit();
}

// ================= FETCHING REAL DATA FOR CHART =================
// Mfano: Kuhesabu jumla ya orders kwa kila siku katika siku 7 zilizopita
$dailyOrders = $conn->query("
    SELECT DATE(created_at) as order_date, COUNT(*) as daily_count
    FROM orders
    WHERE created_at >= DATE(NOW() - INTERVAL 7 DAY)
    GROUP BY order_date
    ORDER BY order_date ASC
");

$chart_labels = [];
$chart_data = [];

// Jaza arrays kwa data za JavaScript
while ($row = $dailyOrders->fetch_assoc()) {
    // Tumia jina la siku na tarehe kama label (e.g., Fri, Dec 12)
    $chart_labels[] = date('D, M j', strtotime($row['order_date'])); 
    $chart_data[] = $row['daily_count'];
}

// Badilisha PHP arrays kuwa JSON strings
$js_labels = json_encode($chart_labels);
$js_data = json_encode($chart_data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Insights Graph</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    body{
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0d47a1, #1565c0, #2196f3);
        padding: 20px;
        animation: slideIn 0.7s ease forwards;
        color: white;
        height: 100vh;
        overflow: hidden;
    }

    @keyframes slideIn{
        from{ opacity: 0; transform: translateX(50px); }
        to{ opacity: 1; transform: translateX(0); }
    }

    .top-buttons{
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .btn{
        padding: 12px 20px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        cursor: pointer;
        color: white;
        transition: 0.3s ease;
    }

    .btn:hover{
        transform: scale(1.07);
        border-color: #fff;
        box-shadow: 0 8px 15px rgba(255,255,255,0.3);
    }

    .graph-card{
        width: 90%;
        max-width: 1000px;
        margin: auto;
        height: 75vh;
        background: rgba(255,255,255,0.15);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
        padding: 20px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
</style>

</head>
<body>

<div class="top-buttons">
    <button class="btn" onclick="window.location.href = 'products_insights.php'">⬅ Back to Insights</button>
    <button class="btn" onclick="refreshPage()">🔄 Refresh Data</button>
</div>

<div class="graph-card">
    <canvas id="barChart"></canvas>
</div>

<script>
function refreshPage(){
    location.reload();
}

// Bar Graph Data
const ctx = document.getElementById('barChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        // Hapa ndipo data ya PHP inapotumiwa
        labels: <?php echo $js_labels; ?>, 
        datasets: [{
            label: 'Daily Orders (Last 7 Days)',
            data: <?php echo $js_data; ?>,
            backgroundColor: 'rgba(255,255,255,0.7)',
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { 
            legend: { 
                labels: { color: 'white' }
            },
            title: {
                display: true,
                text: 'Daily Order Count',
                color: 'white',
                font: { size: 18 }
            }
        },
        scales: {
            x: { 
                grid: { color: 'rgba(255,255,255,0.1)' },
                ticks: { color: 'white' }
            },
            y: { 
                beginAtZero: true,
                grid: { color: 'rgba(255,255,255,0.1)' },
                ticks: { 
                    color: 'white',
                    stepSize: 1 
                }
            }
        }
    }
});
</script>

</body>
</html>
