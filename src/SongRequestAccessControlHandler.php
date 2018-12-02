<?php

namespace Drupal\openkj;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Song request entity.
 *
 * @see \Drupal\openkj\Entity\SongRequest.
 */
class SongRequestAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\openkj\Entity\SongRequestInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished song request entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published song request entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit song request entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete song request entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add song request entities');
  }

}
