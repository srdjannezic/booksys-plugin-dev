<?php
function bookingSteps(){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_GET['success'])){
		//var_dump($_SESSION);
		$post = $_SESSION['post'][$_SERVER['REMOTE_ADDR']];
		$childs = $_SESSION['childs'][$_SERVER['REMOTE_ADDR']];
		$checklist = $_SESSION['checklist'][$_SERVER['REMOTE_ADDR']];

		$pass = createRandomPassword();

		parse_str($post,$post);

		//var_dump($post);

		if(isset($_POST['ReasonCodeDesc'])){
			if($_POST['ReasonCode'] == '96'){
				//cancelled
				include 'front/cancelled.php';
			}
			else{ 

				$postid = '';
				if($_POST['ReasonCodeDesc'] == 'Approved'){
					$data = registerBooking($post,$childs,$checklist,$pass);
					$postid = $data['postId'];

					$hasPass = $data['hasPass'];					
					sendMailToUser($post,$childs,$checklist,$postid,$hasPass,$pass);
					
					include 'front/thankyou.php';
				}
				else{
					include 'front/error.php';
				}
				sendMailToAdmin($post,$childs,$postid);

				//unset($_SESSION['post'][$_SERVER['REMOTE_ADDR']]);
				//unset($_SESSION['childs'][$_SERVER['REMOTE_ADDR']]);
			}
		}
	}
	else{
		$coupons = get_posts(array('post_type' => 'wpcd_coupons','posts_per_page'=>'-1'));
		$packages = get_posts(array('post_type'=>'packages','posts_per_page'=>'-1','post_status'=>'publish'));
		include 'front/frontend.php';
	}
}

add_shortcode('booksys','bookingSteps');

function account(){
	global $wpdb;
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	$email = isset($_SESSION['email'][$_SERVER['REMOTE_ADDR']]) ? $_SESSION['email'][$_SERVER['REMOTE_ADDR']] : null;
	$password = isset($_SESSION['password'][$_SERVER['REMOTE_ADDR']]) ? $_SESSION['password'][$_SERVER['REMOTE_ADDR']] : null;
	//var_dump($password);
	
	$check = $wpdb->get_results('SELECT * FROM wp_postmeta WHERE meta_key = "password" AND meta_value = "' . $password . '" ');


	if($check){
		//var_dump($account);
		$account = get_posts(
			array(
				'post_type'=>'bookings',
				'meta_query'=>array(
					array(
			   			'key'   => 'email',
						'value' => $email
					)
				)
			)
		);
		include 'front/account.php';
	}else{
		include 'front/login.php';
	}
	//session_destroy();
}

add_shortcode('account','account');

function loginform(){
	?>
		<input type="email" name="email" />
		<button type="submit" name="login">Log In</button>
	<?php
}

add_shortcode("loginform","loginform");

function createRandomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


function payment(){
	
	//Version
	$version = "1.0.0";
	//Merchant ID
	$merchantID = "0097883011";
	//Acquirer ID
	$acquirerID = "402971";
	//The SSL secured URL of the merchant to which JCC will send the transaction
	//result //This should be SSL enabled – note https:// NOT http://
	$responseURL = "https://summercamp.zaffasoft.com/reservation?success";
	//Purchase Amount
	$purchaseAmt = "25.00";
	//Pad the purchase amount with 0's so that the total length is 13 characters, i.e. 20.50 will
	//become 0000000020.50
	$purchaseAmt = str_pad($purchaseAmt, 13, "0", STR_PAD_LEFT);
	//Remove the dot (.) from the padded purchase amount(JCC will know from currency how many digits
	//to consider as decimal)
	//0000000020.50 will become 000000002050 (notice there is no dot)
	$formattedPurchaseAmt = substr($purchaseAmt,0,10).substr($purchaseAmt,11);
	//Euro currency ISO Code; see relevant appendix for ISO codes of other
	$currency = 978;
	//The number of decimal points
	$currencyExp = 2;
	//Order number
	$orderID = "TestOrder" . rand(0,1000);
	//Specify we want not only to authorize the amount but also capture at the same time. Alternative
	//value could be M (for capturing later)
	$captureFlag = "A";

	//Password
	$password = "s6iXrTPN";
	//Form the plaintext string to encrypt by concatenating Password, Merchant ID, Acquirer ID, Order
	//ID, Formatter Purchase Amount and Currency
	//This will give 1234abcd | 0011223344 | 402971 | TestOrder12345 | 000000002050 | 978 (spaces
	//and | introduced here for clarity)
	$toEncrypt = $password.$merchantID.$acquirerID.$orderID.$formattedPurchaseAmt.$currency;
	//Produce the hash using SHA1
	//This will give b14dcc7842a53f1ec7a621e77c106dfbe8283779
	$sha1Signature = sha1($toEncrypt);
	//Encode the signature using Base64 before transmitting to JCC
	//This will give sU3MeEKlPx7HpiHnfBBt++goN3k=
	$base64Sha1Signature = base64_encode(pack("H*",$sha1Signature));
	//The name of the hash algorithm use to create the signature; can be MD5 or SHA1; the latter is
	//preffered and is what we used in this example
	$signatureMethod = "SHA1";
	
	
	include('front/payment.php');
}

add_shortcode('payment','payment');

?>