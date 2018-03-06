 <?php 


if(isset($_POST['info_set'])){
	//security token
$info_set = $_POST['info_set'];
$key = '8bdd2867858c8765878ad54a';
$date = md5(date('Y/m/d H:m:s'));
$return_key = $info_set.'b987cd097a098709b'.$key.''.$date;
$use_name = $_POST['item_number'];
// PayPal settings
$paypal_email = 'ireeus@gmail.com';
$return_url = 'http://192.168.0.113/payment.php?return='.$return_key.'';
$cancel_url = 'http://192.168.0.113/payment.php?return=cancel';
$notify_url = 'http://192.168.0.113/payment.php';

$item_name = ''.$use_name.' - Online Payment';
$item_amount = $_POST['payment'];
$sandbox ='';
 
 
$username = $_SESSION['username'];
$sql = "SELECT * FROM `SMOKEHOUSE`.`USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result = mysqli_query($link, $sql);
if ($_SESSION['username'] =='') { header("Location: index.php");} 
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
	{	
		
	if ($row["ACTIVATION"] == '0') { header("Location: activation.php");} 
	//if ($row["NAME"] == '' || $row["SURNAME"] == '' || $row["HOUSENO"] == '' || $row["STREET"] == '' || $row["CITY"] == '' || $row["POSTCODE"] == '' || $row["COUNTY"] == '' || $row["COUNTRY"] == '' || $row["MOBILE"] == '') { header("Location: index.php");}
			
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `PAID` = '$item_amount' WHERE `USERS`.`USERNAME` ='$username'")or die("Nie mogłem Cie zarejestrować!");
			mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `TOKEN` = '$return_key' WHERE `USERS`.`USERNAME` ='$username'")or die("Nie mogłem Cie zarejestrować!");
			mysqli_query($link, "INSERT INTO `SMOKEHOUSE`.`PAYMENTS` (USERNAME, payment_amount, payment_status, itemid, TOKEN) VALUES('$username','$item_amount','Transakcja nieukończona','Zasilenie konta.','$return_key')") or die("Nie mogłem Cie zarejestrować!");

	}
	}		
// Include Functions
//include("functions.php");

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
	$querystring = '';
	
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	
	// Redirect to paypal IPN
	header('location:https://'.$sandbox.'paypal.com/cgi-bin/webscr'.$querystring);
	exit();
} else {
	//Database Connection
	$link = mysqli_connect($servername, $username, $password);
	mysqli_select_db($dbname);
	
	// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}
	
	// assign posted variables to local variables
	$data['item_name']			= $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['custom'] 			= $_POST['custom'];
		
	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
	$fp = fsockopen ('ssl://www.'.$sandbox.'paypal.com', 443, $errno, $errstr, 30);
	
	if (!$fp) {
		// HTTP ERROR
		
	} else {
		fputs($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp($res, "VERIFIED") == 0) {
				
				// Used for debugging
				// mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
						
				// Validate payment (Check unique txnid & correct price)
				$valid_txnid = check_txnid($data['txn_id']);
				$valid_price = check_price($data['payment_amount'], $data['item_number']);
				// PAYMENT VALIDATED & VERIFIED!
				if ($valid_txnid && $valid_price) {
					
					$orderid = updatePayments($data);
					
					if ($orderid) {
						// Payment has been made & successfully inserted into the Database
					} else {
						// Error inserting into DB
						// E-mail admin or alert user
						// mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
					}
				} else {
					// Payment made but data has been changed
					// E-mail admin or alert user
				}
			
			} else if (strcmp ($res, "INVALID") == 0) {
			
				// PAYMENT INVALID & INVESTIGATE MANUALY!
				// E-mail admin or alert user
				
				// Used for debugging
				//@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
			}
		}
	fclose ($fp);
	}
}
}
//$konot_indication = "2";$konot_indication = "1";
?>

	<?php $page = 'profile.php'; 
	session_start();

include("config.php");
$username   = $_SESSION['username'];
$sql    = "SELECT * FROM `USERS` WHERE `USERS`.`username` ='$username'";
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

      
    }
}
	
	
	?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

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

</head>

<body>

    <div id="wrapper">

<?php include('nav.php'); ?>
        <div id="page-wrapper">

            <div class="container-fluid">

			 <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Payments <small> Balance: </small>
                        </h1>

                    </div>
					
                </div>
					  <?php 
