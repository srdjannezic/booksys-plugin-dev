<?php
require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

function registerBooking($post=false,$childs=false,$checklist=false,$password=false){
	global $wpdb;
	$package = $post['packages'];
	$childname = $post['childname'];
	$childspackages = $childs;//$post['childspackages'];

	$bday = $post['bday'];
	$age = $post['age'];
	$note = $post['note'];
	$quantity = $post['quantity'];
	$dial = $post['dial'];
	//var_dump($childs);
	$mothername = $post['mothername'];
	$fathername = $post['fathername'];
	$email = $post['email'];
	$address = $post['address'];
	$phone = $post['phone'];

	$name = $post['name'];

	$childnum = count($childname);
	//var_dump($_POST);
	
//$cardnumber = $post['CardNo'];
	//$expirationdate = $post['CardExpDate'];
	//$securitycode = $post['CardCVV2'];
	$price = $post['sumPrice'];
	$extras = $post['extras'];
	

    $meta = $childspackages;
    $decoded = json_decode(urldecode($meta));
    $childspackages_raw = '';


    if($decoded){
	  updateSlots($decoded,$childnum);	
      foreach ($decoded as $child) {
        //var_dump($child);
        $childspackages_raw .= $child->child . ' (' . $child->birthday . '): ' . $child->package . '; '; 
      }
    }

    $check_decoded = json_decode(urldecode($checklist));
    $checklist_raw = '';

    if($check_decoded){
      foreach ($check_decoded as $child) {
        //var_dump($child);
        $checklist_raw .= $child->child . ' (' . $child->birthday . '): ' . $child->checklist . '; '; 
      }
    }	

    $extras = $extras;
    $qnt = $quantity;

    $extras_raw = '';

    //var_dump($extras);

    $counter = 0;
    foreach($qnt as $key=>$q){
	 	 if($q > 0){
      $extras_raw .= $q.' x ' . $extras[$counter] . '; ';
      $counter ++;
	   }
    }

	$approve = $post['approve'];
	
	$args = array('package'=>$package,'childname'=>$childname,'childspackages'=>$childspackages,'bday'=>$bday,'age'=>$age,'mothername'=>$mothername,'fathername'=>$fathername,'email'=>$email,'address'=>$address,'name'=>$name,'approve'=>$approve,'price'=>$price,'note'=>$note);
	
	//var_dump($args['childspackages']);

	$args2 = array(array('meta_query'=>array('meta_key'=>'email','meta_value'=>$args['email'])),'post_status'=>'publish');
	$check =  new WP_Query($args2);

	$results = $wpdb->get_results('SELECT * FROM wp_postmeta WHERE meta_key = "email" AND meta_value = "' . $args['email'] . '" ');

	$hasPass = false;
	//var_dump($check->query_vars);
	if($results){
		$hasPass = true;
	}

	$postId = wp_insert_post( array(
		'post_title'    => $args['email'] . ' - ' . $args['package'][0],
		'post_type'     => 'bookings',
		'post_status'	=> 'publish',
		'meta_input'    => array(
			'packages'  => $args['package'],
			'childname' => $args['childname'],
			'childspackages' => $args['childspackages'],
			'childspackages_raw' => $childspackages_raw,
			'checklist'	=> $checklist,
			'checklist_raw'	=> $checklist_raw,
			'extras_raw' => $extras_raw,
			'extras'	=> $extras,
			'price'		=> $args['price'],
			'bday' 		=> $args['bday'],
			'phone'		=> $phone,
			'age'		=> $args['age'],
			'email'		=> $args['email'],
			'mothername'=> $args['mothername'],
			'fathername'=> $args['fathername'],
			'address'   => $args['address'],
			'name'	=> $args['name'],
			'pay_status' => $_POST['ReasonCodeDesc'],
			'note' => $args['note'],
			'extras_quantity' => $quantity,
			'dial' => $dial
			)
		) 
	);
	 	
	//var_dump($hasPass);
	return ['postId'=>$postId,'hasPass'=>$hasPass];
	//include 'front/thankyou.php';
}

