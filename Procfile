web: bash -lc "[ -f /app/database/database.sqlite ] || mkdir -p /app/database && touch /app/database/database.sqlite; php artisan migrate --force; php -S 0.0.0.0:8080 -t public"
