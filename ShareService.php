<?php
session_start();



/* We first connect to our database */
include("config.php");

/* Capture connection error if any */
if (mysqli_connect_errno($link)) {
        echo "Failed to connect to DataBase: " . mysqli_connect_error();
    }
else {

  /* Declare an array containing our data points */
   $data_points = array();

  /* Usual SQL Queries */
  $SHARE = $_SESSION['SHARE'];
     $query = "SELECT * FROM `USERS` WHERE  `USERS`.`SHARE` ='$SHARE'";
     $result = mysqli_query($link, $query);
	 
	 
	 
	 
     while($row = mysqli_fetch_array($result))
        {        
	// logowanie do wykresów
	
	
	$user = $row['USERNAME'];

	
	
	
	  mysqli_close($link);
	/* We first connect to our database */
include("config.php");

/* Capture connection error if any */
if (mysqli_connect_errno($link)) {
        echo "Failed to connect to DataBase: " . mysqli_connect_error();
    }
else {
  /* Declare an array containing our data points */
   $data_points = array();

  /* Usual SQL Queries */
  $DATE = date('dmY');
  $username   = $_SESSION['username'];
     $query = "SELECT `TIMESTAMP`,`Temp_in` FROM `ID_NUMBER` WHERE  `ID_NUMBER`.`DATE` ='$DATE' and `ID_NUMBER`.`USERNAME` ='$user'";
     $result = mysqli_query($link, $query);


     while($row = mysqli_fetch_array($result))
        {        
      /* Push the results in our array */
            $point = array("ts" =>  $row['TIMESTAMP'] ,"d1" =>  $row['Temp_in']);
            array_push($data_points, $point);
        }

    /* Encode this array in JSON form */
        echo json_encode($data_points, JSON_NUMERIC_CHECK);
        }
    mysqli_close($link);
	
	
	
        }

 
        }
  
	
?>