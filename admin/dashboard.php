<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ================= QUERY ================= */

$totalGuru = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM guru"))['total'];

$totalTamu = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM tamu"))['total'];

$today = date('Y-m-d');
$todayTamu = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM tamu 
     WHERE DATE(created_at) = '$today'"))['total'];

$pending = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM tamu 
     WHERE status='pending'"))['total'];

/* Statistik Bulanan */
$bulan = [];
$dataBulanan = [];

for ($i = 1; $i <= 12; $i++) {
    $result = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) as total FROM tamu 
         WHERE MONTH(created_at) = '$i' 
         AND YEAR(created_at) = YEAR(CURDATE())"
    ));
    $bulan[] = date("M", mktime(0,0,0,$i,1));
    $dataBulanan[] = $result['total'];
}

include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="container-xxl py-4">

<h4 class="fw-bold mb-4">Dashboard</h4>

<!-- CARD STATISTIK -->
<div class="row g-4 mb-4">

<div class="col-md-3">
    <div class="glass-card">
        <div>
            <h6>Total Kunjungan</h6>
            <h4 class="counter" data-target="<?= $totalTamu ?>">0</h4>
        </div>
        <i class="bx bx-group"></i>
    </div>
</div>

<div class="col-md-3">
    <div class="glass-card">
        <div>
            <h6>Hari Ini</h6>
            <h4 class="counter" data-target="<?= $todayTamu ?>">0</h4>
        </div>
        <i class="bx bx-calendar-check"></i>
    </div>
</div>

<div class="col-md-3">
    <div class="glass-card">
        <div>
            <h6>Total Guru</h6>
            <h4 class="counter" data-target="<?= $totalGuru ?>">0</h4>
        </div>
        <i class="bx bx-user"></i>
    </div>
</div>

<div class="col-md-3">
    <div class="glass-card">
        <div>
            <h6>Pending</h6>
            <h4 class="counter" data-target="<?= $pending ?>">0</h4>
        </div>
        <i class="bx bx-time-five"></i>
    </div>
</div>

</div>

<!-- CHART SETENGAH -->
<div class="row">
    <div class="col-md-6">
        <div class="chart-card">
            <h6 class="mb-3">Statistik Kunjungan Tahun Ini</h6>
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
</div>

</div>

<style>
.layout-page {
    background: linear-gradient(135deg, #eef2ff, #f8faff) !important;
}

/* 3D CARD */
.glass-card {
    padding: 25px;
    border-radius: 20px;
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(12px);
    box-shadow:
        0 10px 25px rgba(0,0,0,0.08),
        0 5px 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: 0.4s ease;
}

.glass-card i {
    font-size: 32px;
    opacity: 0.6;
    transition: 0.3s;
}

.glass-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow:
        0 20px 45px rgba(0,0,0,0.18);
}

.glass-card:hover i {
    transform: scale(1.2);
    opacity: 1;
}

.chart-card {
    padding: 25px;
    border-radius: 20px;
    background: white;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartBulanan');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan); ?>,
        datasets: [{
            label: 'Kunjungan',
            data: <?= json_encode($dataBulanan); ?>,
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79,70,229,0.15)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Counter
document.querySelectorAll('.counter').forEach(counter => {
    counter.innerText = '0';
    const update = () => {
        const target = +counter.getAttribute('data-target');
        const c = +counter.innerText;
        const increment = target / 40;
        if (c < target) {
            counter.innerText = Math.ceil(c + increment);
            setTimeout(update, 20);
        } else {
            counter.innerText = target;
        }
    };
    update();
});
</script>

<?php include 'layouts/footer.php'; ?>