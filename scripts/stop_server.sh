#!/bin/bash
sudo pkill -KILL -f nuxt
sudo service httpd stop
cd /home/manage/my-manage-tool
sudo rm -r storage
cd
sudo rm -r /home/manage/my-manage-tool
