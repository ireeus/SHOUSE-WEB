            
			
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
																
							?> °C
				</span></a></li>
     
              </ul>
      