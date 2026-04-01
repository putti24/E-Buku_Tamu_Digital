<?php
session_start();
include '../config/koneksi.php';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$keyword = isset($_GET['search']) ? $_GET['search'] : "";

/* HITUNG TOTAL DATA */
$total_sql = "
SELECT COUNT(*) as total
FROM tamu
LEFT JOIN guru ON tamu.guru_id = guru.id
WHERE tamu.nama LIKE '%$keyword%'
OR tamu.no_hp LIKE '%$keyword%'
OR guru.nama LIKE '%$keyword%'
";

$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_page = ceil($total_data / $limit);

/* QUERY DATA */
$query = mysqli_query($conn, "
SELECT tamu.*, guru.nama AS nama_guru
FROM tamu
LEFT JOIN guru ON tamu.guru_id = guru.id
WHERE tamu.nama LIKE '%$keyword%'
OR tamu.no_hp LIKE '%$keyword%'
OR guru.nama LIKE '%$keyword%'
ORDER BY tamu.id DESC
LIMIT $start, $limit
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Tamu</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
</head>

<body>
<?php
include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="page-breadcrumb mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Data Tamu
            </li>
        </ol>
    </nav>
</div>

<h4 class="fw-bold mb-4">Data Buku Tamu</h4>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Tamu</h5>

  </div>

  <div class="table-responsive text-nowrap">
    <table class="table table-hover align-middle mb-0">

      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Instansi</th>
          <th>No HP</th>
          <th>Menemui</th>
          <th>Status</th>
        </tr>
      </thead>

      <tbody class="table-border-bottom-0">
        
        <?php $no = $start + 1; while($t = mysqli_fetch_assoc($query)) : ?>
        <tr>
          <td><?= $no++; ?></td>
          <td class="fw-semibold"><?= $t['nama']; ?></td>
          <td><?= $t['instansi']; ?></td>
          <td><?= $t['no_hp']; ?></td>
          <td>
          <?= $t['nama_guru'] ? $t['nama_guru'] : '<span class="text-muted">-</span>'; ?>
          </td>

        <td>
          <?php if($t['status'] == 'pending'): ?>
            <span class="badge bg-label-warning">Pending</span>
          <?php elseif($t['status'] == 'diterima'): ?>
            <span class="badge bg-label-success">Diterima</span>
          <?php else: ?>
            <span class="badge bg-label-danger">Ditolak</span>
          <?php endif; ?>
        </td>

          <td>
            <?php if($t['status'] == 'pending'): ?>
              <a href="aksi-status.php?id=<?= $t['id']; ?>&status=diterima"
                 class="btn btn-sm btn-outline-success me-1">
                 <i class="bx bx-check"></i>
              </a>

              <a href="aksi-status.php?id=<?= $t['id']; ?>&status=ditolak"
                 class="btn btn-sm btn-outline-danger">
                 <i class="bx bx-x"></i>
              </a>
            <?php else: ?>
              <span class="text-muted">Selesai</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>

      </tbody>

    </table>
    <div class="d-flex justify-content-end mt-3">
<nav>
<ul class="pagination">

<?php if($page > 1): ?>
<li class="page-item">
<a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
</li>
<?php endif; ?>

<?php for($i=1; $i <= $total_page; $i++): ?>
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
</body>
<?php include 'layouts/footer.php'; ?>
</html>