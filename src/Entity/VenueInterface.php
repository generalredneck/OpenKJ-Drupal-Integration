<?php

namespace Drupal\openkj\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Venue entities.
 *
 * @ingroup openkj
 */
interface VenueInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Venue name.
   *
   * @return string
   *   Name of the Venue.
   */
  public function getName();

  /**
   * Sets the Venue name.
   *
   * @param string $name
   *   The Venue name.
   *
   * @return \Drupal\openkj\Entity\VenueInterface
   *   The called Venue entity.
   */
  public function setName($name);

  /**
   * Gets the Venue creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Venue.
   */
  public function getCreatedTime();

  /**
   * Sets the Venue creation timestamp.
   *
   * @param int $timestamp
   *   The Venue creation timestamp.
   *
   * @return \Drupal\openkj\Entity\VenueInterface
   *   The called Venue entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Venue published status indicator.
   *
   * Unpublished Venue are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Venue is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Venue.
   *
   * @param bool $published
   *   TRUE to set this Venue to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\openkj\Entity\VenueInterface
   *   The called Venue entity.
   */
  public function setPublished($published);

}
