
<form id="booksys" name="paymentForm" id="paymentForm"
action="" method="POST"> <!-- action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">-->
<input type="hidden" name="sumChildsPackages" id="sumChildsPackages" value="">
<input type="hidden" name="dial" id="dial" value="">

<div id="account-track">
<ul> 
	<li><a href="/account">Log in</a></li>
	<li><a href="/">Register</a></li>
</ul>
</div>
<div id="firstStep" class="step step-1">
	<div class="step-header">
		<h4>Enter child's name and choose packages.</h4>
		<p>All fields are required <span class="alert">*</span></p>
	</div>
	<div class="step-content">
		<div id="child_box">
			<div class="child_row">
				<input name="childname[]" class="childname required" type="text" placeholder="Child's full name" />
				
				<input type="text" class="required bday" placeholder="Date of Birth" name="bday[]" /><i class="fas fa-calendar-alt"></i><br/>
				<label><b>Child Packages</b></label>
				<div class="packages-wrapper">
					<?php foreach($packages as $package) : ?>
						<?php $price = get_post_meta($package->ID,'package_price',true); ?>
						<?php $slots = get_post_meta($package->ID,'package_slots',true); ?>

						<div class="check-row">
							<input type="checkbox" name="childspackages[]" id="checkbox<?= $package->ID ?>" class="required css-checkbox packages <?php if ($slots == 0): ?> disabled <?php endif; ?>" data-id="<?= $package->ID ?>" data-price="<?= $price ?>" value="<?= $package->post_title ?>" <?php if ($slots == 0): ?> disabled <?php endif; ?>/>
							<label class="label-container css-label" for="checkbox<?= $package->ID ?>"></label> 
							<span class="check-desc"><?= $package->post_title ?> <span style="">(Available <?= $slots ?> slots)</span></span>
						</div> 
					<?php endforeach; ?>
				</div>
				<div class="price-wrapper">
					<p><span>Registration fee: </span><span class="price-fee">25€</span></p>
					<p><span>Package: </span><span class="price-package">0€</span></p>
					<p><span>Extras: </span><span class="price-extras">0€</span></p>
					<p><span>Total: </span><span class="price-live"><b>25€</b></span></p>
				</div>

				<div class="accordion-checklist">
					<h6><i class="fas fa-user-plus"><?php echo do_shortcode('[wp-svg-icons icon="plus" wrap="i"]'); ?></i> Fill in your child's medical checklist</h6>
				</div>
				<div class="accordion-checklist-box hide">
				<div class="check-marks">
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist1" class="css-checkbox checklist required" data-id="checklist1" value="Diabetes" />
					<label class="label-container css-label" for="checklist1"></label> 
					<span class="check-desc">Διαβήτης / Diabetes</span>
					</br>
					</div>
					
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist2" class="css-checkbox checklist required" data-id="checklist2" value="Asthma" />
					<label class="label-container css-label" for="checklist2"></label> 
					<span class="check-desc">Άσθμα / Asthma</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist3" class="css-checkbox checklist required" data-id="checklist3" value="Anemia" />
					<label class="label-container css-label" for="checklist3"></label> 
					<span class="check-desc">Αναιμία / Anemia</span>
						</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist4" class="css-checkbox checklist required" data-id="checklist4" value="Epilepsy" />
					<label class="label-container css-label" for="checklist4"></label> 
					<span class="check-desc">Επιληψία / Epilepsy</span>
						</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist5" class="css-checkbox checklist required" data-id="checklist5" value="Eating disorder" />
					<label class="label-container css-label" for="checklist5"></label> 
					<span class="check-desc">Διατροφική διαταραχή / Eating disorder</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist6" class="css-checkbox checklist required" data-id="checklist6" value="Heart problems" />
					<label class="label-container css-label" for="checklist6"></label> 
					<span class="check-desc">Καρδιακό πρόβλημα / Heart problems</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist7" class="css-checkbox checklist required" data-id="checklist7" value="Chest pain?" />
					<label class="label-container css-label" for="checklist7"></label> 
					<span class="check-desc">Πόνοι στο στήθος; / Chest pain?</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist8" class="css-checkbox checklist required" data-id="checklist8" value="Fainting or dizziness" />
					<label class="label-container css-label" for="checklist8"></label> 
					<span class="check-desc">Τάσεις λιποθυμίας ή επεισόδια ζαλάδας; / Fainting or dizziness?</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist9" class="css-checkbox checklist required" data-id="checklist9" value="Any bone problems, that could be aggravated by exercising" />
					<label class="label-container css-label" for="checklist9"></label> 
					<span class="check-desc">Πρόβλημα με οστα/συνδέσμους που μπορεί να επιδεινωθεί με την άσκηση; / Any bone/joint problems, that could be aggravated by exercising?</span>
					</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist10" class="css-checkbox checklist required" data-id="checklist10" value="Receiving any type of medication" />
					<label class="label-container css-label" for="checklist10"></label> 
					<span class="check-desc">Λαμβάνεται φαρμακευτική αγωγή; | Receiving any type of medication?</span>
					
						</br>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist11" class="css-checkbox checklist required" data-id="checklist11" value="Other" />
					<label class="label-container css-label" for="checklist11"></label> 
					<span class="check-desc">Άλλο / Other</span></br>
					<textarea cols="10" class="" rows="20" name="checklist[]" placeholder="Other"></textarea>
					</div>
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist12" class="css-checkbox checklist required" data-id="checklist12" value="None of the above" />
					<label class="label-container css-label" for="checklist12"></label> 
					<span class="check-desc">Κανένα από τα πιο πάνω / None of the above</span>
					</div>
				</div>
			</div>
			
			<div class="accordion-checklist">
					<h6><i class="fas fa-user-plus"><?php echo do_shortcode('[wp-svg-icons icon="plus" wrap="i"]'); ?></i> Fill in COVID-19 checklist</h6>
				</div>
				<div class="accordion-checklist-box hide covid19-checklist-loop">
				<div class="check-marks">
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist13" class="css-checkbox checklist required" data-id="checklist13" value="Does your child have any Covid-19 symptoms? (fever, cough, difficulties breathing)" />
					<label class="label-container css-label" for="checklist13"></label> 
					<span class="check-desc">Το παιδί σας έχει οποιαδήποτε συμπτώματα Covid-19? (πυρετό, βήχα, δύσπνοια) / Does your child have any Covid-19 symptoms? (fever, cough, difficulties breathing)</span>
					</div>
					
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist14" class="css-checkbox checklist required" data-id="checklist14" value="Has he/she recently returned from a travel?" />
					<label class="label-container css-label" for="checklist14"></label> 
					<span class="check-desc">Έχει πρόσφατα ταξιδέψει? | Has he/she recently returned from a travel?</span>
					</div>
					
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist15" class="css-checkbox checklist required" data-id="checklist15" value="Has he/she recently returned from a travel?" />
					<label class="label-container css-label" for="checklist15"></label> 
					<span class="check-desc">Έχει έρθει σε στενή επαφή με ύποπτο ή επιβεβαιωμένο κρούσμα Covid-19? | Has he/she come in contact with a suspicious or confirmed Covid-19 case?</span>
					</div>
					
					<div class="check-row">
					<input type="checkbox" name="checklist[]" id="checklist16" class="css-checkbox checklist required" data-id="checklist16" value="None of the above" />
					<label class="label-container css-label" for="checklist16"></label> 
					<span class="check-desc">Κανένα από τα πιο πάνω  | None of the above</span>
					</div>
					

					</div>
