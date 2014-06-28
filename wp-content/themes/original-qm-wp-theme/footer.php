<?php

/**

 * The template for displaying the footer.

 *

 * Contains footer content and the closing of the

 * #main and #page div elements.

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */

?>

	<footer>

    <div class="social-sharing">

        <a href="https://www.facebook.com/Quantimodology" class="ss-facebook ir" target="_blank">Facebook</a>

        <a href="https://plus.google.com/communities/100581500031158281444" class="ss-googlep ir" target="_blank">Google Plus</a>

        <a href="https://twitter.com/QuantimodoApp" class="ss-twitter ir" target="_blank">Twitter</a>

    </div>

    <div class="rainbow-footer ir">The Rainbow of Happiness</div>

    <div class="helpbutton">

			<div class="hgroup">

				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">

				<input type="hidden" name="cmd" value="_s-xclick">

				<input type="hidden" name="hosted_button_id" value="TSE8GMGWZT3N8">

				<input type="image" src="https://i.imgur.com/qRUJe36.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

				<img alt="" class="paypal" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">

				</form>

                <a class="terms" target="_blank" title="Terms of service" href="<?php echo home_url(); ?>/?page_id=447" target="_blank">Terms of service</a>

			<div class="flattr">

				<a target="_blank" href="https://flattr.com/thing/1198104/Help-Us-Eradicate-Mental-Illness">

				<img border="0" title="Flattr this" alt="Flattr this" src="https://api.flattr.com/button/flattr-badge-large.png"></a>

			</div>

				<div class="coinbase">

					<a data-code="9a37f3e8d1890b775d32fa70613a97e3" data-button-style="buy_now_small" data-custom="QMDONATION" href="https://coinbase.com/checkouts/9a37f3e8d1890b775d32fa70613a97e3" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/bitcoin-button.png" alt='Bitcoin Pay' width="90"/></a></script>

				</div>

			</div>

    </div>

    <div class="cityscape ir">The City of Data</div>

</footer>



<div id="registerModalWrapper">

</div>



<div id="loginModalWrapper">

</div>



<div id="verifyModalWrapper">

</div>



<div id="accountCreationCompleteModalWrapper">

</div>



<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">

jQuery(document).ready(function(){

	 var doCredentialVerification="false";

	 if('true'==doCredentialVerification){
	   	showVerification();
	 }
});

</script>-->



<?php

wp_footer();

?>

</body>

</html>
