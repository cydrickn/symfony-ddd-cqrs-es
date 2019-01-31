if [ ! -f "/var/www/html/var/log/php.error.log" ]; then
    touch /var/www/html/var/log/php.error.log
fi

if [ ! -f "/var/www/html/var/log/www.access.logs" ]; then
    touch /var/www/html/var/log/www.access.logs
fi

exec "$@"