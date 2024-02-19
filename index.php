<!DOCTYPE html>
<html lang="en">
<?php
session_start() ?>
<?php
include 'date/jdf.php';

	if(!isset($_SESSION['login_id']))
	    header('location:login.php');
    include 'db_connect.php';

ob_start();
  if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  }
ob_end_flush();

	include 'header.php';
$f = $_SESSION["cookie_time"];
?>
<style>
    @media (max-width: 1375px)
        .wrapper {
            width: 1383px;
        }
</style>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

        <meta http-equiv="refresh" content="<?php echo $f ?>;url=http://110.110.25.136/login.php">


  <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div>

        </div>
            <hr class="border-primary">
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            if(!file_exists($page.".php")){
                include '404.html';
            }else{
            include $page.'.php';

            }
          ?>
<!--      </div>-->
<!--    </section>-->
    <!-- /.content -->
    <div  class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div style="    direction: rtl;" class="modal-header">
        <h5  class="modal-title">تائیدیه</h5>
      </div>
      <div style="text-align: right" class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">بله</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">بله</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" style="text-align: right">

<!--    <div class="float-right d-none d-sm-inline-block">-->
<!--      <b>--><?php //echo $_SESSION['system']['name'] ?><!--</b>-->
<!--    </div>-->
      <div style="float: left; pointer-events: none;">
          <script type="text/javascript" src="https://1abzar.ir/abzar/tools/time-date/date-fa.php?color=333333&font=9&bg=&kc=CAE09D&kadr=0"></script>
          <div style="display:none"><h2><a href="https://www.1abzar.com/abzar/time-date.php">&#1587;&#1575;&#1593;&#1578; &#1608; &#1578;&#1575;&#1585;&#1610;&#1582;</a></h2></div>

          <script type="text/javascript" src="https://1abzar.ir/abzar/tools/time-date/clock-ir.php?color=333333&font=9&bg=&kc=CAE09D&kadr=0"></script>
          <div style="display:none"><h2><a href="https://www.1abzar.com/abzar/time-date.php">&#1587;&#1575;&#1593;&#1578; &#1608; &#1578;&#1575;&#1585;&#1610;&#1582;</a></h2></div>
      </div>
      <strong> <a href="https://www.atmosphere.ir/"></a></strong>
      <span style="float: right !important;">واحد فناوری و اطلاعات کارخانجات اتمسفر</span>

  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- Bootstrap -->
<?php include 'footer.php' ?>
</body>
</html>

<script>
    window.onclick = function(event) {
        <?php
        $now = time()  - $_SESSION["time_session"];
        if ($_SESSION["cookie_time"]  < $now){
        ?>
        window.location.href ='index.php?page=login';
        <?php
        session_unset();
        session_destroy();
        }
        ?>
    }
    $("#abzar1").click(function (){
        window.location.href = "http://www.google.com";
    });
</script>

