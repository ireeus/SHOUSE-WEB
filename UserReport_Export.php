<?php  



  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;



session_start();
include("config.php");
$username   = $_SESSION['username'];
$DATE= $_SESSION['DATE'];
$sql    = "SELECT `Temp_in`,`Temp_out`,`TIMESTAMP` FROM `ID_NUMBER` WHERE `ID_NUMBER`.`USERNAME` ='$username' and `ID_NUMBER`.`DATE` ='$DATE'  ";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
}}
  exit;  /**/
?> 
  
