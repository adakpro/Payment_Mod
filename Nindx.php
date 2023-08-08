<?php session_start();
include( 'htmlpurifier/library/HTMLPurifier.auto.php');
$config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
	
require "checkToken.php" ;
$strapitoken = checkTokenValid();
?>
<script>
function postRefId (refIdValue) {
			var form = document.createElement("form");
			form.setAttribute("method", "POST");
			form.setAttribute("action", "https://bpm.shaparak.ir/pgwchannel/startpay.mellat");         
			form.setAttribute("target", "_self");
			var hiddenField = document.createElement("input");              
			hiddenField.setAttribute("name", "RefId");
			hiddenField.setAttribute("value", refIdValue);
			form.appendChild(hiddenField);

			document.body.appendChild(form);         
			form.submit();
			document.body.removeChild(form);
		}
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}

</script>
<?php 
$orderUuId	= (isset($_GET['orderUuId']) && $_GET['orderUuId'] != "") ? $_GET['orderUuId'] : "";
if($orderUuId == "") header('Location: /Module/404.php');
require "config.php" ;
if(isset($_POST['Submit']) && isset($_POST['captcha_code'])){
	// code for check server side validation
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
		$msg="1";// Captcha verification is incorrect.		
	}else{// Captcha verification is Correct. Final Code Execute here!		
		$msg="0";		
	}
}
define('in_12369570', 'true');
	
	
	if(isset($_POST['captcha_code'])){
		// code for check server side validation
		
		if(isset($msg) && $msg === '1'){
			echo "<script language='javascript' type='text/javascript'>alert('کلمه امنیتی نادرست');</script>";
		}
		else {
			
			
				$url = 'https://modirsanapi.mcci.local/NewPayment/setModirsanOrder';
				$body = '{
					"orderUuId": "'.$orderUuId.'"
				}';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_POSTFIELDS, 
					$body
					);
						
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					$strapitoken,
					'Content-Type: application/json'
				));

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec($ch);
				
				echo $server_output;

				$obj1 = json_decode($server_output);
				$out3 = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);				
				if($out3 === 200){	
					if( isset( $obj1->code )){
						if($obj1->code == 0){
							echo $obj1->message;
							
						}
						else {
							echo "<script language='javascript' type='text/javascript'>alert('".$obj1->message."');</script>";
						}
					}
					else {
						echo 'خطا';
					}
				}
				
				curl_close ($ch);
			
		}//else msg
	}

?>
<?php
set_error_handler('exceptions_error_handler');
function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

?>

<link href="css/beyond-rtl.css" rel="stylesheet">
<link href="css/beyond-rtl.min.css" rel="stylesheet">
<link href="css/bootstrap.min1.css" rel="stylesheet">
<link href="css/bootstrap-rtl.css" rel="stylesheet">
<link href="css/mycss.css" rel="stylesheet">

<script src="js/jquery.js"></script> 
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css" />
<script src="js/num2per.js"></script> 
<script>

