# Prepo

- [Installation](#installation)
- [Current State](#current-state)
- [TODO](#todo)

Prepo stops you from getting street sweeping parking tickets. It's built off the laravel framework. In active development.

## Installation
1. clone
2. `npm install` (requires [npm](https://www.npmjs.com/get-npm))
3. `php composer.phar install` (requires [composer](https://getcomposer.org/download/)) 
4. `export GOOGLE_BROWSER_API_KEY={...key...}` (requires [google api key with geocoding API access](https://console.cloud.google.com/google/maps-apis/apis/geocoding-backend.googleapis.com))
5. install mysql, create prepo/operp user, grant permissions
5. `php artisan migrate`
6. `php artisan db:seed`
7. `php artisan serve`


## Current State
Shows you a map. When you click it, a marker plots on it and tells you the street sweeping rules

## TODO

- ~~build parser to fill schedule database with actual data from http://archive.sandiego.gov/stormwater/pdf/district3schedule.pdf~~
- ~~avenues and some other street types don't work yet. Streets and Drives definitely should.~~
- add button to show current location
- detect whether the current time is during the street sweeping window
- display all bad parking zones for a given time
- expand beyond north park
