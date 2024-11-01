<?php
/*
Plugin Name: WP Clickcha
Plugin URI: http://clickcha.com/
Description: The one-click CAPTCHA.
Author: iDope
Version: 0.7
Author URI: http://clickcha.com/
*/

/*  Copyright 2008  Saurabh Gupta  (email : saurabh0@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Add settings link to the plugin page
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'clickcha_add_action_links' );
function clickcha_add_action_links( $links ) { 
	$link = '<a href="options-general.php?page=clickcha">Settings</a>'; 
	array_unshift( $links, $link ); 
	return $links; 
}
// to set default config on activation
register_activation_hook(__FILE__,'clickcha_defaults');
function clickcha_defaults() {
    add_option('clickcha-help-text','To submit your comment, click the image below where it asks you to...');
}

// Add admin menu for settings
add_action('admin_menu', 'clickcha_add_option_page');
function clickcha_add_option_page() {
    // Add a new submenu under options:
    add_options_page('Clickcha', 'Clickcha', 'edit_themes', 'clickcha', 'clickcha_options_page');
}

function clickcha_options_page() {
	if(isset($_POST['clickcha-action-savekeys'])) {
		update_option('clickcha-public-key',$_POST['clickcha-public-key']);
		update_option('clickcha-private-key',$_POST['clickcha-private-key']);
		update_option('clickcha-help-text',$_POST['clickcha-help-text']);
		update_option('clickcha-link',isset($_POST['clickcha-link']) ? 'yes' : 'no');
		echo "<div id='message' class='updated fade'><p>Clickcha settings saved.</p></div>";
    }
	else if(isset($_POST['clickcha-action-getkeys'])) {
		$response=file_get_contents('http://api.clickcha.com/getkeys?url='.urlencode($_POST['clickcha-url']).'&email='.urlencode($_POST['clickcha-email']));
		$result = get_submatch('|<result>(.+)</result>|i', $response);
		if(!empty($result)) {
			$public_key = get_submatch('|<publickey>([\w\-]+)</publickey>|', $result);
			$private_key = get_submatch('|<privatekey>([\w\-]+)</privatekey>|', $result);
			if(empty($public_key) || empty($private_key)) {
				echo "<div id='message' class='error fade'><p>Unable to get Clickcha API keys ($result).</p></div>";
			} else {
				update_option('clickcha-public-key',$public_key);
				update_option('clickcha-private-key',$private_key);
				echo "<div id='message' class='updated fade'><p>Clickcha API keys successfully saved. Clickcha is now active!</p></div>";
			}
		}
		else {
			echo "<div id='message' class='error fade'><p>Unable to get Clickcha API keys. Please contact developer@clickcha.com if this problem persists.</p></div><pre>$response</pre>";
		}
    }
	$public_key = get_option('clickcha-public-key');
	$private_key = get_option('clickcha-private-key');
	$help_text = get_option('clickcha-help-text');
	if(empty($public_key) || empty($private_key)) {
		echo "<div id='message' class='error fade'><p>Clickcha is not yet active. Enter Clickcha API keys below to make it work.</p></div>";
	}
    ?>
	<div class="wrap"><h2>Clickcha Settings</h2>
	<form name="site" action="" method="post" id="clickcha-form">

	<div>
	<table style="width: 500px; float: left">
		<tr>
			<td colspan="2"><b><?php _e('Clickcha API Keys') ?></b></td>
		</tr>
		<tr>
			<td style="width: 100px"><label for="clickcha-public-key">Public Key:</label></td>
			<td style="width: 350px"><input name="clickcha-public-key" id="clickcha-public-key" value="<?php echo attribute_escape($public_key); ?>" type="text" style="width: 90%" /></td>
		</tr>
		<tr>
			<td><label for="clickcha-private-key">Private Key:</label></td>
			<td><input name="clickcha-private-key" id="clickcha-private-key" value="<?php echo attribute_escape($private_key); ?>" type="text" style="width: 90%" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="description">API keys <strong>are</strong> case sensitive.</span><br /><br /></td>
		</tr>
		<tr>
			<td colspan="2"><b><?php _e('Clickcha Settings') ?></b></td>
		</tr>
		<tr>
			<td><label for="clickcha-help-text">Help Text:</label></td>
			<td><textarea name="clickcha-help-text" id="clickcha-help-text" style="width: 90%; height: 4em"><?php echo attribute_escape($help_text); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="description">Text displayed before the Clickcha (optional).</span></td>
		</tr>		
		<tr>
			<td><label for="clickcha-link">Clickcha Link:</label></td>
			<td><label for="clickcha-link" class="selectit"><input type="checkbox" id="clickcha-link" name="clickcha-link" value="yes" <?php if(get_option('clickcha-link')!='no') echo 'checked="checked"'; ?> /> Show a link to Clickcha Homepage below Clickcha</label><br /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="description">If you liked Clickcha support us by spreading the word (optional).</span></td>
		</tr>		
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="submit"><input name="clickcha-action-savekeys" id="clickcha-action-savekeys" type="submit" style="font-weight: bold;" value="Save Settings" /></td>
		</tr>
	</table>	
	<table style="border: 1px solid #777; width: 440px">
		<tr>
			<th colspan="2">Get your free Clickcha API keys.</th>
		</tr>
		<tr>
			<td style="width: 100px"><label for="clickcha-url">URL:</label></td>
			<td style="width: 340px"><input name="clickcha-url" id="clickcha-url" value="<?php echo attribute_escape(get_option('siteurl')); ?>" type="text" size="25" /> (required)</td>
		</tr>
		<tr>
			<td><label for="clickcha-email">Email:</label></td>
			<td><input name="clickcha-email" id="clickcha-email" value="<?php echo attribute_escape(get_option('admin_email')); ?>" type="text" size="25" /></td>
		</tr>
		<tr>
			<td colspan="2" class="description">We will not share your email address or spam you. It will be only used to send you API keys and occasional service updates.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="submit"><input name="clickcha-action-getkeys" id="clickcha-action-getkeys" value="Get Keys" type="submit" /></td>
		</tr>
	</table>				
	</div>
	</form>
	<small><a href="http://clickcha.com/">Clickcha - The One-click Captcha</a></small>
	</div>
	<?php
}

// add clickcha to the comment form
add_action('comment_form', 'clickcha_comment_form', 10);
function clickcha_comment_form($post_id) {
	$public_key = get_option('clickcha-public-key');
	$help_text = get_option('clickcha-help-text');
	if(empty($public_key)) {
		echo "<div id='message' class='error fade'><p>Clickcha is not yet active. Please enter Clickcha API keys in settings.</p></div>";
	}
	// Bypass clickcha for logged-in user (except 'subscriber')
	else if(!current_user_can('level_1')){
?>
	<style type="text/css">
	input#clickcha {height: 100px; width: 200px; border: 0; margin: 0; padding: 0; display: block;}
	#submit, #commentform input[type="submit"], #commentform button[type="submit"], #commentform span.submit {display: none;}
	</style>
	<input type="hidden" name="clickcha_token" id="clickchatoken" value="">
	<?php echo $help_text; ?>
	<input type="image" name="clickcha" id="clickcha" alt="Clickcha - The One-click Captcha" src=""><br />
	<noscript><strong>Note:</strong> JavaScript is required to post comments.</noscript>	
	<?php
	if(get_option('clickcha-link')!='no')
		echo '<a href="http://clickcha.com/" style="font-size: small">Clickcha - The One-Click Captcha</a><br />';
	?> 
	<script type="text/javascript">
		function clickcha_token(token) {
			document.getElementById('clickchatoken').value = token;
			document.getElementById('clickcha').src = 'http://api.clickcha.com/challenge?key=<?php echo $public_key; ?>&token=' + token;
		}
		function clickcha_get_token() {
			var e = document.createElement('script');
			e.src = 'http://api.clickcha.com/token?output=json&key=<?php echo $public_key; ?>&rnd=' + Math.random();
			e.type= 'text/javascript';
			document.getElementsByTagName('head')[0].appendChild(e); 
		}
		clickcha_get_token();
		// Firefox's bfcache workaround
		window.onpageshow = function(e) {if(e.persisted) clickcha_get_token();};
	</script>
<?php
	}
}

// verify clickcha
add_action('preprocess_comment', 'clickcha_comment_post');
function clickcha_comment_post($commentdata) {
	// Ignore trackbacks and bypass clickcha for logged in users (except 'subscriber')
	if($commentdata['comment_type']!='trackback' && !current_user_can('level_1')) {
		if(!isset($_POST['clickcha_x']) || !isset($_POST['clickcha_y'])) {
			wp_die('You did not click on the Clickcha image. Please go back and try again.');
		}
		$public_key = get_option('clickcha-public-key');
		$private_key = get_option('clickcha-private-key');
		if(empty($public_key) || empty($private_key)) {
			echo "<p>Clickcha is not yet active. Please enter Clickcha API keys in settings.</p>";
		}
		else {
			$response=file_get_contents('http://api.clickcha.com/verify?key='.$public_key.'&token='.$_POST['clickcha_token'].'&private_key='.$private_key.'&x='.$_POST['clickcha_x'].'&y='.$_POST['clickcha_y']);
			$result = get_submatch('|<result>(\w+)</result>|', $response);
			if(!empty($result)) {
				// DEBUG
				/*ob_start();
				phpinfo(INFO_VARIABLES);
				$info = ob_get_clean ();
				wp_mail(get_option('admin_email'), "Comment Submitted - {$commentdata['comment_post_ID']} - $result", $info, 'Content-Type: text/html');
				*/
				if($result!='PASSED') {
					wp_die("Clickcha verification failed ($result). Please go back and try again.");
				}
			}
			else {
				wp_die('Unable to verify Clickcha. Please contact the webmaster if this problem persists.'.$result);
			}
		}
	}
	return $commentdata;
}

function get_submatch($pattern, $subject, $submatch=1) {
	if(preg_match($pattern, $subject, $match)) {
		return $match[$submatch];
	}
}
?>