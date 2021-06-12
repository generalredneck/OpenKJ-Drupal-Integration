<?php

namespace Drupal\openkj\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\openkj\Entity\Artist;
use Drupal\openkj\Entity\Song;
use Drupal\openkj\Entity\SongRequest;
use Drupal\openkj\Entity\Venue;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "openkj_api_resource",
 *   label = @Translation("OpenKJ api resource"),
 *   uri_paths = {
 *     "canonical" = "/openkj/api",
 *     "create" = "/openkj/api/",
 *   }
 * )
 */
class OpenKJApiResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new OpenKJApiResource object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('openkj'),
      $container->get('current_user')
    );
  }

  /**
   * Responds to POST requests.
   *
   * @return \Drupal\rest\ModifiedResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function post(array $data) {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('restful post openkj_api_resource')) {
      throw new AccessDeniedHttpException();
    }
    $api_key = \Drupal::config('openkj.settings')->get('api_key');
    if ($api_key != $data['api_key']) {
      throw new AccessDeniedHttpException();
    }
    $commands = [
      'venueExists',
      'venueAccepting',
      'submitRequest',
      'search',
      'clearDatabase',
      'clearRequests',
      'connectionTest',
      'addSongs',
      'getSerial',
      'getAccepting',
      'setAccepting',
      'getVenues',
      'getRequests',
      'deleteRequest',
    ];
    if (!in_array($data['command'], $commands)) {
      \Drupal::logger('my_module')->notice(var_export($data, TRUE));
      throw new NotFoundHttpException("Command not found.");
    }
    $response = $this->{$data['command']}($data);
    \Drupal::logger('my_module')->notice(var_export($data, TRUE) . var_export($response->getResponseData(), TRUE));
    return $response;
  }

  // Mobile App stuff
  public function venueExists(array $data) {
    return new ResourceResponse("IMPLEMENT", 200);
  }

  public function venueAccepting(array $data) {
    return new ResourceResponse("IMPLEMENT", 200);
  }

  public function submitRequest(array $data) {
    return new ResourceResponse("IMPLEMENT", 200);
  }

  public function search(array $data) {
    return new ResourceResponse("IMPLEMENT", 200);
  }

  // OpenKJ Application
  public function clearDatabase(array $data) {
    // Remove all the Songs, Artists, and Requests. This happens when we rebuild
    // our OpenKJ song database making a new book.
    return new ResourceResponse("IMPLEMENT", 200);
  }

  public function clearRequests(array $data) {
    $query = \Drupal::entityQuery('song_request')
      ->condition('venue.target_id', $data['venue_id'])
      ->condition('status', 1);
    $ids = $query->execute();
    $requests = SongRequest::loadMultiple($ids);
    foreach ($requests as $request) {
      if (!$request) {
        continue;
      }
      $request->setPublished(FALSE);
      $request->save();
    }
    return new ResourceResponse([
      'command' => $data['command'],
      'error' => FALSE,
    ], 200);
  }

  public function connectionTest(array $data) {
    return new ResourceResponse([
      'connection' => 'ok',
      'command' => $data['command'],
      'error' => false
    ], 200);
  }

  public function addSongs(array $data) {
    /*
     * {
     *   api_key: "",
     *   command: "addSongs",
     *   songs: [
     *     {
     *       "artist": "artist name",
     *       "title": "song title",
     *     }
     *   ]
     * }
     */
    foreach ($data['songs'] as $song) {
      $artist = NULL;
      $query = \Drupal::entityQuery('artist')
        ->condition('name', $song['artist']);
      $ids = $query->execute();
      if (!empty($ids)) {
        $id = array_shift($ids);
        $artist = Artist::load($id);
      }
      else {
        $artist = Artist::create([
          'name' => $song['artist'],
        ]);
        $artist->save();
      }
      if (empty($artist)) {
        $errors[] = 'No artist found named ' . $song['artist'];
        continue;
      }
      $query = \Drupal::entityQuery('song')
        ->condition('name', $song['title'])
        ->condition('artist.target_id', $artist->id());
      $ids = $query->execute();
      if (empty($ids)) {
        $song = Song::create([
          'name' => $song['title'],
          'artist' => $artist->id(),
          'status' => TRUE,
        ]);
        $song->save();
      }
      else {
        $id = array_shift($ids);
        $song = Song::load($id);
        $song->setPublished(TRUE);
        $song->save();
      }
    }
    // work out the error parts of this later.
    $output = [
      'command' => $data['command'],
      'error' => !empty($errors),
      'errors' => $errors,
      'entries processed' => count($data['songs']),
    ];
    return new ResourceResponse($output, 200);
  }

  public function getSerial(array $data) {
    return new ResourceResponse("IMPLEMENT", 200);
  }

  public function getAccepting(array $data) {
    $venue = Venue::load($data['venue_id']);
    return new ResourceResponse([
      'command' => $data['command'],
      'venue_id' => $data['venue_id'],
      'accepting' => $venue->isPublished(),
      'error' => false,
    ], 200);
  }

  public function setAccepting(array $data) {
    // TODO: Error handling for invalid venue.
    $venue = Venue::load($data['venue_id']);
    $venue->setPublished((bool) $data['accepting']);
    $venue->save();

    return new ResourceResponse([
      'command' => $data['command'],
      'venue_id' => $data['venue_id'],
      'accepting' => $venue->isPublished(),
      'error' => false,
    ], 200);
  }

  public function getVenues(array $data) {
    $query = \Drupal::entityQuery('venue');
    $ids = $query->execute();
    $venues = Venue::loadMultiple($ids);
    $return_data = [];
    foreach ($venues as $venue) {
      $return_data[] = [
        'venue_id' => (int) $venue->id(),
        'accepting' => $venue->isPublished(),
        'name' => $venue->label(),
        'url_name' => $venue->uuid(),
      ];
    }
    return new ResourceResponse(
      [
        'command' => $data['command'],
        'error' => 'false',
        'venues' => $return_data,
      ],
      200
    );
  }

  public function getRequests(array $data) {
    $request_data = [];
    $query = \Drupal::entityQuery('song_request')
      ->condition('venue.target_id', $data['venue_id'])
      ->condition('status', 1);
    $ids = $query->execute();
    $requests = SongRequest::loadMultiple($ids);
    foreach ($requests as $request) {
      if (!empty($request->user_display_name->value)) {
        $request_singer = $request->user_display_name->value;
      }
      else {
        $request_singer = $request->getOwner()->getDisplayName();
      }
      switch ($request->group->value) {
        case 'group':
          $request_singer .= " & friends";
          break;

        case 'duet':
          $request_singer .= " & partner";
          break;
      }
      $request_data[] = [
        'request_id' => (int)$request->id(),
        'artist' => $request->song->entity->artist->entity->getName(),
        'title' => $request->song->entity->getName(),
        'singer' => $request_singer,
        'request_time' => (int) $request->getCreatedTime(),
      ];
    }
    $ids = $query->execute();
    return new ResourceResponse([
      'command' => $data['command'],
      'error' => FALSE,
      'requests' => $request_data,
    ], 200);
  }

  public function deleteRequest(array $data) {
    $request = SongRequest::load($data['request_id']);
    if (empty($request)) {
      return new ResourceResponse([
        'command' => $data['command'],
        'error' => TRUE,
        'errors' => [
          "Request " . $data['request_id'] . " couldn't be loaded to be removed.",
        ]
      ], 200);
    }
    $request->setPublished(FALSE);
    $request->save();
    return new ResourceResponse([
      'command' => $data['command'],
      'error' => FALSE,
    ], 200);
  }

}
