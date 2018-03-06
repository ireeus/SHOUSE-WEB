<?php

$page = 'index.php'; 
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
} 
 mysqli_close($link);

 // skrypt zapisuje T_low i T_high do bazy danych
if (isset($_POST['T_high']) || isset($_POST['T_low']) ){
$T_high = $_POST['T_high'];
$T_low = $_POST['T_low'];
$user = $_POST['user'];

include("config.php");

mysqli_query($link, "UPDATE  `SMOKEHOUSE`.`USERS` SET  `T_high` =  '$T_high'  WHERE  `USERS`.`USERNAME` = '$user'");
mysqli_query($link, "UPDATE  `SMOKEHOUSE`.`USERS` SET  `T_low` =  '$T_low' WHERE  `USERS`.`USERNAME` = '$user'");			


				 mysql_close($link);			}
											?>

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
<script src="js/canvasjs.min.js"></script>
 

        <script langauge="javascript">
// #Script_1 // script for refreshing the graph assigned to class id="chartContainer", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#chartContainer').load('myphpservice.html')}, 30000);});		
// #Script_2 // script for refreshing the graph assigned to class id="", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#temp_in').load('temp_in.php')}, 5000);});		
// #Script_3 // script for refreshing the graph assigned to class id="", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#temp_out').load('temp_out.php')}, 5000);});	

		
		
// miejsce na skrypt odświerzający wiadomości 		
		
	// #Script_4 // script for refreshing the graph assigned to class id="messages", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#messages').load('messages.php')}, 5000);});			
		
		


    function blinkLastDateSpan() {
        if ($("#lastDateBlinker").css("visibility").toUpperCase() == "HIDDEN") {
            $("#lastDateBlinker").css("visibility", "visible");
            setTimeout(blinkLastDateSpan, 400);
        } else {
            $("#lastDateBlinker").css("visibility", "hidden");
            setTimeout(blinkLastDateSpan, 400);
        }
    }
    blinkLastDateSpan();

		
		
		
        </script>
</head>
<body> 
    <div id="wrapper">
		<?php include('nav.php'); ?>
        <div id="page-wrapper">

            <div class="container-fluid">
				<!-- Page Heading -->
                <div class="row">
				
					<!-- <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					The temperature is too high. Check the fire place
					</div> -->
					<div class="col-lg-4">		
					
					
						<div  id="temp_in" class="bs-example">
							<ul class="nav nav-pills">
							<li class="active"><a href="#">
							
							<?php 
								/* We first connect to our database */
								include("config.php");
								/* Declare an array containing our data points */
								/* Usual SQL Queries */
								$DATE = $_SESSION['DATE'];
								$username   = $_SESSION['username'];
								$query = "SELECT  `Temp_in` 
											FROM  `ID_NUMBER` 
											WHERE  `ID_NUMBER`.`USERNAME` =  '$username' 
											ORDER BY  `ID_NUMBER`.`ID` DESC 
											LIMIT 1";
								$result1 = mysqli_query($link, $query);
								if (mysqli_num_rows($result1) > 0) { while($row = mysqli_fetch_array($result1))       
															{ $temp = $row['Temp_in'];
														
				
				
				if($temp <=10.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#e5feff'>Temperature (1) </font><span class='badge'>";}
				if($temp >10.01 && $temp <20.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#e5fff3'>Temperature (2) </font><span class='badge'>";}
				if($temp >20.01 && $temp <30.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#f4fcc2'>Temperature (3) </font><span class='badge'>";}
				if($temp >30.01 && $temp <40.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#fceec2'>Smoking temperature (4) </font><span class='badge'>";}
				if($temp >40.01 && $temp <50.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#fccec2'>Smoking temperature (5) </font><span class='badge'>";}
				if($temp >50.01 && $temp <70.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#fcb8b8'>Smoking temperature (6) </font><span class='badge'>";}
				if($temp >70.01 && $temp <120.01){echo "<img src='lib/img/ic_whatshot_white_24dp_2x.png' height='15' width='15'> <font color='#ff7f7f'>Warning! Smoking temperature HIGH (7) </font><span class='badge'>";}
				if($temp >120.01){echo "<img src='lib/img/ic_whatshot_black_24dp_2x.png' height='15' width='15'> <font color='BLACK'><b>!!!Warning Temperature too HIGH !!!(8)</b> </font><span class='badge'>";}
																										

           echo $row['Temp_in'];
														
															}
															mysqli_close($link);	
															}
							?>
							°C</span></a></li>
							</ul>
						</div>
					</div>
					
										<div class="col-lg-4">
						<div  id="temp_out" class="bs-example">
							<ul class="nav nav-pills">
							<li class="active"><a href="#"><?php 
				session_start();
				
				/* We first connect to our database */
				include("config.php");

			/* Declare an array containing our data points */
				 
					/* Usual SQL Queries */
					$DATE = $_SESSION['DATE'];
					$username   = $_SESSION['username'];
					$query = "SELECT  `Temp_out` 
								FROM  `ID_NUMBER` 
								WHERE `ID_NUMBER`.`USERNAME` =  '$username' ORDER BY  `ID_NUMBER`.`ID` DESC 
								LIMIT 1";
					$result1 = mysqli_query($link, $query);
					if (mysqli_num_rows($result1) > 0) {	
															while($row = mysqli_fetch_array($result1))
															{  		

				$temp = $row['Temp_out'];
				if($temp ==0){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#e0f8ff'>Too cold outside</font><span class='badge'>";}
				if($temp >0.01 && $temp <5.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#e0fff4'>Cold weather</font><span class='badge'>";}
				if($temp >5.01 && $temp <10.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#e1ffe0'>A bit cold but ok</font><span class='badge'>";}
				if($temp >10.01 && $temp <15.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#f5ffe0'>Average weather</font><span class='badge'>";}
				if($temp >15.01 && $temp <20.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#fff3e0'>OK weather for smoking</font><span class='badge'>";}
				if($temp >20.01 && $temp <25.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#ffe0e0'>Good weather for smoking</font><span class='badge'>";}
				if($temp >25.01){echo "<img src='lib/img/ic_brightness_4_white_24dp_2x.png' height='15' width='15'> <font color='#f7bbbb'>Perfect weather for smoking</font><span class='badge'>";}
					
														
														echo $row['Temp_out'];	
													
														if($row['Temp_out'] =='0'){echo' or below.';}

															
        
															}
														mysqli_close($link);					
														}
																
							?> °C</span></a></li>
							</ul>
							
						</div>
					</div>
					
					
					
				
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
		<script type="text/javascript">
		$.getJSON("myphpService.php", function(result){
		var dps= [];

		//Insert Array Assignment function here
		for(var i=0; i<result.length;i++) {
			dps.push({"label":result[i].ts, "y":result[i].d1});
		}
		//Insert Chart-making function here
		var chart = new CanvasJS.Chart("chartContainer", {
			zoomEnabled:true,
			panEnabled:true,
			animationEnabled:true,
		title:{
				text: ""
			},

    axisX:{
        title: "Time"
    },

        axisY:{
        title: "Temp °C",
        minimum: -10
    },

    data: [{
        type: "line",
        dataPoints:
            dps
              }]
});
chart.render();

});
</script>
<div id="chartContainer"></div>

<div class="panel panel-green">
                            

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
