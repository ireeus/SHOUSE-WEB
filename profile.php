
	<?php $page = 'profile.php'; 
	session_start();

include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * FROM `USERS` WHERE `USERS`.`username` ='$username'";
$result = mysqli_query($link, $sql);
if ($_SESSION['username'] == '') {
header("Location: sign-in.php");

}
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
	
        if ($row["ACTIVATION"] != '1') {
          header("Location: activation.php");
        }


        if ($row["BALANCE"] < '1') {
           header("Location: payment.php");
	
        }	

      
    }
}
	 mysqli_close($link);
	
	?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Smokehouse - Profile</title>

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
                            Profile <small> Overview</small>
                        </h1>

                    </div>
					
                </div>
				 <table class="table table-bordered">
    <tbody>
      <tr>
        <td>
				Personal details
				
			<?php ///////////////////////////////////////////////////////////////////////////////////////////////////PROFILE UPDATE //////////////////////////////////////////////////////////////////////////////////
	include("config.php");
	$username = $_SESSION['username'];
	$ip = $_SERVER['REMOTE_ADDR'];
	//////////////////////////////////
	if (isset($_POST['name'])) { $name = strip_tags($_POST['name']);}
	if (isset($_POST['surname'])) { $surname = strip_tags($_POST['surname']);}
	if (isset($_POST['company'])) { $company = strip_tags($_POST['company']);}
	if (isset($_POST['street'])) { $street = strip_tags($_POST['street']);}
	if (isset($_POST['city'])) { $city = strip_tags($_POST['city']);}
	if (isset($_POST['postcode'])) { $postcode = strip_tags($_POST['postcode']);}
	if (isset($_POST['country'])) { $country = strip_tags($_POST['country']);}
	if (isset($_POST['mobile'])) { $mobile = strip_tags($_POST['mobile']);}
	if (isset($_POST['landline'])) { $landline = strip_tags($_POST['landline']);}
	
	if( isset($name) !='' || isset($surname)!='' || isset($company)!=''|| isset($street)!=''|| isset($city)!=''|| isset($postcode)!=''|| isset($county)!=''|| isset($county)!=''|| isset($country)!='' || isset($mobile)!='' ){
		///////////////////////////////
		$action = $_GET['id'];
		
		if ($action == 'update') {
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `NAME` = '$name' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `SURNAME` = '$surname' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `COMPANY` = '$company' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `STREET` = '$street' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `CITY` = '$city' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `POSTCODE` = '$postcode' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `COUNTRY` = '$country' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `MOBILE` = '$mobile' WHERE `USERS`.`USERNAME` ='$username'");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `LANDLINE` = '$landline' WHERE `USERS`.`USERNAME` ='$username'");
			$username = strtoupper($username);
		echo '<div class="alert alert-success" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">'.$username.' - </span>Your profile was updated.<br /></div>'; 
include("config.php");
$sql = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {	
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
{ 
	
}}	echo'<a href="index.php">Go to statistics</a>';
			ECHO'</font></span><br>';
		}

	} else echo '';
	$username = $_SESSION['username'];
	$sql = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
	$result = mysqli_query($link, $sql);
	
	if ($_SESSION['username'] =='') {
		header("Location: index.php");
	}

	
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)){ 
			if ($row["NAME"]=='' or $row["SURNAME"]=='' or $row["COMPANY"]=='' or $row["STREET"]=='' or $row["CITY"]=='' or $row["POSTCODE"]=='' or $row["COUNTRY"]=='' or $row["MOBILE"]=='' or $row["LANDLINE"]=='' ){
				echo '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>Please enter your contact details to continue.<br /></div>';}

			$bgcolor="";
			echo '<center><form method="post" action="profile.php?id=update">
<div class="col-md-5">
				<table class="table-hover" border="0"    >

					<tr bgcolor="'.$bgcolor.'" class="tlo-b ">
						<td><b>Name:</b></td>
						<td><input required class="form-control" maxlength="18" type="text" name="name" value="';
			echo $row["NAME"];
			echo '"><br></td>
								</tr>					
					<tr bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>Surname:</b></td>
						<td><input required class="form-control" maxlength="32" type="text" value="';
			echo $row["SURNAME"];
			echo '" name="surname"><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlo-b">
						<td><b>Company:</b></td>
						<td><input  required  class="form-control" maxlength="32" type="text" value="';
			echo $row["COMPANY"];
			echo '" name="company"><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlo-b">
						<td><b>Street:</b></td>
						<td><input  class="form-control" type="text" name="street" maxlength="50" value="';
			echo $row["STREET"];
			echo '"></td><br></tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>City:</b></td>
						<td><br><input  class="form-control" type="text" maxlength="50" name="city" value="';
			echo $row["CITY"];
			echo '"></span><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>Postcode:</b></td>
						<td><input  class="form-control" type="text" maxlength="50" name="postcode" value="';
			echo $row["POSTCODE"];
			echo '"></span><br></td>
								</tr>
					
					<tr bgcolor="'.$bgcolor.'"  class="tlek">
						<td><b>Country:</b></td>
						<td><input  required class="form-control"  type="text" maxlength="50" name="country" value="';
			echo $row["COUNTRY"];
			echo '"></span><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>Mobile:</b></td>
						<td><input  required  class="form-control" type="text" maxlength="50" name="mobile" value="';
			echo $row["MOBILE"];
			echo '"></span><br></td></tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>Landline:</b></td>
						<td><input  class="form-control" type="text" maxlength="50" name="landline" value="';
			echo $row["LANDLINE"];
			echo '"></span><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" class="tlek">
						<td><b>E-mail:</b></td>
						<td><input  required class="form-control"  type="text" maxlength="50" name="county" value="';
			echo $row["EMAIL"];
			echo '" disabled></span><br></td>
								</tr>
					<tr  bgcolor="'.$bgcolor.'" >
						<td colspan="2" align="center"><input type="submit" name="submit" value="Update"></td>
						</tr>
				</table>
			</form></div>';
		}
	} mysqli_close($link);
	?>
	
	</td>
        <td>Password update
		
			<?php ///////////////////////////////////////////////////////////////////////////////////////////////////PASSWORD UPDATE //////////////////////////////////////////////////////////////////////////////////

