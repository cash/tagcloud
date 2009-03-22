<?php

  function frontpage_tagcloud($num_tags) {
    $prev_context = get_context();
    set_context('random');	
	  $string = display_tagcloud(1, $num_tags, 'tags');
	  set_context($prev_context);
	  return $string;
  }

  function tagcloud_init() {
    add_widget_type('tagcloud', elgg_echo('tagcloud:widget:title'), elgg_echo('tagcloud:widget:description'));			     
  }
			
  register_elgg_event_handler('init', 'system', 'tagcloud_init');	
?>
