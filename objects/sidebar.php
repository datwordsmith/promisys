    <section class="sidebar">

		<div style="margin: 10px auto; background: #fff; width: 130px; height: 130px; border-radius: 100px">
			<center><img style="margin-top: 15px;" src="styles/img/hall7logo.png"  height=100px /></center>
		</div>

		<div style="clear: both;"></div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		<li></li>

        <li class="<?php echo $administrator;?>">
          <a href="administrator">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="<?php echo $myprofile;?>">
          <a href="myprofile">
            <i class="ion ion-person-stalker"></i> <span>My Profile</span>
          </a>
        </li>

        <li class="<?php echo $departments;?>">
          <a href="departments">
            <i class="fa fa-briefcase"></i> <span>Departments</span>
          </a>
        </li>

        <li class="<?php echo $investmentcategories;?>">
          <a href="investmentcategories">
            <i class="fa fa-list"></i> <span>Investment Categories</span>
          </a>
        </li>

        <li class="<?php echo $projects;?>">
          <a href="projects">
            <i class="fa fa-map-marker"></i> <span>Projects</span>
          </a>
        </li>

        <!--
        <li class="<?php echo $propertytypes;?>">
          <a href="propertytypes">
            <i class="fa fa-home"></i> <span>Property Types</span>
          </a>
        </li>
        -->

        <li class="<?php echo $clients;?>">
          <a href="clients">
            <i class="ion ion-ios-people"></i> <span>Clients</span>
          </a>
        </li>

        <li class="<?php echo $staff;?>">
          <a href="staff.php">
            <i class="ion ion-person-stalker"></i> <span>Staff</span>
          </a>
        </li>


		    <li class="<?php echo $sales;?>">
          <a href="sales">
            <i class="fa fa-money"></i> <span>Sales</span>
          </a>
        </li>

		    <li class="<?php echo $payment;?>">
          <a href="payment">
            <i class="fa fa-money"></i> <span>Payment History</span>
          </a>
        </li>

        <li class="<?php echo $expectedincome;?>">
          <a href="expectedIncome">
            <i class="fa fa-dot-circle-o"></i> <span>Expected Inflow</span>
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

        <li class="<?php echo $refund;?>">
          <a href="refund">
            <i class="fa fa-undo"></i> <span>Refund</span>
          </a>
        </li>

        <li class="<?php echo $transfer;?>">
          <a href="transfer">
            <i class="ace-icon fa fa-arrow-down"></i> <span>Transfer History</span>
          </a>
        </li>

        <li class="">
          <a href="logout">
            <i class="fa fa-sign-out"></i> <span>Logout</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
