<?php
  $profile = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM staff WHERE id = '$loginid'"));
  
  $fullname = $profile->lastname.' '.$profile->firstname.' '.$profile->middlename;
  $sex = strtolower($profile->sex);
  $pic = $profile->pic;
  if ($pic != null) {
    $smallicon = '<img src="../photos/'.$pic.'" class="user-image"/>';
    $icon = '<img src="../photos/'.$pic.'" class="img-circle"/>';
  } else {
    if ($sex == "male") {
      $smallicon = '<img src="styles/img/avatar5.png" class="user-image"/>';
      $icon = '<img src="styles/img/avatar5.png" class="img-circle"/>';
      $sexcolor = "blue";
    } else {
      $smallicon = '<img src="styles/img/avatar3.png" class="user-image"/>';
      $icon = '<img src="styles/img/avatar3.png" class="img-circle"/>';
      $sexcolor = "#CF4191";
    } 
  }

  
  $role = $profile->role_id;
  $staffrole = mysqli_fetch_object(mysqli_query($conn,  "SELECT * FROM role WHERE id = '$role'"));
?>


    <div class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Hall </b>7</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Hall 7 </b>Real Estate</span>

    </div>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle visible-xs" data-toggle="push-menu" role="button">
        <span class="">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">


          <!-- Tasks: style can be found in dropdown.less -->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="styles/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
        <?php echo $smallicon;?>
              <span class="hidden-xs"><?php echo $fullname; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="styles/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
        <?php echo $icon;?>

                <p>
                  <?php echo $fullname.'<br/><b>'.$staffrole->role.'</b>'; ?>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <!--
        <div class="pull-left">
                  <a href="administrator?changepassword=<?php echo $loginid; ?>" data-toggle="modal" data-target="#changePassword" class="btn btn-default btn-flat">Change Password</a>
                </div>
        -->
                <div class="pull-right">
                  <a href="logout" class="btn btn-default btn-block btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>


