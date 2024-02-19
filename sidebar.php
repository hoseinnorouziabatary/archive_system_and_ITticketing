  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #808183">
    <div class="dropdown">
   	<a href="./" class="brand-link" style="background-color: #51575c">
        <?php if($_SESSION['login_type'] == 0): ?>
        <h3 style="font-size: 15px;" class="text-center p-0 m-0 "><b>ADMIN</b></h3>
        <?php elseif($_SESSION['login_type'] == 1): ?>
            <h3 style="font-size: 15px;"class="text-center p-0 m-0"><b>مدیر ارشد</b></h3>
        <?php elseif($_SESSION['login_type'] == 2): ?>
            <h3 style="font-size: 15px;" class="text-center p-0 m-0"><b>مدیر</b></h3>
        <?php else: ?>
        <h3 style="font-size: 15px;" class="text-center p-0 m-0"><b>کارشناس</b></h3>
        <?php endif; ?>

    </a>

    <?php
    $groupUser = $conn->query("SELECT users.group_id as gid FROM users where users.id =  '" . $_SESSION['login_id'] . "'");
    $group_User = $groupUser->fetch_assoc()['gid'];
    ?>
    </div>
            <div class="sidebar pb-4 mb-4">
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        داشبورد
                      </p>
                    </a>
                  </li>

                          <?php
                          if ($group_User == 3){
                          ?>
                              <li class="nav-item">
                                  <a href="#" class="nav-link nav-edit_project nav-view_project">
                                      <i class="nav-icon fa fa-archive"></i>
                                      <p>
                        بایگانی
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="./index.php?page=new_document" class="nav-link nav-new_document tree-item">
                          <i class="fas fa-angle-right nav-icon"></i>
                          <p>سند جدید</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="./index.php?page=document_list" class="nav-link nav-document_list tree-item">
                          <i class="fas fa-angle-right nav-icon"></i>
                          <p>لیست اسناد</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                <?php }?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_project nav-view_project">
                            <i class="fas fa-ticket-alt nav-icon"  style="color:  #ff9000;"></i>
                            <p>
                                تیکت IT
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="./index.php?page=new_ticket" class="nav-link nav-new_ticket tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>تیکت جدید</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="./index.php?page=ticket_list" class="nav-link nav-ticket_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>لیست تیکت ها</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                  <?php if($_SESSION['login_type'] == 0): ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_user">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                        کاربران
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                          <i class="fas fa-angle-right nav-icon"></i>
                          <p>کاربر جدید</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                          <i class="fas fa-angle-right nav-icon"></i>
                          <p>لیست کاربران</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                <?php endif; ?>
                </ul>
              </nav>
            </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;

      //h:mouse hover nav-bar
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
  		//

  	})
  </script>