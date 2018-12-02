<?php

namespace Drupal\openkj\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Song entities.
 *
 * @ingroup openkj
 */
interface SongInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Song name.
   *
   * @return string
   *   Name of the Song.
   */
  public function getName();

  /**
   * Sets the Song name.
   *
   * @param string $name
   *   The Song name.
   *
   * @return \Drupal\openkj\Entity\SongInterface
   *   The called Song entity.
   */
  public function setName($name);

  /**
   * Gets the Song creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Song.
   */
  public function getCreatedTime();

  /**
   * Sets the Song creation timestamp.
   *
   * @param int $timestamp
   *   The Song creation timestamp.
   *
   * @return \Drupal\openkj\Entity\SongInterface
   *   The called Song entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Song published status indicator.
   *
   * Unpublished Song are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Song is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Song.
   *
   * @param bool $published
   *   TRUE to set this Song to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\openkj\Entity\SongInterface
   *   The called Song entity.
   */
  public function setPublished($published);

}
