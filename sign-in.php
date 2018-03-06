<?php $page = 'sign-in.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign in</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>

<body> 

    <div id="wrapper">

<?php include('nav.php'); ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Sign in <small>Statistics Overview</small>
                        </h1>

                    </div>
					
                </div>
                <!-- /.row -->
<?php 
if (isset($_GET['item'])) {$item = $_GET['item'];
if ($item == '1') {
    echo '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Enter the username. </div>';
} 
elseif ($item == '2') {
    echo '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Enter the password.<br /></div>';
} 
elseif ($item == '3') {
    echo '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Unable to authenticate. Please check the username or password.<br /></div>';
} 
elseif ($item == '4') {
    echo '<div class="alert alert-success" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Your account is activated. Please login<br /></div>';
}
}

?>
					<form class="form-inline" action="login.php" method="post">
						<div class="form-group">Username
							<label class="sr-only" for="USERNAME">Username</label>
							<input type="name" name="username" class="form-control" id="USERNAME" placeholder="name">
						</div><br>
						<div class="form-group">Password
							<label class="sr-only" for="exampleInputPassword3">Password</label>
								<input type="password" name="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
						</div><br><br>
						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div>
						<button type="submit" class="btn btn-default">Sign in</button>
					</form>
					<a href="registration.php"> Registrarion </a>
                <!-- /.row -->
<br><Br><br><p></p><br><Br>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
