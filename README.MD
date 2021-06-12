# OpenKJ Integration for Drupal

## Install
- Log in as an administrator to your drupal site.
- Install openKJ module by going to EXTEND, then INSTALL NEW MODULE.
- OpenKJ Integration module requires the following modules to be present and enabled: Database Search (search_api_db), Search API (search_api), System, Views, Filter, User, REST UI, RESTful Web Services and Serialization.
- Go to CONFIGURATIONS then under web services select REST. All REST resources are disabled.
- In REST resources, enable OpenKJ api resource. Choose the json format and cookie as supported auth.
- Add `$config['openkj.settings']['api_key'] = 'REPLACE WITH SOMETHING SECURE';` to your settings.php
- Log in as an administrator to your drupal site.
- Navigate to /openkj/venue/add
- Add some venue information.
- Navigate to /admin/people/permissions
- Check Anonymous on "Access POST on OpenKJ api resource resource"

## Configuring OpenKJ

- Open OpenKJ on your computer
- Navigate to Tools -> Settings.
- Click on Network on the left bar.
- Check "Use Request Server"
- Fill in Server URL as https://path-to-drupal.com/openkj/api
- Fill in API Key with what you added during installation to settings.php
- Click "close".
- Navigate to Karaoke -> Incoming Requests.
- Select the venue you added from the Venue dropdown.
- Click Update Remote DB

## Features

- Comes with customizable Song, Artists, Song Requests, and Venue entities that have built in displays and full views integration.
- Comes with SearchAPI configured out of the box with a basic song book.
- Users can select the venue they are located at and request songs straight from the song book.
- Users can sign up from the song book.
- Users can choose a custom display name.
- Full OpenKJ API implementation.

