<?php

/**
 * @file
 * template.php
 */

function chicagofilmmakers_menu_tree__menu_block__1(array $variables) {
  return '<ul class="menu">' . $variables['tree'] . '</ul>';
}

function chicagofilmmakers_menu_link__menu_block__1(array $variables) {

  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";

}

function chicagofilmmakers_preprocess_views_view_fields(&$vars) {  

  foreach ($vars['view']->result as $i => $result) {
    // if (isset($result->field_field_video)) {

      $vars['view']->result[$i]->field_field_featured_image = array();
    // }
  }

  /*
  // remove the featured image if the video field has a value
  if (in_array($vars['view']->name, array('screenings'))) {

    unset($vars['view']->field['field_featured_image']);
    dpm($vars['view']->field);
    /*
    if ($vars['view']->field['field_video']->original_value !== null) {
      unset($vars['view']->field['field_featured_image']);
    } 
   
  }
  */   
  

}

function chicagofilmmakers_preprocess_field(&$variables, $hook) {

  // add fitvids container class to any field-video wrapper
  if ($variables['field_name_css'] == 'field-video') {
    $variables['classes_array'][] = 'fitvids-container';
  }
 
}


function chicagofilmmakers_preprocess_node(&$variables) {
    
  if ($variables['type'] == 'screening') {

    // display video, image in that order 
    if (count($variables['field_video']) && count($variables['field_featured_image'])) {
      unset($variables['content']['field_featured_image']);
    }

  }
}

function chicagofilmmakers_preprocess_page(&$variables) {

  // if this is a node page
  if (isset($variables['node']->type)) {

    $node = $variables['node'];

    // if ($node->type == 'screening') dpm($node);

    // add the director to the page so it can be included in the header 
    if (isset($node->field_director)) {
      $variables['directed_by'] = $node->field_director['und'][0]['safe_value'];
    }
  }

}

function chicagofilmmakers_breadcrumb($variables) {

  $breadcrumb = $variables['breadcrumb'];

	if (!empty($breadcrumb)) {

    $output = '<div class="breadcrumb"><span class="breadcrumb-inner">';

    /*
      Last breadcrumb is an array of render objects and not an already rendered link.
      Manually render the last link
    */

    if (is_array($breadcrumb[count($variables['breadcrumb'])-1])) {
      $breadcrumb[count($breadcrumb)-1] = 
        "<strong>" . $breadcrumb[count($breadcrumb)-1]['data'] . "</strong>";
    }

    $output .= implode(htmlentities(' > '), $breadcrumb);	
    $output .= '</span></div>';

    return $output;

	}
  
	
}