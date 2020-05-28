FROM httpd
COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf
RUN apt update; apt install php -y