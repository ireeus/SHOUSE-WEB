 <?php
///////////////////////////////////////////////////////////
// Wyswietlanie wiadomosci o wysokiej lub niskiejtemperaturze
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
	
	if($Temp_in < $T_low){
		$day = date('l \t\h\e jS');
		echo '
	      <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Low Temperature</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> '.$day.'</p>
                                        <p>The temperature in the smoker is going down. You need to check the fireplace or change  <i class="fa fa-bell"></i> alarms range.</p>
                                    </div>
                                </div>
                            </a>
                        </li>
<audio controls autoplay>
  <source src="logout.wav" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>   
					
				
';}
	if ($Temp_in > $T_high){
		
		$day = date('l \t\h\e jS');
		echo '
	<li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>High Temperature</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> '.$day.'</p>
                                        <p>The temperature in the smoker is going up. You need to check the fireplace or change alarms <i class="fa fa-bell"></i> range.  </p>
                                    </div>
                                </div>
                            </a>
                        </li><audio controls autoplay>
  <source src="login.wav" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>   
						';}
	
}
}
		
	}
} 


?>
