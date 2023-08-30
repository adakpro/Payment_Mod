<html>
<head>
<title>نتیجه پرداخت</title>
</head>
<body>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/callback.css" rel="stylesheet">
<script src="js/jquery.js"></script> 
<script src="js/callback.js"></script> 
<?php
include( 'htmlpurifier/library/HTMLPurifier.auto.php');
$config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
	
require "checkToken.php" ;
$strapitoken = checkTokenValid();	
function MellatMsg($msg)
{
	/*if(empty($msg) && $msg !== 0)
	{
		$msg = 'empty';
	}*/
	$MellatMsga = array(
	0		=>		"تراكنش با موفقيت انجام شد",
	11		=>		"شماره كارت نامعتبر است",
	12		=>		"موجودي كافي نيست",
	13		=>		"رمز نادرست است",
	14		=>		"تعداد دفعات وارد كردن رمز بيش از حد مجاز است",
	15		=>		"كارت نامعتبر است",
	16		=>		"دفعات برداشت وجه بيش از حد مجاز است",
	17		=>		"كاربر از انجام تراكنش منصرف شده است",
	18		=>		"تاريخ انقضاي كارت گذشته است",
	19		=>		"مبلغ برداشت وجه بيش از حد مجاز است",
	111		=>		"صادر كننده كارت نامعتبر است",
	112		=>		"خطاي سوييچ صادر كننده كارت",
	113		=>		"پاسخي از صادر كننده كارت دريافت نشد",
	114		=>		"دارنده كارت مجاز به انجام اين تراكنش نيست",
	21		=>		"پذيرنده نامعتبر است",
	23		=>		"خطاي امنيتي رخ داده است",
	24		=>		"اطلاعات كاربري پذيرنده نامعتبر است",
	25		=>		"مبلغ نامعتبر است",
	31		=>		"پاسخ نامعتبر است",
	32		=>		"فرمت اطلاعات وارد شده صحيح نمي باشد",
	33		=>		"حساب نامعتبر است",
	34		=>		"خطاي سيستمي",
	35		=>		"تاريخ نامعتبر است",
	41		=>		"شماره درخواست تكراري است",
	42		=>		"تراكنش sale یافت نشد.",
	43		=>		"قبلا درخواست Verify داده شده است.",
	44		=>		"درخواست Verify یافت نشد.",
	45		=>		"تراكنش Settle شده است.",
	46		=>		"تراکنش Settle نشده است.",
	47		=>		"تراکنش Settle  یافت نشد.",
	48		=>		"تراکنش Reverse شده است.",
	49		=>		"تراکنش Refund یافت نشد.",
	412		=>		"شناسه قبض نادرست است.",
	413		=>		"شناسه پرداخت نادرست است.",
	414		=>		"سازمان صادر کننده قبض نامعتبر است.",
	415		=>		"زمان جلسه کاری به پایان رسیده است.",
	416		=>		"خطا در ثبت اطلاعات",
	417		=>		"شناسه پرداخت کننده نامعتبر است.",
	418		=>		"اشکال در تعریف اطلاعات مشتری",
	419		=>		"تعداد دفعات ورود اطلاعات از حد مجاز گذشته است.",
	421		=>		"IP نامعتبر است.",
	51		=>		"تراکنش تکراری است.",
	54		=>		"تراکنش مرجع موجود نیست.",
	55		=>		"تراکنش نامعتبر است.",
	61		=>		"خطا در واریز",
	);
	if(!empty($MellatMsga[$msg]))
		return trim($MellatMsga[$msg],"."). '.';
	else
	{
		if(is_array($msg))
		{
			var_dump($msg);
		}
		//return $msg;
		return "Invalid MSG : $msg";
	}
}
$ResCode = (isset($_POST['ResCode']) && $_POST['ResCode'] != "") ? $_POST['ResCode'] : "";

