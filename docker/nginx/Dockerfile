FROM alpine:3.12

RUN apk add --update --no-cache nginx

COPY nginx.conf /etc/nginx/
COPY symfony.conf /etc/nginx/conf.d/

RUN adduser -u 1000 -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
