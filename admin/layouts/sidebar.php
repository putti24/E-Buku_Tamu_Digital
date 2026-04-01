<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" width="150">
    </div>

    <ul class="menu-inner py-1">

        <li class="menu-item <?= ($current == 'dashboard.php') ? 'active' : '' ?>">
            <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item <?= ($current == 'data-guru.php') ? 'active' : '' ?>">
            <a href="data-guru.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Data Guru</div>
            </a>
        </li>

        <li class="menu-item <?= ($current == 'data-tamu.php') ? 'active' : '' ?>">
            <a href="data-tamu.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-notepad"></i>
                <div>Data Tamu</div>
            </a>
        </li>
        <li class="menu-item <?= ($current == 'data-review.php') ? 'active' : '' ?>">
            <a href="data-review.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-star"></i>
                <div>Data Review</div>
            </a>
        </li>
    </ul>
</aside>

<div class="layout-page">

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached bg-navbar-theme">
    <div class="navbar-nav-right d-flex align-items-center ms-auto">

        <!-- NAMA ROLE -->
        <span class="fw-semibold me-3">
            <?php
            if ($_SESSION['role'] == 'super_admin') {
                echo "Administrator";
            } else if ($_SESSION['role'] == 'resepsionis') {
                echo "Resepsionis";
            }
            ?>
        </span>

        <!-- USERNAME -->
        <span class="me-3">
            (<?= $_SESSION['username']; ?>)
        </span>

        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
</nav>


<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">