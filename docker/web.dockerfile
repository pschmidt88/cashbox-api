FROM nginx:1.14-alpine

ADD vhost.dev.conf /etc/nginx/conf.d/default.conf