add_action( 'admin_post_nopriv_registerBooking', 'registerBooking' );
add_action( 'admin_post_registerBooking', 'registerBooking' );

function updateSlots($packages,$childnum){
	if(is_array($packages)){
		foreach ($packages as $p) {
			$post = get_page_by_title($p->package,'OBJECT','packages');
			$slots = get_post_meta($post->ID,'package_slots',true);
			//var_dump($slots);
			//var_dump($childnum);
			$new = (int)$slots - (int)$childnum;
			update_post_meta($post->ID,'package_slots',$new);
		}
	}
}

function savePostToSession(){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if(isset($_POST['recaptcha_response'])) {

	    // Build POST request:
	    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	    $recaptcha_secret = '6Lft2v8UAAAAAL-9COkuKQHvUFzA50dTFl6elbSc';
	    $recaptcha_response = $_POST['recaptcha_response'];

	    // Make and decode POST request:
	    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
	    $recaptcha = json_decode($recaptcha);

	    // Take action based on the score returned:
	    if ($recaptcha->score >= 0.5) {
			$posts = $_POST['posts'];

			$_SESSION['post'][$_SERVER['REMOTE_ADDR']] = $posts;
			$_SESSION['childs'][$_SERVER['REMOTE_ADDR']] = $_POST['childs'];
			$_SESSION['checklist'][$_SERVER['REMOTE_ADDR']] = $_POST['checklist'];
	    	return true;
	    } else {
	    	return false;
	        // Not verified - show form error
	    }
		//var_dump($_POST['childspackages']);
	}
	else{
		return false;
	}
}
add_action( 'wp_ajax_nopriv_savePostToSession', 'savePostToSession' );
add_action( 'wp_ajax_savePostToSession', 'savePostToSession' );

function discountPrice(){
	$price = $_POST['price'];
	$childs_num = $_POST['childs_num'];
	$total_packages_num = $_POST['packages_num'];
	$childspackages = $_POST['childspackages'];
	$promoCode = $_POST['promoCode'];
	
	
	$athlete_pid = getAthleteID();
	$user_pid = $_POST['user_pid'];

	
	
		$package_discount = 0;
		$childs_discount = 0;
		$price = 0;
		$temp_price = 0;
		$orig_price = 0;
		$child1 = 0;
		$childsarray = [];



		//$first_kid_price = 0;

		foreach($childspackages as $key=>$childpackage){
			$childindex = $childpackage['childindex'];

			$package_num = array_count_values( array_column($childspackages,'childindex') )[$childindex];

			//var_dump($childspackages);
			//var_dump(array_column($childspackages,'childindex'));
			//var_dump($package_num);


			$packageprice = $childpackage['price'];



			if($childindex == 0){ //first kid
				$sum_discount = discountPackages($packageprice,$package_num);

				$childsarray[$childindex] = $childsarray[$childindex] + ($packageprice - (( $packageprice / 100 ) * $sum_discount) );

			}

			if($childindex > 0){
				$sum_discount = discountPackages($packageprice,$package_num);
				$temp_price = $packageprice - (( $packageprice / 100 ) * $sum_discount ); //first kid discount


				$childsarray[$childindex] = $childsarray[$childindex] + ($temp_price - (( $temp_price / 100 ) * 5 ) ); //5% discount
			}

			$sum_total = discountPackages($packageprice,$package_num);


			$orig_price = $orig_price + ($packageprice - (( $packageprice / 100 ) * $sum_total) );
		}


		foreach($childsarray as $childs){
			$price = $price + $childs;
		}


		//$sum_discount = $package_discount;
		//$price = $price - ( ($price / 100) *  $sum_discount);
	
	//var_dump($promoCode);
	
	$coupon = checkCoupon($promoCode,$price);


	if($coupon){
		$price = $coupon;
	}

	if($athlete_pid == $user_pid){
		$price = discountMembers($orig_price);
	}

	// else if($childindex > 0){ //if more then one child
	// 	//$childs_discount = discountChilds($packageprice);
	// 	$price = $price - ( ($price / 100) * 5 );

	// }

	echo json_encode(array('price'=>$price));
	die();
}
add_action( 'wp_ajax_nopriv_discountPrice', 'discountPrice' );
add_action( 'wp_ajax_discountPrice', 'discountPrice' );

