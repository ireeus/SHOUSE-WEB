<?php
session_start();
if(isset($_POST['DATE'])){
	$date = $_POST['DATE'];
	$_SESSION['DATE'] = $date;
	echo $date;}


$page = 'tooltips.php'; 
session_start();

include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
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

        if ($row["NAME"] == '' || $row["SURNAME"] == '' || $row["COMPANY"] == '' || $row["STREET"] == '' || $row["CITY"] == '' || $row["POSTCODE"] == '' || $row["COUNTRY"] == '' || $row["MOBILE"] == '') {
          header("Location: profile.php");
       }
    }
} ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Smokehouse - Temperature monitoring</title>

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
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> <!-- https://canvasjs.com/assets/script/canvasjs.min.js -->
 







</head>

<body> 

    <div id="wrapper">

<?php include('nav.php'); ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
				
				          <div class="col-lg-4">
            
   
          </div>
				

                </div>
                <!-- /.row -->

              
				
				            
               

            </div>
            <!-- /.container-fluid -->

			

<div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-lightbulb-o "> </i> Using aplication</h3>
                            </div>
                            <div class="panel-body">
							
							
         
  <table class="table table-bordered">
    <tbody>				Use this link to share the graph with friends.<br/>
								<?php 
								// md5() - Calculate the md5 hash of a string
                                // sha1() - Calculate the sha1 hash of a string
								$username   = $_SESSION['username'];
								$encrypted_user = md5($username);
								echo "<a href='http://82.28.186.219/share.php?graph=".$encrypted_user."' target='blank'>http://82.28.186.219/share.php?graph=".$encrypted_user."</a>
								
							
								<br/>
								
								";
								
								
								
								
								
								?>
      <tr>
		<td>History page gives you ability to manage previously recorded smoking data graphs.<br/> The data can be:<br/>- displayed<br/>- exported to .xls file <br/> - or deleted.</td>
        <td>Built-in alarm will monitor a temperature of smoking chamber and warn you whenever is too cold or too hot.<img width='120' src="lib/img/alarms.jpg" ></td>
        <td>When the alarm goes off you'll be able to see what type of alarm it is.<img width='120'  src="lib/img/message.jpg" ></td>
				<td></td>
      </tr>

    </tbody>
  </table>

                            </div>
                        </div>
	<div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-lightbulb-o "> </i> Smoking meat</h3>
                            </div>
                            <div class="panel-body">
                               <img width='350' src="lib/img/started.jpg" >
							<img width='350' src="lib/img/finished.jpg" >
								

                            </div>
                        </div>					
						
						
						
						
    </div>
	
	
	
	
    <!-- /#wrapper -->

    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.php"></script>

    <!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/flot-data.js"></script>
</body>

</html>