</div>
	</div>
	</div>
		<div style="width:100%;overflow:auto;">
			<i class="fas fa-user-minus hide" id="remove_child"><?php echo do_shortcode('[wp-svg-icons icon="minus" wrap="i"]'); ?> Remove Child</i>
			<i class="fas fa-user-plus" id="add_child"><?php echo do_shortcode('[wp-svg-icons icon="plus" wrap="i"]'); ?> Add Child</i>
		</div></br><div style="font-size:10px;"><strong>*IMPORTANT NOTE:</strong> Please add additional child ONLY if they are siblings . Bookings made for children
who are not brothers/sisters will be cancelled and no place at the summer camp will be guaranteed!</div>
	</div>
	<div class="step-footer">
		<div class="book-control">
			<div class="prev-box">&nbsp;</div>
			<div class="center-box"><span class="step-state">1 of 4</span></div>
			<div class="next-box"><a href="step-2" class="move-next"><?php echo do_shortcode('[wp-svg-icons icon="arrow-right" wrap="i"]'); ?></a></div>
		</div>
	</div>
</div>


<div id="secondStep" class="step step-hidden step-2">
	<div class="step-header">
		<h4>Enter parents details.</h4>
		<p>All fields are required <span class="alert">*</span></p>
	</div>
	<div class="step-content">
		<input name="fathername" class="required" type="text" placeholder="Father's/Guardian's name" />
		<input name="mothername" class="required" type="text" placeholder="Mother's/Guardian's name" />

		<input name="email" class="required" type="email" placeholder="Email" pattern=".+@globex.com" />
		<input name="phone" id="phone" class="required form-control" placeholder="(201) 555-0123" type="tel" />
		<textarea cols="10" class="" rows="20" name="address" placeholder="Address"></textarea>
	</div>
	<div class="step-footer">
		<div class="book-control">
			<div class="prev-box"><a href="step-1" class="move-back"><?php echo do_shortcode('[wp-svg-icons icon="arrow-left" wrap="i"]'); ?></a></div>
			<div class="center-box"><span class="step-state">2 of 4</span></div>
			<div class="next-box"><a href="step-3" class="move-next"><?php echo do_shortcode('[wp-svg-icons icon="arrow-right" wrap="i"]'); ?></a></div>
		</div>
	</div>
