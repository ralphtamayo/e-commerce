$(document).ready(function(){
    var paymentMode = $('#salesbundle_payment_paymentMode').val();

    $('#salesbundle_payment_referenceNumber').parent().hide();

    $('#salesbundle_payment_paymentMode').on('change', function() {
        paymentMode = $(this).val();
        
        console.log(paymentMode);
        if (paymentMode == 'BDO') {
            $('#salesbundle_payment_cardNumber').parent().show();
            $('#salesbundle_payment_expirationMonth').parent().show();
            $('#salesbundle_payment_expirationYear').parent().show();

            $('#salesbundle_payment_referenceNumber').parent().hide();
        } else {
            $('#salesbundle_payment_referenceNumber').parent().show();

            $('#salesbundle_payment_cardNumber').parent().hide();
            $('#salesbundle_payment_expirationMonth').parent().hide();
            $('#salesbundle_payment_expirationYear').parent().hide();
        }
    })
})