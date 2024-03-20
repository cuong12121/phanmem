<?php 
    global $tmpl;
    $tmpl -> addScript('form');
    //$tmpl -> addScript('tiny_mce','libraries/jquery/tiny_mce');
    $Itemid = FSInput::get('Itemid',0);
    $link_back = FSRoute::_("index.php?module=messages&Itemid=$Itemid");
?>
<!-- FORM							-->
<?php $url = $_SERVER["REQUEST_URI"]; ?>
<form action="<?php echo $url; ?>" name="fontForm" method="post" onsubmit="javascript: return checkSubmitForm();">
	<div class="form_user_body">
		<div class="form_user_body_inner">
			<div id = "msg_error"></div>
			<!-- FORM MAIN - MESSAGE -->
            <div class="msg-content">
    			<input type="hidden" name='recipients' id='recipients' value="<?php echo $str_members_without_me; ?>"/>
    			<textarea rows="8" cols="30" name='message' id='message' placeholder="Your message to <?php echo $str_members_without_me; ?>" ></textarea>
    			<input type="submit" value="Send" name = 'submit_bt' class='button4 reply_bt' />
            </div>
			<!-- end FORM MAIN - MESSAGE	-->
		</div>
	</div>
	<input type="hidden" name="module" value="messages">
	<input type="hidden" name="view" value="messages">
	<input type="hidden" name="task" value="save_reply">
	<input type="hidden" name="message_id" value="<?php echo FSInput::get('id'); ?>">
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
</form><!-- END Form:  fontForm -->		
