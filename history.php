<?php
session_start();
if(isset($_POST['DATE'])){
	$date = $_POST['DATE'];
	$_SESSION['DATE'] = $date;
	echo $date;}


$page = 'history.php'; 
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
			
			
			<div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Historical charts management</h3>
                            </div>
                            <div class="panel-body">
            <!-- /.container-fluid -->

				<form action="history.php" method="post">
			
				<img src="lib/img/ic_timeline_black_24dp_2x.png" height="30" width="30">  <font color="Green"size="3" > <b>Previous graphs</b></font><br/>
<?php			
///////////////////////////////////////////////////////////
// Skrypt wyświetlający dropdown menu dostępnych dat
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
include("config.php");
$username   = $_SESSION['username'];
$sql    = "
SELECT DISTINCT
 DATE 
 FROM 
 `ID_NUMBER` 
 WHERE 
 `ID_NUMBER`.`USERNAME` = '$username' 
 ORDER BY `ID_NUMBER`.`ID` DESC ";



$result = mysqli_query($link, $sql);


// Dropdown DATE

if (mysqli_num_rows($result) > 0) { echo '
   <div class="col-xs-3">  	
 <select name="DATE" class="form-control  input-sm" id="sel1" onchange="this.form.submit()">
	        <option>Select the date to see the graph.</option>';// output data of each row
    while ($row = mysqli_fetch_assoc($result)) {echo $row['DATE'];
        if ($_POST['DATE'] == $row['DATE']){
        echo '<option  selected="selected" value"' . $row['DATE'] . '" name="DATE">' . $row['DATE'] . '</option>';
		}elseif ($_POST['DATE'] !== $row['DATE']){echo '<option  value"' . $row['DATE'] . '" name="DATE">' . $row['DATE'] . '</option>';}
    }

	
	  echo ' </select> 		</div>
			
				
	 </form>
	
		';
	
}else echo 'No records in the database.';

/* We first connect to our database */
include("config.php");
if (isset($_POST['DATE']) and $_POST['DATE']==='Select the date to see the graph.'){			echo'	</br><div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Use the drop down menu to select required date.
            </div>'; }
if (isset($_POST['DATE'])and $_POST['DATE']!='Select the date to see the graph.')
{ 
	
	
echo'	<script type="text/javascript">
$.getJSON("filtering.php", function(result){
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
</script><a href="UserReport_Export.php"> Export To Excel </a> 
<div id="chartContainer"></div>'; 

 
  


}

 ?><br/><br/><br/><br/><br/><br/>

 <form action="delete.php" method="post">
 
 
 
    <?php
if (isset($_POST['DATE'])){ECHO '';} ELSEIF ( 1==1) {
///////////////////////////////////////////////////////////
// Skrypt wyświetlający dropdown menu dostępnych dat
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
include("config.php");
$username = $_SESSION['username'];
$sql      = "
SELECT DISTINCT
 DATE 
 FROM 
 `ID_NUMBER` 
 WHERE 
 `ID_NUMBER`.`USERNAME` = '$username' 
 ORDER BY `ID_NUMBER`.`ID` DESC ";



$result = mysqli_query($link, $sql);


// Dropdown DATE

if (mysqli_num_rows($result) > 0)
  {
    echo '
         <div class="col-xs-2">  <b>Before deliting make sure the right date is selected and press red button. </b><br/><br/><br/>
 <select name="DELETE" class="form-control  input-sm" id="sel1">
            <option>Select Date to delete</option>'; // output data of each row
    while ($row = mysqli_fetch_assoc($result))
      {
        echo $row['DATE'];
        if ($_POST['DATE'] == $row['DATE'])
          {
            echo '<option  selected="selected" value"' . $row['DATE'] . '" name="DELETE">' . $row['DATE'] . '</option>';
          }
        elseif ($_POST['DELETE'] !== $row['DATE'])
          {
            echo '<option  value"' . $row['DATE'] . '" name="DELETE">' . $row['DATE'] . '</option>';
          }
      }
    
    
    echo ' </select>      
            <br/>
                <input type="submit" class="btn btn-danger btn-sm" value="Delete Previous"></div>   
     </form>
    
        ';
    
  }
else
    echo 'No records in the database.';


if (isset($_POST['DELETE']) and $_POST['DELETE'] === 'Select Date to delete')
  {
    echo '    <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Use the drop down menu to select required date.
            </div>';
  }
;



if (isset($_POST['DELETE']) and $_POST['DELETE'] != 'Select Date to delete')
  {
INCLUDE('config.php');
    $DATE = $_POST['DELETE'];
$username = $_SESSION['username'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to delete a record
$sql = "DELETE FROM `SMOKEHOUSE`.`ID_NUMBER` WHERE `ID_NUMBER`.`USERNAME` = '$username' AND `ID_NUMBER`.`DATE` = '$DATE'  ORDER BY  `ID_NUMBER`.`TIMESTAMP` DESC ";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

}


}



      

  

?>

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
