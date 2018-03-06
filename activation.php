<?php $page = 'activation.php'; 
session_start();

include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result = mysqli_query($link, $sql);
if ($_SESSION['username'] == '') {
header("Location: sign-in.php?item=4");

}
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
		
		if ($row["ACTIVATION"] == '1') {
          header("Location: index.php");
		  if ($row["ACTIVATION"] != $_GET['id']) {header("Location: logout.php?id=1");}
        } 
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Account Activation</title>

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

			 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Activation <small> 
							
							<?php include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) { echo $row["EMAIL"] ;
    }
}      
	 ?></small>
                        </h1>

                    </div>
					
                </div>

	  
<?php

// $action to TOKEN

if (isset($_GET['id']))
{
	$action = $_GET['id'];
	if ($action == $_GET['id'])
	{
		include ("config.php");

		$spr1 = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `USERS` WHERE `USERS`. ACTIVATION='$action'")); //czy TOKEN istnieje
		if ($spr1[0] < 1)
		{
			echo '<h3><font size="3">You account wasn\'t activated during registration process or your activation link is incorrect. Contact support<br /> </font></h3>
      <hr> ';

			// echo $action;
			// echo $row["ACTIVATION"];

			$username = $_SESSION['username'];
			$sql = "SELECT * FROM `USERS` WHERE `USERS`. USERNAME='$username '";
			$result = mysqli_query($link, $sql);
			if (mysqli_num_rows($result) > 0)
			{

				// output data of each row

				while ($row = mysqli_fetch_assoc($result))
				{
					echo 'If you didn\'t recive activation link on your email address <font color="green">' . $row["EMAIL"] . '</font>';
					echo ' Send it again.  
      <form action="activation.php" method="post">
      <input type="text" name="send" hidden value="send">
      <input type="text" hidden name="email" value="' . $row["EMAIL"] . '">
      <input type="submit" value="Resend">
      </form>
      ';
					$wiadomosc = 'Activation link';
					$email = $row["EMAIL"];
					$link = ' http://82.28.186.219/activation.php?id=' . $row["ACTIVATION"] . '';
					$emailfrom = 'ireeus@gmail.com';
					$msg = '' . $wiadomosc . '' . $link . '
				
				
				
				Support e-mail:' . $emailfrom . '';
					$headers = 'SMOKEHOUSE - Account activation:' . '' . "\r\n";
					if (isset($_POST['send']))
					{
						mail($email, $headers, "SMOKEHOUSE - Account activation", $msg);
						echo 'Activation link was sent again. Check your Spam folder for <font color="red">"SMOKEHOUSE - Account activation" </font>or contact support';
					}
				}
			}
		}

		if ($spr1[0] >= 1)
		{
			echo '
               <hr>
             Your account was activated. You can login. <a href="sign-in.php"> Sign in </a>';
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `ACTIVATION` = '1' WHERE `USERS`.`ACTIVATION` ='$action'");
		}
	}
}
else include ("config.php");

$spr1 = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `USERS` WHERE `USERS`. ACTIVATION='$action'")); //czy TOKEN istnieje

if ($spr1[0] < 1)
{

	// echo $action;
	// echo $row["ACTIVATION"];

	$username = $_SESSION['username'];
	$sql = "SELECT * FROM `USERS` WHERE `USERS`. USERNAME='$username '";
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) > 0)
	{

		// output data of each row

		while ($row = mysqli_fetch_assoc($result))
		{
			echo '  
      <form action="activation.php" method="post">
      <input type="text" name="send" hidden value="send">
      <input type="text" hidden name="email" value="' . $row["EMAIL"] . '">
      <input type="submit" value="Resend acticvation link">
      </form>
      ';
			$wiadomosc = 'Activation link';
			$email = $row["EMAIL"];
			$link = ' http://82.28.186.219/activation.php?id=' . $row["ACTIVATION"] . '';
			$emailfrom = 'ireeus@gmail.com';
			$msg = '' . $wiadomosc . '' . $link . '
				
				
				
				Support e-mail:' . $emailfrom . '';
			$headers = 'SMOKEHOUSE - Account activation:' . '' . "\r\n";
			if (isset($_POST['send']))
			{
				mail($email, $headers, "Account activation", $msg);
				echo '<BR/><div class="alert alert-success" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Activation link was sent again. Check your Spam folder for <font color="red">"SMOKEHOUSE - Account activation" </font> or contact support<br /></div>';
			}
		}
	}
}
elseif ($spr1[0] >= 1)
{
	echo '<div class="alert alert-sucess" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Success:</span>Your account was activated. You can login. <a href="sign-in.php"> Sign in </a><br /></div>
               <hr>
             ';
	mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `ACTIVATION` = '1' WHERE `USERS`.`ACTIVATION` ='$action'");
}

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

