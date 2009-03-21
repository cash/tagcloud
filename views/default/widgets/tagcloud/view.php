<div class="contentWrapper">
<?php

	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 30;

  $prev_context = get_context();
  set_context('random');	
	echo display_tagcloud(1, $num_items, 'tags', 'object', '', page_owner());
	get_context($prev_context);
?>
</div>