</div>

<div id="thirdStep" class="step step-hidden step-3">
	<div class="step-header">
		<h4>Choose extra features</h4><span style="font-size:12px;">(for each registration you will receive a complimentary T-shirt & cap, below you can order <strong style="text-decoration:underline;">extra</strong> caps or tshirts / με κάθε εγγραφή λαβάνετε ένα δωρεάν μπλουζάκι και καπελάκι, πιο κάτω μπορείτε να παραγγείλετε <strong style="text-decoration:underline;">επιπλέον</strong> μπλουζάκια ή καπελάκια)</span>
	</div>
	<div class="step-content">
		<div class="packages-wrapper">
	<?php //foreach($packages as $package) : ?>
		<?php 
		$terms = get_terms([
	    	'taxonomy' => 'extras',
	    	'hide_empty' => false,
		]);
		if(is_array($terms)){
		foreach($terms as $term){
			$t_id = $term->term_id;
			$term_meta = get_option( "taxonomy_$t_id" ); 
			
			$price = $term_meta['price_term_meta'];
			?>
						<div class="check-row">
							<div class="check-marks">
								<input type="checkbox" name="extras[]" id="checkbox<?= $t_id ?>" class="css-checkbox extras" data-id="<?= $t_id ?>" data-price="<?= $price ?>" value="<?= $term->name ?> <?= $price ?>€" />
								<label class="label-container css-label" for="checkbox<?= $t_id ?>"></label> 
								<span class="check-desc"><?= $term->name; ?> <span class="extra-price"><?= $price ?>€</span></span>
							</div>
							<div class="quantity-box">
							    <input type='button' value='-' class='qtyminus' field='quantity[]' />
							    <input type='text' name='quantity[]' value='0' class='qty' />
							    <input type='button' value='+' class='qtyplus' field='quantity[]' />
							</div>
						</div>			
			<?php
		}
		}
		?>
	</div>
					<div class="price-wrapper">
					<p><span>Registration fee: </span><span class="price-fee">25€</span></p>
					<p><span>Package: </span><span class="price-package">0€</span></p>
					<p><span>Extras: </span><span class="price-extras">0€</span></p>
					<p><span>Total: </span><span class="price-live"><b>25€</b></span></p>
				</div>
	<?php //endforeach; ?>
	</div>
	<div class="step-header">
		<h4 style="margin-top: 50px !important;">Enter promo code or your ID if you are our member.</h4>
	</div>
	<div class="step-content">
	

		<p> 
			<input class="promo" name="promo" id="promo" type="text" placeholder="Promo code">
			<button id="promo-cta" class="promo-cta">Apply</button>
		</p>
		<p>
		<input type="text" class="promo" name="user_pid" id="user_pid" value="" placeholder="Member ID">
		<button class="promo-cta" id="member-cta">Apply</button>
		</p>
	</div>
	<div class="step-footer">
		<div class="book-control">
			<div class="prev-box"><a href="step-2" class="move-back"><?php echo do_shortcode('[wp-svg-icons icon="arrow-left" wrap="i"]'); ?></a></div>
			<div class="center-box"><span class="step-state">3 of 4</span></div>
			<div class="next-box"><a href="step-4" class="move-next"><?php echo do_shortcode('[wp-svg-icons icon="arrow-right" wrap="i"]'); ?></a></div>
		</div>
	</div>
