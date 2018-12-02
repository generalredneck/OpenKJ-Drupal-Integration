<?php

/**
 * @file
 * Contains song.page.inc.
 *
 * Page callback for Song entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Song templates.
 *
 * Default template: song.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_song(array &$variables) {
  // Fetch Song Entity Object.
  $song = $variables['elements']['#song'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
