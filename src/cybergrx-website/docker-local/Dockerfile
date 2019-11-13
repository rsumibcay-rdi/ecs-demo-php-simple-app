FROM amazonlinux:2

# Install epel package repository for newer version of php
# amazonlinux is centos 7 with php 5.4 which is near EOL
# production is runnin PHP 7
# https://forums.aws.amazon.com/message.jspa?messageID=853646
RUN yum -y update \
     && yum -y install wget \
     && yum -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
     && wget https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
     && wget https://centos7.iuscommunity.org/ius-release.rpm \
     && rpm -Uvh ius-release*.rpm \
     && yum -y update \
     && yum -y install curl httpd mod_ssl \
     && yum -y install --enablerepo=ius-archive php70u php70u-opcache php70u-xml php70u-mcrypt php70u-gd php70u-devel php70u-mysql php70u-mysqlnd php70u-intl php70u-mbstring php70u-bcmath php70u-soap php70u-json php70u-xmlrpc php70u-redis php70u-pecl-xdebug \
     && ln -s /usr/sbin/httpd /usr/sbin/apache2 \
     && mkdir -p /var/www/html

# Override configs
ADD configs/15-xdebug.ini /etc/php.d/15-xdebug.ini
ADD configs/php.conf /etc/httpd/conf.d/php.conf
ADD configs/ssl.conf /etc/httpd/conf.d/ssl.conf
ADD configs/httpd.conf /etc/httpd/conf/httpd.conf
ADD configs/ssl/cybergrx.local.crt /etc/pki/tls/certs/cybergrx.local.crt
ADD configs/ssl/cybergrx.local.csr /etc/pki/tls/private/cybergrx.local.csr
ADD configs/ssl/cybergrx.local.key /etc/pki/tls/private/cybergrx.local.key

# Configure apache folders
RUN chown -R apache:apache /var/www
ENV APACHE_RUN_USER apache
ENV APACHE_RUN_GROUP apache
ENV APACHE_LOG_DIR /var/log/apache2

EXPOSE 80 443 9000

CMD ["/usr/sbin/apache2", "-D",  "FOREGROUND"]
#CMD ["tail", "-f", "/dev/null"]

