<form role="search" method="get" id="searchform" action="https://www.google.com/search" autocomplete='off'>
	<div><label class="screen-reader-text" for="s">Search for:</label>
	<input type="text" value="" name="q" id="dhl_s" onkeydown="" onkeyup="">
	<input type="submit" id="dhl_searchsubmit" value="Search">
	</div>
</form>
<!-- start:within head section --> <style type='text/css'> /*Customize the style to fit your webpage*/ #isk-srch-widget{color:#4d4d4d;position:relative;border:solid 5px #999; width:224px; height:26px;} #isk-srch-kwlist {background: #f1f1f1; color: #4d4d4d; position:absolute; margin:0; min-width:150px; width:auto; clear:both; border-left:solid 1px #ccc; border-right:solid 1px #ccc; border-top:solid 1px #ccc;} dl#isk-srch-kwlist dd { min-width:150px; width:auto; display:block; margin:0; padding:5px; border:solid 1px #efefef;border-bottom:solid 1px #ccc; border-top:solid 1px $fff;cursor:pointer;} #isk-srch-kw { float:left; padding: 0px 6px 3px 0; height: 25px; } #isk-srch-button { float:right; border:solid 1px #ccc; background-color:#005F9F;color:#fff; padding:3px 6px;font-weight:bold; cursor:pointer; } .isk-sugg-hover { background-color:#646464;color:#fff;cursor: pointer;} .isk-srch-error {position:absolute;padding: 0.3em 0.3em;margin:0;border:1px solid #005F9F;border-top:none;background:#ffffff;color: #ff0000;font-type:Arial;font-weight:bold;} </style> <!--[if IE]> <style type='text/css'> #isk-srch-widget{width:235px; height:20px;} #isk-srch-kw { border:none; padding: 5px 6px 0 6px; height:18px;} #isk-srch-button { background-color:#005F9F;color:#fff; padding:4px 6px;font-weight:bold; cursor:pointer; } </style> <![endif]--> <!-- end:within head section --> <!-- start:within body section -->

<script type='text/javascript' src='http://<?php echo DHL_JS_HOST; ?>/1.0/loadWidget/<?php echo $_SERVER['HTTP_HOST']; ?>/SearchWidget.js?srchField=<?php echo $dhl_field; ?>&srchButton=<?php echo $dhl_button; ?>&srchType=CUSTOM'></script>

<!-- srchField: Id (or) Name for the Search TextBox srchButton: Id (or) Name for the Search Button srchType: Type of widget --> <!-- end:within body section -->
