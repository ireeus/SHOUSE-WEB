            
			
              <ul class="nav nav-pills">
                <li class="active"><a href="#">
				
				<?php 
				session_start();
				
				/* We first connect to our database */
				include("config.php");

			/* Declare an array containing our data points */
				

  /* Usual SQL Queries */
  $DATE = $_SESSION['DATE'];
  $username   = $_SESSION['username'];

     $query = "SELECT  `Temp_in` 
FROM  `ID_NUMBER` 
WHERE `ID_NUMBER`.`USERNAME` =  '$username' ORDER BY  `ID_NUMBER`.`ID` DESC 
LIMIT 1";
     $result1 = mysqli_query($link, $query);
  if (mysqli_num_rows($result1) > 0) {

    while($row = mysqli_fetch_array($result1))
        {  
			
				$temp = $row['Temp_in'];
				
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
			  
			  <?php
///////////////////////////////////////////////////////////
// Wyswietlanie ustawionej niskiej temperatury
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * 
FROM  `USERS` 
 WHERE 
 `USERS`.`USERNAME` = '$username' 
";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
		$T_high = $row['T_high'];
		$T_low = $row['T_low'];
		mysqli_close($link);
		include("config.php");
$username   = $_SESSION['username'];
  $DATE = date('dmY');
$sql    = "SELECT  `Temp_in` 
FROM  `ID_NUMBER` 
WHERE `ID_NUMBER`.`USERNAME` =  '$username' AND `ID_NUMBER`.`DATE` = '$DATE' ORDER BY  `ID_NUMBER`.`ID` DESC 
LIMIT 1
";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
	$Temp_in = $row['Temp_in'];
	$T_dif = $T_high - $T_low;
	$T_dif_value = 5;
	if($T_high < $T_low) {echo '<div class="alert alert-danger alert-dismissable">High temp needs to be greater than Low temp</div>';}
	
	elseif($T_dif < 5) {echo '
	<div class="alert alert-danger alert-dismissable">
	
	
	Alarms range needs to be greater than '.$T_dif_value. '</div>';}	
	elseif($Temp_in < $T_low){echo '';}
	elseif ($Temp_in > $T_high){echo '';}
	
}
}
		
	}
} ?>
      