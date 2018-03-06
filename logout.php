<?php if (isset($_GET['id'])=="1") {header("Location: sign-in.php?item=5");}
else 
session_start();
session_destroy();
session_start();
$_SESSION['logout'] = 'Logout';

header("Location: sign-in.php");
session_destroy();
die;
?>