<?php
include("config.php");


//Variables Incomming
$DATE = date('dmY');
$USERNAME = $_GET["un"];
$Temp_in = $_GET["to"];
$Temp_out = $_GET["ti"];


$Temp_in = number_format($Temp_in,1);
$Temp_out = number_format($Temp_out,1);
// Echo Results
echo "!DEBUG INFORMATION!";

echo "DATE: ";
echo $DATE; 
echo nl2br("\n");

echo "<BR/> USERNAME:";
echo $USERNAME; 
echo "<BR/> Temp_in:";
echo $Temp_in; 
echo "<BR/> Temp_out:";
echo $Temp_out; 


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
echo nl2br("Connected successfully \n");
echo nl2br("\n");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



//Indavidual Database Entry
$sql = "INSERT INTO ID_NUMBER (DATE, USERNAME, Temp_in, Temp_out) VALUES ('".$DATE."', '".$USERNAME."', '".$Temp_in."', '".$Temp_out."')"; 
if (mysqli_query($conn, $sql)) {
	echo "New indavidual record created successfully";
	echo nl2br("\n");
	echo nl2br("\n");
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		


mysqli_close($conn);
 

?>


