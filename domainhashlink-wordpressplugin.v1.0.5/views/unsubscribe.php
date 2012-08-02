<script language="JavaScript" type="text/javascript">
$(function() {
    setTimeout(function(){
        location.href = "<?php echo DHLOutput::$options_page.DHL_CONFIG; ?>";
    },2000);
});
</script>
<?php if($register->code == 0): ?>
<div class="success"><?php echo $register->message; ?></div>
<?php else: ?>
<div class="error"><?php echo $register->message; ?></div>
<?php endif; ?>
