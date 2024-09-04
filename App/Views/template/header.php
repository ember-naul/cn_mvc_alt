<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Casa & Negócios</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
</head>
<?php 
$_SESSION['cliente'] = false;
$_SESSION['profissional'] = false;
if ($_SESSION['logado'] == true): ?>

  <body class="hold-transition layout-top-nav">
    <div class="wrapper">
      <?php require_once __DIR__ . '/../../../App/Views/template/navbar.php'; ?>
      <div class="content-wrapper p-2">
      <?php endif ?>
      <?php if (isset($_SESSION['sucesso'])) { ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $_SESSION['sucesso'] ?>
        </div>
        <?php
        unset($_SESSION['sucesso']);
      }
      if (isset($_SESSION['erro'])) {
        ?>

        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $_SESSION['erro'] ?>
        </div>
        <?php
        unset($_SESSION['erro']);
      }
      ?>
   