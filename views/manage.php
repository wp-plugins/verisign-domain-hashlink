<h3><?php DHLOutput::_e('Manage Subscription'); ?></h3>
<?php if(count($errors) > 0): ?>
<div class="error"><?php echo $errors['main']; ?></div>
<?php endif; ?>
<iframe id="ifrmsrc" src="<?php echo isset($vl->value) ? $vl->value : DHL_DOMAIN; ?>" width="100%" height="<?php echo DHL_IFRAME_SIZE; ?>" frameBorder="0" />