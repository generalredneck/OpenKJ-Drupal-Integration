<?php

/**
 * @file
 * Contains venue.page.inc.
 *
 * Page callback for Venue entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Venue templates.
 *
 * Default template: venue.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_venue(array &$variables) {
  // Fetch Venue Entity Object.
  $venue = $variables['elements']['#venue'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