if($ResCode == '0')
{
	if(isset($_POST['RefId']) && $_POST['RefId'] != "" && isset($_POST['SaleOrderId']) && $_POST['SaleOrderId'] != "" && isset($_POST['CardHolderPan']) && $_POST['CardHolderPan'] != ""
	&& isset($_POST['FinalAmount']) && $_POST['FinalAmount'] != "" && isset($_POST['SaleReferenceId']) && $_POST['SaleReferenceId'] != "" && isset($_POST['CardHolderInfo']) && $_POST['CardHolderInfo'] != ""){
		
		$RefId = $purifier->purify($_POST['RefId']);
		$SaleOrderId = $purifier->purify($_POST['SaleOrderId']);
		$CardHolderPan = $purifier->purify($_POST['CardHolderPan']);
		$FinalAmount = $purifier->purify($_POST['FinalAmount']);
		$SaleReferenceId = $purifier->purify($_POST['SaleReferenceId']);
		$CardHolderInfo = $purifier->purify($_POST['CardHolderInfo']);
		
		
			$url = 'https://modirsanapi.mcci.local/NewPayment/modulepayments/moduleverify';
			$body = '{
				"orderId": '.$SaleOrderId.',
				"saleOrderId": '.$SaleOrderId.',
				"saleReferenceId": '.$SaleReferenceId.',
				"cardHolderPan": "'.$CardHolderPan.'",
				"finalAmount": '.$FinalAmount.',
				"cardHolderInfo": "'.$CardHolderInfo.'"
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

			$outputVerify = curl_exec($ch);
			$obj = json_decode($outputVerify);
			//echo $obj->{'message'};
			if( isset( $obj->{'code'} ) &&  $obj->{'code'} == '0'){ // if verify ok				
				$url = 'https://modirsanapi.mcci.local/NewPayment/modulepayments/modulesettle';
				$body = '{
					"orderId": '.$SaleOrderId.',
					"saleOrderId": '.$SaleOrderId.',
					"saleReferenceId": '.$SaleReferenceId.'
				}';
				$chsettle = curl_init();
				curl_setopt($chsettle, CURLOPT_URL,$url);
				curl_setopt($chsettle, CURLOPT_POST, 1);
				curl_setopt($chsettle, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($chsettle, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($chsettle, CURLOPT_POSTFIELDS, 
					$body
					);
						
				curl_setopt($chsettle, CURLOPT_HTTPHEADER, array(
					$strapitoken,
					'Content-Type: application/json'
				));

				curl_setopt($chsettle, CURLOPT_RETURNTRANSFER, true);

				$outputSettle = curl_exec($chsettle);
				$obj = json_decode($outputSettle);
				 
				if( isset( $obj->{'code'} ) &&  $obj->{'code'} == '0'){ // if settle ok
					
				}else {
					/*$url = 'https://modirsanapi.mcci.local/payments/reverse';
					$body = '{
						"orderId": '.$SaleOrderId.',
						"saleOrderId": '.$SaleOrderId.',
						"saleReferenceId": '.$SaleReferenceId.'
					}';
					$chsettle = curl_init();
					curl_setopt($chsettle, CURLOPT_URL,$url);
					curl_setopt($chsettle, CURLOPT_POST, 1);
					curl_setopt($chsettle, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($chsettle, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($chsettle, CURLOPT_POSTFIELDS, 
						$body
						);
							
					curl_setopt($chsettle, CURLOPT_HTTPHEADER, array(
						$token,
						'Content-Type: application/json'
					));

					curl_setopt($chsettle, CURLOPT_RETURNTRANSFER, true);

					$outputReverse = curl_exec($chsettle);
					$obj = json_decode($outputReverse);*/
				}
				
				
				
			}else {
				/*$url = 'https://modirsanapi.mcci.local/payments/reverse';
					$body = '{
						"orderId": '.$SaleOrderId.',
						"saleOrderId": '.$SaleOrderId.',
						"saleReferenceId": '.$SaleReferenceId.'
					}';
					$chsettle = curl_init();
					curl_setopt($chsettle, CURLOPT_URL,$url);
					curl_setopt($chsettle, CURLOPT_POST, 1);
					curl_setopt($chsettle, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($chsettle, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($chsettle, CURLOPT_POSTFIELDS, 
						$body
						);
							
					curl_setopt($chsettle, CURLOPT_HTTPHEADER, array(
						$token,
						'Content-Type: application/json'
					));

					curl_setopt($chsettle, CURLOPT_RETURNTRANSFER, true);

					$outputReverse = curl_exec($chsettle);
					$obj = json_decode($outputReverse);*/
			}
			curl_close ($ch);
			
		
	
		
?>

<div class="container">
   <div class="row">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header success">
					<img src="img/logo.png" style="position:absolute;right:45%"/>
            </div>
            <div class="content">
               <h1>عملیات با موفقیت انجام شد</h1>
               <p>پرداخت شما با موفقیت انجام شد.</p>
               <a href="https://chclub.mci.ir">تکمیل فرایند</a><br />
			   <b id="progresslabel"></b><br />
			   <progress value="0" max="25" id="progressBar"></progress>
            </div>
            
         </div>
      </div>
   </div>
</div><?php 
	}//if posted data problem
	else{
	?>
	<div class="container">
   <div class="row">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header success">
					<img src="img/logo.png" style="position:absolute;right:45%"/>
            </div>
            <div class="content">
               <h1>داده های ارسالی نا معتبر</h1><br />
			   <b id="progresslabel"></b><br />
			   <progress value="0" max="25" id="progressBar"></progress>
            </div>
            
         </div>
      </div>
   </div>
</div>
	<?php }
}//if result 0
	
	else{?>
	
<div class="container">
   <div class="row">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header error">
					<img src="img/logo.png" style="position:absolute;right:45%"/>               
            </div>
            <div class="content">
               <h1>عملیات با خطا مواجه شد.</h1>
               <p><?php
				if(isset($_POST['ResCode'])){
					$res = $purifier->purify($_POST['ResCode']);
					echo MellatMsg($res);
				}
				?></p>
               <a class="error" href="https://chclub.mci.ir">بازگشت</a><br />
			   <b id="progresslabel"></b><br />
			   <progress value="0" max="25" id="progressBar"></progress>
            </div>
            
         </div>
      </div>
   </div>
</div>
</body>
</html>
<?php
	if(isset($_POST['RefId']) && $_POST['RefId'] != "" && isset($_POST['SaleOrderId']) && $_POST['SaleOrderId'] != "" ){
			$RefId = $purifier->purify($_POST['RefId']);
		    $SaleOrderId = $purifier->purify($_POST['SaleOrderId']);
		    $ResCode = $purifier->purify($_POST['ResCode']);
			
			
				$url = 'https://modirsanapi.mcci.local/NewPayment/modulepayments/modulecancel';
				$body = '{
					"orderId": '.$SaleOrderId.',
					"saleOrderId": '.$SaleOrderId.',
					"resCode": '.$ResCode.'
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

				$outputVerify = curl_exec($ch);
				//echo $outputVerify;
			}

		
}
?>