function logOut(){
	unset($_SESSION['email'][$_SERVER['REMOTE_ADDR']]);
	unset($_SESSION['password'][$_SERVER['REMOTE_ADDR']]);
}
add_action( 'wp_ajax_nopriv_logOut', 'logOut' );
add_action( 'wp_ajax_logOut', 'logOut' );

function discountPackages($price,$packages_num,$childindex=0){
	$discount = 0;

	if($packages_num == 4){
		$discount = 5;
		$price = $price - ( ($price / 100) * 5 ); //10%
	}
	else if($packages_num >= 5){
		$discount = 10;
		$price = $price - ( ($price / 100) * 10 ); //15%
	}
	else{
		$price = $price;
		$discount = 0;
	}
	return $discount;	
}

// function discountPackagesOneChild($price, $packages_num){
// 	$discount = 0;

// 	if($packages_num == 4){
// 		$discount = 10;
// 		$price = $price - ( ($price / 100) * 5 ); //10%
// 	}
// 	else if($packages_num >= 5){
// 		$discount = 15;
// 		$price = $price - ( ($price / 100) * 10 ); //15%
// 	}
// 	else{
// 		$price = $price;
// 		$discount = 0;
// 	}
// 	return $discount;		
// }

function discountChilds($price){
	$new_price = $price - ( ($price / 100) * 5 );
	$discount = 5;
	return $discount;
}

function discountMembers($price){
	$new_price = $price - ( ($price / 100) * 10 ); //10% discount for athletes

	return $new_price;
}

function checkCoupon($promo,$price){
	global $wpdb;

	$new_price = false;

	$args = array(
		'post_type' => 'wpcd_coupons');
	$post = get_posts($args);
	
	$hasCoupon = false;

	foreach($post as $coupon){
		$code = get_post_meta($coupon->ID, 'coupon_details_coupon-code-text')[0];
		//var_dump($meta);
		$discount = get_post_meta($coupon->ID, 'coupon_details_discount-text')[0];

		$expire_date = get_post_meta( $coupon_id, 'coupon_details_expire-date', true );

		$today = date('d-m-Y');

		$discount = str_replace('%', '', $discount);
		//var_dump($discount);

		if($promo == $code){
			$hasCoupon = true;

			$new_price = $price - ( ($price / 100) * $discount ); //10% discount for athletes

			break;
		}
	}


	
	return $new_price;	
}

function getAthleteID(){
	global $wpdb;

	$args = array(
		'post_type' => 'athletes');
	$post = get_posts($args)[0];

	$meta = get_post_meta($post->ID, 'athlete_id');

	
	return $meta[0];
}

function formatPrice(){
	$price = $_POST['price'];

	//Version
	$version = "1.0.0";
	//Merchant ID
	$merchantID = "0097883011";
	//Acquirer ID
	$acquirerID = "402971";
	$orderID = "TestOrder".rand(0,1000);
	$captureFlag = "A";
	$currency = 978;

	//Password
	$password = "s6iXrTPN";
	$purchaseAmt = str_pad($price, 13, "0", STR_PAD_LEFT);

	$formattedPurchaseAmt = substr($purchaseAmt,0,10).substr($purchaseAmt,11);

	$toEncrypt = $password.$merchantID.$acquirerID.$orderID.$formattedPurchaseAmt.$currency;
	//Produce the hash using SHA1
	//This will give b14dcc7842a53f1ec7a621e77c106dfbe8283779
	$sha1Signature = sha1($toEncrypt);
	//Encode the signature using Base64 before transmitting to JCC
	//This will give sU3MeEKlPx7HpiHnfBBt++goN3k=
	$base64Sha1Signature = base64_encode(pack("H*",$sha1Signature));

	echo json_encode(array('price'=>$formattedPurchaseAmt,'signature'=>$base64Sha1Signature,'orderid'=>$orderID));
	die();
}
add_action( 'wp_ajax_nopriv_formatPrice', 'formatPrice' );
add_action( 'wp_ajax_formatPrice', 'formatPrice' );

