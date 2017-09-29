#!/bin/bash

if [[ "$ADMIN_USER" != "" ]]; then
    htpasswd -D /etc/nginx/.htpasswd admin
else
    export ADMIN_USER="admin"
fi

if [[ "$ADMIN_PASS" == "" ]]; then
    ADMIN_PASS="supersecret"
fi

htpasswd -b /etc/nginx/.htpasswd $ADMIN_USER $ADMIN_PASS

#Launch nginx and rserver
service php7.0-fpm start
service nginx start

if [ -z "$(ls -A /db)" ]; then
  tar xzvf /usr/local/src/test.tar.gz -C /db/
fi

sequenceserver -d /db & 2>&1 > /dev/stdout

tail -f /dev/stdout
