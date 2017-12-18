
<script type="text/javascript" src="http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

<form>
  <button type="button" style="cursor:pointer;" value="Pay Now" id="submit">Pay Now</button>
</form>

<script>
  document.getElementById("submit").addEventListener("click", function(e){
    getpaidSetup({
      PBFPubKey: '<?php echo $public_key; ?>',
      customer_email: '<?php echo $email; ?>',
      customer_firstname:'<?php echo $firstname; ?>',
      customer_lastname: '<?php echo $lastname; ?>',
      custom_description: '<?php echo $description; ?>',
      custom_logo: '<?php echo $logo; ?>',
      custom_title: '<?php echo $title; ?>',
      amount: <?php echo $amount; ?>,
      customer_phone: '<?php echo $phone; ?>',
      country: '<?php echo $country; ?>',
      currency: '<?php echo $currency; ?>',
      txref: '<?php echo $txnref; ?>',
      integrity_hash: '<?php echo $integrity_hash ?>',
      onclose: function() {},
      callback: function(response) {
        var flw_ref = response.tx.flwRef; // collect flwRef returned and pass to a          server page to complete status check.
        console.log("This is the response returned after a charge", response);
        if (
          response.tx.chargeResponse == "00" ||
          response.tx.chargeResponse == "0"
        ) {
          //http://localhost:3434/ravepay/index.php?route=payment/ravepay/callback&trxref=rvp45-59b6c855584c3
           

           window.location.href = '<?php echo $callback; ?>index.php?route=payment/ravepay/callback&flw_ref='+flw_ref; //Add your success page here
        
        } else {
          window.location.href = '<?php echo $callback; ?>index.php?route=payment/ravepay/callback&flw_ref='+flw_ref;
        }
      }
    });
  });




</script>