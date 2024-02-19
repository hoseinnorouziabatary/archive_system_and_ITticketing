<!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-success navbar-dark " style="background-color: #003495">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link text-white"  href="./" role="button" style="margin-left: -20px"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>



    </ul>

    <ul class="navbar-nav ml-auto">
     

     <li class="nav-item dropdown" style="width: 215px;    margin-right: -16px;">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill" style="margin: -12px;">
<!--                  <span class="fa fa-user"></span>-->
                  <span class="fa fa-angle-down"></span>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ." ". ucwords($_SESSION['login_lastname']) ?></b></span>
                     <img src="<?php if(($_SESSION['login_avatar'])) {echo 'assets/uploads/'.$_SESSION['login_avatar']; } else echo "./assets/uploads/1606978560_avatar.jpg" ?>" alt="..." width="25%" style="border: double #6db6ed;border-radius: 13px;">

<!--                     <img src="./assets/uploads/1606978560_avatar.jpg" alt="..." width="25%" style="border: double #6db6ed;border-radius: 13px;">-->
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
<!--                manage profile-->
<!--              <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>-->

                <a class="dropdown-item" href="ajax.php?action=logout" style="font-weight: bold;text-align: right;">  خروج&nbsp;&nbsp;<i class="fa fa-power-off"></i></a>
            </div>
      </li>
        <li class="nav-item" style="  width: 9px; margin-right: 28px;">
            <a style="padding-right: unset;" class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script>
     $('#manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
      })

  </script>