function loginUser(){
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(isset($_POST['login'])){
		unset($_SESSION['email'][$_SERVER['REMOTE_ADDR']]);
		unset($_SESSION['password'][$_SERVER['REMOTE_ADDR']]);
		$_SESSION['email'][$_SERVER['REMOTE_ADDR']] = $_POST['email'];
		$_SESSION['password'][$_SERVER['REMOTE_ADDR']] = $_POST['password'];

		wp_redirect( home_url( '/account' ) );
	}
}

add_action( 'admin_post_nopriv_loginUser', 'loginUser' );
add_action( 'admin_post_loginUser', 'loginUser' );

function responsePayment(){
	//var_dump($_POST);
}

add_action( 'admin_post_nopriv_responsePayment', 'responsePayment' );
add_action( 'admin_post_responsePayment', 'responsePayment' );

function sendMailToUser($post,$childs,$checklist,$postid,$hasPass,$pass){
  
  $packs_query = '';
  $extras_query = '';
  
  $message = '<p>Thank you for your reservation.</p>
  <table>
  <thead><th>Booking ID</th><th>Childs Packages</th><th>Extras</th><th>Childs Checklist</th><th>Price</th><th>Payment Status</th></thead>
  <tbody>
		<tr>
			<td>' . $postid . '</td>
			<td>';

				if(is_array($childs)){
					foreach($childs as $pack){
						$decoded = json_decode(urldecode($pack));
					    if($decoded){
					      foreach ($decoded as $child) {
					        //var_dump($child);
					        $message .= '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
					        $packs_query .= 'packages[]=' . $child->child . ' ('. $child->birthday . '): ' . $child->package . '&';
					      }
					    }
						//echo $pack . '<br/>';
					}
				} 
				else{
					$pack = $childs;
					$decoded = json_decode(urldecode($pack));
				    if($decoded){
				      foreach ($decoded as $child) {
				        //var_dump($child);
				        $packs_query .= 'packages[]=' . $child->child . ' ('. $child->birthday . '): ' . $child->package . '&';
				        $message .= '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
				      }
				    }
				}		
			$message .= '</td>
			<td>'; 
			$extras = $post['extras'];
		    $qnt = $post['quantity'];

		    //var_dump($extras);

		    $counter = 0;
		    foreach($qnt as $key=>$q){
			 	 if($q > 0){
			 	 	$extras_query .= 'extras[]=' . $q .' x ' . $extras[$counter] . '&';
		      		
		      		$message .= $q.' x ' . $extras[$counter] . '<br/>';
		      		$counter ++;
			  	 }
		    }		
			$message .= '</td>
			<td>';
				if(is_array($checklist)){
					foreach($checklist as $pack){
						$decoded = json_decode(urldecode($pack));
					    if($decoded){
					      foreach ($decoded as $child) {
					        //var_dump($child);
					        $message .= '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
					        // $packs_query .= 'packages[]=' . $child->child . ' ('. $child->birthday . '): ' . $child->checklist . '&';
					      }
					    }
						//echo $pack . '<br/>';
					}
				} 
				else{
					$pack = $checklist;
					$decoded = json_decode(urldecode($pack));
				    if($decoded){
				      foreach ($decoded as $child) {
				        //var_dump($child);
				        // $packs_query .= 'packages[]=' . $child->child . ' ('. $child->birthday . '): ' . $child->package . '&';
				        $message .= '<p><b>' . $child->child . '</b>: ' . $child->checklist.'</p>'; 
				      }
				    }
				}

			$message .= '<td>' . $post['sumPrice'] . '€</td>
			<td>' .  $_POST['ReasonCodeDesc'] . '</td>
		</tr>
	</tbody>
	</table>';

	//if(!$hasPass){
		$message .=
		'<p>Please keep either print or keep your pdf ticket safe and ensure you/your child can present it on the first day of camp. <br/>The ticket cannot be re-issued. A password has automatically been generated for your online overview.<br/><br/>
		Your password is: '.$pass.'<br/>
		Copy it, and save.<br/><br/>
		</p>';
	//}

	$message .= '<p>To check your booking overview please click <a href="https://summercamp.zaffasoft.com/account/" target="blank">here</a>.
		<br/>
		Thank you, <br/><br/>
		
		The LNC Team<br/>
		T: +35725318181<br/>
		E: info@limassolnauticalclub.com<br/>
		W: www. limassolnauticalclub.com</p>';

//php mailer variables
  $to = $post['email'];
  $subject = "Thank you for booking on our website.";
  $headers = 'From: noreply@summercamp.zaffasoft.com' . "\r\n" .
    'Reply-To: noreply@summercamp.zaffasoft.com' . "\r\n";
//$urlpack = http_build_query($childs);
//$urlextras = http_build_query($post['extras']);

//var_dump($packs_query);
//var_dump($extras_query);

$mother = $post['mothername'];
$father = $post['fathername'];

$html = file_get_contents(plugin_dir_url(__FILE__) . "front/pdftemplate.php?email=".$to.'&price='.$post['sumPrice'] . '&bookid='.$postid . '&father=' . $father . '&mother=' . $mother . '&' . $packs_query . $extras_query);




// instantiate and use the dompdf class
$dompdf = new Dompdf();



$dompdf->loadHtml($html);

$dompdf->set_option('isRemoteEnabled', TRUE);


// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();
//$dompdf->get_canvas()->get_cpdf()->setEncryption("123", "123");

// Output the generated PDF to Browser
$output = $dompdf->output();

$r1 = rand(0,1000000);
$r2 = rand(0,1000000);
$r3 = rand(0,1000000);

$path = plugin_dir_path(__FILE__) . 'document'.$r1.$r2.$r3.'.pdf';

file_put_contents($path, $output);

//Here put your Validation and send mail
$sent = wp_mail($to, $subject, $message, $headers,$path);
      if($sent) {
      	//echo 'sent';
      }//message sent!
      else  {

      }//message wasn't sent
unlink($path);

}

