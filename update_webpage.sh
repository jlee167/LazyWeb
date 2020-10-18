#!/bin/bash

DEST=/var/www/lazyweb
DEST2=/var/www/html
SRC=./client/*

sudo cp -r -f ${SRC} ${DEST}
sudo cp -r -f ./vendor ${DEST}
sudo cp -r -f ./streams ${DEST}
sudo cp -r -f ${SRC} ${DEST2}
sudo cp -r -f ./vendor ${DEST2}
sudo cp -r -f ./streams ${DEST2}
sudo systemctl reload apache2