$(document).ready(function(){
	  $("#charge").hide();
 $("#increaseDiv").click(function(){
    $("#charge").toggle();
  });
  
});
</script>
<html>
<head>
<title>پرداخت مبلغ دانگل</title>
</head>
<body style="direction:rtl;background: #fff;font-size: smaller;">
	<div style="overflow: hidden;">	
		<div class="row">		
			<div class="container-fluid d-flex justify-content-center">
				<div class="col-sm-12">
					<div style="width:100%;height:50px;background:#ff9900">
					</div>
				</div>
			</div>
		</div>	
		<div class="row" style="border-bottom: 3px solid #a4a4a4;">	
		<form method="POST" onsubmit="return validate(this);" action="" style="width:100%">	
			<div class="container-fluid d-flex justify-content-center">
				<div class="col-sm-12">
					<div class="row" style=" padding: 25px">
                        <!--<div class="col-sm-6 text-center">
                            <img src="img/avatar.png" alt=" " class="header-avatar" height="128" width="128"/>
                        </div>-->
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6 profile-info">
                            <div style="font-size:x-large;text-align:center"><br/><br/>
								<?php 
								$url2 = 'https://modirsanapi.mcci.local/NewPayment/getModirsanOrder';
								$ch2 = curl_init();
								curl_setopt($ch2, CURLOPT_URL,$url2);
								curl_setopt($ch2, CURLOPT_POST, 1);
								curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
								curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
								curl_setopt($ch2, CURLOPT_POSTFIELDS, '{"orderUuId":"'.$orderUuId.'"}');
								curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
									$strapitoken,
									'Content-Type: application/json'
								));

								curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

								$outputlist = curl_exec($ch2);
								$obj = json_decode($outputlist);
								$out2 = curl_getinfo($ch2, CURLINFO_RESPONSE_CODE);
								//echo $strapitoken;
								if($out2 === 200){	
									if( isset( $obj->{'status'} ) &&  $obj->{'status'} == 0){
										$price = $obj->{'data'}->{'amountPay'};
										$uuid = $obj->{'data'}->{'dealerUuid'};
										$quantity = $obj->{'data'}->{'nbOfModulesApproved'};
										$payStartDate = $obj->{'data'}->{'payStartDate'};
										$mohebId = $obj->{'data'}->{'depositID'};
										$dealerCode = $obj->{'data'}->{'dealerCode'};
										$productName = $obj->{'data'}->{'productName'};
										$now = date('Y-m-d\TH:i:s',strtotime('+4 hours +30 minutes')); // or your date as well										
										//$now = date('Y-m-d\TH:i:s'); // or your date as well
										
										$t1 = strtotime($now);
										$t2 = strtotime($payStartDate);
										$diff = $t1 - $t2;
										/*echo $now;
										echo '<br />';
										echo $payStartDate;*/
										$hours = round($diff / ( 60 * 60 ));
										if($hours <= 73){
											?>
											<div class="row" style="font-size:x-large; padding: 5px 25px;color:#272727;">
												<div class="col-md-12" style="text-align:center">
													<div class="form-group">
														<div class="row">
															<div class="col-md-12" style="text-align:right">
																مدیر محترم مرکز فروش و خدمات حضوری همراه اول 
															</div>
														</div>
														<div class="row">															
															<div class="col-md-12" style="text-align:right">
																 کد <?php echo $dealerCode; ?>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12" style="text-align:right">
																درخواست دانگل جنابعالی مورد تایید قرار گرفت.
															</div>
														</div>
														<div class="row">															
															<div class="col-md-12" style="text-align:right">
																 تعداد: <?php echo $quantity; ?>
															</div>
														</div>
														<div class="row">															
															<div class="col-md-12" style="text-align:right">
																 مبلغ: <?php if(is_numeric($price)) echo number_format($price); else echo $price; ?> ریال
															</div>
														</div>
														<div class="row">															
															<div class="col-md-12" style="text-align:right">
																مهلت پرداخت: <?php echo 72-$hours; ?> ساعت مانده
															</div>
														</div>
														<table border="0" cellpadding="10" cellspacing="1" width="100%" class="demo-table">
															<tr class="tablerow">
																<td>
																	<input name="captcha_code" style="height: 45px;border-radius: 4em !important;text-align: center;" autocomplete="off" id="captcha_code" type="text" maxlength="6" pattern="^[a-zA-Z0-9]{6}$" class="form-control" required>
																</td>
																<td>
																	<img src="lib/captcha.php?rand=<?php echo rand();?>" onclick='javascript: refreshCaptcha();' id='captchaimg'>
																</td>
															</tr>
														</table>
													</div>
													<div class="form-group">
														<input value="پرداخت" name="Submit" id="paymentbtn" type="Submit" class="btn btn-lg form-control" style="font-size: x-large;height: 43px;background:#10962d;color:#fff;padding:0;border-radius:4em;"> 
													</div>
												</div>
											</div>
											<?php
										}
										else{
											?>
											<div class="row" style="font-size:x-large; padding: 5px 25px;color:#838383;">
												<div class="col-md-12" style="text-align:center">
													<div class="form-group">
														<div class="row">
															<div class="col-md-12" style="text-align:right">
																مدیر محترم مرکز فروش و خدمات حضوری همراه اول <br />
																	کد <?php echo $dealerCode; ?><br />
																	با توجه به عدم پرداخت در مهلت مقرر درخواست مربوطه لغو شد.

															</div>
														</div>
														
												</div>
											</div>
											<?php
										}
									}
									else{
										
										$msg = $obj->{'data'};
										?>										
											<div class="row" style="font-size:x-large; padding: 5px 25px;color:#838383;">
												<div class="col-md-12" style="text-align:center">
													<div class="form-group">
														<div class="row">
															<div class="col-md-12">
																 لینک وارد شده نامعتبر می باشد یا فرایند در مرحله پرداخت نمی باشد<br />
															</div>
														</div>
														
												</div>
											</div>
										<?php
									}
									
	}
				curl_close ($ch2);
?>
							</div>
                        </div>
                        <div class="col-sm-3"></div>
					</div>
				</div>
			</div>
		</form>
		
</div>

		
</body>
</html>
