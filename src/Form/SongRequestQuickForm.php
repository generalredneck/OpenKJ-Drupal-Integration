<?php

namespace Drupal\openkj\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\openkj\Entity\Song;
use Drupal\openkj\Entity\SongRequest;
use Drupal\openkj\Entity\Venue;
use Drupal\user\Entity\User;

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
    $venue = Venue::load(1);
    $form['description'] = [
      '#markup' => '<p>' . $this->t(
        'Requesting: %artist - %song',
        [
          '%artist' => $song->artist->entity->getName(),
          '%song' => $song->getName()
        ]
      ) . '</p><p>' . $this->t(
        'Venue: %venue',
        ['%venue' => $venue->getName()]
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
    $form['user_id'] = [
      '#type' => 'hidden',
      '#value' => \Drupal::currentUser()->id(),
    ];
    $form['venue_id'] = [
      '#type' => 'hidden',
      '#value' => $venue->id(),
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
    //TODO: Validate all the ids in the hidden fields.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $song_request = SongRequest::create([]);
    $requester = User::load($form_state->getValue('user_id'));
    $song = Song::load($form_state->getValue('song_id'));
    $artist = $song->artist->entity;
    $venue = Venue::load($form_state->getValue('venue_id'));
    $song_request->setName($this->t(
      "Request for @artist - @song @ @venue",
      [
        '@artist' => $artist->getName(),
        '@song' => $song->getName(),
        '@venue' => $venue->getName(),
      ]
    ));
    $song_request->setOwner($requester);
    $song_request->set('song', $song);
    $song_request->set('venue', $venue);
    $song_request->setPublished(TRUE);
    $song_request->set('group', $form_state->getValue('group'));
    $song_request->save();
    $form_state->setRedirect('<front>', []);
  }

}
