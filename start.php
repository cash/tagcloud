<?php

/**
 * Tag cloud plugin
 * Cash Costello
 */

/**
 * Instructions for including on front page
 *
 * If using the custom_index plugin, edit the layout view. This is found at
 * /mod/custom_index/views/default/canvas/layouts/new_index.php. Each section
 * begins with a "if (is_plugin_enabled()) {" and ends with a closing bracket
 * "}". Be careful when editing this file to make sure every <?php has a
 * corresponding ?>.
 *
 * To insert the front page tag cloud, figure out where you want it and then
 * add this code:

<?php
if (is_plugin_enabled('tagcloud')) {
?>
	<!-- display latest tags -->
	<div class="index_box">
		<h2><?php echo elgg_echo('tagcloud'); ?></h2>
		<div class="contentWrapper">
			<?php echo tagcloud_create_cloud(25); ?>
		</div>
	</div>
<?php
}
?>

 * See the documentation for tagcloud_create_cloud() for information on its
 * options.
 */



/**
 * Display a tag cloud
 * 
 * @param int $num_tags Number of tags to display
 * @param int $guid Who's tags - 0 for all site tags
 * @param string $sort Sort type: random, alpha, count (popularity)
 * @param int $scale How large should the tags be (default is 100)
 * @return string
 */
function tagcloud_create_cloud($num_tags, $guid=0, $sort='random', $scale=100) {
	
	if ($guid == 0) {
		$guid = ELGG_ENTITIES_ANY_VALUE;
	}

	$options = array('container_guids' => $guid, 
					'limit' => $num_tags,
					'threshold' => 0);
	$tag_data = elgg_get_tags($options);

	$view_vars = array(	'value' => $tag_data,
						'sort' => $sort,
						'scale' => $scale,
					);
	if ($guid) {
		$view_vars['container_guid'] = $guid;
	}

	return elgg_view("output/tagcloud", $view_vars);
}

function tagcloud_init() {
	add_widget_type('tagcloud', elgg_echo('tagcloud:widget:title'), elgg_echo('tagcloud:widget:description'));
}

register_elgg_event_handler('init', 'system', 'tagcloud_init');	
?>