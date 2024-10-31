<?php
/*
Plugin Name: Old Post Notifier
Plugin URI: http://alisko.org/eklentiler/old-post-notifier-eklentisi-v0-1/
Description: With this plugin, an notification can be added to old posts.
Author: Ali Bahsisoglu
Version: 1.0
Text Domain: oldpost
Author URI: http://www.alibahsisoglu.com.tr
*/ 

## Plugin Page URL 
$purl = "http://alisko.org/eklentiler/old-post-notifier-eklentisi-v0-1/";

## Define Plugin path and Day
define('GUN', get_option("old_post_day"));
define('OLD_POST_URL', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)));

## Wordpress Localization
function oldpost_lang(){
	load_plugin_textdomain('oldpost', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/lang', dirname(plugin_basename(__FILE__)).'/lang');
}

## CSS for Warning Message
function cssekle(){
?>
<!-- Old Post Notifier -->
<style type="text/css">
.ikaz {
    margin-top: 0.5em;
	margin-bottom: 0.5em;
    padding: 1em 1.5em 1em 5.5em;
    border-bottom: 2px solid #fff;
    border-top: 2px solid #fff;
    color:<?=get_option("old_post_ikazyazi")?>;
	background: <?=get_option("old_post_ikazbg")?> url(<?php echo(OLD_POST_URL.'/ikaz.png')?>) 2.2em center no-repeat; border-color: <?=get_option("old_post_ikazkenar")?>;
}
.ikaz .kapat{ position:relative; float:right; top:-5px; right:-5px; }
.ikaz .kapat img{border:none; background:none;}
.ikaz a  {color: <?=get_option("old_post_ikazlink")?>;}
</style>
<!-- Old Post Notifier -->
<?php
}

## Settings Form Update
if($_POST['result'] == 'ok'){
		update_option('old_post_day', $_POST['min_day']);
		update_option('old_post_ikazbg', $_POST['ikazbg']);
		update_option('old_post_ikazyazi', $_POST['ikazyazi']);
		update_option('old_post_ikazkenar', $_POST['ikazkenar']);
		update_option('old_post_ikazlink', $_POST['ikazlink']);
		update_option('old_post_ikaz', $_POST['notifier']);
		update_option('old_post_exclude', $_POST['exclude']);
}

## Plugin Deactive
function old_deactivate(){
	delete_option("old_post_day");
	delete_option("old_post_ikazbg");
	delete_option("old_post_ikazyazi");
	delete_option("old_post_ikazkenar");
	delete_option("old_post_ikazlink");
	delete_option("old_post_ikaz");
	delete_option("old_post_exclude");
}

## Plugin Activate
function old_activate(){
	global $purl;
	oldpost_lang();
	if (!get_option("old_post_day")) {
		add_option("old_post_day", '14', 'Minumum Days For Old Post', 'yes');
	}
	if (!get_option("old_post_ikazbg")) {
		add_option("old_post_ikazbg", '#fff6bf', 'Color of Background', 'yes');
	}
	if (!get_option("old_post_ikazyazi")) {
		add_option("old_post_ikazyazi", '#444', 'Color of Text', 'yes');
	}
	if (!get_option("old_post_ikazkenar")) {
		add_option("old_post_ikazkenar", '#ffd324', 'Color of Border', 'yes');
	}
	if (!get_option("old_post_ikazlink")) {
		add_option("old_post_ikazlink", '#817134', 'Color of Links', 'yes');
	}
	if (!get_option("old_post_exclude")) {
		add_option("old_post_exclude", ' ', 'Color of Links', 'yes');
	}
	if (!get_option("old_post_ikaz")) {
		add_option("old_post_ikaz", sprintf(__('This post was published <strong>%s</strong> ago which may make its actuality or expire date not be valid anymore. This site is not responsible for any misunderstanding.', 'oldpost'),'%old_date%'), 'Old post ikaz', 'yes');
	}
	$turl = "http://www.alisko.org/old-post-notifier-eklentisi-v0-1/trackback";
	$thead = __('I have downloaded Old Post Notifier', 'oldpost');
	$tbody = sprintf(__('I installed the plugin to %s.', 'oldpost'), get_option('blogname'));
	send_trackback($turl,$thead,$tbody);	
}

## Javascript for Settings Page
function my_init_method() {
    wp_enqueue_script('jquery');
	?>
	<script type="text/javascript"> 
	var imageUrl= '<?php echo(OLD_POST_URL.'/color.png')?>';
	function iColorShow(id,id2){var eICP=jQuery("#"+id2).position();
	jQuery("#iColorPicker").css({'top':eICP.top+(jQuery("#"+id).outerHeight())+"px",'left':(eICP.left)+"px",'position':'absolute'}).fadeIn("fast");jQuery("#iColorPickerBg").css({'position':'absolute','top':0,'left':0,'width':'100%','height':'100%'}).fadeIn("fast");var def=jQuery("#"+id).val();jQuery('#colorPreview span').text(def);jQuery('#colorPreview').css('background',def);jQuery('#color').val(def);var hxs=jQuery('#iColorPicker');for(i=0;i<hxs.length;i++){var tbl=document.getElementById('hexSection'+i);var tblChilds=tbl.childNodes;for(j=0;j<tblChilds.length;j++){var tblCells=tblChilds[j].childNodes;for(k=0;k<tblCells.length;k++){jQuery(tblChilds[j].childNodes[k]).unbind().mouseover(function(a){var aaa="#"+jQuery(this).attr('hx');jQuery('#colorPreview').css('background',aaa);jQuery('#colorPreview span').text(aaa)}).click(function(){var aaa="#"+jQuery(this).attr('hx');
	jQuery("#"+id).val(aaa).css("background",aaa);jQuery("#iColorPickerBg").hide();jQuery("#iColorPicker").fadeOut();jQuery(this)})}}}}
	this.iColorPicker=function(){jQuery("input.iColorPicker").each(function(i){
	if(i==0){
		jQuery(document.createElement("div")).attr("id","iColorPicker").css('display','none').html('<table class="pickerTable" id="pickerTable0"><thead id="hexSection0"><tr><td style="background:#f00;" hx="f00"></td><td style="background:#ff0" hx="ff0"></td><td style="background:#0f0" hx="0f0"></td><td style="background:#0ff" hx="0ff"></td><td style="background:#00f" hx="00f"></td><td style="background:#f0f" hx="f0f"></td><td style="background:#fff" hx="fff"></td><td style="background:#ebebeb" hx="ebebeb"></td><td style="background:#e1e1e1" hx="e1e1e1"></td><td style="background:#d7d7d7" hx="d7d7d7"></td><td style="background:#cccccc" hx="cccccc"></td><td style="background:#c2c2c2" hx="c2c2c2"></td><td style="background:#b7b7b7" hx="b7b7b7"></td><td style="background:#acacac" hx="acacac"></td><td style="background:#a0a0a0" hx="a0a0a0"></td><td style="background:#959595" hx="959595"></td></tr><tr><td style="background:#ee1d24" hx="ee1d24"></td><td style="background:#fff100" hx="fff100"></td><td style="background:#00a650" hx="00a650"></td><td style="background:#00aeef" hx="00aeef"></td><td style="background:#2f3192" hx="2f3192"></td><td style="background:#ed008c" hx="ed008c"></td><td style="background:#898989" hx="898989"></td><td style="background:#7d7d7d" hx="7d7d7d"></td><td style="background:#707070" hx="707070"></td><td style="background:#626262" hx="626262"></td><td style="background:#555" hx="555"></td><td style="background:#464646" hx="464646"></td><td style="background:#363636" hx="363636"></td><td style="background:#262626" hx="262626"></td><td style="background:#111" hx="111"></td><td style="background:#000" hx="000"></td></tr><tr><td style="background:#f7977a" hx="f7977a"></td><td style="background:#fbad82" hx="fbad82"></td><td style="background:#fdc68c" hx="fdc68c"></td><td style="background:#fff799" hx="fff799"></td><td style="background:#c6df9c" hx="c6df9c"></td><td style="background:#a4d49d" hx="a4d49d"></td><td style="background:#81ca9d" hx="81ca9d"></td><td style="background:#7bcdc9" hx="7bcdc9"></td><td style="background:#6ccff7" hx="6ccff7"></td><td style="background:#7ca6d8" hx="7ca6d8"></td><td style="background:#8293ca" hx="8293ca"></td><td style="background:#8881be" hx="8881be"></td><td style="background:#a286bd" hx="a286bd"></td><td style="background:#bc8cbf" hx="bc8cbf"></td><td style="background:#f49bc1" hx="f49bc1"></td><td style="background:#f5999d" hx="f5999d"></td></tr><tr><td style="background:#f16c4d" hx="f16c4d"></td><td style="background:#f68e54" hx="f68e54"></td><td style="background:#fbaf5a" hx="fbaf5a"></td><td style="background:#fff467" hx="fff467"></td><td style="background:#acd372" hx="acd372"></td><td style="background:#7dc473" hx="7dc473"></td><td style="background:#39b778" hx="39b778"></td><td style="background:#16bcb4" hx="16bcb4"></td><td style="background:#00bff3" hx="00bff3"></td><td style="background:#438ccb" hx="438ccb"></td><td style="background:#5573b7" hx="5573b7"></td><td style="background:#5e5ca7" hx="5e5ca7"></td><td style="background:#855fa8" hx="855fa8"></td><td style="background:#a763a9" hx="a763a9"></td><td style="background:#ef6ea8" hx="ef6ea8"></td><td style="background:#f16d7e" hx="f16d7e"></td></tr><tr><td style="background:#ee1d24" hx="ee1d24"></td><td style="background:#f16522" hx="f16522"></td><td style="background:#f7941d" hx="f7941d"></td><td style="background:#fff100" hx="fff100"></td><td style="background:#8fc63d" hx="8fc63d"></td><td style="background:#37b44a" hx="37b44a"></td><td style="background:#00a650" hx="00a650"></td><td style="background:#00a99e" hx="00a99e"></td><td style="background:#00aeef" hx="00aeef"></td><td style="background:#0072bc" hx="0072bc"></td><td style="background:#0054a5" hx="0054a5"></td><td style="background:#2f3192" hx="2f3192"></td><td style="background:#652c91" hx="652c91"></td><td style="background:#91278f" hx="91278f"></td><td style="background:#ed008c" hx="ed008c"></td><td style="background:#ee105a" hx="ee105a"></td></tr><tr><td style="background:#9d0a0f" hx="9d0a0f"></td><td style="background:#a1410d" hx="a1410d"></td><td style="background:#a36209" hx="a36209"></td><td style="background:#aba000" hx="aba000"></td><td style="background:#588528" hx="588528"></td><td style="background:#197b30" hx="197b30"></td><td style="background:#007236" hx="007236"></td><td style="background:#00736a" hx="00736a"></td><td style="background:#0076a4" hx="0076a4"></td><td style="background:#004a80" hx="004a80"></td><td style="background:#003370" hx="003370"></td><td style="background:#1d1363" hx="1d1363"></td><td style="background:#450e61" hx="450e61"></td><td style="background:#62055f" hx="62055f"></td><td style="background:#9e005c" hx="9e005c"></td><td style="background:#9d0039" hx="9d0039"></td></tr><tr><td style="background:#790000" hx="790000"></td><td style="background:#7b3000" hx="7b3000"></td><td style="background:#7c4900" hx="7c4900"></td><td style="background:#827a00" hx="827a00"></td><td style="background:#3e6617" hx="3e6617"></td><td style="background:#045f20" hx="045f20"></td><td style="background:#005824" hx="005824"></td><td style="background:#005951" hx="005951"></td><td style="background:#005b7e" hx="005b7e"></td><td style="background:#003562" hx="003562"></td><td style="background:#002056" hx="002056"></td><td style="background:#0c004b" hx="0c004b"></td><td style="background:#30004a" hx="30004a"></td><td style="background:#4b0048" hx="4b0048"></td><td style="background:#7a0045" hx="7a0045"></td><td style="background:#7a0026" hx="7a0026"></td></tr></thead><tbody><tr><td style="border:1px solid #000;background:#fff;cursor:pointer;height:60px;-moz-background-clip:-moz-initial;-moz-background-origin:-moz-initial;-moz-background-inline-policy:-moz-initial;" colspan="16" align="center" id="colorPreview"><span style="color:#000;border:1px solid rgb(0, 0, 0);padding:5px;background-color:#fff;font:11px Arial, Helvetica, sans-serif;"></span></td></tr>		<tr><td style="border:1px solid rgb(0, 0, 0);background:#000;cursor:pointer;height:10px;-moz-background-clip:-moz-initial;-moz-background-origin:-moz-initial;-moz-background-inline-policy:-moz-initial;" colspan="16" align="center" id="colorPickerCredits"></td></tr></tbody></table><style>#iColorPicker input{margin:2px}</style>').appendTo("body");jQuery(document.createElement("div")).attr("id","iColorPickerBg").click(function(){jQuery("#iColorPickerBg").hide();jQuery("#iColorPicker").fadeOut()}).appendTo("body");jQuery('table.pickerTable td').css({'width':'12px','height':'14px','border':'1px solid #000','cursor':'pointer'});jQuery('#iColorPicker table.pickerTable').css({'border-collapse':'collapse'});jQuery('#iColorPicker').css({'border':'1px solid #ccc','background':'#333','padding':'5px','color':'#fff','z-index':9999})}jQuery('#colorPreview').css({'height':'50px'});jQuery(this).css("backgroundColor",jQuery(this).val()).after('<a href="javascript:void(null)" id="icp_'+this.id+'" onclick="iColorShow(\''+this.id+'\',\'icp_'+this.id+'\')"><img src="'+imageUrl+'" style="border:0;margin:0 0 0 3px" align="absmiddle" ></a>')})};
	jQuery(function(){iColorPicker()});
	</script>
	<?php
	}

## Find the how many days between two times
function gunbul($time1,$time2,$brake){

	list ($d1, $m1, $y1) = explode ($brake, $time1);
	list ($d2, $m2, $y2) = explode ($brake, $time2);

	$time1 = mktime (0, 0, 0, $m1, $d1, $y1);
	$time2 = mktime (0, 0, 0, $m2, $d2, $y2);
	
	$last = ($time1 > $time2) ? ($time1 - $time2) : ($time2 - $time1); 
	return $last;
}

## Send a trackback to my plugin page
function send_trackback($trackback_url, $title, $excerpt) {
	global $wpdb, $wp_version;
	$title = urlencode($title);
	$excerpt = urlencode($excerpt);
	$blog_name = urlencode(get_settings('blogname'));
	$tb_url = $trackback_url;
	$url = urlencode(get_settings('home'));
	$query_string = "title=$title&url=$url&blog_name=$blog_name&excerpt=$excerpt";
	$trackback_url = parse_url($trackback_url);
	$http_request = 'POST ' . $trackback_url['path'] . ($trackback_url['query'] ? '?'.$trackback_url['query'] : '') . " HTTP/1.0\r\n";
	$http_request .= 'Host: '.$trackback_url['host']."\r\n";
	$http_request .= 'Content-Type: application/x-www-form-urlencoded; charset='.get_settings('blog_charset')."\r\n";
	$http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
	$http_request .= "User-Agent: WordPress/" . $wp_version;
	$http_request .= "\r\n\r\n";
	$http_request .= $query_string;
	if ( '' == $trackback_url['port'] )
		$trackback_url['port'] = 80;
	$fs = @fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 4);
	@fputs($fs, $http_request);
	@fclose($fs);
}

