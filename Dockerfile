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
FROM wurmlab/sequenceserver:1.0.12

# File Author / Maintainer
MAINTAINER Rafael Hernandez <https://github.com/fikipollo>

################## BEGIN INSTALLATION ######################
#Add the link to internal MRS service
RUN apt-get update \
    && apt-get -y install nginx php-fpm apache2-utils \
    && apt-get clean

#Copy files
COPY configs/* /tmp/

RUN rm /var/www/html/* \
    && mv /tmp/*.png /var/www/html/ \
    && mv /tmp/*.php /var/www/html/ \
    && chown www-data:www-data /var/www/html/* \
    && chmod 660 /var/www/html/* \
    && cat /tmp/rules >> /etc/sudoers \
    && mv /tmp/default /etc/nginx/sites-available/ \
    && mv /tmp/entrypoint.sh /usr/bin/entrypoint.sh \
    && chmod +x /usr/bin/entrypoint.sh \
    && rm -r /tmp/* \
    && htpasswd -b -c /etc/nginx/.htpasswd admin supersecret

##################### INSTALLATION END #####################

ENTRYPOINT ["/usr/bin/entrypoint.sh"]
