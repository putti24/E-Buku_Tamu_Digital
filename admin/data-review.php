<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ================= PAGINATION ================= */
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM review");
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_page = ceil($total_data / $limit);

/* ================= QUERY ================= */
$query = mysqli_query($conn,
"SELECT r.*, t.nama 
 FROM review r
 JOIN tamu t ON r.tamu_id = t.id
 ORDER BY r.id DESC
 LIMIT $start, $limit");

include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="page-breadcrumb mb-3">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Data Review
            </li>
        </ol>
    </nav>
</div>

<div class="container-xxl py-4">
<h4 class="fw-bold mb-4">Data Review</h4>

<div class="card">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">

<thead class="table-light">
<tr>
    <th width="60">No</th>
    <th>Nama</th>
    <th width="130">Rating</th>
    <th>Review</th>
    <th width="120">Status</th>
    <th width="150">Aksi</th>
</tr>
</thead>

<tbody>

<?php 
$no = $start + 1;
while($r = mysqli_fetch_assoc($query)) : 
?>

<tr>
<td><?= $no++; ?></td>

<td class="fw-semibold"><?= $r['nama']; ?></td>

<td>
<?php 
for($i=1;$i<=5;$i++){
    if($i <= $r['rating']){
        echo "<span style='color:#facc15;'>★</span>";
    } else {
        echo "<span style='color:#ddd;'>★</span>";
    }
}
?>
</td>

<td>
<?= $r['tags']; ?>
</td>

<td>
<?php if($r['status']=='pending'): ?>
    <span class="badge bg-label-warning">Pending</span>
<?php else: ?>
    <span class="badge bg-label-success">Approved</span>
<?php endif; ?>
</td>

<td>
<?php if($r['status']=='pending'): ?>
    <a href="approve-review.php?id=<?= $r['id']; ?>" 
       class="btn btn-sm btn-outline-success me-1">
       <i class="bx bx-check"></i>
    </a>
<?php endif; ?>

<a href="hapus-review.php?id=<?= $r['id']; ?>" 
   class="btn btn-sm btn-outline-danger"
   onclick="return confirm('Yakin hapus review?')">
   <i class="bx bx-trash"></i>
</a>
</td>

</tr>

<?php endwhile; ?>

</tbody>
</table>
</div>

<!-- PAGINATION -->
<div class="d-flex justify-content-end p-3">
<nav>
<ul class="pagination mb-0">

<?php if($page > 1): ?>
<li class="page-item">
<a class="page-link" href="?page=<?= $page-1 ?>">Prev</a>
</li>
<?php endif; ?>

<?php for($i=1;$i<=$total_page;$i++): ?>
<li class="page-item <?= ($i==$page)?'active':'' ?>">
<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
</li>
<?php endfor; ?>

<?php if($page < $total_page): ?>
<li class="page-item">
<a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
</li>
<?php endif; ?>

</ul>
</nav>
</div>

</div>
</div>

<?php include 'layouts/footer.php'; ?>