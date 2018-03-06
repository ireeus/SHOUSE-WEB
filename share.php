<?php


$page = 'share.php'; 
session_start();

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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> <!-- https://canvasjs.com/assets/script/canvasjs.min.js -->
 
        <script langauge="javascript">
// #Script_1 // script for refreshing the graph assigned to class id="chartContainer", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#chartContainer').load('shareservice.html')}, 30000);});		
// #Script_2 // script for refreshing the graph assigned to class id="", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#temp_in').load('temp_in.php')}, 5000);});		
// #Script_3 // script for refreshing the graph assigned to class id="", every 3 seconds (30000).
		$(document).ready(function() {setInterval(function () {$('#temp_out').load('temp_out.php')}, 5000);});	
		
		
		
        </script>








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
			
			
			<div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-share-square-o"></i> Shared graph  - 
                            
            <!-- /.container-fluid -->

<?php			
///////////////////////////////////////////////////////////
// Skrypt wyświetlający wykres udostępniony
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

if(isset($_GET['graph'])) {

	
include("config.php");
$share = $_GET['graph'];

$sql    = "SELECT * FROM `USERS`  WHERE `USERS`.`SHARE` = '$share'  ";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {	
	
	
session_start();
$username = $row["SHARE"];

$_SESSION['SHARE'] = $username;

		echo  $row["USERNAME"];
}}


echo '</h3></div>
                            <div class="panel-body">';
// Dropdown DATE




	
echo'	<script type="text/javascript">
$.getJSON("ShareService.php", function(result){
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
        title: "°C",
        minimum: 0
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
<div id="chartContainer"></div>'; 

 
  


}
 ?>
 
 
 <BR/><BR/><BR/><BR/>
 
   

<BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/><BR/>

<?php//koniec chart area ?>


                               
                            </div>
                        </div>
<?php//koniec chart area ?>	
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
