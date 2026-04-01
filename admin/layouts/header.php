<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en"
class="light-style layout-menu-fixed"
data-theme="theme-default"
data-assets-path="../assets/"
data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <title>E-Buku Tamu Digital</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />


    <style>

/* Background */
body {
    background: #f5f7ff !important;
}

/* FLOATING SIDEBAR STYLE */
#layout-menu {
    margin: 20px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.08);
    background: linear-gradient(180deg, #ffffff, #f8f9ff);
    height: calc(100vh - 40px);
    transition: all 0.3s ease;
}

/* Menu spacing */
.menu-inner .menu-item {
    margin: 6px 10px;
}

.menu-inner .menu-link {
    border-radius: 14px;
    transition: 0.3s ease;
    padding: 10px 14px;
    font-weight: 500;
}

.menu-inner .menu-link:hover {
    background: rgba(105,108,255,0.1);
    transform: translateX(5px);
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, #696cff, #8f94fb);
    color: white !important;
    box-shadow: 0 8px 20px rgba(105,108,255,0.3);
}

.menu-item.active .menu-link i {
    color: white !important;
}

.menu-icon {
    transition: 0.3s ease;
}

.menu-link:hover .menu-icon {
    transform: scale(1.1);
}

.layout-page {
    padding: 20px;
}

/* Navbar floating */
.layout-navbar {
    margin: 20px 20px 0 0;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

</style>
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    
<div class="layout-container">