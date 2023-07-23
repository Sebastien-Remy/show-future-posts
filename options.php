<?php
/**
 * Filename: options.php
 * Show Future Posts - Uninstall
 */

// Form
$mode = '';
if(!empty($_POST['do']))
{
	switch($_POST['do'])
	{
		// update options
		case 'sfp_update' :
			update_option('showfutureposts_posts', wp_strip_all_tags($_POST['showfutureposts_posts']));
			update_option('showfutureposts_cats', wp_strip_all_tags($_POST['showfutureposts_cats']));
			ShowFuturePosts::no_future_posts();
			echo '<div id="message" class="updated fade"><p>'.__('Options updated', 'sfp').'</p></div>';
			break;
		//  uninstall plugin
		case __('UNINSTALL Show Future Posts', 'sfp') :
			if(trim($_POST['uninstall_sfp_yes']) == 'yes')
			{
				ShowFuturePosts::reset_future();
				delete_option('showfutureposts_posts');
				delete_option('showfutureposts_cats');
				echo '<div id="message" class="updated fade"><p>';
				echo __('Exclude lists deleted', 'sfp').'</p></div>';
				$mode = 'end-UNINSTALL';
			}
			break;
		default:
			break;
	}
}

switch($mode) {
	// Deactivation
	case 'end-UNINSTALL':
		$deactivate_url = 'plugins.php?action=deactivate&amp;plugin=show-future-posts/show-future-posts.php';
		if ( function_exists('wp_nonce_url') ) 
			$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_show-future-posts/show-future-posts.php');
		echo '<div class="wrap">';
		echo '<h2>'.__('Uninstall', 'sfp').' "No Future Posts"</h2>';
		echo '<p><strong><a href="'.$deactivate_url.'">'.__('Click here', 'sfp').'</a> '.__('to finish the uninstall and to deactivate "Show Future Posts".', 'sfp').'</strong></p>';
		echo '</div>';
		break;
	// View Page
	default:
			
		
	?>
	<div class="wrap">
	
	<h2>Show Future Posts</h2>
	
	<div id="poststuff">

	<div class="postbox">
		<h2 style="border-bottom: 1px solid #eee;"><?php _e('Settings') ?></h2>
		<div class="inside">
			<p><?php _e('Normaly all posts will change from "future" to "publish".<br />Which posts and categories do you want to keep in future.', 'sfp') ?></p>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<table class="form-table">
				<tr>
					<th scope="row" style="padding:0"><?php _e('Exclude posts IDs', 'sfp') ?>:</th>
					<td style="padding:0">
						<input type="text" size="60" name="showfutureposts_posts" value="<?php echo get_option('showfutureposts_posts'); ?>" style="width:100%" />
						<?php _e('comma-separated', 'sfp') ?>
					</td>
				</tr>
				<tr>
					<th scope="row" style="padding:0"><?php _e('Exclude categories IDs', 'sfp') ?>:</th>
					<td style="padding:0">
						<input type="text" size="60" name="nofutureposts_cats" value="<?php echo get_option('nofutureposts_cats'); ?>" style="width:100%" />
						<?php _e('comma-separated', 'sfp') ?>
					</td>
				</tr>
				</table>
				<p>
					<input type="hidden" name="do" value="sfp_update" />
					<input type="submit" name="update" value="<?php _e('Update options', 'sfp') ?>" class="button" />
				</p>
			</form>
		</div>
	</div>
	
	<!-- Uninstall -->
	<div class="postbox">
		<h2 style="border-bottom: 1px solid #eee;"><?php _e('Uninstall', 'sfp') ?></h2>
			<div class="inside">
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
				<p>
					<?php _e('Delete exclude lists and deactivate the plugin.', 'sfp') ?><br/>
				</p>
				<p>
					<input type="checkbox" name="uninstall_sfp_yes" value="yes" />&nbsp;<?php _e('Yes', 'sfp'); ?><br /><br />
					<input type="submit" name="do" value="<?php _e('UNINSTALL No Future Posts', 'sfp') ?>" class="button" style="color:red" />
				</p>
			</form>
		</div>
	</div>
	
	</div>
	
	</div>

<?php
} // End switch($mode)