## Donation Button
function donation(){
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="ali@bahsisoglu.com">
<input type="hidden" name="lc" value="TR">
<input type="hidden" name="item_name" value="Alisko.Org">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/tr_TR/i/scr/pixel.gif" width="1" height="1">
</form>
<?php
}	
	
## main function
function old_posts($content) {
	global $post;
	if (empty($post) || !is_single())
		return $content;
		
	$exclude = get_option('old_post_exclude');
	$arexclude = explode(",",$exclude);
	foreach((get_the_category()) as $category) {
		if(in_array($category->cat_ID,$arexclude)){
			return $content;
		}
	}
	if(in_array($post->ID,$arexclude)){
		return $content;
	}
	if (time() - strtotime($post->post_date) > (GUN * 24 * 60 * 60)){
		$last = gunbul(get_the_time("j/m/Y"),date("j/m/Y"),'/');
		$day = (date("d",$last) - 1);
		$month = date("m",$last) -1;
		$year = date("Y",$last) - 1970;
		
		if($day == 0)
			$day = "";
		else
			$day = sprintf(__ngettext(" %d day", " %d days", $day, 'oldpost'), $day);
		if($year == 0)
			$year = "";
		else
			$year = sprintf(__ngettext(" %d year", " %d years", $year, 'oldpost'), $year);
		if($month == 0)
			$month = "";
		else
			$month = sprintf(__ngettext(" %d month", " %d months", $month, 'oldpost'), $month);
		$content1= $content;
		$content = "<div class=\"ikaz\">";
		$content .="<a href=\"javascript:void(null)\" onclick=\"javascript:this.parentNode.style.display='none';\" class=\"kapat\"><img src=\"".OLD_POST_URL."/cross_grey_small.png\" title=\"Close this notification\" alt=\"close\" /></a>";
		$content .= str_replace("%old_date%", $year.$month.$day, get_option('old_post_ikaz'));
		$content .= "</div>";
		$content .= $content1;
	}
	return $content;
}
## Settings page menu
function admin_page_old(){
	add_options_page('Old Post Notifier', 'Old Post Notifier', 8, __FILE__, old_settings);
}

