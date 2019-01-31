FROM nginx:alpine

COPY opt/docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY opt/docker/nginx/upstream.conf /etc/nginx/conf.d/upstream.tmp

RUN mkdir -p /var/www/html