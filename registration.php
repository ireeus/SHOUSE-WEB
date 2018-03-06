<?php $page = 'registration.php'; 

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registration</title>

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

			
			
<?php


$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_GET['action'])) {$action = 'execute';
if ($action == 'execute')
	{ //echo 'execute ok';

	//
	include ("config.php");
	//$account_type = $_POST['account_type'];
	$username = substr(addslashes(htmlspecialchars($_POST['username'])) , 0, 32);
	$password = substr(addslashes($_POST['password']) , 0, 32);
	$vpassword = substr($_POST['vpassword'], 0, 32);
	$email = substr($_POST['email'], 0, 32);
	$vemail = substr($_POST['vemail'], 0, 32);
	$username = trim($username);
	
	/*
	echo $username.'--<br>';
	echo $password.'--<br>';
	echo $vpassword.'--<br>';
	echo $email.'--<br>';
	echo $vemail.'--<br>';
	*/
	// several checks of username and email 
	$query1 = "SELECT COUNT(*) FROM `USERS` USERS WHERE USERNAME='$username' LIMIT 1";
	$query2 = "SELECT COUNT(*) FROM `USERS` USERS WHERE EMAIL='$email' LIMIT 1";
	$spr1 = mysqli_fetch_array(mysqli_query($link,$query1)); //checkinhg if username exists 
	$spr2 = mysqli_fetch_array(mysqli_query($link,$query2)); // checking if email exists
	$pos = strpos($email, "@");
	$pos2 = strpos($email, ".");
	$emailx = explode("@", $email);
	
	

	$warning = '';
	$spr4 = strlen($username);
	$spr5 = strlen($password);

	// CHECKING WHAT WAS DONE INCORRECTLY 
	if (!$username || !$email || !$password || !$vpassword || !$vemail)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>You need to fill out all fields<br /></div>';
		}

	if ($spr4 < 4)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>The username needs to be at least 4 characters long.<br /></div>';
		}

	if ($spr5 < 4)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>The password needs to be at least 4 characters long.<br /></div>';
		}

	if ($spr1[0] >= 1)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>This username already exist.<br /></div>';
		}

	if ($spr2[0] >= 1)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>This e-mail is taken!<br /></div>';
		}

	if ($email != $vemail)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>E-mails don\'t match<br /></div>';
		}

	if ($password != $vpassword)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Passwords don\'t match<br /></div>';
		}

	if ($pos == false OR $pos2 == false)
		{
		$warning.= '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Incorrect e-mail<br /></div>';
		}



	// If there is something wrong, locks the registration and shows errors

	if ($warning)
		{
		echo $warning;
		}
	  else
		{

		// if everything is ok adds the user to the database and shows information 
 

		$username = str_replace(' ', '', $username);
		$password = md5($password); //Password encryption
		$share = md5($username); //username encryption for sharing purpose
		$token_char = $email . 'activation' . $username;
		$token = md5($token_char);
		$T_low = '0';
		$T_high = '99';
		// inserts user data to USERS and ADDRESS tables
		$query3 = "INSERT INTO `SMOKEHOUSE`.`USERS` (`USERNAME`, `PASSWORD`, `EMAIL`, `ACTIVATION`, `BALANCE`, `IP`, `SHARE`,`T_low`,`T_high`) VALUES ('$username','$password','$email','$token','1','$ip','$share','$T_low','$T_high')";
		mysqli_query($link,$query3) or die("Error: 0001");// Error: 0001 unable to register in USERS table
		//mysql_query("INSERT INTO `SMOKEHOUSE`.`ADDRESS` (`USERNAME`) VALUES ('$username')") or die("Error: 0002"); // Error: 0002 unable to register in ADDRESS table

		/*
		//Checking the values added to the database
		echo $username.'<br>';
		echo $email.'<br>';
		echo $password.'<br>';
		echo $token.'<br>';
		echo $ip.'<br>';
		*/
	
	
		// Sending activation link

		$message = 'Activation link';
		$email = $_POST['email'];
		$link = ' http://82.28.186.219/activation.php?id=' . $token . '';
		$msg = '' . $message . '' . $link . '';
		$emailfrom = 'ireeus@gmail.com';
		$headers = 'Account activation :' . ' ' . $emailfrom . '' . "\r\n";
		mail($email, $headers, "Account activation.", $msg);
		echo ' <div class="alert alert-success">
  <strong>Success!</strong> Your account <span style="color: red; font-weight: bold;">' . $username . ' </span> was registred. To continue, you need to activate your account. Please check your email (spam folder) for activation link.</span>
</div>
 <br /><br /><br /><br /><br /><br /><br />';
 $status = '1';
 
 
 
		}
	}}
if (isset($status) === '1') {echo'ok <br><br> ';}
elseif (isset($status) !='1' ) {
	if (isset($_POST['username']) and isset($_POST['email']) and isset($_POST['vemail'])) {$username = $_POST['username']; $email = $_POST['email']; $vemail = $_POST['vemail'];
	echo '
<form method="post" action="registration.php?action=execute">
<table>
<label><tr class="tlo-b"><td>	  <label for="username"><BR>Username: </label></td>
<td><input class="form-control" maxlength="18" type="text" name="username" value="'.$username.'"></td></tr></label>
<tr class="tlek"><td><label for="pass"><BR>Password: </label></td>
<td><input  class="form-control" maxlength="32" type="password" name="password"></td></tr>
<tr class="tlo-b"><td><label for="pass1"><BR>Repeat passsword:</label></td>
<td><input class="form-control" maxlength="32" type="password" name="vpassword"></td></tr>
<tr class="tlo-b"><td><label for="email"><BR>E-mail:</label></td>
<td><input class="form-control" type="text" name="email" maxlength="50" value="'.$email.'"></td></tr>
<tr class="tlek"><td><label for="email1"><BR>Repeat e-mail:</label>:</td>
<td><input class="form-control" type="text" maxlength="50" name="vemail" value="'.$vemail.'"></span></td></tr>
	

<tr><td colspan="2" align="center"><input type="submit"  class="btn btn-info" value="Register"><br><br><a href="sign-in.php"> Sign in </a><br><br><br><br><br><br><br></td></tr>
</table></form>

'
;
	
	
	}

else	
	echo '
<form method="post" action="registration.php?action=execute">
<table>
<label><tr class="tlo-b"><td>	  <label for="username"><BR>Username: </label></td>
<td><input class="form-control" maxlength="18" type="text" name="username" value=" "></td></tr></label>
<tr class="tlek"><td><label for="pass"><BR>Password: </label></td>
<td><input  class="form-control" maxlength="32" type="password" name="password"></td></tr>
<tr class="tlo-b"><td><label for="pass1"><BR>Repeat passsword:</label></td>
<td><input class="form-control" maxlength="32" type="password" name="vpassword"></td></tr>
<tr class="tlo-b"><td><label for="email"><BR>E-mail:</label></td>
<td><input class="form-control" type="text" name="email" maxlength="50" value=""></td></tr>
<tr class="tlek"><td><label for="email1"><BR>Repeat e-mail:</label>:</td>
<td><input class="form-control" type="text" maxlength="50" name="vemail" value=""></span></td></tr>
	

<tr><td colspan="2" align="center"><input type="submit"  class="btn btn-info" value="Register"><br><br><a href="sign-in.php"> Sign in </a><br><br><br><br><br><br><br></td></tr>
</table></form>

'
;}
	//echo $token;

?>




                <!-- /.row -->

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
