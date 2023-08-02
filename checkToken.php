<?php
function checkTokenValid(){
require "config.php" ;
$token ="qqq";
// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
/*if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
*/ 
// Change character set to utf8

$user='modirsan';
$password='p@ssw0rd121';
$url = 'https://modirsanapi.mcci.local/NewPayment/auth/local';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
	"identifier=$user&password=$password");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	//echo $server_output;
	$obj = json_decode($server_output);
	//print $obj->{'jwt'}; 
	if( isset( $obj->{'jwt'} ) ){ 		
		$token = $obj->{'jwt'};
		/*$sql2 = "UPDATE `starpi_token` SET `token` = '$token' WHERE user='modirsan'";//enabled=1 and approved=1 and verified=0 and level_id=4";
		$result2 = $conn->query($sql2);*/
		$token = "Authorization: Bearer $token";
		//echo "else";
	}
return $token;
}

?>