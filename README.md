## Deploy app

- copy .env.example to .env
- change .env -> 'APP_NAME'
- change .env -> 'APP_ENV' to production
- change .env -> 'APP_DEBUG' to false
- change .env -> 'APP_URL'
- run 'composer install'
- run 'php artisan deploy'

## Email list to send

- PATH: config/getcarrier.php (variable 'sendTo')
- OUTPUT: config('getcarrier.sendTo')
- NEED TO CHANGE:
    - Change array in the file 'config/getcarrier.php'
    - Run console command 'php artisan optimize:clear' (Compiled views, application cache, route, configuration, compiled services and packages, cache cleared)

This app developed by [SpaceCode Team](https://spacecode.dev).
