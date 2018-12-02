<?php

namespace Drupal\openkj\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Song request entities.
 *
 * @ingroup openkj
 */
interface SongRequestInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Song request name.
   *
   * @return string
   *   Name of the Song request.
   */
  public function getName();

  /**
   * Sets the Song request name.
   *
   * @param string $name
   *   The Song request name.
   *
   * @return \Drupal\openkj\Entity\SongRequestInterface
   *   The called Song request entity.
   */
  public function setName($name);

  /**
   * Gets the Song request creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Song request.
   */
  public function getCreatedTime();

  /**
   * Sets the Song request creation timestamp.
   *
   * @param int $timestamp
   *   The Song request creation timestamp.
   *
   * @return \Drupal\openkj\Entity\SongRequestInterface
   *   The called Song request entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Song request published status indicator.
   *
   * Unpublished Song request are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Song request is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Song request.
   *
   * @param bool $published
   *   TRUE to set this Song request to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\openkj\Entity\SongRequestInterface
   *   The called Song request entity.
   */
  public function setPublished($published);

}
