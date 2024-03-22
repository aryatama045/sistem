<?php
    error_reporting(1);
    ini_set('display_errors','on');
    ini_set('display_errors',1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Leprindo | Login Page</title>
    <meta name="description" content="Login Page" />

    <!-- Favicon Tags Start -->
    <link rel="shortcut icon" href="https://place-hold.it/100x100/127352/fff/fff?text=LEP.&fontsize=35&bold" type="image/x-icon" >
    <link rel="icon" type="image/png" href="https://place-hold.it/128x128/127352/fff/fff?text=LEP.&fontsize=35&bold" sizes="128x128" />
    <meta name="application-name" content="Leprindo" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <!-- Favicon Tags End -->

    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>font/CS-Interface/style.css" />
    <!-- Font Tags End -->

    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/datatables.min.css" />
    <!-- Vendor Styles End -->


    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/styles.css" />
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/main.css" />
    <!-- Template Base Styles End -->

    <script src="<?= base_url('assets/') ?>js/base/loader.js"></script>
</head>


<body>

    <?php $this->load->view('templates/side_menubar'); ?>

    <main>
        <div class="container">

