############################################################
# Dockerfile to build Blast container image for the eBioKit
# Based on wurmlab/sequenceserver
# Version 0.9 September 2017
# TODO:
# - Auto add entries
# - Webservice + docker for makeblastdb
# - Sequenceserver logs
# - Organize databases in folders? (genomic, protein...)
############################################################

# Set the base image to wurmlab/sequenceserver
FROM ubuntu:16.04

# File Author / Maintainer
MAINTAINER Rafael Hernandez <https://github.com/fikipollo>

################## BEGIN INSTALLATION ######################
#Add the link to internal MRS service
RUN apt-get update \
    && apt-get -y install build-essential ruby ruby-dev ncbi-blast+ nginx php-fpm apache2-utils sudo wget csh fcgiwrap \
    && apt-get clean \
    && gem install sequenceserver \
    && gem install ncbi-blast-dbs

#Copy files
COPY configs/* /tmp/

RUN wget -O /tmp/wwwblast.tar.gz ftp://ftp.ncbi.nih.gov/blast/executables/legacy/2.2.26/wwwblast-2.2.26-x64-linux.tar.gz

RUN rm /var/www/html/* \
    && mv /tmp/*.html /var/www/html/ \
    && mv /tmp/*.png /var/www/html/ \
    && mv /tmp/*.php /var/www/html/ \
    && cat /tmp/rules >> /etc/sudoers \
    && mv /tmp/default /etc/nginx/sites-available/ \
    && mv /tmp/entrypoint.sh /usr/bin/entrypoint.sh \
    && chmod +x /usr/bin/entrypoint.sh \
    && mv /tmp/admin_tools /usr/local/bin/admin_tools \
    && chmod +x /usr/local/bin/admin_tools \
    && mv /tmp/test.tar.gz /usr/local/src/ \
    && mv /tmp/sequenceserver /etc/init.d/sequenceserver  \
    && chmod +x /etc/init.d/sequenceserver \
    && tar -xzvf /tmp/wwwblast.tar.gz -C /var/www/html/ \
    && rm -r /tmp/* \
    && chown www-data:www-data /var/www/html/* \
    && chmod 660 /var/www/html/*.* \
    && htpasswd -b -c /etc/nginx/.htpasswd admin supersecret \
    && echo ":database_dir: /db" > ~/.sequenceserver.conf
##################### INSTALLATION END #####################

ENTRYPOINT ["/usr/bin/entrypoint.sh"]
