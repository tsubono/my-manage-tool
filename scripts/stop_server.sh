#!/bin/bash
isExistApp = `pgrep httpd`
sudo pkill -KILL -f nuxt

if [[ -n  $isExistApp ]]; then
    sudo service httpd stop
fi
cd /home/manage/my-manage-tool
sudo rm -r storage
cd
sudo rm -r /home/manage/my-manage-tool
