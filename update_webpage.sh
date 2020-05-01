#!/bin/bash

DEST=/var/www/lazyweb
SRC=./client/*

sudo cp -r -f ${SRC} ${DEST}
sudo cp -r -f ./vendor ${DEST}
sudo cp -r -f ./streams ${DEST}
sudo systemctl reload apache2
