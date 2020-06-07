<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		body{
			margin:0;
		}
		.page{
			max-width: 100%;
			margin: 0 auto;
		}
		.cover{
			width: 100%;
		}
		.cover img{
			width: 100%;
			height: auto;
		}

		.page-header{
			margin-top: 20px;
		}

		.header-logo{
			max-width: 180px;
			display: inline-block;
			vertical-align: middle;
		}
		.header-info{
			display: inline-block;
			
			margin-left: 20px;
		}
		.header-logo img{
			width: 100%;
		}
		.page-info{
			margin-top: 10px;
		}
		.page-content{
			margin-top: 15px;
		}
/*		.page-content p{
			font-size: 12px;
		} */
		.header-info p, .page-info p{
			margin: 1px 0px;
			font-size: 14px;
		}

		.page-footer{
			width:100%;
			position: absolute;
			bottom: 0;
			margin-top: 15px;
		}

		.page-footer img{
			width: 100%;
		}
		.info-social span img {
    		max-width: 20px;
		}

		.info-social span{
			color:#0f1e6f;
		}

		.footer-info p{
			font-size: 16px;
			margin:0;
			color: #0f1e6f;
		}

		span.insta *, span.fb * {
    		vertical-align: middle;
		}

		.fb{
			margin-left: 20px;
		}
	</style>
</head>
<body>
<div class="page">
	<div class="cover">
		<img class="nautical-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/nautical-cover.jpg"/>
		<img class="sponsors-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/sponsors-cover.jpg"/>
	</div>
	<div class="page-header">
		<div class="header-logo"><img class="nautical-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/logo-header.png"/></div>
		<div class="header-info">
			<p>LNC Summer Camp 2020 <span style="position: absolute; left: 75%; top: 290px;"><strong>Booking ID: #<?= $_GET['bookid'] ?></strong></span></p>
			<p>
			
			
			<?php 
			if(empty($_GET['packages'])) echo '';
			else {
			foreach ($_GET['packages'] as $package) {
				echo $package . '<br/>';
			} 
			} ?>
			
			
			
	<?php
if(empty($_GET['extras'])) echo '';
else {
foreach ($_GET['extras'] as $extra) {
echo $extra . '<br/>';
}

} ?>
			
			
			
			
			
			
			
			
			</p>
			<p>Price: <?= $_GET['price'] ?>€</p>
		</div>
	</div>
	<div class="page-info">
		<p>Name: <?= $_GET['father'] ?> <?= $_GET['mother'] ?></p>
		
	</div>
	<div class="page-content"><span style="font-size: 12px; position: absolute; display: block;">
		<p><b>COPY OF TERMS & CONDITIONS</b> (As agreed during registration)</p>
		<p>
		Please check your booking for any mistakes and inform LNC within 24 hours<br/>
		The booking is only valid for the person(s) registered on this ticket<br/>
		- Cancellations, ticket transfer and refunds are not allowed<br/>
		- Reselling tickets is strictly forbidden<br/>
		- Please ensure that you/your child can present the ticket (digital or hard copy) on arrival<br/>
		- Children are expected to arrive between 07:25 – 08:00 a.m. and be picked up by 13:15 p.m..<br/>
		The LNC has the right to refuse entry to latecomers.<br/>
		- Unless stated otherwise, this ticket does not include meals/drinks.<br/>
		Please ensure your child has all the necessary meals/drinks until pick-up time!<br/>
		- Children are not allowed to carry sharp objects, glass bottles, flammable materials and other dangerous<br/>
		or sharp objects.<br/>
		- Smartphones are not permitted!<br/>
		- All children have to comply with the instructions of the LNC staff. LNC has the right to banish participants<br/>
		that refuse to comply and obstruct the operation of the summer camp.<br/>
		- Ticket holders consent to filming and sound recording as participants of the Summer Camp.<br/>
		Photographs/Video taken will be used for promotion.</p></span>
	</div>
	<div class="page-footer">
		<div class="footer-info" style="position: inherit; display: block; margin-left: 30%; margin-right: auto; top: 30px;"><span style="font-size:12px;">
			<p class="info-1" style="font-size:12px;">For info/questions regarding the Summer Camp please contact:</p>
			<p class="info-2" style="font-size:12px;">Tel: 25 318181 | Email: info@limassolnauticalclub.com</p>
			<div class="info-social">
				<span class="insta">
					<img class="insta-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/insta_z.png"/>
					<span class="insta-msg">@limassolnauticalclub</span>
				</span>
				<span class="fb">
					<img class="fb-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/fb_z.png"/>
					<span class="fcb-msg">facebook.com/NOLimassol</span>
				</span>
			</div>
		</div>
		<img class="footer-img" src="http://summercamp.zaffasoft.com/wp-content/plugins/booksys/resources/footer.jpg"/>		
	</div>
</div></span>
</body>
</html>