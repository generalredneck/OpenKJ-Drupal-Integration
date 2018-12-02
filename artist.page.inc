<?php

/**
 * @file
 * Contains artist.page.inc.
 *
 * Page callback for Artist entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Artist templates.
 *
 * Default template: artist.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_artist(array &$variables) {
  // Fetch Artist Entity Object.
  $artist = $variables['elements']['#artist'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
