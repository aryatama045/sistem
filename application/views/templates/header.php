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
    <title>Leprindo | <?= $pagetitle; ?></title>
    <meta name="description" content="<?= $pagetitle; ?>" />

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

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/tagify.css" />

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/select2.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/select2-bootstrap4.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/bootstrap-datepicker3.standalone.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/vendor/fancybox.css"/>

    <!-- <script src="<?= base_url('assets/') ?>js/base/loader.js"></script> -->
    <style>
        .dataTables_length {
            margin-bottom: 2em;
        }
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }
        div.dataTables_scrollHead{
            width: 100% !important;
        }


        #page{
            display: none;
        }

        #loading {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100vw;
            height: 100vh;
            background-color: rgba(192, 192, 192, 0.5);
            background-image: url('../../../assets/Loading-Screen.gif');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 150px 150px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }


    </style>
</head>


<body >

    <div id="loader" class="center"></div>

    <?php $this->load->view('templates/side_menubar'); ?>

    <main>
        <div class="container">

