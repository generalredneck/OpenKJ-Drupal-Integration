<?php

namespace Drupal\openkj;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Artist entity.
 *
 * @see \Drupal\openkj\Entity\Artist.
 */
class ArtistAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\openkj\Entity\ArtistInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished artist entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published artist entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit artist entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete artist entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add artist entities');
  }

}
