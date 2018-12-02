<?php

namespace Drupal\openkj\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Song request entities.
 */
class SongRequestViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
