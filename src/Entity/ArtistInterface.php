<?php

namespace Drupal\openkj\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Artist entities.
 *
 * @ingroup openkj
 */
interface ArtistInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Artist name.
   *
   * @return string
   *   Name of the Artist.
   */
  public function getName();

  /**
   * Sets the Artist name.
   *
   * @param string $name
   *   The Artist name.
   *
   * @return \Drupal\openkj\Entity\ArtistInterface
   *   The called Artist entity.
   */
  public function setName($name);

  /**
   * Gets the Artist creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Artist.
   */
  public function getCreatedTime();

  /**
   * Sets the Artist creation timestamp.
   *
   * @param int $timestamp
   *   The Artist creation timestamp.
   *
   * @return \Drupal\openkj\Entity\ArtistInterface
   *   The called Artist entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Artist published status indicator.
   *
   * Unpublished Artist are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Artist is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Artist.
   *
   * @param bool $published
   *   TRUE to set this Artist to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\openkj\Entity\ArtistInterface
   *   The called Artist entity.
   */
  public function setPublished($published);

}
