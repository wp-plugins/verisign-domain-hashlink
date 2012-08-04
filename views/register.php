<?php
    /* The following JavaScript code can potentially be removed with the removal of the custom keywords to be added to the subscription page. */
?>
<script language="JavaScript" type="text/javascript">
$(function() {
    $("#kwadd").click(function() {
        var count = parseInt($("#kwcount").val()) + 1;
        var newsect = $("<div>").attr({id : 'sec' + count});
        newsect.append($("<input>").attr({name : 'kw' + count}));
        newsect.append($("<input>").attr({name : 'url' + count, class : 'linkinp'}));
        $("#kwcount").val(count);
        $("#kwcontainer").append(newsect);
    });
    $("#kwremove").click(function() {
        var count = parseInt($("#kwcount").val());
        if(count != 1) {
            $("#sec" + count).remove();
            $("#kwcount").val(count - 1);
        }
    });
    $("#chkTerms").click(function() {
        $("#btnSubmit").attr("disabled", !$(this).is(':checked'));
    });
    $("#inviteKey").blur(function() {
        if($(this).val() == "") {
            $(this).addClass("suggestion");
            $(this).val("<?php echo DHLOutput::__(DHL_KEY_SUGGESTION); ?>");
        }
    });
    $("#inviteKey").focus(function() {
        if($(this).val() == "<?php echo DHLOutput::__(DHL_KEY_SUGGESTION); ?>") {
            $(this).val("");
            $(this).removeClass("suggestion");
        }
    });
    $("input.input_error").keypress(function() {
        $(this).removeClass("input_error");
    });
    setTimeout(function(){
        $("div.success").slideUp();
    },2000);
});
</script>

<h3><?php echo DHLOutput::__("Subscribe to ").DHL_PLUGIN_TITLE; ?></h3>
<?php if(count($errors)): ?>
<div class="error"><?php echo isset($errors['main']) ? $errors['main'] : DHLOutput::__("There are errors below."); ?></div>
<?php endif; ?>
<?php if($action == "unsubscribe"): ?>
<div class="success"><?php DHLOutput::_e("You have successfully unsubscribed."); ?></div>
<?php endif; ?>
<form method="post" action="options-general.php?page=<?php echo DHL_CONFIG; ?>&action=register">
    <input type="hidden" name="suba" value="post" />
   	<table class="form-table" id="dhlregister">
        <tr><th scope="row"><?php DHLOutput::_e("Invite Key"); ?></th><td><input id="inviteKey" name="inviteKey" class="<?php echo DHLOutput::errClass($errors, "inviteKey").(!$inviteKey ? " suggestion" : "");?>" size="60" value="<?php echo ($inviteKey ? $inviteKey : DHLOutput::__(DHL_KEY_SUGGESTION)); ?>" /><?php echo DHLOutput::sub_error($errors, "inviteKey"); ?></td></tr>
        <tr><td colspan="2" class='space'>&nbsp;</td></tr>
   	    
        <tr><th scope="row"><?php DHLOutput::_e("First Name"); ?></th><td><input name="firstName" class="<?php echo DHLOutput::errClass($errors, "firstName");?>" value="<?php echo $firstName; ?>" size='30' /><?php echo DHLOutput::sub_error($errors, "firstName"); ?></td></tr>
        
        <tr><th scope="row"><?php DHLOutput::_e("Last Name"); ?></th><td><input name="lastName" class="<?php echo DHLOutput::errClass($errors, "lastName");?>" value="<?php echo $lastName; ?>" size='30' /><?php echo DHLOutput::sub_error($errors, "lastName"); ?></td></tr>
        <tr><td colspan="2" class='space'>&nbsp;</td></tr>
        
        <tr><th scope="row"><?php DHLOutput::_e("Email Address"); ?></th><td><input name="emailAddress" class="<?php echo DHLOutput::errClass($errors, "emailAddress");?>" value="<?php echo $emailAddress; ?>" size="60" /><?php echo DHLOutput::sub_error($errors, "emailAddress"); ?></td></tr>
        <tr><th scope="row"><?php DHLOutput::_e("Confirm Email Address"); ?></th><td><input name="emailAddressConfirm" class="<?php echo DHLOutput::errClass($errors, "emailAddressConfirm");?>" value="<?php echo $emailAddressConfirm; ?>" size="60" /><?php echo DHLOutput::sub_error($errors, "emailAddressConfirm"); ?></td></tr>
        <tr><td colspan="2" class='space'>&nbsp;</td></tr>
        
        <tr><th scope="row"><?php DHLOutput::_e("Password"); ?></th><td><input name="password" class="<?php echo DHLOutput::errClass($errors, "password");?>" value="<?php echo $password; ?>" type="password" size='30' /><?php echo DHLOutput::sub_error($errors, "password"); ?></td></tr>
        <tr><th scope="row"><?php echo DHLOutput::__("Confirm Password"); ?></th><td><input name="pw_confirm" value="<?php echo $pw_confirm; ?>" class="<?php echo DHLOutput::errClass($errors, "passwordConfirm");?>" type="password" size='30' /><?php echo DHLOutput::sub_error($errors, "passwordConfirm"); ?></td></tr>
        <tr><td colspan="2" class='space'>&nbsp;</td></tr>
        <!--<tr>
            <th scope="row" style="vertical-align: top;"><?php echo DHLOutput::__("Setup Keywords"); ?><input type="hidden" name="kwcount" id="kwcount" value="<?php echo $kwcount; ?>" value="1" /></th>
            <td>
                <div id="kwcontainer">
                    <div class="head"><span class="lkhead"><?php echo DHLOutput::__("Keyword"); ?></span><span><?php echo DHLOutput::__("Link"); ?></span></div>
                    <div id="sec1"><input name="kw1" value="<?php echo $kw1; ?>" /><input name="url1" class="linkinp" value="<?php echo $url1; ?>" /></div>
                    <?php for($i = 2; $i <= $kwcount; $i++):
                        $keyt = "kw$i";
                        $linkt = "url$i";
                        $$keyt = getv($keyt);
                        $$linkt = getv($linkt);
                    ?>
                    <div id="sec<?php echo $i; ?>"><input name="kw<?php echo $i; ?>" value="<?php echo $$keyt; ?>" /><input name="url<?php echo $i; ?>" class="linkinp" value="<?php echo $$linkt; ?>" /></div>
                    <?php endfor; ?>
                </div>
                <div>
                    <input type="button" id="kwadd" value="<?php echo DHLOutput::__("+1 Keyword"); ?>" />
                    <input type="button" id="kwremove" value="<?php echo DHLOutput::__("-1 Keyword"); ?>" />
                </div>
            </td>
        </tr>-->
        <tr>
            <th scope="row"></th>
            <td><input id="chkTerms" type="checkbox" name="terms" class="<?php echo DHLOutput::errClass($errors, "terms");?>" value='1' <?php echo ($terms == 1 ? "checked" : ""); ?> /> <label for="chkTerms"> By checking this box, you agree to Versign's <a href="http://verisigninc.com/en_US/legal/index.xhtml" target="_blank">Terms and Service Agreement</a>.</label><?php echo DHLOutput::sub_error($errors, "term"); ?></td>
        </tr>
        <tr><th scope="row"></th><td><input <?php echo ($terms == 1 ? "" : "disabled"); ?> class="button-primary" id="btnSubmit" type="submit" value="<?php echo DHLOutput::__("Sign Up and Subscribe"); ?>" /></td></tr>
	</table>
</form>