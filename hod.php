<?php
	clearstatcache();

	require_once ("connector/connect.php");

	// re-create session
	session_start();

	require_once ("functions/hod_loginfunction.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HALL 7 | PROMISYS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="styles/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="styles/img/favicon.png" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<!--	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<script>
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});

	//SUPER ADMIN
	window.setTimeout(function() {
		$("#superadmin").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "administrator"
		});
	}, 4000);

	//OFFICE ADMIN
	window.setTimeout(function() {
		$("#officer").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "officer/"
		});
	}, 4000);

	//ADMIN
	window.setTimeout(function() {
		$("#admin").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "admin/"
		});
	}, 4000);

	//HR
	window.setTimeout(function() {
		$("#hr").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "hr/"
		});
	}, 4000);

	//ADVISORY
	window.setTimeout(function() {
		$("#advisory").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "advisory/"
		});
	}, 4000);

	//COMMS
	window.setTimeout(function() {
		$("#comms").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "comms/"
		});
	}, 4000);

	//ACCOUNTS
	window.setTimeout(function() {
		$("#accounts").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "accounts/"
		});
	}, 4000);

	//INNOVATION STUDIO
	window.setTimeout(function() {
		$("#studio").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "studio/"
		});
	}, 4000);

	//PROJECTS
	window.setTimeout(function() {
		$("#projects").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "projects/"
		});
	}, 4000);

	//PROCUREMENT
	window.setTimeout(function() {
		$("#procurement").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "procurement/"
		});
	}, 4000);

	//LEGAL
	window.setTimeout(function() {
		$("#legal").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "legal/"
		});
	}, 4000);

	//CONTROL
	window.setTimeout(function() {
		$("#control").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "control/"
		});
	}, 4000);

	//STAFF
	window.setTimeout(function() {
		$("#staff").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			window.location = "ia/index"
		});
	}, 4000);

	window.setTimeout(function() {
		$("#inactive-alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			var stateObj = {};
			window.history.pushState(stateObj, "", "hod");
		});
	}, 4000);


</script>

<body class="hold-transition login-page">
<div class="se-pre-con"></div>
<div class="login-box">

    <center>
		<img src="styles/img/topper.png" width="300px" alt="User Image">
	</center>
  <!-- /.login-logo -->
  <div class="login-box-body">

	<!--<p class="login-box-msg">Sign in to start your session</p>-->

						<?php
									if (isset($_GET['hod'])) {
									echo '<div class="alert alert-block alert-success" id="superadmin">
									<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
									</div>';
									}
									if (isset($_GET['officer'])) {
									echo '<div class="alert alert-block alert-success" id="officer">
									<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
									</div>';
									}
									if (isset($_GET['admin'])) {
										echo '<div class="alert alert-block alert-success" id="admin">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}	
									if (isset($_GET['accounts'])) {
										echo '<div class="alert alert-block alert-success" id="accounts">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}																		
									if (isset($_GET['hr'])) {
									echo '<div class="alert alert-block alert-success" id="hr">
									<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
									</div>';
									}									
									if (isset($_GET['comms'])) {
									echo '<div class="alert alert-block alert-success" id="comms">
									<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
									</div>';
									}
									if (isset($_GET['studio'])) {
										echo '<div class="alert alert-block alert-success" id="studio">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}		
									if (isset($_GET['projects'])) {
										echo '<div class="alert alert-block alert-success" id="projects">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}	
									if (isset($_GET['procurement'])) {
										echo '<div class="alert alert-block alert-success" id="procurement">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}		
									if (isset($_GET['legal'])) {
										echo '<div class="alert alert-block alert-success" id="legal">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}																																		
									if (isset($_GET['advisory'])) {
										echo '<div class="alert alert-block alert-success" id="advisory">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}			
									if (isset($_GET['control'])) {
										echo '<div class="alert alert-block alert-success" id="control">
										<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
										</div>';
									}																
									if (isset($_GET['staff'])) {
									echo '<div class="alert alert-block alert-success" id="staff">
									<i class="icon fa fa-unlock"></i> Login Successful.  <i class="fa fa-spinner fa-pulse"></i> Redirecting...
									</div>';
									}
									if (isset($_GET['account_inactive'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<i class="icon fa fa-lock"></i> Oops! Your account is currently inactive. Kindly contact the Administrator.
									</div>';
									}
									if (isset($_GET['login_error'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<i class="icon fa fa-info"></i> Error! Incorrect Email/Password!
									</div>';
									}
									if (isset($_GET['session_expired'])) {
									echo '<div class="callout callout-danger" id="">
									Oops! Your session has expired. Please login again to continue
									</div>';
									}
						?>

    <h4 class="text-center font-weight-bold mb-3"><b>H. O. D. Login</b></h4>


    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name = "email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name = "password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name= "login" class="btn btn-default form-control">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->
    <div class="inline-group">
        <p class="mt-2"><a href="forgotpassword">I forgot my password</a> <a class="pull-right" href="index">Staff Login</a></p>
    </div>
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3.1.1 -->
<script src="plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });


</script>
</body>
</html>
