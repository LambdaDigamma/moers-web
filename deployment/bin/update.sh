# ------------------------------------------------------------------------------
# Updates the application.
# Usage: update.sh
# ------------------------------------------------------------------------------

php artisan down

php artisan migrate --force

php artisan trail:generate
php artisan cache:clear

php artisan google-fonts:fetch
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

php artisan optimize

php artisan up
