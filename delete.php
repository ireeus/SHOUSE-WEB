


<?php

INCLUDE('config.php');


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
session_start();
$DATE = $_POST['DELETE'];

$username   = $_SESSION['username'];
echo $username;
echo $DATE;

// sql to delete a record
$sql = "DELETE FROM `SMOKEHOUSE`.`ID_NUMBER` WHERE `ID_NUMBER`.`USERNAME` = '$username' AND `ID_NUMBER`.`DATE` = '$DATE' ";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

header('Location: index.php');
exit;


?>