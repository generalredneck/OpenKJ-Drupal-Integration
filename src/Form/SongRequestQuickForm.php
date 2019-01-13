<?php

namespace Drupal\openkj\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\openkj\Entity\Song;

/**
 * Implements an example form.
 */
class SongRequestQuickForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'song_request_quick';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $song_id = $this->getRequest()->query->get('song_id');
    $song = Song::load($song_id);
    $form['description'] = [
      '#markup' => '<p>' . $this->t(
        'Requesting: %artist - %song',
        [
          '%artist' => $song->artist->entity->getName(),
          '%song' => $song->getName()
        ]
      ) . '</p><p>' . $this->t(
        'Venue: %venue',
        ['%venue' => 'venue']
      ) . '</p><p>' . $this->t(
        'Singing as: %name',
        ['%name' => \Drupal::currentUser()->getDisplayName()]
      ) . '</p>',
    ];
    $form['song_id'] = [
      '#type' => 'hidden',
      '#value' => $song_id,
    ];
    $form['group'] = [
      '#type' => 'radios',
      '#title' => $this
        ->t("Who's singing?"),
      '#default_value' => 'alone',
      '#options' => [
        'alone' => $this->t('Alone'),
        'duet' => $this->t('Duet'),
        'group' => $this->t('Group'),
      ],
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Request'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
