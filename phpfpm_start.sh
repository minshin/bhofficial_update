#!/bin/bash
rm -rf /root/octobercms/*
cp -rf /root/octobercms_temp/* /root/octobercms
chmod 777 -R /root
chmod 777 -R /root/octobercms/storage
supervisord -c /etc/supervisor/supervisord.conf
