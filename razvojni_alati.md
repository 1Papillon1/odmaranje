## Config
- config/log-viewer.php
- config/debugbar.php

## https://github.com/opcodesio/log-viewer
- composer require package/name --dry-run (test installation)
- composer require opcodesio/log-viewer
- php artisan log-viewer:publish
- php artisan vendor:publish --tag="log-viewer-config"
- php artisan vendor:publish --provider="Opcodes\LogViewer\Providers\LogViewerServiceProvider" (odabrati log viewer)

# Pročitaj - https://log-viewer.opcodes.io/docs/3.x/configuration/access-to-log-files
- app/Providers/LogViewerServiceProvider.php - dodaj LogViwer i boot metodu

# Forbbiden issues
- sudo usermod -a -G wheel fitapp - dodaj korisnika `fitapp` u grupu `wheel` - sudoers
- sudo usermod -a -G fitapp nobody 

- cd /home/fitapp/tin.fitapp.cloud/odmaranje/odmaranje-app

# Postavi vlasništvo na korisnika i grupu `fitapp`
- sudo chown -R fitapp:fitapp .

# Postavi prava pristupa za direktorije (755) i datoteke (644)
- sudo find . -type d -exec chmod 755 {} \;
- sudo find . -type f -exec chmod 644 {} \;

# Posebna prava za `storage` i `bootstrap/cache`
- sudo chown -R fitapp:fitapp storage bootstrap/cache
- sudo chmod -R 775 storage bootstrap/cache

# Log folderi prava
- sudo chown -R fitapp:fitapp /home/fitapp/tin.fitapp.cloud/odmaranje/odmaranje-app/storage/logs
- sudo chmod -R 775 /home/fitapp/tin.fitapp.cloud/odmaranje/odmaranje-app/storage/logs


## https://github.com/barryvdh/laravel-debugbar
- composer require barryvdh/laravel-debugbar --dev --dry-run
- composer require barryvdh/laravel-debugbar --dev
- php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"