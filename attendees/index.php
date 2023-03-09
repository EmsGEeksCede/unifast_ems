<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php
if (!isset($_SESSION['login_id']))
  header('location:login.php');
include 'header.php'
?>

<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
  <div class="wrapper">
    <?php include 'topbar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
      <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-md">
          <?php
          $page = isset($_GET['page']) ? $_GET['page'] : 'home';
          include $page . '.php';
          ?>
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <!-- <aside class="control-sidebar control-sidebar-dark"> -->
      <!-- Control sidebar content goes here -->
    <!-- </aside> -->
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
    <div class="float-right d-none d-sm-inline-block">
      <b>Unified Student Financial Assistance System for Tertiary Education</b>
    </div>
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <!-- Bootstrap -->
  <?php include 'footer.php' ?>
</body>

</html>