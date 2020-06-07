<!-- <form method="post" name="paymentForm" id="paymentForm"
action="https://tjccpg.jccsecure.com/EcomPayment/RedirectAuthLink"> -->
<input type="hidden" name="Version" value="<?= $version?>"><input
type="hidden" name="MerID" value="<?= $merchantID?>"><input
type="hidden" name="AcqID" value="<?= $acquirerID?>"><input
type="hidden" name="MerRespURL" value="<?= $responseURL ?>">
<input type="hidden" class="PurchaseAmt" name="PurchaseAmt" value="000000002500">
<input type="hidden" name="PurchaseCurrency" value="<?= $currency?>">
<input type="hidden" name="PurchaseCurrencyExponent" value="<?= $currencyExp?>">
<input type="hidden" class="orderid" name="OrderID" value="<?= $orderID?>">
<input type="hidden" name="CaptureFlag" value="<?= $captureFlag?>"><input
type="hidden" class="signature" name="Signature" value="<?= $base64Sha1Signature?>"><input
type="hidden" name="SignatureMethod" value="<?= $signatureMethod?>">
<!-- Text fields for customer to enter his credit card details 
<table>
<tr>
<td>Credit Card Number:</td>
<td><input type="text" name="CardNo"></td>
</tr>
<tr>
<td>
Expiration Date:<br>
Please enter in format MMYY, e.g:<br>
if card expires in November (11) of 2012 please enter 1112)
</td>
Instead of Text box, Select fields could be used instead for a more user
friendly form
<td><input type="text" name="CardExpDate"></td>
</tr>
<tr>
<td>CVV Code:</td>
<td><input type="text" name="CardCVV2"></td>
</tr>
</table>
<button type="submit" name="submitPaymentButton"></button>
</form> -->