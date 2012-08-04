<script language="JavaScript" type="text/javascript">
$(function() {
    setTimeout(function(){
        location.href = "<?php echo DHLOutput::$options_page.DHL_CONFIG; ?>&action=manage";
    },2000);
});
</script>
<h3><?php DHLOutput::_e('Subscription Complete'); ?></h3>
<div class="success"><?php echo $register->message; ?></div>
<p><?php DHLOutput::_e("You will be automatically redirected to manage your account... "); ?><a href="<?php echo DHLOutput::$options_page.DHL_CONFIG; ?>&action=manage"><?php DHLOutput::_e("Click here to continue."); ?></a></p>