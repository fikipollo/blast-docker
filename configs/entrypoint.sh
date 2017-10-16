#!/bin/bash

htpasswd -D /etc/nginx/.htpasswd admin
htpasswd -b /etc/nginx/.htpasswd $ADMIN_USER $ADMIN_PASS

#ADD DEFAULT DATABASES IF EMPTY
if [ -z "$(ls -A /db)" ]; then
  cp -r /usr/local/src/original_db/* /db/
fi

sed -i 's/upload_max_filesize = .*/upload_max_filesize = '$MAX_FILE_SIZE'M/g' /etc/php/7.0/fpm/php.ini
sed -i 's/post_max_size = .*/post_max_size = '$MAX_FILE_SIZE'M/g' /etc/php/7.0/fpm/php.ini
sed -i 's/client_max_body_size .*/client_max_body_size '$MAX_FILE_SIZE'M;/g' /etc/nginx/sites-enabled/default

echo ":database_dir: /db" > ~/.sequenceserver.conf
echo ":port: 4567" >> ~/.sequenceserver.conf
echo ":num_threads: $CPU_NUMBER" >> ~/.sequenceserver.conf
echo $MAX_FILE_SIZE > /raw/.max_file_size
echo $CPU_NUMBER > /raw/.cpu_numbers

chmod -R 777 /tmp

python /var/www/html/blast/update_databases.py -d /db -b /var/www/html/blast -c $CPU_NUMBER

#Launch nginx and rserver
service php7.0-fpm start
service fcgiwrap start
service nginx start
service sequenceserver start

tail -f /var/log/blast.log