$username = $_SESSION['username'];
$ip       = $_SERVER['REMOTE_ADDR'];


//////////////////////////////////
if (isset($_POST['pass']) && isset($_POST['rpass'])&& isset($_POST['old_pass'])) {
    $pass = $_POST['pass'];
	$rpass = $_POST['rpass'];
    $old_pass = $_POST['old_pass'];
	

	
}

if (isset($pass) != '' && isset($rpass) != '' && isset($old_pass) != '') {
    ///////////////////////////////
    $action = $_GET['id'];

        
    if ($action == 'update_password') {
        //$username = strtoupper($username);
		
		
		
		
        include("config.php");
        $sql    = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
        $result = mysqli_query($link, $sql);
	
if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo '<div class="alert alert-success" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">' . $username . ' - </span>Your password has been updated<br /></div>';
                
            }
        }
        ECHO '</font></span><br>';
    }
    
} else
    echo '';

$username = $_SESSION['username'];
$sql      = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result   = mysqli_query($link, $sql);

if ($_SESSION['username'] == '') {
    header("Location: index.php");
}


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {

		$old_pass =  md5($old_pass);
		$pass =  md5($pass);
	$mysql_pass = $row['PASSWORD'];
	
	    // if password typed in the form is equal to the one stored in database matches update password	
		
		if ($old_pass!==$mysql_pass) { echo '<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">' . $username . ' - </span>Enter current password<br /></span></div>';}
	elseif ($old_pass==$mysql_pass) { mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `PASSWORD` = '$pass' WHERE `USERS`.`USERNAME` ='$username'");    
	       
	
	session_destroy();
	
	}
		
       
       
        
    }
}$bgcolor = "";
        echo '<center><form method="post" action="profile.php?id=update_password">
<div class="col-md-5">
                <table class="table-hover" border="0"    >

                    <tr bgcolor="' . $bgcolor . '" class="tlo-b ">
                        <td><b>Old Password:</b></td>
                        <td><input required class="form-control" maxlength="18" type="text" name="old_pass" value=""><br></td>
                                </tr>                    
                    <tr bgcolor="' . $bgcolor . '" class="tlek">
                        <td><b>New Password:</b></td>
                        <td><input required class="form-control" maxlength="32" type="text" value="" name="pass"><br></td>
                                </tr>
                    <tr  bgcolor="' . $bgcolor . '" class="tlo-b">
                        <td><b>Repeat Password:</b></td>
                        <td><input  required  class="form-control" maxlength="32" type="text" value="" name="rpass"><br></td>
                                </tr>
                    <tr  bgcolor="' . $bgcolor . '" >
                        <td colspan="2" align="center"><input type="submit" name="submit" value="Update"></td>
                        </tr>
                </table>
            </form></div>';
mysqli_close($link);
?>
		
		
		
		
		
		
		
		
		</td>

      </tr>

      </tr>
    </tbody>
  </table>
	
	
	



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
