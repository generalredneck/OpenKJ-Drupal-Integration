<?php

/**
 * @file
 * Contains song_request.page.inc.
 *
 * Page callback for Song request entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Song request templates.
 *
 * Default template: song_request.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_song_request(array &$variables) {
  // Fetch SongRequest Entity Object.
  $song_request = $variables['elements']['#song_request'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
