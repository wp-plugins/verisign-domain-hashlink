<form method="post" action="options.php" id="google_form">
   	<table class="form-table">
    <?php settings_fields(DHLSettings::$settingsGroup); ?>
        <tr><td scope="row" colspan="2">
            <h3><?php DHLOutput::_e('Setup Account'); ?></h3>
        </td></tr>
        <tr valign="top">
			<th scope="row"><?php echo DHL_PLUGIN_TITLE.' '.DHLOutput::__('Invite Key'); ?></th>
			<td>
				<input type="text" name="dhl_token_id" value="<?php echo (getv("token") ? getv("token") : DHLSettings::getVal('dhl_token_id')); ?>"> <?php echo (getv("token") ? DHLOutput::__('Do not forget to Save') : ""); ?>
			</td>
		</tr>
		<tr><th scope="row"></th><td><input class="button-primary" type="submit" value="<?php DHLOutput::_e('Save Changes') ?>" /></td></tr>
	</table>
</form>