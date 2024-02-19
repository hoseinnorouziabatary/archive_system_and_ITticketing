<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
   if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
   }
  ob_end_flush();
?>
<?php
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<?php include 'header.php' ?>
<body  class="hold-transition login-page bg-info" style="background-image: url('background.jpg');background-color: #ffffff !important;">
<!--<img src="logo.png" alt="..." width="50%">-->
<div class="login-box">
  <div class="login-logo">
<!--    <a href="#" class="text-white"><b>--><?php //echo $_SESSION['system']['name'] ?><!-- - Admin</b></a>-->
    <img src="logo.png" alt="..." width="80%">
  </div>
  <!-- /.login-logo -->
  <div id="card" class="card">
    <div id="login_card_body" style="border-radius: 50px; padding: 25px;" class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="username" class="form-control" name="username" required placeholder="UserName">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-alt"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault()
    start_load()
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        end_load();
      },
      success:function(resp){
          console.log(resp);
        if(resp == 1){
          location.href ='index.php?page=home';
        }else if (resp == 3){
            $('#login-form').prepend('<div class="alert alert-danger" style="text-align: right;">.این کاربر غیر فعال شده است</div>')
            end_load();
        }else{
          $('#login-form').prepend('<div class="alert alert-danger" style="text-align: right;">.نام کاربری یا کلمه عبور اشتباه است</div>')
          end_load();
        }
      }
    })
  })
  })
</script>
<?php include 'footer.php' ?>

</body>
</html>
