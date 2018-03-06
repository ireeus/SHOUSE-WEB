 <?php //Navigation ?>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <?php //Brand and toggle get grouped for better mobile display ?>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Smokehouse</a>
            </div>
           <?php // Top Menu Items ?>
		   <?php if ($page == 'sign-in.php' or $page =='registration.php' or $page == 'share.php') {echo ' <!--';} ?>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown"  >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					
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
	if($Temp_in < $T_low || $Temp_in > $T_high){echo '
	
<i class="fa fa-envelope blink"></i>';}  else echo '<i class="fa fa-envelope"></i>';

	
}
}
		
	}
} ?>
      
					
					
					
					 <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown" id="messages" >
                      
<?php include('messages.php'); ?>
					  
                    </ul>
                </li>
				

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            
											<div class="col-xl-1"> 
											<span class="label label-danger">High Temperature Alarm</span>

											<form action="index.php" method="post">
											<input type="text" maxlength="2" name="T_high" autocomplete="off" value="<?php
///////////////////////////////////////////////////////////
// Wyswietlanie ustawionej wysokiej temperatury
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
include("config.php");
$username   = $_SESSION['username'];
$sql    = "
SELECT
 T_high 
 FROM 
 `USERS` 
 WHERE 
 `USERS`.`USERNAME` = '$username' 
";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {echo $row['T_high'];
	}
} ?>">
											<span class="label label-info">Low Temperature Alarm</span>							
										<input type="text" hidden="hidden" name="user" value="<?php echo $username; ?>">
											<input type="text" maxlength="2" name="T_low" autocomplete="off" value="<?php
///////////////////////////////////////////////////////////
// Wyswietlanie ustawionej niskiej temperatury
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
include("config.php");
$username   = $_SESSION['username'];
$sql    = "
SELECT
 T_low
 FROM 
 `USERS` 
 WHERE 
 `USERS`.`USERNAME` = '$username' 
";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {echo $row['T_low'];
	}
} ?>"> 
												<button type="submit" class="btn-xs btn-success">Submit</button>
											</form>
											
											
											

                        </li>

                    </ul>
                </li>
				<?php if ($page == 'sign-in.php' or $page == 'registration.php' or $page == 'share.php') {echo '<!--';} ?>
				<?php /////////// Login and profile drop down menu ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $username; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                      
                        <li>
                            <a href="payment.php"><i class="fa fa-fw fa-gear"></i> Payments</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
				<?php ///////////END Login and profile drop down menu ?>
				
            </ul><?php if ($page == 'sign-in.php' or $page == 'registration.php' or $page == 'share.php') {echo '-->';} ?>
			      
            <?php // Sidebar Menu Items - These collapse to the responsive navigation menu on small screens ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
				
				<?php if ($page == 'sign-in.php' or $page == 'registration.php' or $page == 'share.php') {echo '<!--';} ?>
					 
                    <li <?php if ($page == 'index.php') {echo 'class="active"';} ?>>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li <?php if ($page == 'history.php') {echo 'class="active"';} ?>>
                        <a href="history.php"><i class="fa fa-fw fa-bar-chart-o"></i> History</a>
                    </li> 
					<li <?php if ($page == 'tooltips.php') {echo 'class="active"';} ?>>
                        <a href="tooltips.php"><i class="fa fa-fw fa-lightbulb-o "></i> Help</a>
                    </li> 
                   
                   
                    <?php if ($page == 'sign-in.php' or $page == 'registration.php' or $page == 'share.php') {echo '-->';} ?>
                </ul>
            </div></nav>
			
            <?php // /.navbar-collapse ?>
        
