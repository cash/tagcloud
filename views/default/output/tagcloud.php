<?php

/**
 * Elgg tagcloud
 * Displays a tagcloud
 *
 *
 * @uses $vars['tagcloud'] An array of stdClass objects with two elements:
 *			'tag' (the text of the tag) and 'total' (the number of elements with this tag)
 * @uses $vars['value'] Same as $vars['tagcloud']
 * @uses $vars['type'] Entity type
 * @uses $vars['subtype'] Entity subtype
 * @uses $vars['owner_guid']
 * @uses $vars['container_guid']
 * @uses $vars['scale'] Scaling factor of tag font size - default is 100
 * @uses $vars['sort'] Options: count, random(default), alpha,
 */

$params = '';
if (!empty($vars['subtype'])) {
	$params .= "&entity_subtype=" . urlencode($vars['subtype']);
} 
if (!empty($vars['type'])) {
	$params .= "&entity_type=" . urlencode($vars['type']);
}
if (!empty($vars['owner_guid'])) {
	$params .= "&owner_guid=" . $vars['owner_guid'];
}
// 1.7 does not support container_guid yet
if (!empty($vars['container_guid'])) {
	$params .= "&owner_guid=" . $vars['container_guid'];
} 

if (empty($vars['tagcloud']) && !empty($vars['value'])) {
	$vars['tagcloud'] = $vars['value'];
}

$scale = 100;
if (isset($vars['scale'])) {
	$scale = $vars['scale'];
}

$sort = 'random';
if (isset($vars['sort'])) {
	$sort = $vars['sort'];
}

if (!empty($vars['tagcloud']) && is_array($vars['tagcloud'])) {

	switch ($sort) {
		case 'alpha':
			usort($vars['tagcloud'], create_function('$a, $b', 'return strcmp($a->tag, $b->tag);'));
			break;
		case 'random':
			shuffle($vars['tagcloud']);
			break;
		case 'count':
		default:
			break;
	}

	$counter = 0;
	$cloud = "";
	$max = 0;
	foreach($vars['tagcloud'] as $tag) {
		if ($tag->total > $max) {
			$max = $tag->total;
		}
	}
	
	foreach($vars['tagcloud'] as $tag) {
		if (!empty($cloud)) {
			$cloud .= ", ";
		}

		// size is a percentage with the minimum percentage being 60%

		// protecting against division by zero warnings
		$size = round((log($tag->total) / log($max + .0001)) * $scale) + 30;
		if ($size < 60) {
			$size = 60;
		}
		$encoded_tag = htmlspecialchars($tag->tag, ENT_QUOTES, 'UTF-8');
		$style = "font-size: {$size}%; text-decoration: none;";
		$url = $vars['url'] . "pg/search/?q=". urlencode($tag->tag) . "&search_type=tags{$params}";
		$cloud .= "<a href='$url' title='$encoded_tag ($tag->total)' style='$style'>$encoded_tag</a>";
	}

	echo $cloud;

}