$username = $_SESSION['username'];
include('config.php');
$sql = "SELECT * FROM `USERS` WHERE `USERS`.`USERNAME` ='$username'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
	{
  if (isset($_GET['return'])) {$action = $_GET['return'];
		$PAID = $row['PAID'];
		$TOKEN = $row['TOKEN'];
		$username = $_SESSION['username'];
		$BALANCE = $row['BALANCE'];
		$NEW_BALANCE = $PAID + $BALANCE;

// wprowadzanie danych o płatnościach po otrzymaniu klucza transakcji I AKTYWACJA PŁATNOŚCI
  
    if ($action == $row['TOKEN']) {

		mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `BALANCE` = '$NEW_BALANCE' WHERE `USERS`.`TOKEN` ='$TOKEN'")or die("Nie mogłem Cie zarejestrować!");
		mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `TOKEN` = 'TOKEN_ACTIVATED' WHERE `USERS`.`TOKEN` ='$TOKEN'")or die("Nie mogłem Cie zarejestrować!");
		mysqli_query($link, "UPDATE `SMOKEHOUSE`.`PAYMENTS` SET `payment_status` = '<font color='green'>Payment added</font>' WHERE `PAYMENTS`.`TOKEN` ='$TOKEN'")or die("Nie mogłem Cie zarejestrować!");
		
		echo '<font color="green" size="3">You account was tpped up by '.$PAID.' &#163; <form action="payment.php"> </font><input type="submit" class="btn btn-success btn-lg " value="OK"></form>';
}
  $action = $_GET['return'];

if($action == 'cancel'){
	//anuluje token
	mysqli_query($link, "UPDATE `SMOKEHOUSE`.`USERS` SET `TOKEN` = 'TOKEN_CANCELED' WHERE `USERS`.`USERNAME` ='$username'")or die("Nie mogłem Cie zarejestrować!");
	mysqli_query($link, "UPDATE `SMOKEHOUSE`.`PAYMENTS` SET `payment_status` = 'Transaction canceled by user' WHERE `PAYMENTS`.`TOKEN` ='$TOKEN'")or die("Nie mogłem Cie zarejestrować!");

		echo '<font color="red" size="5">Transaction canceled by user.</font> ';
		echo $TOKEN;
		}
	}		
}}

	 ?>
				
				
<form class="paypal" action="payment.php" method="post" id="paypal_form" >
		
	
		<div class="col-md-6">
  <label for="ex1">Enter the amount you wouldlike to pay in (min 5 GBP)</label>
  
		<input type="number" required class="form-control" name="payment"  min="5"  nid="ex1"/>

		<br><br>

		<input type="hidden" name="info_set" value="<?php echo md5('payment'); echo md5(date('Y/m/d H:m:s')); echo md5($username); ?>" />
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="no_note" value="1" />
		<input type="hidden" name="lc" value="UK" />
		<input type="hidden" name="currency_code" value="GBP" />
		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
		<input type="hidden" name="first_name" value="Customer's First Name"  />
		<input type="hidden" name="last_name" value="Customer's Last Name"  />
		<input type="hidden" name="payer_email" value=""  />
		<input type="hidden" name="item_number" value="<?php  echo $_SESSION['username']; ?>" / >
		<input type="submit" name="submit" class="btn btn-primary btn-lg " value="Pay"/>
	</form>
				
				<BR><BR>
				
				
				<?php 

// Skrypt wyświetlający tabelę przesyłek
$username = $_SESSION['username'];


$sql = "SELECT * FROM `PAYMENTS` WHERE `PAYMENTS`.`USERNAME` ='$username' ORDER BY `PAYMENTS`.`TIMESTAMP` DESC";
$result = mysqli_query($link, $sql);
	// Początek tabeli	

if (mysqli_num_rows($result) > 0) {echo '

<CENTER>
<table WIDTH="100%" class="table-hover" border="1" >
	<tr bgcolor="#E0E0E0">
		<td><center><b><div class="glyphicon glyphicon-calendar"></div>Transaction date</b></center></font></td>
		<td><center><b><div class="glyphicon glyphicon-tag"></div> Status</b></center></td>
		<td><center><b><div class="glyphicon glyphicon-th-large"></div> Amount</b></center></td>
		
	</tr>
';
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
		{
			if (isset($row["STATUS"]))$STATUS = $row["STATUS"];
			// wyświetla dane z tabeli
			echo '
			<tr>';
				echo '<td><font size="2" >'.$row["TIMESTAMP"].'</font></center></td>';
				echo '<td><font size="2" >'.$row["payment_status"].'</font></center></td>';
				echo '<td><font size="2" >'.$row["payment_amount"].'</font></center></td>';				
						echo '
			</tr>';
		} 
		
	}	else echo 'There is no records of transaction in the databse.';
// zakończenie tabeli	
echo '
</table></CENTER>';
?>
				          <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>

