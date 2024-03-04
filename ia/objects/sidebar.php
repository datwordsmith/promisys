    <section class="sidebar">
		
		<div style="margin: 10px auto; background: #fff; width: 130px; height: 130px; border-radius: 100px">
			<center><img style="margin-top: 15px;" src="styles/img/hall7logo.png"  height=100px /></center>
		</div>
		
		<div style="clear: both;"></div>
		
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		<li></li>
		
        <li class="<?php echo $myprofile;?>">
          <a href="index">
            <i class="ion ion-person-stalker"></i> <span>My Profile</span>
          </a>
        </li>  

        <li class="<?php echo $projects;?>">
          <a href="projects">
            <i class="fa fa-map-marker"></i> <span>Projects</span>
          </a>
        </li>
        
        <li class="<?php echo $prospects;?>">
          <a href="prospects">
            <i class="fa fa-users"></i> <span>Prospects</span>
          </a>
        </li>

        <li class="<?php echo $repository;?>">
          <a href="repository">
            <i class="fa fa-folder-open-o"></i> <span>Repository</span>
          </a>
        </li>

        <li class="treeview <?php echo $birthdays;?>">
          <a href="">
            <i class="fa fa-birthday-cake"></i>
            <span>Birthdays</span>
            <span class="pull-right-container">
              <span class="label label-warning"><?php totalBirthdays(); ?></span>
            </span>
          </a>
            <ul class="treeview-menu">
              <li class="<?php echo $clientbirthdays;?>">
                <a href="clientBirthdays"><i class="fa fa-circle-o"></i>
                  <span>Client Birthdays</span>
                  <span class="pull-right-container">
                    <span class="label label-primary"><?php clientBirthdays(); ?></span>
                  </span>                  
                </a>
              </li>

              <li class="<?php echo $staffbirthdays;?>">
                <a href="staffBirthdays"><i class="fa fa-circle-o"></i>
                  <span>Staff Birthdays</span>
                  <span class="pull-right-container">
                    <span class="label label-danger"><?php staffBirthdays(); ?></span>
                  </span>                  
                </a>
              </li>


            </ul>
        </li>
		
        <li class="">
          <a href="logout">
            <i class="fa fa-sign-out"></i> <span>Logout</span>
          </a>
        </li>		
		
      </ul>
    </section>
    <!-- /.sidebar -->


