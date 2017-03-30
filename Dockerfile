# The FROM instruction sets the Base Image for subsequent instructions.
# Using Nginx as Base Image
FROM daocloud.io/mint_org/php_fpm:v5625
MAINTAINER King <87287864@qq.com>

RUN rm -rf /root/octobercms

RUN mkdir /root/octobercms

RUN mkdir /root/octobercms_temp

COPY . /root/octobercms_temp

COPY ./phpfpm_start.sh  /usr/local/bin

RUN chmod 777 /usr/local/bin/phpfpm_start.sh