</div>
<div id="fifthStep" class="step step-hidden step-4">
	<div class="step-header">
		<h4>Summary</h4>
	</div>
	<div id="summaryBox">
		<div id="choosenPackages">Choosen packages: <span></span></div>
		<div id="choosenExtras">Choosen extras: <span></span></div>
		<div id="childsMother">Mother: <span></span></div>
		<div id="childsFather">Father: <span></span></div>
		<div id="userEmail">Email: <span></span></div>
		<div id="userPhone">Phone: <span></span></div>
		<div id="userAddress">Address: <span></span></div>
		<div id="userChecklist">Your checklist: <span></span></div>
		<div id="packPrice">Packages price: <span></span></div>
		<div id="extrasPrice">Extras price: <span></span></div>
		<div id="feePrice">Registration fee: <span><u>25€</u></span></div>
		<div id="totalBox">Total price: <span id="totalMoney"><b>25€</b></span></div>

		<textarea name="note" cols="10" rows="20" placeholder="TEAMMATES: If you wish your child(ren) to be in the same team with a friend/relative please provide
the full name and a contact number of the child here. If you do not provide this information at
registration we will not be able to assist you. *Please note: children should be of same age"></textarea></br>
<div style="font-size:10px"><strong>*IMPORTANT NOTE:</strong> We understand that children like to have their friends/relatives as teammates and
we do try our best to meet your requests. However, please bear in mind that due to age difference and
the amount of requests we cannot always fulfill 100% of them. We kindly ask all parents/guardians to
understand this and explain it to their children. Thank you for collaborating on this matter.</div>
	</div>
	<br/>
	<div class="check-row">
		<input type="checkbox" id="checkbox-approve" class="css-checkbox" data-id="checkbox-approve" name="approve" />
		<label for="checkbox-approve" class="css-label"></label>
		<a href="https://summercamp.zaffasoft.com/wp-content/uploads/2020/02/TERMs_CONDITIONS_2020.pdf" target="_blank">Accept terms and conditions</a>
		
	</div>
	<div class="check-row">
		<input type="checkbox" id="checkbox-gdpr" class="css-checkbox" data-id="checkbox-gdpr" name="gdpr" />
		<label for="checkbox-gdpr" class="css-label"></label>
		<a href="https://summercamp.zaffasoft.com/wp-content/uploads/2020/02/GDPR_Policy_2020.pdf" target="_blank">Accept GDPR policy</a>
		
	</div>


	
	<div class="check-row">
		<input type="checkbox" id="checkbox-covid" class="css-checkbox" data-id="checkbox-covid" name="covid19" />
		<label for="checkbox-covid" class="css-label"></label>
		<a href="https://tickets.limassolnauticalclub.com/wp-content/uploads/2020/05/covid19.pdf" target="_blank">Accept COVID-19 policy</a>
		
	</div>
	
	<div style="text-align: center;width: 100%;"> 
		
		<input type="hidden" name="action" value="savePostToSession">
		<input type="hidden" name="sumPrice" id="sumPrice" value="25">
	<input type="submit" id="complete" Name="submitPaymentButton" value="Complete and Pay" />
	<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
	</div>
	
	<div class="step-footer">
		<div class="book-control">
			<div class="prev-box"><a href="step-3" class="move-back"><?php echo do_shortcode('[wp-svg-icons icon="arrow-left" wrap="i"]'); ?></a></div>
			<div class="center-box"><span class="step-state">4 of 4</span></div>
			<div class="next-box">&nbsp;</div>
		</div>
	</div>
</div>


</form>

<form method="POST" name="paymentForm" id="paymentJCC">
	<?php payment(); ?>

	<input type="submit" class="hide" id="complete" Name="submitPaymentButton" value="Complete and Pay" />

</form>