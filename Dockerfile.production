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
     && yum -y install curl httpd \
     && yum -y install --enablerepo=ius-archive php70u php70u-opcache php70u-xml php70u-mcrypt php70u-gd php70u-devel php70u-mysql php70u-intl php70u-mbstring php70u-bcmath php70u-soap php70u-redis \
     && ln -s /usr/sbin/httpd /usr/sbin/apache2

# Override configs
ADD docker-container-configs/php.conf /etc/httpd/conf.d/php.conf

# Install website
RUN rm -rf /var/www/html/* && mkdir -p /var/www/html
ADD src /var/www/html

# Configure apache
RUN chown -R apache:apache /var/www
ENV APACHE_RUN_USER apache
ENV APACHE_RUN_GROUP apache
ENV APACHE_LOG_DIR /var/log/apache2

EXPOSE 80

CMD ["/usr/sbin/apache2", "-D",  "FOREGROUND"]