function sendMailToAdmin($post,$childs,$postid){
  $message = '<p>New reservation on website from ' . $post['email'] . '.</p>
  <table>
  <thead><th>Booking ID</th><th>Childs Packages</th><th>Extras</th><th>Price</th><th>Payment Status</th></thead>
  <tbody>
		<tr>
			<td>' . $postid . '</td>
			<td>';
				if(is_array($childs)){
					foreach($childs as $pack){
						$decoded = json_decode(urldecode($pack));
					    if($decoded){
					      foreach ($decoded as $child) {
					        //var_dump($child);
					        $message .= '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
					      }
					    }
						//echo $pack . '<br/>';
					}
				} 
				else{
					$pack = $childs;
					$decoded = json_decode(urldecode($pack));
				    if($decoded){
				      foreach ($decoded as $child) {
				        //var_dump($child);
				        $message .= '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
				      }
				    }
				}		
			$message .= '</td>
			<td>'; 
			$extras = $post['extras'];
		    $qnt = $post['quantity'];

		    //var_dump($extras);

		    $counter = 0;
		    foreach($qnt as $key=>$q){
			 	 if($q > 0){
		      		$message .= $q.' x ' . $extras[$counter] . '<br/>';
		      		$counter ++;
			  	 }
		    }		
			$message .= '</td>
			<td>' . $post['sumPrice'] . '€</td>
			<td>' .  $_POST['ReasonCodeDesc'] . '</td>
		</tr>
	</tbody>
	</table>
  ';



  $email = $post['email'];
//php mailer variables
  $to = get_option('admin_email');
  $subject = "You have new booking on website...";
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

//Here put your Validation and send mail
$sent = wp_mail($to, $subject, $message, $headers);
      if($sent) {
      	//echo "sent";
      }//message sent!
      else  {

      }//message wasn't sent


}
?>