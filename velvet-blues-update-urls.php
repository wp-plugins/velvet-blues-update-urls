<?php
/*
Plugin Name: Velvet Blues Update URLs
Plugin URI: http://www.velvetblues.com/web-development-blog/wordpress-plugin-update-urls/
Description: This plugin updates all urls in your website by replacing the old urls with the new.
Author: Velvet Blues
Author URI: http://www.velvetblues.com/
Version: 1.0.1
*/
/*  Copyright 2008  Velvet Blues Web Design  (email : info@velvetblues.com)

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
	
/* Functions for the options page */	
	function VelvetBluesUU_add_options_page() {
		add_options_page("Update URLs Setings", "Update Urls", "manage_options", __FILE__, "VelvetBluesUU_options_page");
	}
	function VelvetBluesUU_options_page() {
	
	/* Function which updates urls */
	function VB_update_urls($links,$oldurl,$newurl) {	
		global $wpdb;
		//permalinks query
		$permquery = "UPDATE $wpdb->posts SET guid = replace(guid, '".$oldurl."','".$newurl."')";
		$result = $wpdb->query( $permquery );
		if($links == 1){
		//content query
		$contquery = "UPDATE $wpdb->posts SET post_content = replace(post_content, '".$oldurl."','".$newurl."')";
		$result = $wpdb->query( $contquery );
		}
	}
		if( isset( $_POST['VBUU_settings_submit'] ) ) {
		 
			$vbuu_update_links = attribute_escape($_POST['VBUU_update_links']);
			$vbuu_oldurl = attribute_escape($_POST['VBUU_oldurl']);
			$vbuu_newurl = attribute_escape($_POST['VBUU_newurl']);
			VB_update_urls($vbuu_update_links,$vbuu_oldurl,$vbuu_newurl);
			echo '<div id="message" class="updated fade"><p><strong>URLs have been updated.</p></strong><p>You can now uninstall this plugin.</p></div>';
		}
?>
<div class="wrap">
<h2>Update URLs Settings</h2>
<form method="post" action="options-general.php?page=velvet-blues-update-urls/velvet-blues-update-urls.php">
<input type="hidden" id="_wpnonce" name="_wpnonce" value="abcab64052" />
<p>These settings let you update both your permalinks and any urls embedded in your content. It will replace all occurences of the old url with the new url.</p>
<p><b>Current Website Addresss:</b> <?php bloginfo('url');  ?></p>
<p><b>Current Installation Location:</b> <?php bloginfo('wpurl'); ?></p>
<p>If the settings above do not reflect the new location or domain, then you will need to <a href="options-general.php">update these settings</a> before or after you run this tool.</p>
<table class="form-table">
<tr>
<th scope="row" style="width:350px;">Update urls AND links in page or post content?</th>
<td>
	<p><input name="VBUU_update_links" type="radio" id="VBUU_update_true" value="1" checked="checked" /> <label for="VBUU_update_true">Yes</label></p>
	<p><input name="VBUU_update_links" type="radio" id="VBUU_update_false" value="0" /> <label for="VBUU_update_false">No, I only want to update the urls, and not any links.</label></p>
</td>

</tr>
<tr>
<th scope="row" style="width:300px;">Old URL</th>
<td>
	<p><input name="VBUU_oldurl" type="text" id="VBUU_oldurl" value="" style="width:300px;" />/</p>
</td>
</tr>
<tr>
<th scope="row" style="width:300px;">New URL</th>
<td>
	<p><input name="VBUU_newurl" type="text" id="VBUU_newurl" value="" style="width:300px;" />/</p>
</td>
</tr>
</table>
<p class="submit">
<input name="VBUU_settings_submit" value="Update URLs" type="submit" />
</p>
</form>
<?
}
	 
add_action('admin_menu', 'VelvetBluesUU_add_options_page'); 
?>