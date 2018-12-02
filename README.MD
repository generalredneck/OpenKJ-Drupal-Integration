# OpenKJ Integration for Drupal

## Install

- Simply follow the normal steps for installing any Drupal 8 module.
- Add `$config['openkj.settings']['api_key'] = 'REPLACE WITH SOMETHING SECURE';` to your settings.php
- Log in as an administrator to your drupal site.
- Navigate to /openkj/venue/add
- Add some venue information.

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
- Full OpenKJ API implementation.

