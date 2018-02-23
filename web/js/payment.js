$(document).ready(function(){
	var paymentMode = $('#salesbundle_payment_paymentMode').val();

	checkPaymentMode(paymentMode);

	$('#salesbundle_payment_paymentMode').on('change', function() {
		paymentMode = $(this).val();
		
		checkPaymentMode(paymentMode);
	})

	function checkPaymentMode(paymentMode)
	{
		if (paymentMode == 'BDO') {
			$('#salesbundle_payment_cardNumber').parent().show();
			$('#salesbundle_payment_expirationDate').parent().show();

			$('#salesbundle_payment_referenceNumber').parent().hide();
		} else if (paymentMode == 'Cebuana') {
			$('#salesbundle_payment_referenceNumber').parent().show();

			$('#salesbundle_payment_cardNumber').parent().hide();
			$('#salesbundle_payment_expirationDate').parent().hide();
		} else {
			$('#salesbundle_payment_cardNumber').parent().hide();
			$('#salesbundle_payment_expirationDate').parent().hide();
			
			$('#salesbundle_payment_referenceNumber').parent().hide();
		}
	}
})