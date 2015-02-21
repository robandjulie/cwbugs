<?php

/**
 * @file
 * Default theme implementation for field collection items.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */


	$start = strtotime($content['field_date_time']["#items"][0]['value']) - (5 * 3600);

	list($month, $day) = explode(' ', strip_tags($content['field_date_time'][0]['#markup']));
	
	$location = null;
	if (isset($content['field_location'])) {
		$location = $content['field_location']['#items'][0];	
	}
	
	$ticket_url = null;
	if (isset($content['field_tickets_url'])) {
		$ticket_url = $content['field_tickets_url']['#items'][0]['url'];
	}
?>

<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <div class="content"<?php print $content_attributes; ?>>

  	<div class="screening-date-wrapper">

	  	<div class="screening-date">
	  		<div class="month"><?php print $month; ?></div>
	  		<div class="day"><?php print $day; ?></div>
	  	</div>

	  	<div class="screening-location">

	  		<?php 

	  			$city_state_zip_line = $address_lines = array();

	  			foreach (array('name', 'street', 'additional') as $k) {
	  				if (strlen($location[$k])) $address_lines[] = $location[$k];
	  			}
	  			foreach (array('city', 'province', 'postal_code') as $k) {
	  				if (strlen($location[$k])) $city_state_zip_line[] = $location[$k];
	  			}
	  		?>
	  		<?php 
	  			if (count($address_lines)) {
	  				print implode("<br/>", $address_lines); 
	  			}
	  		?>
	  		<br/>
	  		<?php 
	  			if (count($city_state_zip_line) > 0) {
	  				print implode(", ", $city_state_zip_line);
	  			}
	  		?>
	  		<br/>
	  		<strong>
	  			<?php 
	  				print date('g:i a', $start); 
	  			?>
	  		</strong>
	  	</div>

	  	<?php if ($ticket_url): ?>
		<div class="screening-tickets">
	  		<a class="blue-button" href="<?php print $ticket_url; ?>">Buy Tickets</a>
	  	</div>
	  	<?php endif; ?>
	  	
	  	<div class="clearfix"></div>

	</div>

  </div>
</div>
