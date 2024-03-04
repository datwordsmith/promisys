<?php
	clearstatcache();

	require_once ("connector/connect.php");	
	
	// re-create session
	session_start();
	
	require_once ("functions/loginfunction.php"); 	
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
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="styles/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

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
	
	window.setTimeout(function() {
		$("#inactive-alert").fadeTo(300, 0).slideUp(300, function(){
			$(this).remove(); 	
			var stateObj = {};
			window.history.pushState(stateObj, "", "forgotpassword");
		});
	}, 4000);
		
		
</script>

<body class="hold-transition get-password">
<div class="se-pre-con"></div>
<div class="login-box">

    <center>
		<img src="styles/img/topper.png" width="200px" alt="User Image">
	</center>
  <!-- /.login-logo -->
  <div class="login-box-body">

	<center><i class="fa fa-key fa-4x" style="color: purple;" aria-hidden="true"></i></center>
	<p style="color: purple;">Enter your email address to recover your password.</p><!---->
						
						<?php 									
									if (isset($_GET['success'])) {
									echo '<div class="callout callout-success" id="inactive-alert">	
									<i class="icon fa fa-unlock"></i> Your password has been reset and sent to your email.
									</div>';	
									}
									if (isset($_GET['failed'])) {
									echo '<div class="callout callout-danger" id="inactive-alert">
									<i class="icon fa fa-info"></i> Error! Please try again!
									</div>';	
									}	
									if (isset($_GET['wrongemail'])) {
									echo '<div class="callout callout-warning" id="inactive-alert">
									<i class="icon fa fa-info"></i> Oops! The email you entered does not exist on this portal.
									</div>';	
									}									
						?>
	
	
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name = "email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <button type="submit" name= "changePassword" class="btn btn-default btn-block btn-flat">Submit</button>
      </div>
    </form>
	
	<center><a href="index">Return to Login</a><br></center>
	
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