## Settings part
function old_settings(){
	global $purl;
?>
	<div class="wrap">
	<h2>Old Post Notifier</h2>
	<?php if($_POST['result'] == 'ok'){ ?>
	<div class="updated"><p><strong><?php _e('Settings Saved.', 'oldpost');?></strong></p></div>
	<?php } ?>
	<form method="post" action="options-general.php?page=old-post-notifier/old-post-notifier.php">
	<?php wp_nonce_field('old-post-notifier'); ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><strong><?php _e('Minimum Days', 'oldpost');?></strong></th>
			<td><input type="text" name="min_day" value="<?php echo get_option('old_post_day'); ?>" size="4" /><br /><strong><?php _e('Time limitation of old post notification.', 'oldpost');?></strong></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Exclude Categories', 'oldpost');?></strong></th>
			<td><input type="text" name="exclude" value="<?php echo get_option('old_post_exclude'); ?>" size="40" /><br /><strong><?php _e('Enter comma-seperated category IDs to exclude them from warning message', 'oldpost');?></strong></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Background Color', 'oldpost');?></strong></th>
			<td><input id="ikazbg" name="ikazbg" class="iColorPicker" value="<?php echo get_option('old_post_ikazbg'); ?>" type="text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Text Color', 'oldpost');?></strong></th>
			<td><input id="ikazyazi" name="ikazyazi" class="iColorPicker" value="<?php echo get_option('old_post_ikazyazi'); ?>" type="text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Border Color', 'oldpost');?></strong></th>
			<td><input id="ikazkenar" name="ikazkenar" class="iColorPicker" value="<?php echo get_option('old_post_ikazkenar'); ?>" type="text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Link Color', 'oldpost');?></strong></th>
			<td><input id="ikazlink" name="ikazlink" class="iColorPicker" value="<?php echo get_option('old_post_ikazlink'); ?>" type="text"></td>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Warning Message', 'oldpost');?></strong></th>
			<td><textarea name="notifier" id="notifier" rows="3" cols="80"><?php echo get_option('old_post_ikaz'); ?></textarea><br /><strong><?php _e('Don\'t forget to add %old_date% where you want the time to appear in your message.', 'oldpost');?></strong></td>
			<script type="text/javascript">
			jQuery(document).ready(function($){
					$("textarea[name='notifier']")
						.bind("keyup",
						function(){
							$(".ikaz").html( $(this).val() );
						});
					});
			</script>
		</tr>
		<tr valign="top">
			<th scope="row"><strong><?php _e('Preview', 'oldpost');?></strong></th>
			<td>
				<div style="width: 500px;" class="ikaz"><?php echo get_option('old_post_ikaz'); ?></div>
			</td>
		</tr>
		</table>
	<input type="hidden" name="result" value="ok">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="min_day,notifier,ikazlink,ikazkenar,ikazyazi,ikazbg,result" />
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'oldpost');?>" />
	</p>
	</form>
	<h2>Support and Donation</h2>
	<?php
	printf(__('Follow me on <a href="%1$s" target="_blank">Twitter</a> and <a href="%2$s" target="_blank">Friendfeed</a><br />', 'oldpost'),"http://www.twitter.com/alisko", "http://www.friendfeed.com/alisko");
	printf(__('For more information and support, visit <a href="%s" target="_blank">plugin</a> page<br />', 'oldpost'),$purl);
	printf('<a href="%1$s" target="_blank">Ali Bahsisoglu</a> & <a href="%2$s" target="_blank">Alisko</a><br />',"http://www.alibahsisoglu.com.tr","http://alisko.org");
	donation(); 
	?>
	</div>
<?php
}


add_action("init", "oldpost_lang");
register_deactivation_hook( __FILE__, 'old_deactivate' );
register_activation_hook( __FILE__, 'old_activate' );
add_filter( 'the_content', 'old_posts' );
add_action('admin_head','cssekle');
add_action('admin_head', 'my_init_method');
add_action('wp_head', 'cssekle');
add_action('admin_menu', 'admin_page_old');
?>